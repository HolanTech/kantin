@extends('layouts.master')

@section('title', 'Semua Order')

@section('head')
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <!-- DataTables Responsive CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css">
@endsection

@section('content')
    <style>
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
    </style>
    <div class="container mt-2">
        <div class="table-responsive mt-4">
            <table id="datatable" class="table table-striped table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>Tanggal</th>
                        <th>Nama</th>
                        <th>Total Order</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($order as $d)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($d->tanggal)->format('d-m-Y') }}</td>
                            <td>{{ $d->user->name }}</td>
                            <td>Rp.{{ number_format($d->total_order, 0) }}</td>
                            <td>
                                <a href="{{ route('order.show', $d->id) }}" class="btn btn-info btn-sm" title="Detail">
                                    <i class="fas fa-print"></i>
                                </a>
                                {{-- <form action="{{ route('order.destroy', $d->id) }}" method="POST"
                                style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" title="Hapus"
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus order ini?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form> --}}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">Tidak ada data order.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="d-flex justify-content-between mb-3">
        <a href="{{ route('order.create') }}" class="btn btn-primary rounded-circle" id="fab" title="Tambah Order">
            <i class="fas fa-plus"></i>
        </a>
    </div>

@endsection

@section('scripts')
    <!-- DataTables JavaScript -->
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#datatable').DataTable();
        });
    </script>
@endsection
