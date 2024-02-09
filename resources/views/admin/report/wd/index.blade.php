@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-12 mt-3">
            <div class="card">
                <div class="card-header bg-primary d-flex justify-content-center text-white">
                    <h3 class="card-title mb-0">Filter Transaksi</h3>
                </div>
                <div class="card-body">
                    <form id="filterForm" action="{{ route('wd.filter') }}" method="GET">
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="user">Pilih user:</label>
                                <select name="user" id="user" class="form-control select2">
                                    <option value="">Semua</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->rfid }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="bulan">Pilih Bulan:</label>
                                <select name="bulan" id="bulan" class="form-control select2">
                                    <option value="">Semua</option>
                                    <option value="jan">Januari</option>
                                    <option value="feb">Februari</option> <!-- Koreksi typo 'Februai' -->
                                    <option value="mar">Maret</option>
                                    <option value="apr">April</option>
                                    <option value="mei">Mei</option>
                                    <option value="jun">Juni</option>
                                    <option value="jul">Juli</option>
                                    <option value="agt">Agustus</option>
                                    <option value="sep">September</option>
                                    <option value="okt">Oktober</option>
                                    <option value="nov">November</option>
                                    <option value="des">Desember</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Tanggal Awal & Akhir :</label>
                                <div class="input-group">
                                    <input type="date" name="date_start" class="form-control" placeholder="Mulai">
                                    <input type="date" name="date_end" class="form-control" placeholder="Sampai">
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center mt-3">
                            <button type="submit" class="btn btn-primary w-25 mx-2">Tampilkan</button>
                            <button id="downloadButton" type="button" class="btn btn-success w-25 mx-2">Download</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('script')
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                theme: 'bootstrap4'
            })
        });
        document.addEventListener("DOMContentLoaded", function() {
            $('#downloadButton').click(function(e) {
                e.preventDefault();
                var form = $('#filterForm');
                var actionUrl = form.attr('action');
                var data = form.serialize(); // Mengumpulkan data
                var baseUrl = "{{ route('wd.print') }}";
                var downloadUrl = baseUrl + "?" + data; // Membangun URL
                window.location.href = downloadUrl; // Mengarahkan user ke URL untuk download
            });
        });
    </script>
@endpush
