@extends('auth.layout')

@section('title', 'Change Password | CaterCaptain')

@section('content')
<h1>Change Password</h1>
<p class="sub">Secure your account with a new password.</p>

<form method="POST" action="{{ route('change-password.submit') }}">
    @csrf

    <label for="current_password">Current Password</label>
    <input id="current_password" type="password" name="current_password" required>

    <label for="password">New Password</label>
    <input id="password" type="password" name="password" required>

    <label for="password_confirmation">Confirm New Password</label>
    <input id="password_confirmation" type="password" name="password_confirmation" required>

    <button class="btn" type="submit">Change Password</button>
</form>
@endsection
