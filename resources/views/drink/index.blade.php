@extends('layouts.master')

@section('title', 'Drinks')

@section('content')
    <style>
        .card {
            border-top-left-radius: 50px;
            /* Radius lengkung untuk sudut kiri atas */
            border-bottom-right-radius: 50px;
            /* Radius lengkung untuk sudut kanan atas */

        }

        #fab {
            position: fixed;
            bottom: 70px;
            right: 20px;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            font-size: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }

        .card-equal-height {
            display: flex;
            flex-wrap: wrap;

        }

        .card-equal-height .card {
            flex: 1 0 auto;
            display: flex;
            flex-direction: column;
        }

        .card-img-top {
            width: 100%;
            /* Membuat gambar penuh lebar card */
            /* height: 45%; */
            height: 150px;
            /* Tentukan tinggi tetap */
            justify-content: center;
            object-fit: cover;
            /* Pastikan gambar tetap proporsional */
        }

        .card-title {
            font-size: 14px;
            font-weight: bold;
        }

        .card-text {
            font-size: 12px;

        }

        .button {
            display: flex;
            justify-content: space-between;
            /* margin-top: auto; */
            /* Membuat tombol tetap di bagian bawah */
        }
    </style>

    <div class="content">
        <a href="{{ route('drink.create') }}" class="btn btn-primary rounded-circle" id="fab">
            <i class="fas fa-plus"></i>
        </a>
        <div class="row card-equal-height">
            @foreach ($drinks as $drink)
                <div class="col-6">
                    <div class="card d-flex flex-column">
                        <img class="card-img-top" src="{{ Storage::url($drink->image) }}" alt="{{ $drink->name }}">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $drink->name }}</h5>
                            <p class="card-text">{{ Str::limit($drink->description, 100) }}</p>
                            <p class="card-text">Rp. {{ number_format($drink->price, 2, ',', '.') }}</p>
                            <div class="button">

                                <!-- Tombol Status -->
                                <button id="statusBtn{{ $drink->id }}"
                                    class="btn btn-{{ $drink->status == 'ready' ? 'success' : 'danger' }}"
                                    onclick="updateStatus({{ $drink->id }})">
                                    @if ($drink->status == 'ready')
                                        <i class="fas fa-check"></i>
                                    @else
                                        <i class="fas fa-times"></i>
                                    @endif
                                </button>
                                <a href="{{ route('drink.edit', $drink->id) }}" class="btn btn-primary">Edit</a>

                                <!-- Tombol Hapus -->
                                <form action="{{ route('drink.destroy', $drink->id) }}" method="POST"
                                    onsubmit="return confirm('Are you sure?');" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>

@endsection
@push('script')
    <script>
        function updateStatus(drinkId) {
            $.ajax({
                type: "POST",
                url: '{{ url('/update-drink-status/') }}' + '/' + drinkId, // Perbaiki URL sesuai route
                data: {
                    _token: '{{ csrf_token() }}',
                    // id: drinkId, // Ini tidak perlu karena `id` sudah ada di URL
                },
                success: function(data) {
                    // Perbarui tampilan tombol status
                    var statusBtn = $('#statusBtn' + drinkId);
                    if (data.status == 'ready') {
                        statusBtn.removeClass('btn-danger').addClass('btn-success');
                        statusBtn.html('<i class="fas fa-check"></i>');
                    } else {
                        statusBtn.removeClass('btn-success').addClass('btn-danger');
                        statusBtn.html('<i class="fas fa-times"></i>');
                    }
                },
                error: function(error) {
                    console.log('Error:', error);
                }
            });
        }
        $(document).ready(function() {
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
