@extends('layouts.dashboard')

@section('title', 'Dishes | CaterCaptain')

@section('crumbs')
    Home / Masters / <b>Dishes</b>
@endsection

@push('styles')
<style>
    .page-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        flex-wrap: wrap;
    }
    .page-head h1 { margin: 0; font-size: 22px; }
    .page-head p { margin: 4px 0 0; color: var(--muted); font-size: 13px; }
    .btn-primary {
        border: 0;
        border-radius: 10px;
        padding: 10px 14px;
        font: inherit;
        font-weight: 800;
        background: var(--orange);
        color: #fff;
        cursor: pointer;
    }
    .card {
        margin-top: 14px;
        background: var(--card);
        border: 1px solid var(--line);
        border-radius: 14px;
        padding: 14px;
        box-shadow: 0 10px 30px rgba(15, 23, 42, 0.06);
    }
    .search {
        display: flex;
        align-items: center;
        gap: 8px;
        border: 1px solid var(--line);
        border-radius: 10px;
        padding: 8px 10px;
        width: min(320px, 100%);
        background: #fff;
    }
    .table-wrap { margin-top: 10px; overflow: auto; }
    table {
        width: 100%;
        border-collapse: collapse;
        min-width: 640px;
        font-size: 13px;
    }
    th, td {
        text-align: left;
        padding: 10px 8px;
        border-bottom: 1px solid #eef2f7;
    }
    th { color: #64748b; font-weight: 700; }
    .action {
        width: 32px;
        height: 32px;
        border-radius: 10px;
        border: 1px solid #fdba74;
        color: #f97316;
        display: inline-grid;
        place-items: center;
    }
</style>
@endpush

@section('content')
    <div class="page-head">
        <div>
            <h1>Dishes</h1>
            <p>Manage dish master</p>
        </div>
        <button class="btn-primary">+ Add Dish</button>
    </div>

    <div class="card">
        <form class="search" method="GET" action="{{ route('masters.dishes') }}">
            🔍
            <input type="text" name="q" value="{{ $q }}" placeholder="Search dishes..." style="border:0;outline:none;width:100%;font:inherit;">
        </form>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Dish</th>
                        <th>Category</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($dishes as $dish)
                    <tr>
                        <td>{{ $dish->dish }}</td>
                        <td>{{ $dish->category_name ?? '-' }}</td>
                        <td><span class="action">✎</span></td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" style="color:#94a3b8;">No dishes found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
