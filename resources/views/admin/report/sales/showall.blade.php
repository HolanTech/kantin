@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-12">
            <h3>Daftar Transaksi</h3>
        </div>
        <div class="col-3">
            <a href="{{ route('sales.report') }}" class="btn btn-primary">Kembali</a>
        </div>
    </div>

    <div class="table-responsive mt-4">
        <table id="datatable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Nama</th>
                    <th scope="col">RFID</th>
                    <th scope="col">Tanggal</th>
                    <th scope="col">Jumlah</th>
                    <th scope="col">Detail</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($saless as $sales)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $sales->user->name }}</td>
                        <td>{{ $sales->rfid }}</td>
                        <td>{{ \Carbon\Carbon::parse($sales->tanggal)->format('d-m-Y') }}</td>
                        <td>Rp {{ number_format($sales->total_order, 2, ',', '.') }}</td>
                        <td>
                            <a href="{{ route('sales.detail', $sales->id) }}" class="btn btn-info btn-sm" title="Detail">
                                <i class="fas fa-print"></i>
                            </a>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="6">Tidak ada data top-up.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <h3>Sumery Transaksi</h3>
    <ul>

        <table>
            <thead>
                <tr>
                    <th>Total transaksi</th>
                    <th> : </th>
                    <th>{{ $total }}</th>

                </tr>
                <tr>
                    <th>Total Pembeli</th>
                    <th> : </th>
                    <th> {{ $user }}</th>
                </tr>
                <tr>
                    <th>Total Pendaptan</th>
                    <th> : </th>
                    <td>Rp {{ number_format($pendapatan, 2, ',', '.') }}</td>


                </tr>
                <tr>
                    <th>Nama Item</th>
                    <th> </th>
                    <th>Total Kuantitas</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($items as $item)
                    <tr>
                        <td>{{ $item['nama_item'] }}</td>
                        <th> : </th>
                        <td>{{ $item['total_kuantitas'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>


    </ul>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            $('#datatable').DataTable(); // Pastikan ID ini sesuai dengan ID tabel Anda
        });

        // $(document).ready(function() {
        //     $('#datatable').DataTable({
        //         "responsive": true,
        //         "lengthChange": false,
        //         "autoWidth": false,
        //         "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        //     }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        // });
    </script>
@endpush
