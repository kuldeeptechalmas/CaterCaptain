@extends('layouts.dashboard')

@section('title', 'Dashboard | CaterCaptain')

@section('crumbs')
    Home / <b>Dashboard</b>
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

    .filters {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }
    .filters input,
    .filters select {
        border: 1px solid var(--line);
        border-radius: 10px;
        padding: 8px 10px;
        font: inherit;
        font-size: 13px;
        background: #fff;
    }

    .stat-grid {
        margin-top: 16px;
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
        overflow: hidden;
    }
    .stat::before {
        content: "";
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 4px;
        background: #2563eb;
    }
    .stat.orange::before { background: #f97316; }
    .stat.red::before { background: #ef4444; }
    .stat.green::before { background: #16a34a; }
    .stat .title { color: #64748b; font-size: 12px; }
    .stat .value { font-size: 22px; font-weight: 800; }
    .stat .meta { color: #64748b; font-size: 12px; }

    .grid {
        margin-top: 14px;
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 14px;
    }
    .card {
        background: var(--card);
        border: 1px solid var(--line);
        border-radius: 14px;
        padding: 14px;
    }
    .card-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 10px;
    }
    .card-title {
        display: flex;
        align-items: center;
        gap: 8px;
        font-weight: 700;
    }
    .btn-sm {
        border: 0;
        border-radius: 8px;
        padding: 6px 10px;
        font: inherit;
        font-size: 12px;
        font-weight: 700;
        background: #64748b;
        color: #fff;
        cursor: pointer;
    }
    table {
        width: 100%;
        border-collapse: collapse;
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
    }
    .pill.pending { background: #fff3cd; color: #b45309; }
    .pill.approved { background: #dbeafe; color: #1d4ed8; }
    .pill.received { background: #dcfce7; color: #15803d; }

    .alert-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px;
        border-radius: 10px;
        background: #f8fafc;
        margin-bottom: 8px;
    }
    .alert-item .name { font-weight: 700; }
    .alert-item .sub { color: #64748b; font-size: 12px; }
    .tag {
        padding: 4px 8px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 700;
        background: #fee2e2;
        color: #b91c1c;
    }
    .tag.low { background: #ffedd5; color: #c2410c; }

    .wide { margin-top: 14px; }
    .search {
        display: flex;
        align-items: center;
        gap: 8px;
        border: 1px solid var(--line);
        border-radius: 10px;
        padding: 8px 10px;
        width: min(280px, 100%);
    }
    .pagination {
        display: flex;
        gap: 6px;
        align-items: center;
        justify-content: flex-end;
    }
    .page-btn {
        border: 1px solid var(--line);
        padding: 6px 10px;
        border-radius: 8px;
        background: #fff;
        font-size: 12px;
    }

    @media (max-width: 1100px) {
        .grid { grid-template-columns: 1fr; }
        .stat-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    }

    @media (max-width: 600px) {
        .stat-grid { grid-template-columns: 1fr; }
        .page { padding: 16px; }
    }
</style>
@endpush

@section('content')
    <div class="page-head">
        <div>
            <h1>Dashboard</h1>
            <p>HQ overview and activity</p>
        </div>
        <div class="filters">
            <input type="date">
            <span style="align-self:center;color:#94a3b8;">to</span>
            <input type="date">
            <select>
                <option>All Kitchens</option>
                <option>Kitchen A</option>
                <option>Kitchen B</option>
            </select>
        </div>
    </div>

    <section class="stat-grid">
        <div class="stat">
            <div class="title">Pending Material Requests</div>
            <div class="value">5</div>
            <div class="meta">Awaiting HQ approval</div>
        </div>
        <div class="stat orange">
            <div class="title">Low Stock Items</div>
            <div class="value">8</div>
            <div class="meta">Below threshold</div>
        </div>
        <div class="stat red">
            <div class="title">Low Stock Alerts</div>
            <div class="value">3</div>
            <div class="meta" style="color:#ef4444;">Critical items</div>
        </div>
        <div class="stat green">
            <div class="title">Active Events</div>
            <div class="value">12</div>
            <div class="meta">Confirmed</div>
        </div>
    </section>

    <section class="grid">
        <div class="card">
            <div class="card-head">
                <div class="card-title">Pending Material Requests</div>
                <button class="btn-sm">View All</button>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Request #</th>
                        <th>Kitchen</th>
                        <th>Date</th>
                        <th>Items</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><b>MR-001</b></td>
                        <td>Kitchen A</td>
                        <td>17 Feb 2026</td>
                        <td>5 items</td>
                        <td><span class="pill pending">Pending</span></td>
                        <td>👁️</td>
                    </tr>
                    <tr>
                        <td><b>MR-002</b></td>
                        <td>Kitchen B</td>
                        <td>16 Feb 2026</td>
                        <td>8 items</td>
                        <td><span class="pill approved">Approved</span></td>
                        <td>🚚</td>
                    </tr>
                    <tr>
                        <td><b>MR-003</b></td>
                        <td>Kitchen A</td>
                        <td>15 Feb 2026</td>
                        <td>3 items</td>
                        <td><span class="pill received">Received</span></td>
                        <td>👁️</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="card">
            <div class="card-head">
                <div class="card-title">Low Stock Alerts</div>
                <button class="btn-sm" style="background:#f97316;">View All Alerts</button>
            </div>
            <div class="alert-item">
                <div>
                    <div class="name">Cooking Oil</div>
                    <div class="sub">5 L remaining</div>
                </div>
                <span class="tag">Critical</span>
            </div>
            <div class="alert-item">
                <div>
                    <div class="name">Basmati Rice</div>
                    <div class="sub">15 kg remaining</div>
                </div>
                <span class="tag low">Low</span>
            </div>
            <div class="alert-item">
                <div>
                    <div class="name">Paneer</div>
                    <div class="sub">8 kg remaining</div>
                </div>
                <span class="tag low">Low</span>
            </div>
        </div>
    </section>

    <section class="card wide">
        <div class="card-head">
            <div class="card-title">Recent Activity</div>
            <div style="display:flex; gap:8px;">
                <button class="btn-sm">View All</button>
                <button class="btn-sm">Export</button>
            </div>
        </div>
        <div class="search">🔎 <span style="color:#94a3b8;">Search activity...</span></div>
        <table style="margin-top:10px;">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Action</th>
                    <th>User</th>
                    <th>Module</th>
                </tr>
            </thead>
            <tbody>
                <tr><td>2026-02-17</td><td>10:30</td><td>Material Request Created</td><td>Rajesh</td><td>Material Request</td></tr>
                <tr><td>2026-02-17</td><td>09:15</td><td>Stock In</td><td>Amit</td><td>Inventory</td></tr>
                <tr><td>2026-02-16</td><td>16:00</td><td>Event Created</td><td>Priya</td><td>Events</td></tr>
                <tr><td>2026-02-16</td><td>14:30</td><td>Staff Assigned</td><td>Rajesh</td><td>Staff</td></tr>
                <tr><td>2026-02-15</td><td>11:00</td><td>HQ Profile Updated</td><td>Admin</td><td>HQ Setup</td></tr>
            </tbody>
        </table>
        <div class="pagination" style="margin-top:10px;">
            <span class="page-btn">Previous</span>
            <span class="page-btn" style="background:#f97316;color:#fff;border-color:#f97316;">1</span>
            <span class="page-btn">2</span>
            <span class="page-btn">Next</span>
        </div>
    </section>
@endsection
