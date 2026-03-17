<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Petty Cash Report</title>
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
    <h1>Petty Cash Report</h1>
    <div class="meta">Generated on {{ \Illuminate\Support\Carbon::now()->format('d M Y') }}</div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Captain</th>
                <th>Amount</th>
                <th>Issue Date</th>
                <th>Created By</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($issues as $issue)
            <tr>
                <td>{{ $issue->id }}</td>
                <td>{{ $issue->captain_name ?: '-' }}</td>
                <td>{{ number_format((float) $issue->amount, 2) }}</td>
                <td>{{ $issue->issue_date ? \Illuminate\Support\Carbon::parse($issue->issue_date)->format('d M Y') : '-' }}</td>
                <td>{{ $issue->created_by_name ?: '-' }}</td>
                <td>{{ $issue->created_at ? \Illuminate\Support\Carbon::parse($issue->created_at)->format('d M Y') : '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6">No petty cash issues match your filters.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
