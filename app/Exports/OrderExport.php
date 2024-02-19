<?php

namespace App\Exports; // Pastikan namespace ini sesuai dengan lokasi file Anda

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\Exportable;
use App\Models\Order;

class OrderExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithEvents
{
    use Exportable;

    protected $request;
    private $rowNumber = 0; // Tambahkan properti untuk nomor baris
    private $totalOrder = 0; // Menyimpan total biaya admin
    public function __construct($request)
    {
        $this->request = $request;
    }

    public function query()
    {
        $query = order::query()->orderBy('tanggal', 'asc');
        // Filter berdasarkan user jika user_id diberikan dan tidak sama dengan 'all'
        if ($this->request->filled('user') && $this->request->user != '') {
            $query->whereHas('user', function ($q) {
                $q->where('rfid', $this->request->user);
            });
        }

        // Filter berdasarkan bulan jika bulan diberikan dan tidak sama dengan 'all'
        if ($this->request->filled('bulan') && $this->request->bulan != '') {
            $monthNum = date('m', strtotime($this->request->bulan . " 1 2021"));
            $year = now()->year; // Menggunakan tahun saat ini
            $query->whereMonth('created_at', '=', $monthNum)->whereYear('created_at', '=', $year);
        }

        // Filter berdasarkan rentang tanggal jika tanggal diberikan
        if ($this->request->filled('date_start') && $this->request->filled('date_end')) {
            $startDate = $this->request->date_start;
            $endDate = $this->request->date_end;
            $query->whereBetween('created_at', [$startDate . " 00:00:00", $endDate . " 23:59:59"]);
        }
        return $query;
    }

    public function headings(): array
    {
        return [
            'No',
            'Tanggal',
            'User ID',
            'Nama',
            'Total Order',
            // Sesuaikan dengan kebutuhan Anda
        ];
    }

    public function map($order): array
    {
        $this->rowNumber++; // Increment nomor baris setiap kali map dipanggil
        $this->totalOrder += $order->total_order; // Menambahkan admin ke total
        return [
            $this->rowNumber,
            $order->tanggal,
            $order->user->rfid ?? 'N/A', // Pastikan relasi dengan user tersedia
            $order->user->name ?? 'N/A', // Pastikan relasi dengan user tersedia
            $order->total_order,


            // Sesuaikan dengan struktur data Anda
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $row = $event->sheet->getHighestRow();
                $event->sheet->setCellValue('D' . ($row + 1), "Total");
                $event->sheet->setCellValue('E' . ($row + 1), $this->totalOrder);
            },
        ];
    }
}
