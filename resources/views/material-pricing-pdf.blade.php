<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Material Pricing</title>
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
    </style>
</head>
<body>
    <h1>Material Pricing</h1>
    <div class="meta">Generated on {{ \Illuminate\Support\Carbon::now()->format('d M Y') }}</div>

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
            </tr>
        </thead>
        <tbody>
            @forelse ($materials as $index => $material)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $material->name }}</td>
                <td>{{ $material->unit_symbol ?? '-' }}</td>
                <td>{{ $material->price_unit ? '₹ ' . number_format((float) $material->price_unit, 0) : '-' }}</td>
                <td>{{ $material->price_kg ? '₹ ' . number_format((float) $material->price_kg, 0) : '-' }}</td>
                <td>{{ $material->price_litre ? '₹ ' . number_format((float) $material->price_litre, 0) : '-' }}</td>
                <td>{{ $material->price_piece ? '₹ ' . number_format((float) $material->price_piece, 0) : '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7">No materials found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
