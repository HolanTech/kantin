@extends('layouts.master')
@section('title', 'Order')
@section('content')
    <style>
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
    </style>
    <a href="{{ route('order.create') }}" class="btn btn-primary rounded-circle" id="fab">
        <i class="fas fa-plus"></i>
    </a>
@endsection
