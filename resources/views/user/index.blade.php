@extends('layouts.master')

@section('title', 'Profile')

@section('content')
    <style>
        .img {
            border-radius: 50%;
            width: 100%
        }

        a {
            text-decoration: none;
        }
    </style>
    <div class="container mt-4">
        <div class="row">
            <div class="col-3">
                {{-- Bagian Avatar atau Foto Profil --}}
                <img class="img" src="{{ asset('img/avatar.png') }}" alt="Profile Picture" class="img-thumbnail">
            </div>
            <div class="col-8">
                {{-- Informasi Profil --}}
                <h4>{{ Auth::user()->name }}</h4>
                <p>{{ Auth::user()->email }}</p>
                <p>{{ Auth::user()->no_hp }}</p>
                {{-- Tambahkan informasi lain yang relevan --}}
            </div>
        </div>
        <div class="row">
            <ul>
                <li><a href="">Saldo</a></li>
                <li><a href="">Edit</a></li>
                <li>
                    <a class="btn btn-link pr-0" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>
    </div>
@endsection
