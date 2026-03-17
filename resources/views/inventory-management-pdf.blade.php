<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Inventory Management</title>
    <style>
        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            color: #111827;
            font-size: 12px;
        }
        h1 { margin: 0 0 6px; font-size: 18px; }
        .meta { color: #6b7280; margin-bottom: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #e5e7eb; padding: 6px; text-align: left; }
        th { background: #f3f4f6; }
        .summary { margin-top: 12px; }
    </style>
</head>
<body>
    <h1>Raw Material Ledger</h1>
    <div class="meta">Generated on {{ \Illuminate\Support\Carbon::now()->format('d M Y') }}</div>

    <div class="summary">
        <table>
            <thead>
                <tr>
                    <th>Material</th>
                    <th>Current Qty</th>
                    <th>Minimum Qty</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $selectedMaterial->name ?? '-' }}</td>
                    <td>{{ number_format((float) ($selectedMaterial->qty ?? 0), 2) }} {{ $selectedMaterial->unit_symbol ?? '' }}</td>
                    <td>{{ number_format((float) ($selectedMaterial->min_qty ?? 0), 2) }} {{ $selectedMaterial->unit_symbol ?? '' }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div style="margin-top: 12px; font-weight: bold;">Ledger Entries</div>
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
                <td colspan="6">No ledger entries found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
