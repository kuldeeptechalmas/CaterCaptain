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
                <th>Date</th>
                <th>Type</th>
                <th>Amount</th>
                <th>Note</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($entries as $entry)
            <tr>
                <td>{{ $entry->entry_date ? \Illuminate\Support\Carbon::parse($entry->entry_date)->format('Y-m-d') : '-' }}</td>
                <td>{{ $entry->type }}</td>
                <td>{{ number_format((float) $entry->amount, 2) }}</td>
                <td>{{ $entry->note ?: '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4">No petty cash entries match your filters.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 14px; font-weight: bold;">Balances</div>
    <table style="margin-top: 6px;">
        <thead>
            <tr>
                <th>Opening Balance</th>
                <th>Total Spent</th>
                <th>Current Balance</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ number_format((float) $issueTotal, 2) }}</td>
                <td>{{ number_format((float) $spendTotal, 2) }}</td>
                <td>{{ number_format((float) $totalBalance, 2) }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
