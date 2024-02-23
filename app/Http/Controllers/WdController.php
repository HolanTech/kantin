<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Wd;
use App\Models\User;
use App\Models\Order;
use App\Exports\WdExport;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class WdController extends Controller
{
    public function index()
    {
        $users = User::with('wd')->where('id', '!=', 1)->get();

        return view('admin.report.wd.index', compact('users'));
    }

    public function filter(Request $request)
    {
        $query = Wd::query(); // Mulai dengan query dasar

        // Filter berdasarkan user jika user_id diberikan dan tidak sama dengan 'all'
        if ($request->filled('rfid')) {
            $query->where('rfid', $request->rfid);
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

        $wds = $query->orderBy('tanggal', 'desc')->get(); // Eksekusi query

        return view('admin.report.wd.showall', compact('wds')); // Pastikan view Anda sesuai
    }
    public function print(Request $request)
    {
        // dd($request->all());
        $query = Wd::query();

        // Filter berdasarkan user jika user_id diberikan dan tidak sama dengan 'all'
        if ($request->filled('rfid')) {
            $query->where('rfid', $request->rfid);
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
        $totalAdmin = $orders->sum('admin');
        $totalOrder = $orders->sum('kredit');

        $pdf = PDF::loadView('admin.report.wd.print', compact('orders', 'totalOrder', 'totalAdmin'));

        // Pastikan direktori penyimpanan tersedia dan memiliki izin yang sesuai
        return $pdf->download('laporan-transaksi.pdf');
    }
    public function exportExcel(Request $request)
    {
        return Excel::download(new WdExport($request), 'laporan-penarikan.xlsx');
    }
}
