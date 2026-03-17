@extends('auth.layout')

@section('title', 'Forgot Password | CaterCaptain')

@section('content')
<div class="login-logo" aria-hidden="true">
    <svg viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
        <rect x="6" y="6" width="52" height="52" rx="14" fill="url(#g)"/>
        <path d="M24 18v14c0 3 2 5 5 5s5-2 5-5V18m-10 6h10" stroke="#fff" stroke-width="4" stroke-linecap="round"/>
        <path d="M40 18v30" stroke="#fff" stroke-width="4" stroke-linecap="round"/>
        <defs>
            <linearGradient id="g" x1="10" y1="10" x2="54" y2="54" gradientUnits="userSpaceOnUse">
                <stop stop-color="#F97316"/>
                <stop offset="1" stop-color="#7C3AED"/>
            </linearGradient>
        </defs>
    </svg>
</div>
<h1 class="login-title">CaterCaptain</h1>
<p class="login-sub">Reset your password</p>

<form method="POST" action="{{ route('forgot-password.submit') }}">
    @csrf

    <div class="field">
        <label for="email">Registered Email</label>
        <div class="input-wrap">
            <span class="input-icon" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="none">
                    <path d="M4 6h16a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2Z" stroke="currentColor" stroke-width="1.8"/>
                    <path d="m3 8 9 6 9-6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </span>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
        </div>
    </div>

    <div class="field">
        <label for="password">New Password</label>
        <div class="input-wrap">
            <span class="input-icon" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="none">
                    <rect x="5" y="10" width="14" height="10" rx="2" stroke="currentColor" stroke-width="1.8"/>
                    <path d="M8 10V7a4 4 0 1 1 8 0v3" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                </svg>
            </span>
            <input id="password" type="password" name="password" required>
        </div>
    </div>

    <div class="field">
        <label for="password_confirmation">Confirm New Password</label>
        <div class="input-wrap">
            <span class="input-icon" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="none">
                    <rect x="5" y="10" width="14" height="10" rx="2" stroke="currentColor" stroke-width="1.8"/>
                    <path d="M8 10V7a4 4 0 1 1 8 0v3" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                </svg>
            </span>
            <input id="password_confirmation" type="password" name="password_confirmation" required>
        </div>
    </div>

    <button class="login-btn" type="submit">Update Password</button>

    <div style="margin-top: 14px; font-size: 13px; color: #64748b; text-align: center;">
        Back to
        <a href="{{ route('logins') }}" style="color:#f97316;text-decoration:none;font-weight:700;">Login</a>
    </div>
</form>
@endsection
