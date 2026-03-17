<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Raw Material Report</title>
    <style>
        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            color: #111827;
            font-size: 12px;
        }

        h1 {
            margin: 0 0 10px;
            font-size: 18px;
        }

        .meta {
            color: #6b7280;
            margin-bottom: 14px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #e5e7eb;
            padding: 8px;
            text-align: left;
        }

        th {
            background: #f3f4f6;
        }

    </style>
</head>
<body>
    <h1>Raw Material Report</h1>
    <div class="meta">Generated on {{ \Illuminate\Support\Carbon::now()->format('d M Y') }}</div>

    @if(isset($moments) && count($moments) > 0)
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
                <td colspan="8">No raw material movements match your filters.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    @endif

    <table style="margin-top: 16px;">
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
                <td>{{ $material->is_active ? 'Active' : 'Inactive' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="9">No raw materials match your filters.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
