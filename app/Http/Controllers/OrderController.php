<?php

namespace App\Http\Controllers;

use App\Models\Wd;
use App\Models\Food;
use App\Models\User;
use App\Models\Drink;
use App\Models\Order;
use App\Models\Saldo;
use App\Models\Snack;
use App\Models\Topup;
use PDF;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use function Laravel\Prompts\select;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class OrderController extends Controller
{
    public function index()
    {
        $id = Auth::id();
        // Menggunakan whereDate untuk membandingkan kolom 'tanggal' dengan tanggal hari ini
        $order = Order::where('kantin_id', $id)
            ->whereDate('tanggal', now()->toDateString())
            ->orderBy('tanggal', 'desc')
            ->get();
        $total = Order::where('kantin_id', $id)
            ->whereDate('tanggal', now()->toDateString())
            ->SUM('total_order');
        $orderCount = Order::where('kantin_id', $id)
            ->whereDate('tanggal', now()->toDateString())
            ->count();
        return view('order.index', compact('order', 'orderCount', 'total'));
    }

    public function report()
    {
        $id = Auth::id();
        $order = Order::where('kantin_id', $id)->orderBy('tanggal', 'desc')->get();
        $user = Auth::user();
        $saldo = Saldo::where('rfid', $user->rfid)->first();
        return view('order.report', compact('order', 'saldo'));
    }
    public function checkSaldo(Request $request)
    {
        // Validasi request
        $request->validate([
            'rfidInputCheck' => 'required',
        ]);

        // Membaca data saldo dari database
        $saldo = Saldo::where('rfid', $request->rfidInputCheck)->first();

        if ($saldo) {
            // Jika saldo ada, tampilkan saldo
            return response()->json(['success' => true, 'message' => 'Saldo ditemukan.', 'saldo' => $saldo->saldo]);
        } else {
            // Jika saldo tidak ada, berikan pesan tidak ditemukan
            return response()->json(['success' => false, 'message' => 'RFID tidak ditemukan.']);
        }
    }
    public function create()
    {
        $id = Auth::id();
        $foods = Food::where('kantin_id', $id)->where('status', 'ready')->orderByDesc('likes')->get();
        $drinks = Drink::where('kantin_id', $id)->where('status', 'ready')->orderByDesc('likes')->get();
        $snacks = Snack::where('kantin_id', $id)->where('status', 'ready')->orderByDesc('likes')->get();
        $saldo = Saldo::all();
        // dd($id, $foods, $drinks, $snacks);
        return view('order.create', compact('foods', 'drinks', 'snacks', 'saldo'), ['showBottomNav' => false]);
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'rfidInput' => 'required',
            'password' => 'required',
            'totalItems' => 'required|integer',
            'totalPrice' => 'required|numeric',
            'orderDetails' => 'required|string',
        ]);
        $pembeli = User::where('rfid', $validated['rfidInput'])->first();

        // Verifikasi password
        if (!$pembeli || !Hash::check($validated['password'], $pembeli->password)) {
            return back()->with('error', 'RFID atau Password Anda Salah');
        }
        $saldoPembeli = Saldo::where('rfid', $validated['rfidInput'])->firstOrFail();

        if ($saldoPembeli->saldo < $validated['totalPrice']) {
            return back()->with('error', 'Saldo tidak cukup. Saldo Anda saat ini: Rp. ' . $saldoPembeli->saldo);
        }

        // Mencari saldo penjual berdasarkan RFID yang sedang login
        $rfidPenjual = trim(Auth::user()->rfid);
        $saldoPenjual = Saldo::where('rfid', $rfidPenjual)->first();

        if (!$saldoPenjual) {
            return back()->with('error', 'Saldo penjual tidak ditemukan.');
        }

        $order = Order::create([
            'tanggal' => now(),
            'kantin_id' => Auth::id(),
            'rfid' => $validated['rfidInput'],
            'jumlah_item' => $validated['totalItems'],
            'total_order' => $validated['totalPrice'],
            'saldo_awal' => $saldoPembeli->saldo,
            'saldo_akhir' => $saldoPembeli->saldo - $validated['totalPrice'],
        ]);
        Topup::create([
            'tanggal' => now()->toDateString(),
            'rfid' =>  $rfidPenjual,
            'debet' => $validated['totalPrice'],
            'kredit' => '0',
            'payment' => 'saldo',
        ]);
        Wd::create([
            'tanggal' => now()->toDateString(),
            'rfid' =>  $validated['rfidInput'],
            'debet' => '0',
            'kredit' => $validated['totalPrice'],
            'payment' => 'saldo',
        ]);
        $this->processOrderDetails($order->id, $validated['orderDetails']);

        // Mengurangi saldo pembeli
        $saldoPembeli->saldo -= $validated['totalPrice'];
        $saldoPembeli->save();

        // Menambahkan saldo ke penjual
        $saldoPenjual->saldo += $validated['totalPrice'];
        $saldoPenjual->save();
        // Setelah order berhasil disimpan
        return redirect()->route('order.show', $order->id)->with('success', 'Order berhasil disimpan dan saldo penjual telah diperbarui.');

        // return redirect()->route('order.index')->with('success', 'Order berhasil disimpan dan saldo penjual telah diperbarui.');
    }



    protected function processOrderDetails($orderId, $orderDetails)
    {
        $orderDetailsArray = explode("__", $orderDetails);
        foreach ($orderDetailsArray as $detail) {
            $detail = trim($detail);
            $parts = explode(': ', $detail, 2);
            if (count($parts) === 2) {
                [$itemName, $itemDetails] = $parts;
                if (preg_match('/(\d+)x Rp (\d+) = Rp (\d+)/', $itemDetails, $matches) && count($matches) === 4) {
                    $quantity = $matches[1];
                    $pricePerUnit = $matches[2];
                    OrderDetail::create([
                        'order_id' => $orderId,
                        'nama_item' => trim($itemName),
                        'kuantitas' => trim($quantity),
                        'harga_per_unit' => trim($pricePerUnit),
                    ]);
                    // Di dalam loop foreach di processOrderDetails
                    $this->addLikeToFood($itemName, $pricePerUnit);
                    $this->addLikeToDrink($itemName, $pricePerUnit);
                    $this->addLikeToSnack($itemName, $pricePerUnit);
                }
            }
        }
    }


    protected function addLikeToFood($itemName, $pricePerUnit)
    {
        $this->addLikeToItem('food', $itemName, $pricePerUnit);
    }

    protected function addLikeToDrink($itemName, $pricePerUnit)
    {
        $this->addLikeToItem('drinks', $itemName, $pricePerUnit);
    }

    protected function addLikeToSnack($itemName, $pricePerUnit)
    {
        $this->addLikeToItem('snacks', $itemName, $pricePerUnit);
    }

    protected function addLikeToItem($tableName, $itemName, $pricePerUnit)
    {
        $item = DB::table($tableName)
            ->where('price', $pricePerUnit)
            ->where('name', 'like', "%{$itemName}%")
            ->first();

        if ($item) {
            DB::table($tableName)->where('id', $item->id)->increment('likes');
        } else {
            Log::warning("Item not found for liking in table {$tableName} with name {$itemName} and price {$pricePerUnit}");
        }
    }





    public function show(Request $request, $id)
    {
        $order = Order::with('details')->findOrFail($id);

        // Anda perlu mendapatkan nilai rfid dari order yang ditemukan, bukan string 'rfid'
        // Misalnya, $order->rfid untuk mendapatkan rfid dari order yang sedang ditampilkan
        $user = User::where('rfid', $order->rfid)->first(); // Menggunakan first() karena asumsinya satu rfid untuk satu user

        return view('order.show', compact('order', 'user'));
    }
    public function raport()
    {
        $users = User::with('orders')->where('role', 'pengguna')->get();
        $canteens = User::with('orders')->where('role', 'pengelola')->get();

        return view('admin.report.sales.index', compact('users', 'canteens'));
    }

    public function filter(Request $request)
    {
        $query = Order::query(); // Mulai dengan query dasar

        // Filter berdasarkan user jika user_id diberikan dan tidak sama dengan 'all'
        if ($request->filled('user')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('rfid', $request->user);
            });
        }

        // Filter berdasarkan kantin jika kantin_id diberikan dan tidak sama dengan 'all'
        if ($request->filled('kantin_id')) {
            $query->where('kantin_id', $request->kantin_id);
        }

        // Filter berdasarkan bulan jika bulan diberikan dan tidak sama dengan 'all'
        if ($request->filled('bulan')) {
            $monthNum = date('m', strtotime($request->bulan));
            $year = now()->year; // Menggunakan tahun saat ini
            $query->whereMonth('created_at', '=', $monthNum)
                ->whereYear('created_at', '=', $year);
        }

        // Filter berdasarkan rentang tanggal jika tanggal diberikan
        if ($request->filled('date_start') && $request->filled('date_end')) {
            $startDate = $request->date_start;
            $endDate = $request->date_end;
            $query->whereBetween('created_at', [$startDate . " 00:00:00", $endDate . " 23:59:59"]);
        }

        $saless = $query->orderBy('tanggal', 'desc')->get(); // Eksekusi query

        return view('admin.report.sales.showall', compact('saless')); // Pastikan view Anda sesuai
    }
    public function print(Request $request)
    {
        // dd($request->all());
        $query = Order::query();

        // Filter berdasarkan user jika user_id diberikan dan tidak sama dengan 'all'
        if ($request->filled('user') && $request->user != '') {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('rfid', $request->user);
            });
        }

        // Filter berdasarkan kantin jika kantin_id diberikan dan tidak sama dengan 'all'
        if ($request->filled('kantin_id') && $request->kantin_id != '') {
            $query->where('kantin_id', $request->kantin_id);
        }

        // Filter berdasarkan bulan jika bulan diberikan dan tidak sama dengan 'all'
        if ($request->filled('bulan') && $request->bulan != '') {
            // Asumsi bulan diberikan dalam format 'jan', 'feb', dll.
            $monthNum = date('m', strtotime($request->bulan . " 1 2021"));
            $year = now()->year; // Menggunakan tahun saat ini
            $query->whereMonth('created_at', '=', $monthNum)->whereYear('created_at', '=', $year);
        }

        // Filter berdasarkan rentang tanggal jika tanggal diberikan
        if ($request->filled('date_start') && $request->filled('date_end')) {
            $startDate = $request->date_start;
            $endDate = $request->date_end;
            $query->whereBetween('created_at', [$startDate . " 00:00:00", $endDate . " 23:59:59"]);
        }

        $orders = $query->orderBy('tanggal', 'desc')->get();
        // Menghitung total dari semua total_order
        $totalOrder = $orders->sum('total_order');

        $pdf = PDF::loadView('admin.report.sales.print', compact('orders', 'totalOrder'));

        // Pastikan direktori penyimpanan tersedia dan memiliki izin yang sesuai
        return $pdf->download('laporan-transaksi.pdf');
    }



    public function detail(Request $request, $id)
    {
        $order = Order::with('details')->findOrFail($id);
        // Tidak perlu mencari user lagi jika model Order sudah memiliki relasi ke User
        // asumsikan Anda sudah mendefinisikan relasi tersebut di model Order

        return view('admin.report.sales.show', compact('order'));
        // Anda tidak perlu mengirim 'user' ke view jika 'order' sudah memiliki relasi ke 'user'
        // Anda bisa mengakses user melalui $order->user di view
    }
}
