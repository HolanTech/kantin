@extends('layouts.master')

@section('title', 'E-Kantin')

@section('content')
    <style>
        .custom-carousel .carousel-item {
            height: 300px;
            /* Contoh tinggi, sesuaikan sesuai kebutuhan */
        }

        .custom-carousel .carousel-item img {
            height: 100%;
            object-fit: cover;
            /* Ini akan menjaga rasio aspek gambar */
        }
    </style>

    <div class="container">
        <div id="carouselExampleIndicators" class="carousel slide custom-carousel" data-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="d-block w-100" src="{{ asset('img/menu3.png') }}" alt="First slide">
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="{{ asset('img/menu1.png') }}" alt="Second slide">
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="{{ asset('img/menu2.png') }}" alt="Third slide">
                </div>
            </div>
        </div>
    </div>
    <div class="container mt-4">
        <div class="row">
            <!-- Card for Food -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <h3 class="card-title mb-0">Food</h3>
                        <a href="{{ route('food.index') }}" class="btn btn-primary"> <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>

            <!-- Card for Drink -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <h3 class="card-title mb-0">Drink</h3>
                        <a href="{{ route('drink.index') }}" class="btn btn-primary"> <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>

            <!-- Card for Snack -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <h3 class="card-title mb-0">Snack</h3>
                        <a href="{{ route('snack.index') }}" class="btn btn-primary"> <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container mt-4">
        <div class="row">
            <!-- Tombol untuk Menampilkan Modal -->
            <div class="col-md-12 text-center">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#customModal">
                    Tampilkan Modal
                </button>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="customModal" tabindex="-1" role="dialog" aria-labelledby="customModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="customModalLabel">Custom Modal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Isi modal sesuai kebutuhan Anda -->
                    <p>Isi modal disini...</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.carousel').carousel({
                interval: 3000 // Waktu pergantian gambar dalam milidetik (3 detik)
            });
        });
    </script>
@endpush
