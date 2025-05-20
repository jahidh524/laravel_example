@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Login</h2>
    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                {{ $error }}
            @endforeach
        </div>
    @endif
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="mb-3">
            <label for="identifier">Phone No / Username:</label>
            <input type="text" id="identifier" name="identifier" required class="form-control"
                title="Enter your phone number or username" placeholder="e.g., 01712345678 or username"
                value="{{ old('identifier') }}">
        </div>
        <div class="mb-3">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required class="form-control"
                title="Enter your password" placeholder="••••••••">
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
        <a href="/register" class="btn btn-link">Register</a>
        <br><br>
        {{-- <a href="" class="btn btn-danger mt-2">Login with Google</a> --}}
    </form>
</div>
@endsection