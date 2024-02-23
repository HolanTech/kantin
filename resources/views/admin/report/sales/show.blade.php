<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Transaksi</title>
    <style>
        @media screen {
            body {
                font-family: 'Arial', sans-serif;
                margin: 0;
                font-size: 12px;
                padding: 20px;
            }

            #fab {
                position: fixed;
                bottom: 5%;
                right: 20px;
                width: 60px;
                height: 60px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                z-index: 1500;
            }
        }

        @media print {


            body,
            html {
                width: 80mm;
                /* Sesuaikan dengan lebar kertas Anda */
                font-family: 'Arial', sans-serif;
                margin: 0;
                font-size: 10px;
                /* Ukuran font yang lebih kecil untuk cetakan */
            }

            .container {
                padding: 5mm;
            }

            #fab {
                display: none;

                /* Sembunyikan tombol saat mencetak */
            }

            table,
            th,
            td {
                border: 1px solid black;
                border-collapse: collapse;
                width: 100%;
                font-size: 10px;
                /* Ukuran font kecil untuk tabel */
            }

            th,
            td {
                padding: 2px;
                /* Padding lebih kecil */
                text-align: left;
            }
        }

        #fab {
            position: fixed;
            bottom: 5%;
            left: 20px;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1500;
            text-decoration: none;
        }

        img {
            position: absolute;
            right: 5%;
            top: 5%;
            width: 50px;
            height: 40px;
        }
    </style>
</head>

<body>
    <a href="{{ route('sales.report') }}" id="fab" class="btn btn-primary">Kembali</a>

    <div class="container">
        <img src="{{ asset('assets/dist/img/logo.png') }}" alt="">
        <h2>Detail Transaksi</h2>

        <h3><strong>{{ $kantinOwner->name }}</strong></h3>

        <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($order->tanggal)->format('d-m-Y') }}
        </p>
        <p><strong>Nama:</strong> {{ $buyer->name }}</p>
        <p><strong>RFID:</strong> {{ $order->rfid }}</p>
        <p><strong>Total Order:</strong> Rp{{ number_format($order->total_order, 2) }}</p>

        ...................................<span> Detail Pesanan </span>.................................

        <br><br>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Nama Item</th>
                    <th>Jumal</th>
                    <th>Harga per-item</th>
                    <th>Total Harga</th>
                </tr>
            </thead>
            <tbody>
                @php $totalKeseluruhan = 0; @endphp <!-- Inisialisasi variabel di sini -->
                @foreach ($order->details as $detail)
                    <tr>
                        <td>{{ $detail->nama_item }}</td>
                        <td>{{ $detail->kuantitas }}</td>
                        <td>Rp{{ number_format($detail->harga_per_unit, 2) }}</td>
                        <td>Rp{{ number_format($detail->kuantitas * $detail->harga_per_unit, 2) }}</td>
                        @php $totalKeseluruhan += $detail->kuantitas * $detail->harga_per_unit; @endphp <!-- Update total -->
                    </tr>
                @endforeach
                <tr>
                    <td colspan="3" class="text-right"><strong>Total Keseluruhan:</strong></td>
                    <td>Rp{{ number_format($totalKeseluruhan, 2) }}</td>
                </tr>
            </tbody>
        </table>
        <br>
        <br>
        ......................................... <span>Lunas</span> ..........................................


        <div style="margin-top: 20px;">
            <p><strong>Saldo Awal:</strong> Rp{{ number_format($order->saldo_awal, 2) }}</p>
            <p><strong>Saldo Akhir:</strong> Rp{{ number_format($order->saldo_akhir, 2) }}</p>
        </div>
    </div>

    <script>
        // Jika Anda ingin langsung mencetak halaman setelah dimuat
        window.onload = function() {
            window.print();
        }
    </script>
</body>

</html>
