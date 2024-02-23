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
    <div class="col-12 mt-3 mb-3">
        <div class="p-3" style="background-color: #f8f9fa; border-radius: 5px; border: 1px solid #e9ecef;">
            <h6 class="font-weight-bold text-uppercase">Notes:</h6>
            <ul class="list-unstyled">
                <li><small><strong>Cash:</strong> Top-up user</small></li>
                <li><small><strong>Saldo:</strong> Penerimaan kantin</small></li>
            </ul>
        </div>
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
