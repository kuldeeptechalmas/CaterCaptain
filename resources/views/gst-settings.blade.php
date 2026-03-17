@extends('layouts.dashboard')

@section('title', 'GST Settings | CaterCaptain')

@section('crumbs')
    Home / HQ Setup / <b>GST Settings</b>
@endsection

@push('styles')
<style>
    .page h1 { margin: 8px 0 14px; font-size: 22px; }
    .card {
        background: var(--card);
        border: 1px solid var(--line);
        border-radius: 14px;
        padding: 16px;
        box-shadow: 0 10px 30px rgba(15, 23, 42, 0.06);
    }
    .form-grid {
        display: grid;
        grid-template-columns: repeat(12, minmax(0, 1fr));
        gap: 12px;
    }
    .field { display: grid; gap: 6px; }
    .field label { font-size: 13px; font-weight: 700; color: #0f172a; }
    .field input {
        width: 100%;
        border: 1px solid #cbd5e1;
        border-radius: 10px;
        padding: 10px 12px;
        font: inherit;
    }
    .col-6 { grid-column: span 6; }
    .btn {
        margin-top: 14px;
        border: 0;
        border-radius: 10px;
        padding: 10px 14px;
        font: inherit;
        font-weight: 800;
        background: var(--orange);
        color: #fff;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    @media (max-width: 720px) {
        .col-6 { grid-column: span 12; }
    }
</style>
@endpush

@section('content')
    <h1>GST Settings</h1>
    <div class="card">
        <div class="form-grid">
            <div class="field col-6">
                <label for="gst_number">GST Number</label>
                <input id="gst_number" type="text" value="24ABCDE1234F1Z5">
            </div>
            <div class="field col-6">
                <label for="gst_tax">Tax %</label>
                <input id="gst_tax" type="text" value="18">
            </div>
        </div>
        <button class="btn" type="button">Save</button>
    </div>
@endsection
