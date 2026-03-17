@extends('auth.layout')

@section('title', 'Login | CaterCaptain')

@section('content')
<h1>Welcome Back</h1>
<p class="sub">Sign in to continue catering operations.</p>

<form method="POST" action="{{ route('logins') }}">
    @csrf

    <label for="email">Email</label>
    <input id="email" type="email" name="email" value="{{ old('email') }}" autofocus>

    <label for="password">Password</label>
    <input id="password" type="password" name="password">

    <div class="row-inline">
        <label><input type="checkbox" name="remember">Remember me</label>
        <a href="{{ route('forgot-password') }}" style="color:#0f766e;text-decoration:none;font-weight:700;">Forgot Password?</a>
    </div>

    <button class="btn" type="submit">Login</button>
</form>
@endsection
