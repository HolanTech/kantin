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
    <h3 style="text-align: center;">Daftar Top-up dan Penerimaan</h3>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">Tanggal</th>
                <th scope="col">Nama</th>
                <th scope="col">RFID</th>
                <th scope="col">Biaya Admin</th>
                <th scope="col">Jumlah</th>
                <th scope="col">Metode</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ \Carbon\Carbon::parse($order->tanggal)->format('d-m-Y') }}</td>
                    <td>{{ $order->user->name }}</td>
                    <td>{{ $order->rfid }}</td>
                    <td>Rp {{ number_format($order->admin, 2, ',', '.') }}</td>
                    <td>Rp {{ number_format($order->debet, 2, ',', '.') }}</td>
                    <td>{{ $order->payment }}</td>

                </tr>
            @endforeach
            <tr>
                <td colspan="4" style="text-align: right;"><strong>Total:</strong></td>
                <td><strong>Rp {{ number_format($totalAdmin, 2, ',', '.') }}</strong></td>
                <td><strong>Rp {{ number_format($totalOrder, 2, ',', '.') }}</strong></td>
                <td></td>
            </tr>
        </tbody>
    </table>
</body>

</html>
