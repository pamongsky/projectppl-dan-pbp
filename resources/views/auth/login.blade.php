@extends('layouts.app')

@section('content')
    <style>
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

        .login-card .form-group .icon {
            width: 20px;
            margin-right: 10px;
        }

        .login-card input[type="text"],
        .login-card input[type="password"] {
            background: transparent;
            border: none;
            border-bottom: 1px solid #fff;
            color: rgba(255, 255, 255, 0.8);
            width: 100%;
            outline: none;
            padding: 5px;
        }

        .login-card input[type="text"]:focus,
        .login-card input[type="password"]:focus {
            color: rgba(255, 255, 255, 0.8);
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
            <p>Welcome, please login to continue!</p>
            
            <form action="{{ route('login.submit') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="id">
                        <img src="{{ asset('images/username.png') }}" class="icon" alt="ID Icon">
                        <input type="text" name="id" placeholder="Enter Your ID" required>
                    </label>
                </div>
                
                <div class="form-group">
                    <label for="password">
                        <img src="{{ asset('images/password.png') }}" class="icon" alt="Password Icon">
                        <input type="password" name="password" placeholder="Password" required>
                    </label>
                </div>

                <button type="submit" class="btn-login">LOGIN</button>
            </form>
            
            <a href="{{ url()->previous() }}" class="back-link">Back</a>
        </div>
    </div>
@endsection
