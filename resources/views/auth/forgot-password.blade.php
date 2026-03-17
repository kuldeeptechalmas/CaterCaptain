@extends('auth.layout')

@section('title', 'Forgot Password | CaterCaptain')

@section('content')
<h1>Forgot Password</h1>
<p class="sub">Reset your account password with registered email.</p>

<form method="POST" action="{{ route('forgot-password.submit') }}">
    @csrf

    <label for="email">Registered Email</label>
    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>

    <label for="password">New Password</label>
    <input id="password" type="password" name="password" required>

    <label for="password_confirmation">Confirm New Password</label>
    <input id="password_confirmation" type="password" name="password_confirmation" required>

    <button class="btn" type="submit">Update Password</button>
</form>
@endsection
