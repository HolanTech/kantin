@extends('layouts.master')

@section('title', 'Profile')

@section('content')
    <style>
        .profile-img {
            border-radius: 50%;
            max-width: 150px;
            /* Atur lebar maksimum */
            margin: 0 auto;
            /* Pusatkan gambar */
        }

        .profile-info h4 {
            margin-top: 20px;
        }

        .profile-info p {
            color: #666;
            font-size: 16px;
        }

        .profile-links {
            display: flex;
            justify-content: space-around;
            /* Mendistribusikan link secara merata */
            list-style-type: none;
            /* Hapus bullet list */
            padding: 0;
        }

        .profile-links a {
            text-decoration: none;
            color: #007bff;
            /* Warna link */
        }

        .profile-links a:hover {
            text-decoration: underline;
            /* Tambahkan underline saat hover */
        }

        @media (max-width: 768px) {
            .profile-img {
                max-width: 100px;
                /* Lebih kecil pada layar HP */
            }

            /* .profile-links {
                                    flex-direction: column; */
            /* Tumpuk link secara vertikal pada layar kecil */
            /* align-items: center;
                                } */

            /* .profile-links a {
                                        margin: 5px 0;
                                        /* Tambahkan margin vertikal pada link */
            /* } */
            */
        }
    </style>

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-4 text-center">
                {{-- Bagian Avatar atau Foto Profil --}}
                <img class="profile-img img-thumbnail" src="{{ asset('img/login.png') }}" alt="Profile Picture">
            </div>
            <div class="col-md-8 text-center">
                {{-- Informasi Profil --}}
                <div class="profile-info">
                    <h3>{{ Auth::user()->name }}</h3>
                    <p>{{ Auth::user()->email }}</p>
                    <p>{{ Auth::user()->no_hp }}</p>
                    {{-- Tambahkan informasi lain yang relevan --}}
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12">
                <ul class="profile-links">
                    {{-- <li><a class="btn btn-outline-primary m-1" href="#">Saldo</a></li> --}}
                    {{-- <li><a class="btn btn-outline-primary m-1" href="#">Edit</a></li> --}}
                    <li>
                        <a class="btn btn-outline-primary m-1" href="{{ route('logout') }}"
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
    </div>
@endsection
