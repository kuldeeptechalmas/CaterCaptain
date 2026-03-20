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
    <h1>Wastage Record</h1>
    <div class="meta">Generated on {{ \Illuminate\Support\Carbon::now()->format('d M Y') }}</div>

    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Kitchen</th>
                <th>Material</th>
                <th>Qty</th>
                <th>Unit</th>
                <th>Note</th>
            </tr>
        </thead>
        <tbody>


            @if (isset($waste_records))
            @foreach ($waste_records as $item)
            <tr>
                <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}</td>
                <td>HQ Cater Caption</td>
                <td>{{ $item->material_name }}</td>
                <td>{{ $item->qty }}</td>
                <td>{{ $item->unit_symbol }}</td>
                <td>{{ $item->note }}</td>
            </tr>
            @endforeach
            @endif
        </tbody>
    </table>
</body>
</html>
