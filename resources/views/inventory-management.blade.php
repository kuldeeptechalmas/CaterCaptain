@extends('layouts.dashboard')

@section('title', 'Inventory Management | CaterCaptain')

@section('crumbs')
    Home / HQ Setup / <b>Inventory</b>
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
    .stats {
        margin-top: 14px;
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 12px;
    }
    .stat {
        background: var(--card);
        border: 1px solid var(--line);
        border-radius: 14px;
        padding: 14px;
        display: grid;
        gap: 6px;
        position: relative;
    }
    .stat::before {
        content: "";
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 4px;
        background: #2563eb;
        border-radius: 14px 0 0 14px;
    }
    .stat.green::before { background: #16a34a; }
    .stat.orange::before { background: #f97316; }
    .stat.red::before { background: #ef4444; }
    .stat .value { font-size: 22px; font-weight: 800; }
    .stat .meta { color: var(--muted); font-size: 12px; }
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
    select, .btn-chip {
        border: 1px solid var(--line);
        border-radius: 10px;
        padding: 8px 10px;
        font: inherit;
        font-size: 13px;
        background: #fff;
    }
    .btn-chip.green { color: #15803d; border-color: #86efac; }
    .btn-chip.orange { color: #ea580c; border-color: #fdba74; }
    .btn-chip.gray { color: #475569; border-color: #cbd5e1; text-decoration: none; }
    .table-wrap { margin-top: 10px; overflow: auto; }
    table {
        width: 100%;
        border-collapse: collapse;
        min-width: 980px;
        font-size: 13px;
    }
    th, td {
        text-align: left;
        padding: 10px 8px;
        border-bottom: 1px solid #eef2f7;
    }
    th { color: #64748b; font-weight: 700; }
    .bar {
        height: 6px;
        border-radius: 999px;
        background: #e2e8f0;
        position: relative;
        overflow: hidden;
    }
    .bar span {
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        background: var(--orange);
    }
    .pill {
        display: inline-flex;
        align-items: center;
        padding: 4px 8px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 700;
        background: #dcfce7;
        color: #15803d;
    }
    .pill.low { background: #ffedd5; color: #c2410c; }
    .pill.critical { background: #fee2e2; color: #b91c1c; }
    .action {
        width: 32px;
        height: 32px;
        border-radius: 10px;
        border: 1px solid #fdba74;
        color: #f97316;
        display: inline-grid;
        place-items: center;
        margin-right: 6px;
    }
    .section-title {
        margin: 16px 0 8px;
        font-weight: 800;
        font-size: 16px;
    }
    .summary-grid {
        margin-top: 12px;
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 10px;
    }
    .summary-card {
        background: #fff;
        border: 1px solid var(--line);
        border-radius: 12px;
        padding: 12px;
    }
    .summary-card .label { color: var(--muted); font-size: 12px; }
    .summary-card .value { font-weight: 800; margin-top: 6px; }
    @media (max-width: 1100px) {
        .stats { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    }
    @media (max-width: 640px) {
        .stats { grid-template-columns: 1fr; }
        .summary-grid { grid-template-columns: 1fr; }
    }
</style>
@endpush

@section('content')
    <div class="page-head">
        <div>
            <h1>Inventory Management</h1>
            <p>Manage inventory and stock</p>
        </div>
        <div style="display:flex; gap:10px; flex-wrap:wrap;">
            <select>
                <option>HQ / Kitchens</option>
            </select>
            <button class="btn-primary">+ Add Material</button>
        </div>
    </div>

    <section class="stats">
        <div class="stat">
            <div>Total Materials</div>
            <div class="value">{{ $totalMaterials }}</div>
            <div class="meta">In inventory</div>
        </div>
        <div class="stat green">
            <div>Good Stock</div>
            <div class="value">{{ $goodCount }}</div>
            <div class="meta">Above minimum</div>
        </div>
        <div class="stat orange">
            <div>Low Stock</div>
            <div class="value">{{ $lowCount }}</div>
            <div class="meta">Below threshold</div>
        </div>
        <div class="stat red">
            <div>Critical</div>
            <div class="value">{{ $criticalCount }}</div>
            <div class="meta">Urgent restock</div>
        </div>
    </section>

    <div class="card">
        <form class="toolbar" method="GET" action="{{ route('inventory.management') }}">
            <div class="search">
                🔍
                <input type="text" name="q" value="{{ $q }}" placeholder="Search materials..." style="border:0;outline:none;width:100%;font:inherit;">
            </div>
            <select name="material_id">
                <option value="">Select material for ledger</option>
                @foreach ($materialOptions as $option)
                <option value="{{ $option->id }}" {{ $selectedMaterialId === (int) $option->id ? 'selected' : '' }}>
                    {{ $option->name }}
                </option>
                @endforeach
            </select>
            <button class="btn-chip gray" type="submit">Apply</button>
            <select>
                <option>All Status</option>
            </select>
            <button class="btn-chip green" type="button">⬇ Stock In</button>
            <button class="btn-chip orange" type="button">⬆ Stock Out</button>
            <button class="btn-chip gray" type="button">✎ Physical Entry</button>
            <button class="btn-chip gray" type="button">⬇ Export</button>
        </form>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Material Name</th>
                        <th>Unit</th>
                        <th>Current Qty</th>
                        <th>Min Qty</th>
                        <th>Stock Level</th>
                        <th>Price/Unit</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($materials as $index => $material)
                    @php
                        $pct = $material->stock_level;
                        $pctValue = $pct === null ? 0 : min(200, max(0, $pct));
                        $status = $material->status_label;
                    @endphp
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td><b>{{ $material->name }}</b></td>
                        <td>{{ $material->unit_symbol ?? '-' }}</td>
                        <td>{{ number_format((float) $material->qty, 0) }} {{ $material->unit_symbol ?? '' }}</td>
                        <td>{{ number_format((float) $material->min_qty, 0) }} {{ $material->unit_symbol ?? '' }}</td>
                        <td>
                            <div class="bar"><span style="width: {{ $pctValue }}%;"></span></div>
                            <div style="font-size:12px;color:#64748b;margin-top:4px;">
                                {{ $pct === null ? '-' : number_format($pct, 0) . '%' }}
                            </div>
                        </td>
                        <td>
                            @if ($material->material_price !== null)
                                ₹ {{ number_format((float) $material->material_price, 0) }}
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            <span class="pill {{ strtolower($status) === 'low' ? 'low' : (strtolower($status) === 'critical' ? 'critical' : '') }}">
                                {{ $status }}
                            </span>
                        </td>
                        <td>
                            <span class="action">✎</span>
                            <span class="action">🗑</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" style="color:#94a3b8;">No inventory data found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($selectedMaterial)
        <div class="section-title">Raw Material Ledger</div>
        <div style="display:flex; gap:8px; flex-wrap:wrap; margin-bottom:8px;">
            <a class="btn-chip gray" href="{{ route('inventory.management.pdf', ['material_id' => $selectedMaterialId]) }}" target="_blank">View PDF</a>
            <a class="btn-chip gray" href="{{ route('inventory.management.pdf.download', ['material_id' => $selectedMaterialId]) }}">Download PDF</a>
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Type</th>
                        <th>Qty</th>
                        <th>From</th>
                        <th>To</th>
                        <th>Note</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($moments as $moment)
                    <tr>
                        <td>{{ $moment->created_at ? \Illuminate\Support\Carbon::parse($moment->created_at)->format('Y-m-d') : '-' }}</td>
                        <td>{{ strtoupper($moment->status) }}</td>
                        <td>{{ number_format((float) $moment->qty, 2) }} {{ $moment->unit_symbol ?? '' }}</td>
                        <td>{{ $moment->from_kitchen_name ?? $moment->from_hq_value ?? '-' }}</td>
                        <td>{{ $moment->to_kitchen_name ?? $moment->to_hq_value ?? '-' }}</td>
                        <td>{{ $moment->note ?: '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="color:#94a3b8;">No ledger entries found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="section-title">Current Stock</div>
        <div class="summary-grid">
            <div class="summary-card">
                <div class="label">Material</div>
                <div class="value">{{ $selectedMaterial->name ?? '-' }}</div>
            </div>
            <div class="summary-card">
                <div class="label">Current Qty</div>
                <div class="value">
                    {{ number_format((float) ($selectedMaterial->qty ?? 0), 2) }}
                    {{ $selectedMaterial->unit_symbol ?? '' }}
                </div>
            </div>
            <div class="summary-card">
                <div class="label">Minimum Qty</div>
                <div class="value">
                    {{ number_format((float) ($selectedMaterial->min_qty ?? 0), 2) }}
                    {{ $selectedMaterial->unit_symbol ?? '' }}
                </div>
            </div>
        </div>
        @endif
    </div>
@endsection
