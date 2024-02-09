@extends('layouts.master')

@section('title', 'E-Kantin')
@section('order')
    {{ $orderCount }}
@endsection
@section('content')
    <style>
        .carousel-item {
            width: 100% !important;
            height: 250px !important;
            object-fit: cover !important;
        }
    </style>


    <!-- Carousel for Foods -->
    <div class="container ">
        <div class="row">
            <div class="col-4">
                <div id="carouselFoods" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        @foreach ($foods as $food)
                            <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                <img class="d-block w-100" src="{{ Storage::url($food->image) }}" alt="{{ $food->name }}">
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Carousel for Drinks -->
            <div class="col-4">

                <div id="carouselDrinks" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        @foreach ($drinks as $drink)
                            <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                <img class="d-block w-100" src="{{ Storage::url($drink->image) }}"
                                    alt="{{ $drink->name }}">
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Carousel for Snacks -->
            <div class="col-4">

                <div id="carouselSnacks" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        @foreach ($snacks as $snack)
                            <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                <img class="d-block w-100" src="{{ Storage::url($snack->image) }}"
                                    alt="{{ $snack->name }}">
                            </div>
                        @endforeach
                    </div>
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
                        <a href="{{ route('drink.index') }}" class="btn btn-primary"> <i
                                class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>

            <!-- Card for Snack -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <h3 class="card-title mb-0">Snack</h3>
                        <a href="{{ route('snack.index') }}" class="btn btn-primary"> <i
                                class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="container mt-4">
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
    </div> --}}

@endsection
@push('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.carousel').carousel({
                interval: 3000 // Waktu pergantian gambar dalam milidetik (3 detik)
            });

            var maxHeight = 0;
            $('.card').each(function() {
                if ($(this).height() > maxHeight) {
                    maxHeight = $(this).height();
                }
            });
            $('.card').height(maxHeight);
        });
    </script>
@endpush
