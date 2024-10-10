@extends('layout')

@section('content')
    <style>
        .error-container {
           
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 0 20px;
        }
        .error-icon {
            font-size: 4rem;
            color: #dc3545;
        }
        .error-message {
            font-size: 1.25rem;
            color: #333;
        }
        .btn-back {
            margin-top: 20px;
        }
    </style>


    <div class="container error-container">
        <div>
            <div class="error-icon">
                <i class="bi bi-exclamation-triangle"></i>
            </div>
            <h1 class="error-message">
                @if (session('error_message'))
                    {{ session('error_message') }}
                @else
                    Có gì đó sai. Thử lại sau!
                @endif
            </h1>
            <a href="{{ url('/') }}" class="btn btn-primary btn-back">Trở về trang chủ</a>
        </div>
    </div>


    @endsection
