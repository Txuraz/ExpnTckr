
@extends('layouts.app')
@section('title', 'Expense Tracker')

@section('content')
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6 text-center">
                <h1>Welcome to Expense Tracker</h1>
                <p class="mt-3">Track your expenses with ease!</p>
            </div>
        </div>

        <div class="row justify-content-center mt-4">
            <div class="col-md-6 text-center">
                <div class="mb-3">
                    <a href="{{ route('register.form') }}" class="btn btn-primary btn-lg">Register</a>
                </div>
                <div>
                    <a href="{{ route('login.form') }}" class="btn btn-success btn-lg">Login</a>
                </div>
            </div>
        </div>
    </div>
@endsection
