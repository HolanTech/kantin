<?php

namespace App\Http\Controllers;

use App\Models\Wd;
use App\Models\User;
use App\Models\Order;
use App\Models\Saldo;
use App\Models\Topup;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $users = User::where('role', 'pengguna')->count();
        $canteens = User::where('role', 'pengelola')->count();
        $sales = Order::whereDate('created_at', Carbon::today())->count();
        $topup = Topup::whereDate('created_at', Carbon::today())->count();

        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();
        $daysInMonth = $endOfMonth->day;

        $transactions = Order::with('user')->select([
            DB::raw('DATE(created_at) as date'),
            'kantin_id',
            DB::raw('COUNT(*) as total_transactions'),
            DB::raw('SUM(total_order) as total_income')
        ])
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->groupBy('date', 'kantin_id')
            ->get();

        // Inisialisasi array untuk menyimpan data per kantin
        $dataPerKantin = [];

        // Inisialisasi struktur data untuk setiap hari dalam bulan
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $dateKey = Carbon::createFromDate($startOfMonth->year, $startOfMonth->month, $day)->format('Y-m-d');
            foreach ($transactions as $transaction) {
                if ($transaction->date === $dateKey) {
                    $kantinName = $transaction->user ? $transaction->user->name : 'Unknown';
                    if (!isset($dataPerKantin[$kantinName])) {
                        $dataPerKantin[$kantinName] = ['transactions' => [], 'income' => []];
                    }
                    $dataPerKantin[$kantinName]['transactions'][$dateKey] = $transaction->total_transactions;
                    $dataPerKantin[$kantinName]['income'][$dateKey] = $transaction->total_income;
                }
            }
        }

        // Pastikan setiap kantin memiliki entri untuk setiap hari dalam bulan, bahkan jika tidak ada transaksi
        foreach ($dataPerKantin as $kantinName => &$data) {
            for ($day = 1; $day <= $daysInMonth; $day++) {
                $dateKey = Carbon::createFromDate($startOfMonth->year, $startOfMonth->month, $day)->format('Y-m-d');
                if (!isset($data['transactions'][$dateKey])) {
                    $data['transactions'][$dateKey] = 0;
                    $data['income'][$dateKey] = 0;
                }
            }
        }
        $currentYear = Carbon::now()->year;
        $dataPerBulanPerKantin = [];

        for ($month = 1; $month <= 12; $month++) {
            $startOfMonth = Carbon::createFromDate($currentYear, $month, 1)->startOfMonth();
            $endOfMonth = Carbon::createFromDate($currentYear, $month, 1)->endOfMonth();

            $monthlyTransactions = Order::with('user')
                ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                ->selectRaw('kantin_id, SUM(total_order) as total_income, COUNT(*) as total_transactions')
                ->groupBy('kantin_id')
                ->get();

            foreach ($monthlyTransactions as $transaction) {
                $kantinName = $transaction->user ? $transaction->user->name : 'Unknown';

                if (!isset($dataPerBulanPerKantin[$kantinName])) {
                    $dataPerBulanPerKantin[$kantinName] = array_fill(1, 12, ['total_income' => 0, 'total_transactions' => 0]);
                }

                $dataPerBulanPerKantin[$kantinName][$month]['total_income'] = $transaction->total_income;
                $dataPerBulanPerKantin[$kantinName][$month]['total_transactions'] = $transaction->total_transactions;
            }
        }

        $topupbulanan = Topup::with('user')
            ->selectRaw('rfid, SUM(debet) as total_debet')
            ->where('payment', '!=', 'saldo')
            // Tambahkan kondisi untuk membatasi hasil ke bulan ini
            ->whereBetween('tanggal', [Carbon::now()->startOfMonth(), Carbon::now()])
            ->groupBy('rfid')
            ->get();
        $wdbulanan = Wd::with('user')
            ->selectRaw('rfid, SUM(kredit) as total_kredit')
            ->where('payment', '!=', 'saldo')
            // Tambahkan kondisi untuk membatasi hasil ke bulan ini
            ->whereBetween('tanggal', [Carbon::now()->startOfMonth(), Carbon::now()])
            ->groupBy('rfid')
            ->get();

        // dd($topupbulanan);

        return view('admin.dashboard', [
            'users' => $users,
            'canteens' => $canteens,
            'sales' => $sales,
            'topup' => $topup,
            'dataPerKantin' => $dataPerKantin,
            'dataPerBulanPerKantin' => $dataPerBulanPerKantin,
            'topupbulanan' => $topupbulanan,
            'wdbulanan' => $wdbulanan
        ]);
    }




    public function user()
    {
        $users = User::with('saldos')
            ->where('role', 'pengguna')->get();

        return view('admin.user.index', compact('users'));
    }

    public function topup()
    {
        $users = User::where('role', 'pengguna')->get();

        return view('admin.user.topup', compact('users'));
    }



    public function topupstore(Request $request)
    {
        // Validasi request
        $request->validate([
            'rfidInputTopUp' => 'required',
            'nominalInput' => 'required|numeric',
            'admin' => 'required|numeric',
            'paymentMethod' => 'required|in:cash,debit',
        ]);

        // Cari saldo berdasarkan RFID
        $saldo = Saldo::where('rfid', $request->rfidInputTopUp)->first();
        $saldoAkhir = ($saldo ? $saldo->saldo : 0) + $request->nominalInput;
        if ($saldoAkhir > 250000) {
            // Jika melebihi, kembalikan dengan pesan kesalahan
            return back()->with('error', 'Pengisian saldo tidak boleh terlalu banyak. Anda hanya bisa menyimpan saldo maksimal Rp250.000 di dalam akun.');
        }
        if ($saldo) {
            // Jika saldo ada, tambahkan saldo baru
            $saldo->saldo += $request->nominalInput;
        } else {
            // Jika saldo tidak ada, buat saldo baru
            $saldo = new Saldo();
            $saldo->rfid = $request->rfidInputTopUp;
            $saldo->saldo = $request->nominalInput;
        }

        // Simpan data ke database
        $saldo->save();

        // Perbarui saldo jika metode pembayaran adalah 'cash'
        if ($request->paymentMethod == 'cash') {
            Topup::create([
                'tanggal' => now()->toDateString(),
                'rfid' => $request->rfidInputTopUp,
                'admin' => $request->admin,
                'debet' => $request->nominalInput,
                'kredit' => '0',
                'payment' => 'cash',
            ]);
        } elseif ($request->paymentMethod == 'debit') { // Perbaikan typo 'debet' menjadi 'debit'
            // Logika untuk debit, perhatikan perubahan dari 'debet' menjadi 'debit'
            Topup::create([
                'tanggal' => now()->toDateString(),
                'rfid' => $request->rfidInputTopUp,
                'admin' => $request->admin,
                'debet' => $request->nominalInput, // Pertimbangkan untuk mengganti nama kolom menjadi lebih netral jika debit dan kredit adalah tipe transaksi
                'kredit' => '0',
                'payment' => 'debit', // Sesuaikan dengan nilai yang benar
            ]);
        }

        // Redirect atau berikan respon sesuai kebutuhan
        return redirect()->back()->with('success', 'Top-Up berhasil dilakukan. Saldo Anda sekarang: ' . $saldo->saldo);
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



    public function canteen()
    {
        $canteens = User::with('saldos')
            ->where('role', 'pengelola')->get();
        return view('admin.canteen.index', compact('canteens'));
    }

    public function wd()
    {
        $canteens = User::where('role', 'pengelola')->get();

        return view('admin.canteen.wd', compact('canteens'));
    }

    public function wdstore(Request $request)
    {
        // Validasi request
        $request->validate([
            'rfidInput' => 'required',
            'nominalInput' => 'required|numeric|min:0', // Pastikan nominal positif
            'admin' => 'required|numeric|min:0', // Pastikan admin positif
            'paymentMethod' => 'required|in:cash,debit',
        ]);

        // Cari saldo berdasarkan RFID
        $saldo = Saldo::where('rfid', $request->rfidInput)->first();
        if (!$saldo) {
            // Jika saldo tidak ada, kembalikan dengan pesan kesalahan
            return back()->with('error', 'Saldo tidak ditemukan.');
        }

        // Hitung saldo akhir setelah pengurangan
        $saldoAkhir = $saldo->saldo - ($request->nominalInput + $request->admin);
        if ($saldoAkhir < 0) {
            // Jika saldo akhir negatif, kembalikan dengan pesan kesalahan
            return back()->with('error', 'Saldo Anda tidak mencukupi untuk pengambilan nominal tersebut.');
        }

        // Kurangi saldo
        $saldo->saldo = $saldoAkhir;
        // Simpan perubahan ke database
        $saldo->save();
        Wd::create([
            'tanggal' => now()->toDateString(),
            'rfid' => $request->rfidInput,
            'kredit' => $request->nominalInput - $request->admin,
            'admin' => $request->admin,
            'debet' => '0',
            'payment' => $request->paymentMethod,
        ]);
        // Tidak perlu logika untuk 'cash' karena ini adalah operasi WD

        // Redirect atau berikan respon sesuai kebutuhan
        return redirect()->back()->with('success', 'WD sebesar :Rp. ' . $request->nominalInput . '   berhasil dilakukan. Saldo Anda sekarang: ' . $saldo->saldo);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
