@extends('layouts.dashboard')

@section('title', 'Raw Material Report | CaterCaptain')

@section('crumbs')
    Home / Reports / <b>Raw Material Report</b>
@endsection

@push('styles')
<style>
    :root {
        --accent: #0f766e;
        --accent-2: #f59e0b;
    }
    .page-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
    }
    .page-head h1 {
        margin: 0;
        font-size: 22px;
    }
    .filters {
        margin-top: 16px;
        background: var(--card);
        border: 1px solid var(--line);
        border-radius: 18px;
        padding: 18px;
        display: grid;
        grid-template-columns: repeat(12, minmax(0, 1fr));
        gap: 14px;
        box-shadow: 0 10px 30px rgba(15, 23, 42, 0.06);
    }
    .field {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }
    .field label {
        font-size: 12px;
        font-weight: 800;
        color: #475569;
        text-transform: uppercase;
        letter-spacing: 0.04em;
    }
    .filters input,
    .filters select {
        width: 100%;
        border: 1px solid var(--line);
        border-radius: 12px;
        padding: 11px 12px;
        font: inherit;
        background: #fff;
    }
    .filters input:focus,
    .filters select:focus {
        outline: none;
        border-color: var(--accent);
        box-shadow: 0 0 0 3px rgba(15, 118, 110, 0.15);
    }
    .field.name { grid-column: span 4; }
    .field.unit { grid-column: span 2; }
    .field.kitchen { grid-column: span 3; }
    .field.status { grid-column: span 3; }
    .field.qty-min { grid-column: span 2; }
    .field.qty-max { grid-column: span 2; }
    .actions {
        grid-column: span 4;
        display: flex;
        gap: 10px;
        align-items: flex-end;
        flex-wrap: wrap;
    }
    .btn {
        border: 0;
        border-radius: 12px;
        padding: 11px 16px;
        font: inherit;
        font-weight: 800;
        cursor: pointer;
    }
    .btn-primary {
        background: linear-gradient(90deg, var(--accent), var(--accent-2));
        color: #fff;
    }
    .btn-ghost {
        background: #e2e8f0;
        color: #0f172a;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    .btn-outline {
        background: #fff;
        color: var(--accent);
        border: 1px solid rgba(15, 118, 110, 0.3);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    .table-wrap {
        margin-top: 16px;
        background: var(--card);
        border: 1px solid var(--line);
        border-radius: 18px;
        overflow: auto;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        min-width: 760px;
    }
    th, td {
        padding: 12px 14px;
        text-align: left;
        border-bottom: 1px solid var(--line);
        font-size: 14px;
    }
    th {
        background: #f1f5f9;
        color: #475569;
        position: sticky;
        top: 0;
    }
    .pill {
        display: inline-block;
        padding: 4px 8px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 700;
    }
    .pill.active { background: #dcfce7; color: #14532d; }
    .pill.inactive { background: #fee2e2; color: #7f1d1d; }
    .empty { padding: 18px; text-align: center; color: #64748b; }

    @media (max-width: 1100px) {
        .field.name { grid-column: span 6; }
        .field.unit { grid-column: span 3; }
        .field.kitchen { grid-column: span 3; }
        .field.status { grid-column: span 4; }
        .field.qty-min, .field.qty-max { grid-column: span 4; }
        .actions { grid-column: span 4; }
    }
    @media (max-width: 820px) {
        .filters { grid-template-columns: repeat(6, minmax(0, 1fr)); }
        .field.name { grid-column: span 6; }
        .field.unit,
        .field.kitchen,
        .field.status,
        .field.qty-min,
        .field.qty-max { grid-column: span 3; }
        .actions { grid-column: span 6; }
    }
    @media (max-width: 560px) {
        .filters { grid-template-columns: 1fr; }
        .field, .actions { grid-column: span 1; }
        .actions { flex-direction: column; align-items: stretch; }
    }
</style>
@endpush

@section('content')
    <div class="page-head">
        <div>
            <h1>Raw Material Report</h1>
            <div style="margin-top:4px;color:#64748b;">Stores available: {{ $storeCount }}</div>
        </div>
    </div>

    <form class="filters" method="GET" action="{{ route('material.report') }}">
        <div class="field name" style="width: 92%;">
            <label for="q">Search Name</label>
            <input id="q" name="q" type="text" value="{{ request('q') }}" placeholder="e.g. Rice">
        </div>

        <div class="field unit">
            <label for="unit_id">Unit</label>
            <select id="unit_id" name="unit_id">
                <option value="">All units</option>
                @foreach ($units as $unit)
                <option value="{{ $unit->id }}" {{ request('unit_id') == $unit->id ? 'selected' : '' }}>
                    {{ $unit->name }} ({{ $unit->symbol }})
                </option>
                @endforeach
            </select>
        </div>

        <div class="field kitchen">
            <label for="kitchen_id">Kitchen</label>
            <select id="kitchen_id" name="kitchen_id">
                <option value="">All kitchens</option>
                @foreach ($kitchens as $kitchen)
                <option value="{{ $kitchen->id }}" {{ request('kitchen_id') == $kitchen->id ? 'selected' : '' }}>
                    {{ $kitchen->name }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="field status">
            <label for="status">Status</label>
            <select id="status" name="status">
                <option value="">All</option>
                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <div class="actions" style="width: 490px;">
            <button type="submit" class="btn btn-primary">Apply Filters</button>
            <a class="btn btn-ghost" href="{{ route('material.report') }}">Clear</a>
            <a class="btn btn-outline" href="{{ route('material.report.pdf', request()->query()) }}" target="_blank">View PDF</a>
            <a class="btn btn-outline" href="{{ route('material.report.pdf.download', request()->query()) }}">Download PDF</a>
        </div>
    </form>

    @if(isset($moments) && count($moments) > 0)
    <div class="table-wrap" style="margin-top: 22px;">
        <table>
            <thead>
                <tr>
                    <th>Movement Date</th>
                    <th>Material</th>
                    <th>Qty</th>
                    <th>Unit</th>
                    <th>Status</th>
                    <th>From</th>
                    <th>To</th>
                    <th>Note</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($moments as $moment)
                <tr>
                    <td>{{ $moment->created_at ? \Illuminate\Support\Carbon::parse($moment->created_at)->format('d M Y') : '-' }}</td>
                    <td>{{ $moment->material_name ?? '-' }}</td>
                    <td>{{ number_format((float) $moment->qty, 3) }}</td>
                    <td>{{ $moment->unit_symbol ?? '-' }}</td>
                    <td>{{ ucfirst($moment->status) }}</td>
                    <td>{{ $moment->from_kitchen_name ?? $moment->from_hq_value ?? '-' }}</td>
                    <td>{{ $moment->to_kitchen_name ?? $moment->to_hq_value ?? '-' }}</td>
                    <td>{{ $moment->note ?? '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="empty">No raw material movements match your filters.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @endif

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Unit</th>
                    <th>Kitchen</th>
                    <th>HQ</th>
                    <th>Qty</th>
                    <th>Min Qty</th>
                    <th>Price</th>
                    <th>Pricing Date</th>
                    <th>Status</th>
                    <th>Updated</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($materials as $material)
                <tr>
                    <td>{{ $material->name }}</td>
                    <td>{{ $material->unit_symbol }}</td>
                    <td>{{ $material->kitchen_name ?? '-' }}</td>
                    <td>{{ $material->hq_value ?? '-' }}</td>
                    <td>{{ number_format((float) $material->qty, 3) }}</td>
                    <td>{{ number_format((float) $material->min_qty, 3) }}</td>
                    <td>{{ $material->material_price !== null ? number_format((float) $material->material_price, 2) : '-' }}</td>
                    <td>{{ $material->pricing_date ? \Illuminate\Support\Carbon::parse($material->pricing_date)->format('d M Y') : '-' }}</td>
                    <td>
                        <span class="pill {{ $material->is_active ? 'active' : 'inactive' }}">
                            {{ $material->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td>{{ $material->updated_at ? \Illuminate\Support\Carbon::parse($material->updated_at)->format('d M Y') : '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" class="empty">No raw materials match your filters.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
