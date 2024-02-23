@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-12">
            <h3>Laporan Penarikan Dana</h3>
        </div>
        <div class="col-3">
            <a href="{{ route('wd.index') }}" class="btn btn-primary">Kembali</a>
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
                @forelse ($wds as $wd)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $wd->user->name }}</td>
                        <td>{{ $wd->rfid }}</td>
                        <td>{{ \Carbon\Carbon::parse($wd->tanggal)->format('d-m-Y') }}</td>
                        <td>Rp {{ number_format($wd->kredit, 2, ',', '.') }}</td>
                        <td>Rp {{ number_format($wd->admin, 2, ',', '.') }}</td>
                        <td>{{ $wd->payment }}</td>
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
                <li><small><strong>Cash/Debit:</strong> Penarikan kantin</small></li>
                <li><small><strong>Saldo:</strong> Penerimaan kantin</small></li>
            </ul>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            $('#datatable').DataTable();
        });

        // $(document).ready(function() {
        //     $('#datatable').DataTable({
        //         "responsive": true,
        //         "lengthChange": true,
        //         "autoWidth": true,
        //         "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        //     }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        // });
    </script>
@endpush
