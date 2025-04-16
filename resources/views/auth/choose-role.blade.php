@extends('layouts.app')
@section('title', 'Pilih Role')
@section('content')
    <style>
        /* Tetap menggunakan style yang sama */
        body {
            font-family: Arial, sans-serif;
            position: relative;
            overflow: hidden;
        }

        .background-overlay {
            background: url('{{ asset('images/test2.jpg') }}') no-repeat center center fixed;
            background-size: cover;
            opacity: 0.6;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
        }

        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-card {
            background-color: #1b7066;
            opacity: 0.9;
            padding: 20px;
            border-radius: 10px;
            width: 400px;
            text-align: center;
            color: #fff;
            z-index: 1;
        }

        .login-card img.logo {
            width: 100px;
            margin-bottom: 20px;
        }

        .login-card h2 {
            margin-bottom: 10px;
        }

        .login-card .form-group {
            margin: 10px 0;
            display: flex;
            align-items: center;
        }

        .login-card .form-group label {
            display: flex;
            align-items: center;
            width: 100%;
        }

        .login-card .form-group input[type="radio"] {
            margin-right: 10px;
        }

        .login-card .btn-login {
            background-color: #19D6A4;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            color: #fff;
            font-weight: bold;
            cursor: pointer;
            margin-top: 20px;
            width: 100%;
        }

        .login-card .btn-login:hover {
            background-color: #17b892;
        }

        .login-card .back-link {
            color: #ccc;
            font-size: 0.9em;
            text-decoration: none;
        }

        .login-card .back-link:hover {
            color: #fff;
        }
    </style>

    <!-- Background overlay -->
    <div class="background-overlay"></div>

    <div class="login-container">
        <div class="login-card">
            <img src="{{ asset('images/undip.png') }}" class="logo" alt="Logo">
            <h2>Bridge Information Systems</h2> <br>
            <p>Please select your role to continue:</p>
            
            <form action="{{ route('set-role') }}" method="POST">
                @csrf
                <div>
                <label for="role">Pilih Role:</label>
                    <select name="role" id="role">
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}" @if(session('role') == $role->name) selected @endif>{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn-login">CONTINUE</button>
            </form>
            
            <a href="{{ url()->previous() }}" class="back-link">Back</a>
        </div>
    </div>
@endsection
