<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Petty Cash Report | CaterCaptain</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #f5f7fb;
            --ink: #0f172a;
            --muted: #64748b;
            --card: #ffffff;
            --border: #e2e8f0;
            --accent: #0f766e;
            --accent-2: #f59e0b;
        }

        body {
            margin: 0;
            font-family: 'Manrope', sans-serif;
            background: radial-gradient(circle at 10% 10%, rgba(15, 118, 110, 0.08), transparent 55%), var(--bg);
            color: var(--ink);
        }

        .wrap {
            width: min(1180px, 94%);
            margin: 22px auto 40px;
        }

        .page-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
        }

        .page-head h1 {
            margin: 0;
            font-size: 28px;
            letter-spacing: -0.02em;
        }

        .back-link {
            text-decoration: none;
            font-weight: 700;
            color: var(--accent);
        }

        .filters {
            margin-top: 16px;
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 18px;
            padding: 18px;
            display: grid;
            grid-template-columns: repeat(12, minmax(0, 1fr));
            gap: 14px;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.06);
        }

        .field {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .field label {
            font-size: 12px;
            font-weight: 800;
            color: #475569;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .filters input,
        .filters select {
            width: 100%;
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 11px 12px;
            font: inherit;
            background: #fff;
        }

        .filters input:focus,
        .filters select:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(15, 118, 110, 0.15);
        }

        .field.search {
            grid-column: span 4;
        }

        .field.captain {
            grid-column: span 3;
        }

        .field.creator {
            grid-column: span 3;
        }

        .field.date-from,
        .field.date-to {
            grid-column: span 2;
        }

        .field.amount-min,
        .field.amount-max {
            grid-column: span 2;
        }

        .actions {
            grid-column: span 6;
            display: flex;
            gap: 10px;
            align-items: flex-end;
            flex-wrap: wrap;
            padding-top: 19px;
            align-items: center;
        }

        .btn {
            border: 0;
            border-radius: 12px;
            padding: 11px 16px;
            font: inherit;
            font-weight: 800;
            cursor: pointer;
        }

        .btn-primary {
            background: linear-gradient(90deg, var(--accent), var(--accent-2));
            color: #fff;
        }

        .btn-ghost {
            background: #e2e8f0;
            color: #0f172a;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-outline {
            background: #fff;
            color: var(--accent);
            border: 1px solid rgba(15, 118, 110, 0.3);
        }

        .table-wrap {
            margin-top: 16px;
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 18px;
            overflow: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 860px;
        }

        th,
        td {
            padding: 12px 14px;
            text-align: left;
            border-bottom: 1px solid var(--border);
            font-size: 14px;
        }

        th {
            background: #f1f5f9;
            color: #475569;
            position: sticky;
            top: 0;
        }

        .empty {
            padding: 18px;
            text-align: center;
            color: #64748b;
        }

        @media (max-width: 1100px) {
            .field.search {
                grid-column: span 6;
            }

            .field.captain,
            .field.creator {
                grid-column: span 3;
            }

            .field.date-from,
            .field.date-to,
            .field.amount-min,
            .field.amount-max {
                grid-column: span 3;
            }

            .actions {
                grid-column: span 12;
            }
        }

        @media (max-width: 820px) {
            .filters {
                grid-template-columns: repeat(6, minmax(0, 1fr));
            }

            .field.search {
                grid-column: span 6;
            }

            .field.captain,
            .field.creator,
            .field.date-from,
            .field.date-to,
            .field.amount-min,
            .field.amount-max {
                grid-column: span 3;
            }

            .actions {
                grid-column: span 6;
            }
        }

        @media (max-width: 560px) {
            .filters {
                grid-template-columns: 1fr;
            }

            .field,
            .actions {
                grid-column: span 1;
            }

            .actions {
                flex-direction: column;
                align-items: stretch;
            }
        }

        @media (max-width: 960px) {
            .filters {
                grid-template-columns: repeat(6, minmax(0, 1fr));
            }

            .field.search,
            .field.captain,
            .field.creator {
                grid-column: span 6;
            }

            .field.date-from,
            .field.date-to,
            .field.amount-min,
            .field.amount-max {
                grid-column: span 3;
            }

            .actions {
                grid-column: span 6;
            }
        }

        @media (max-width: 720px) {
            .filters {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .field,
            .actions {
                grid-column: span 2;
            }
        }

    </style>
</head>
<body>
    <div class="wrap">
        <div class="page-head">
            <h1>Petty Cash Report</h1>
            <a class="back-link" href="{{ route('dashboard') }}">Back to Dashboard</a>
        </div>

        <form class="filters" method="GET" action="{{ route('petty-cash.report') }}">
            <div class="field search" style="margin-right: 20px;">
                <label for="q">Search Captain</label>
                <input id="q" name="q" type="text" value="{{ request('q') }}" placeholder="e.g. Alex">
            </div>

            <div class="field captain">
                <label for="captain_id">Captain</label>
                <select id="captain_id" name="captain_id">
                    <option value="">All captains</option>
                    @foreach ($users as $user)
                    <option value="{{ $user->id }}" {{ request('captain_id') == $user->id ? 'selected' : '' }}>
                        {{ trim($user->first_name . ' ' . $user->last_name) }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="field creator">
                <label for="created_by">Created By</label>
                <select id="created_by" name="created_by">
                    <option value="">All users</option>
                    @foreach ($users as $user)
                    <option value="{{ $user->id }}" {{ request('created_by') == $user->id ? 'selected' : '' }}>
                        {{ trim($user->first_name . ' ' . $user->last_name) }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="field date-from" style="margin-right: 20px;">
                <label for="date_from">Date From</label>
                <input id="date_from" name="date_from" type="date" value="{{ request('date_from') }}">
            </div>

            <div class="field date-to" style="margin-right: 20px;">
                <label for="date_to">Date To</label>
                <input id="date_to" name="date_to" type="date" value="{{ request('date_to') }}">
            </div>

            <div class="field amount-min" style="margin-right: 20px;">
                <label for="amount_min">Amount Min</label>
                <input id="amount_min" name="amount_min" type="number" step="0.01" value="{{ request('amount_min') }}">
            </div>

            <div class="field amount-max" style="margin-right: 20px;">
                <label for="amount_max">Amount Max</label>
                <input id="amount_max" name="amount_max" type="number" step="0.01" value="{{ request('amount_max') }}">
            </div>

            <div class="actions">
                <button type="submit" class="btn btn-primary">Apply Filters</button>
                <a class="btn btn-ghost" href="{{ route('petty-cash.report') }}">Clear</a>
                <a class="btn btn-outline" href="{{ route('petty-cash.report.pdf', parameters: request()->query()) }}" target="_blank">View PDF</a>
                <a class="btn btn-outline" href="{{ route('petty-cash.report.pdf.download', request()->query()) }}">Download PDF</a>
            </div>
        </form>

        <div class="table-wrap">
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
                        <td colspan="6" class="empty">No petty cash issues match your filters.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
