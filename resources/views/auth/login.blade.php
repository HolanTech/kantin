@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center">
                        <img style="width: 100px;" src="{{ asset('img/login.png') }}" alt="">
                        <br>{{ __('E Kantin') }}
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="row mb-3">
                                <label for="login"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Email or Username') }}</label>

                                <div class="col-md-6">
                                    <input id="login" type="text"
                                        class="form-control @error('login') is-invalid @enderror" name="login"
                                        value="{{ old('login') }}" required autocomplete="login" autofocus>

                                    @error('login')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="current-password" value="123456">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6 offset-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                            {{ old('remember') ? 'checked' : '' }}>

                                        <label class="form-check-label" for="remember">
                                            {{ __('Remember Me') }}
                                        </label>
                                    </div>
                                </div>
                            </div>


                            <!-- Input fields and other form elements -->

                            <div class="form-group row mb-0">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary w-100">{{ __('Login') }}</button>
                                </div>
                            </div>

                            <div class="form-group row mt-2">
                                <div class="col-md-6 col-sm-3">
                                    @if (Route::has('password.request'))
                                        <a class="btn btn-link pl-0" href="{{ route('password.request') }}">
                                            {{ __('Lupa Password?') }}
                                        </a>
                                    @endif
                                </div>

                                <div class="col-md-6 col-sm-3 text-right">
                                    @if (Route::has('register'))
                                        <a class="btn btn-link pr-0"
                                            href="{{ route('register') }}">{{ __('Register') }}</a>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
