@extends('layouts.dashboard')

@section('title', 'Material Pricing | CaterCaptain')

@section('crumbs')
    Home / HQ Setup / <b>Material Pricing</b>
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
    .toolbar {
        display: flex;
        gap: 10px;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
    }
    .search {
        display: flex;
        align-items: center;
        gap: 8px;
        border: 1px solid var(--line);
        border-radius: 10px;
        padding: 8px 10px;
        width: min(360px, 100%);
        background: #fff;
    }
    .btn-outline {
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        padding: 8px 12px;
        font: inherit;
        font-size: 12px;
        background: #fff;
        cursor: pointer;
        text-decoration: none;
        color: #0f172a;
    }
    .table-wrap { margin-top: 10px; overflow: auto; }
    table {
        width: 100%;
        border-collapse: collapse;
        min-width: 820px;
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
        display: grid;
        place-items: center;
    }
</style>
@endpush

@section('content')
    <div class="page-head">
        <h1>Material Pricing</h1>
        <button class="btn-primary">+ Add Price</button>
    </div>

    <div class="card">
        <div class="toolbar">
            <div class="search">🔍 <span style="color:#94a3b8;">Search materials...</span></div>
            <a class="btn-outline" href="{{ route('material.pricing.pdf.download') }}">⬇️ Export</a>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Material</th>
                        <th>Unit</th>
                        <th>Price/Unit</th>
                        <th>Price/Kg</th>
                        <th>Price/Litre</th>
                        <th>Price/Piece</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($materials as $index => $material)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td><b>{{ $material->name }}</b></td>
                        <td>{{ $material->unit_symbol ?? '-' }}</td>
                        <td>₹ {{ number_format((float) ($material->price_unit ?? 0), 0) }}</td>
                        <td>{{ $material->price_kg ? '₹ ' . number_format((float) $material->price_kg, 0) : '-' }}</td>
                        <td>{{ $material->price_litre ? '₹ ' . number_format((float) $material->price_litre, 0) : '-' }}</td>
                        <td>{{ $material->price_piece ? '₹ ' . number_format((float) $material->price_piece, 0) : '-' }}</td>
                        <td><span class="action">✎</span></td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" style="color:#94a3b8;">No materials found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
