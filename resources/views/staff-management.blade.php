@extends('layouts.dashboard')

@section('title', 'Staff Management | CaterCaptain')

@section('crumbs')
    Home / HQ Setup / <b>Staff Management</b>
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
        grid-template-columns: repeat(2, minmax(0, 1fr));
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
        width: min(320px, 100%);
        background: #fff;
    }
    select {
        border: 1px solid var(--line);
        border-radius: 10px;
        padding: 8px 10px;
        font: inherit;
        font-size: 13px;
        background: #fff;
    }
    .table-wrap { margin-top: 10px; overflow: auto; }
    table {
        width: 100%;
        border-collapse: collapse;
        min-width: 900px;
        font-size: 13px;
    }
    th, td {
        text-align: left;
        padding: 10px 8px;
        border-bottom: 1px solid #eef2f7;
    }
    th { color: #64748b; font-weight: 700; }
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
    .pill.inactive { background: #ffedd5; color: #c2410c; }
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
    @media (max-width: 1100px) {
        .stats { grid-template-columns: 1fr; }
    }
</style>
@endpush

@section('content')
    <div class="page-head">
        <div>
            <h1>Staff Management</h1>
            <p>Manage staff and roles</p>
        </div>
        <button class="btn-primary">+ Add Staff</button>
    </div>

    <section class="stats">
        <div class="stat">
            <div>Total Staff</div>
            <div class="value">{{ $totalStaff }}</div>
            <div class="meta">All staff</div>
        </div>
        <div class="stat green">
            <div>Active Staff</div>
            <div class="value">{{ $activeStaff }}</div>
            <div class="meta">Currently active</div>
        </div>
    </section>

    <div class="card">
        <div class="toolbar">
            <div class="search">🔍 <span style="color:#94a3b8;">Search staff...</span></div>
            <select>
                <option>All Roles</option>
            </select>
            <select>
                <option>All Status</option>
            </select>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Role</th>
                        <th>Phone</th>
                        <th>Salary Type</th>
                        <th>Rate</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($staff as $index => $member)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $member->name }}</td>
                        <td>{{ $member->role_name ?? '-' }}</td>
                        <td>{{ $member->phone }}</td>
                        <td>{{ $member->salary_type }}</td>
                        <td>₹ {{ number_format((float) $member->rate, 0) }}</td>
                        <td>
                            <span class="pill {{ $member->is_active ? '' : 'inactive' }}">
                                {{ $member->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td>
                            <span class="action">✎</span>
                            <span class="action">🗑</span>
                            <span class="action">📋</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" style="color:#94a3b8;">No staff found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
