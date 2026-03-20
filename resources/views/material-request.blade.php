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

    .page-head h1 {
        margin: 0;
        font-size: 22px;
    }

    .page-head p {
        margin: 4px 0 0;
        color: var(--muted);
        font-size: 13px;
    }

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

    .stat.orange::before {
        background: #f97316;
    }

    .stat.red::before {
        background: #ef4444;
    }

    .stat.green::before {
        background: #16a34a;
    }

    .stat .title {
        color: #64748b;
        font-size: 12px;
    }

    .stat .value {
        font-size: 22px;
        font-weight: 800;
    }

    .stat .meta {
        color: #64748b;
        font-size: 12px;
    }

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

    th,
    td {
        text-align: left;
        padding: 10px 8px;
        border-bottom: 1px solid #eef2f7;
    }

    th {
        color: #64748b;
        font-weight: 700;
    }

    .pill {
        display: inline-flex;
        align-items: center;
        padding: 4px 8px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 700;
    }

    .pill.pending {
        background: #fff3cd;
        color: #b45309;
    }

    .pill.approved {
        background: #dbeafe;
        color: #1d4ed8;
    }

    .pill.received {
        background: #dcfce7;
        color: #15803d;
    }

    .alert-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px;
        border-radius: 10px;
        background: #f8fafc;
        margin-bottom: 8px;
    }

    .alert-item .name {
        font-weight: 700;
    }

    .alert-item .sub {
        color: #64748b;
        font-size: 12px;
    }

    .tag {
        padding: 4px 8px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 700;
        background: #fee2e2;
        color: #b91c1c;
    }

    .tag.low {
        background: #ffedd5;
        color: #c2410c;
    }

    .wide {
        margin-top: 14px;
    }

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
        .grid {
            grid-template-columns: 1fr;
        }

        .stat-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 600px) {
        .stat-grid {
            grid-template-columns: 1fr;
        }

        .page {
            padding: 16px;
        }
    }

</style>
@endpush

@section('content')
@vite(['resources/css/app.css', 'resources/js/app.js'])

<div class="page-head">
    <div>
        <h1>Material Requests</h1>
        <p>Kitchen → HQ request flow</p>
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
        <div class="title">Pending</div>
        <div class="value">2</div>
        <div class="meta">Awaiting HQ approval</div>
    </div>
    <div class="stat orange">
        <div class="title">Approved</div>
        <div class="value">5</div>
        <div class="meta">Ready to dispatch</div>
    </div>
    <div class="stat red">
        <div class="title">Dispatched</div>
        <div class="value">3</div>
        <div class="meta" style="color:#ef4444;">In transit</div>
    </div>
    <div class="stat green">
        <div class="title">Received</div>
        <div class="value">12</div>
        <div class="meta">Completed</div>
    </div>
</section>

<section style="padding-top: 21px;">
    <div class="card">
        <table>
            <thead>
                <tr>
                    <th>Request</th>
                    <th>Kitchen</th>
                    <th>Date</th>
                    <th>Items</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @if (isset($material_request))
                @foreach ($material_request as $item)
                <tr>
                    <td><b>MR-{{ $item->id }}</b></td>
                    <td>Kitchen A</td>
                    <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}</td>
                    <td>{{ $item->item_count }} items</td>
                    <td><span class="pill pending">{{ $item->status }}</span></td>
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>
    </div>
</section>

<script>
    // Pusher.logToConsole = true;
    document.addEventListener('DOMContentLoaded', (event) => {
        window.Echo.channel("channel-low-stock")
            .listen(".event-low-stock", (e) => {
                oldhtml = $('#dataofnotification').html();
                const dateObj = new Date(e['notification'].created_at);

                // Format as dd/mm/yy
                const formatted = dateObj.toLocaleDateString('en-GB', {
                    day: '2-digit'
                    , month: '2-digit'
                    , year: '2-digit'
                });


                var html = `<div style="background: var(--card); border: 1px solid var(--line); border-radius: 14px; padding: 14px; overflow: hidden;">
    <div style="display: flex">
        <div style="font-size: 15px;">
           ${e['notification'].message}
        </div>
        <div style="font-size: 12px;">
            ${formatted}
        </div>
    </div>
    <div style="font-size: 11px;">
        ${e['notification'].data}
    </div>
</div>
`;
                $('#dataofnotification').html(html + oldhtml);


            });
    });

</script>
@endsection
