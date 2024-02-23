<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Transaksi</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        .table th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <h2 style="text-align: center;">Laporan Transaksi</h2>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">Tanggal</th>
                <th scope="col">Nama Kantin</th>
                <th scope="col">RFID</th>
                <th scope="col">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ \Carbon\Carbon::parse($order->tanggal)->format('d-m-Y') }}</td>
                    <td>{{ $order->user->name }}</td>
                    <td>{{ $order->rfid }}</td>
                    <td>Rp {{ number_format($order->total_order, 2, ',', '.') }}</td>

                </tr>
            @endforeach
            <tr>
                <td colspan="4" style="text-align: right;"><strong>Total:</strong></td>
                <td><strong>Rp {{ number_format($totalOrder, 2, ',', '.') }}</strong></td>
            </tr>
        </tbody>
    </table>
    <style>
        .summary-container {
            font-family: Arial, sans-serif;
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .summary-container h3 {
            color: #333;
            text-align: center;
        }

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        th,
        td {
            text-align: left;
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }

        /* th {
            background-color: #f2f2f2;
        }

        tbody tr:hover {
            background-color: #f5f5f5;
        } */
    </style>
    <div class="summary-container">
        <h3>Summary Transaksi</h3>
        <table>
            <thead>
                <tr>
                    <th>Total Transaksi</th>
                    <th>:</th>
                    <td>{{ $total }}</td>
                </tr>
                <tr>
                    <th>Total Pembeli</th>
                    <th>:</th>
                    <td>{{ $user }}</td>
                </tr>
                <tr>
                    <th>Total Pendapatan</th>
                    <th>:</th>
                    <td>Rp {{ number_format($pendapatan, 2, ',', '.') }}</td>
                </tr>
            </thead>
        </table>
        <table>
            <thead>
                <tr>
                    <th>Nama Item</th>
                    <th>Total Kuantitas</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $item)
                    <tr>
                        <td>{{ $item['nama_item'] }}</td>
                        <td>{{ $item['total_kuantitas'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</body>

</html>
