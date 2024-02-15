@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-12">
            <h3>Daftar Top-up dan Penerimaan </h3>
        </div>
        <div class="col-3">
            <a href="{{ route('topup.index') }}" class="btn btn-primary">Kembali</a>
        </div>
    </div>

    <div class="table-responsive mt-4">
        <table id="datatable" class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Nama</th>
                    <th scope="col">RFID</th>
                    <th scope="col">Tanggal</th>
                    <th scope="col">Jumlah</th>
                    <th scope="col">Biaya admin</th>
                    <th scope="col">Payment</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($topups as $topup)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $topup->user->name }}</td>
                        <td>{{ $topup->rfid }}</td>
                        <td>{{ \Carbon\Carbon::parse($topup->tanggal)->format('d-m-Y') }}</td>
                        <td>Rp {{ number_format($topup->debet, 2, ',', '.') }}</td>
                        <td>Rp {{ number_format($topup->admin, 2, ',', '.') }}</td>
                        <td>{{ $topup->payment }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">Tidak ada data top-up.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="col-12">
        <small>Note: cash = top-up user</small><br>
        <small>saldo = penerimaan kantin</small>
    </div>
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
