<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Topup;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class TopupController extends Controller
{
    public function index()
    {
        $users = User::with('topup')->where('id', '!=', 1)->get();

        return view('admin.report.topup.index', compact('users'));
    }

    public function filter(Request $request)
    {
        $query = Topup::query(); // Mulai dengan query dasar

        // Filter berdasarkan user jika user_id diberikan dan tidak sama dengan 'all'
        if ($request->filled('user')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('rfid', $request->user);
            });
        }

        // // Filter berdasarkan kantin jika kantin_id diberikan dan tidak sama dengan 'all'
        // if ($request->filled('kantin_id')) {
        //     $query->where('kantin_id', $request->kantin_id);
        // }

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

        $topups = $query->get(); // Eksekusi query

        return view('admin.report.topup.showall', compact('topups')); // Pastikan view Anda sesuai
    }
    public function print(Request $request)
    {
        // dd($request->all());
        $query = Topup::query();

        // Filter berdasarkan user jika user_id diberikan dan tidak sama dengan 'all'
        if ($request->filled('user') && $request->user != '') {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('rfid', $request->user);
            });
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

        $orders = $query->get();
        // Menghitung total dari semua total_order
        $totalOrder = $orders->sum('debet');

        $pdf = PDF::loadView('admin.report.topup.print', compact('orders', 'totalOrder'));

        // Pastikan direktori penyimpanan tersedia dan memiliki izin yang sesuai
        return $pdf->download('laporan-topup.pdf');
    }
}
