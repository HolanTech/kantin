@extends('layouts.admin')

@section('content')
    <style>
        /* Penambahan CSS untuk vertikal centering */
        .vertical-center {
            display: flex;
            align-items: center;
            /* Ini akan menengahkan item-item flex secara vertikal */
            justify-content: center;
            /* Ini akan menengahkan item-item flex secara horizontal */
        }
    </style>
    <div class="card">
        <div class="card-header bg-primary vertical-center">
            <h3 class="card-title">Canteen Table</h3>
        </div>

        <div class="card-body">
            <a href="{{ route('user.create') }}" class="btn btn-primary">Add User</a>

            <table id="datatable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>RFID</th>
                        <th>Name</th>
                        <th>Phone Number</th>
                        <th>Saldo</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($canteens as $canteen)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $canteen->rfid }}</td>
                            <td>{{ $canteen->name }}</td>
                            <td>{{ $canteen->no_hp }}</td>
                            <td>
                                @if ($canteen->saldos->isNotEmpty())
                                    @foreach ($canteen->saldos as $saldo)
                                        Rp. {{ number_format($saldo->saldo, 2) }}
                                        <br>
                                    @endforeach
                                @else
                                    Rp. 0.00
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('user.edit', $canteen->id) }}" class="btn btn-success">Edit</a>
                                <button type="button" class="btn btn-danger" data-toggle="modal"
                                    data-target="#deleteModal{{ $canteen->id }}">
                                    Delete
                                </button>

                                <!-- Delete Modal -->
                                <div class="modal fade" id="deleteModal{{ $canteen->id }}" tabindex="-1" role="dialog"
                                    aria-labelledby="deleteModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteModalLabel">Delete canteen</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                Are you sure you want to delete this canteen?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Close</button>
                                                <form action="{{ route('user.destroy', $canteen->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Delete Modal -->

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            $('#datatable').DataTable();
        });
    </script>
@endpush
