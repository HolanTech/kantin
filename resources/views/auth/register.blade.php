@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Register') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="row mb-3">
                                <label for="name"
                                    class="col-md-4 col-form-label text-md-start">{{ __('Full Name') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text"
                                        class="form-control @error('name') is-invalid @enderror" name="name"
                                        value="{{ old('name') }}" required autofocus>

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="rfid"
                                    class="col-md-4 col-form-label text-md-start">{{ __('RFID') }}</label>

                                <div class="col-md-6">
                                    <input id="rfid" type="text"
                                        class="form-control @error('rfid') is-invalid @enderror" name="rfid"
                                        value="{{ old('rfid') }}" required autofocus>

                                    @error('rfid')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="no_hp"
                                    class="col-md-4 col-form-label text-md-start">{{ __('Phone number') }}</label>

                                <div class="col-md-6">
                                    <input id="no_hp" type="text"
                                        class="form-control @error('no_hp') is-invalid @enderror" name="no_hp"
                                        value="{{ old('no_hp') }}" required autofocus>

                                    @error('no_hp')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="password"
                                    class="col-md-4 col-form-label text-md-start">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <div class="input-group">
                                        <input id="password" type="password"
                                            class="form-control @error('password') is-invalid @enderror" name="password"
                                            required>
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary" type="button" id="togglePassword"
                                                style="border-top-right-radius: .25rem; border-bottom-right-radius: .25rem;"><ion-icon
                                                    name="eye-outline"></ion-icon></button>
                                        </div>
                                    </div>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>


                            <div class="row mb-3">
                                <label for="no_hp"
                                    class="col-md-4 col-form-label text-md-start">{{ __('Register as') }}</label>
                                <div class="col-md-6">
                                    <select name="role" id="role" class="form-control select2" required autofocus>

                                        <option value="pengguna">User</option>
                                        <option value="pengelola">Canteen</option>
                                    </select>
                                    @error('no_hp')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Register') }}
                                    </button>
                                </div>
                                @if (Route::has('login'))
                                    <span>Already have an account?<a class="btn btn-link"
                                            href="{{ route('login') }}">{{ __('Login') }}</a></span>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            $('.select2').select2();

            $('#togglePassword').click(function() {
                const password = $('#password');
                const type = password.attr('type') === 'password' ? 'text' : 'password';
                password.attr('type', type);
                // Mengganti ikon berdasarkan kondisi
                $(this).find('svg').toggleClass(
                    '<ion-icon name="eye-off-outline"></ion-icon>'
                );
            });
        });
    </script>
@endpush
