@extends('auth.layouts')

@section('content')
    <div class="mt-16">
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                {{ $message }}
            </div>
        @elseif ($message = Session::get('error'))
            <div class="alert alert-danger" role="alert">
                {{ $message }}
            </div>
        @endif
    </div>
    <div class="d-flex justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="text-center">
            <h1 class="mb-4">Selamat Datang</h1>
            <p class="mb-4">Silakan login atau daftar untuk melanjutkan ke dashboard</p>
            <a href="{{ route('login') }}" class="btn btn-danger btn-lg me-2">Login</a>
            <a href="{{ route('register') }}" class="btn btn-primary btn-lg">Register</a>
        </div>
    </div>
    <style>
    .alert {
        padding: 15px;
        margin-bottom: 20px;
        border: 1px solid transparent;
        border-radius: 4px;
    }
    .alert-danger {
        background-color: #f2dede;
        border-color: #ebccd1;
        color: #a94442;
    }
</style>

@endsection
