@extends('auth.layout')

@section('title', 'Register | CaterCaptain')

@section('content')
<h1>Create Account</h1>
<p class="sub">Register your profile to manage events and inventory.</p>

<form method="POST" action="{{ route('register.submit') }}">
    @csrf

    <div class="grid-2">
        <div>
            <label for="first_name">First Name</label>
            <input id="first_name" type="text" name="first_name" value="{{ old('first_name') }}" required>
        </div>
        <div>
            <label for="last_name">Last Name</label>
            <input id="last_name" type="text" name="last_name" value="{{ old('last_name') }}" required>
        </div>
    </div>

    <label for="email">Email</label>
    <input id="email" type="email" name="email" value="{{ old('email') }}" required>

    <label for="phone">Phone</label>
    <input id="phone" type="text" name="phone" value="{{ old('phone') }}">

    <label for="password">Password</label>
    <input id="password" type="password" name="password" required>

    <label for="password_confirmation">Confirm Password</label>
    <input id="password_confirmation" type="password" name="password_confirmation" required>

    <button class="btn" type="submit">Register</button>
</form>
@endsection
