@extends('layouts.dashboard')

@section('title', 'Petty Cash | CaterCaptain')

@section('crumbs')
    Home / <b>Petty Cash</b>
@endsection

@push('styles')
<style>
    .page-head h1 { margin: 0; font-size: 22px; }
    .page-head p { margin: 4px 0 0; color: var(--muted); font-size: 13px; }
    .tabs {
        margin-top: 18px;
        display: flex;
        gap: 24px;
        border-bottom: 1px solid var(--line);
    }
    .tab {
        padding: 10px 2px 12px;
        font-weight: 700;
        color: #64748b;
        cursor: pointer;
        border-bottom: 2px solid transparent;
    }
    .tab.active { color: var(--orange); border-color: var(--orange); }
    .card {
        margin-top: 16px;
        background: var(--card);
        border: 1px solid var(--line);
        border-radius: 14px;
        padding: 16px;
        box-shadow: 0 10px 30px rgba(15, 23, 42, 0.06);
    }
    .form-grid {
        display: grid;
        grid-template-columns: repeat(12, minmax(0, 1fr));
        gap: 12px;
    }
    .field { display: grid; gap: 6px; }
    .field label { font-size: 13px; font-weight: 700; }
    .field input,
    .field select {
        width: 100%;
        border: 1px solid #cbd5e1;
        border-radius: 10px;
        padding: 10px 12px;
        font: inherit;
    }
    .col-12 { grid-column: span 12; }
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
    .summary {
        margin-top: 14px;
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 12px;
    }
    .summary-card {
        background: #fff;
        border: 1px solid var(--line);
        border-radius: 14px;
        padding: 14px;
        position: relative;
        overflow: hidden;
    }
    .summary-card::before {
        content: "";
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 4px;
        background: var(--orange);
    }
    .summary-card .label { color: var(--muted); font-size: 12px; }
    .summary-card .value { margin-top: 6px; font-weight: 800; font-size: 20px; }
    table {
        width: 100%;
        border-collapse: collapse;
        min-width: 620px;
        font-size: 13px;
    }
    th, td {
        text-align: left;
        padding: 10px 8px;
        border-bottom: 1px solid #eef2f7;
    }
    th { color: #64748b; font-weight: 700; }
    .type-badge {
        display: inline-flex;
        align-items: center;
        padding: 4px 10px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 700;
        background: #e0f2fe;
        color: #0284c7;
    }
    .type-badge.spend { background: #fee2e2; color: #dc2626; }
    .hidden { display: none; }
    .msg {
        margin-top: 10px;
        border-radius: 10px;
        font-size: 13px;
        padding: 10px 12px;
    }
    .msg.ok { color: #15803d; background: #dcfce7; border: 1px solid #86efac; }
    .msg.err { color: #b91c1c; background: #fee2e2; border: 1px solid #fca5a5; }
    @media (max-width: 720px) {
        .summary { grid-template-columns: 1fr; }
    }
</style>
@endpush

@section('content')
    <div class="page-head">
        <h1>Petty Cash (Cater Captain)</h1>
        <p>Issue, spend and view petty cash ledger</p>
    </div>

    @if (session('status'))
    <div class="msg ok">{{ session('status') }}</div>
    @endif

    @if ($errors->any())
    <div class="msg err">{{ $errors->first() }}</div>
    @endif

    <div class="tabs">
        <div class="tab active" data-tab="issue">Petty Cash Issue</div>
        <div class="tab" data-tab="ledger">Petty Cash Ledger</div>
    </div>

    <section id="tab-issue" class="card">
        <div style="display:flex; align-items:center; gap:8px; font-weight:800; margin-bottom:6px;">
            <span style="width:20px;height:20px;border-radius:50%;background:#ffedd5;color:#f97316;display:grid;place-items:center;">+</span>
            Petty Cash Issue
        </div>
        <p style="color:#64748b; margin-top:0;">Record when petty cash is issued to Cater Captain.</p>

        <form method="POST" action="{{ route('petty-cash.issue.store') }}">
            @csrf
            <div class="form-grid">
                <div class="field col-12">
                    <label for="captain_id">Catercaptain *</label>
                    <select id="captain_id" name="captain_id" required>
                        <option value="">Select Catercaptain</option>
                        @foreach ($users as $user)
                        <option value="{{ $user->id }}" {{ old('captain_id') == $user->id ? 'selected' : '' }}>
                            {{ trim($user->first_name . ' ' . $user->last_name) }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="field col-12">
                    <label for="amount">Amount (₹) *</label>
                    <input id="amount" name="amount" type="number" step="0.01" value="{{ old('amount', '0') }}" required>
                </div>
                <div class="field col-12">
                    <label for="issue_date">Date *</label>
                    <input id="issue_date" name="issue_date" type="date" value="{{ old('issue_date', now()->toDateString()) }}" required>
                </div>
            </div>
            <div style="margin-top:12px;">
                <button class="btn-primary" type="submit">Record Issue</button>
            </div>
        </form>
    </section>

    <section id="tab-ledger" class="card hidden">
        <div class="summary">
            <div class="summary-card">
                <div class="label">Opening Balance</div>
                <div class="value">₹ {{ number_format((float) $issueTotal, 2) }}</div>
            </div>
            <div class="summary-card">
                <div class="label">Total Spent</div>
                <div class="value">₹ {{ number_format((float) $spendTotal, 2) }}</div>
            </div>
            <div class="summary-card">
                <div class="label">Current Balance</div>
                <div class="value">₹ {{ number_format((float) $totalBalance, 2) }}</div>
            </div>
        </div>

        <div style="margin-top:12px; display:flex; gap:8px; flex-wrap:wrap;">
            <a class="btn-primary" style="background:#fff;color:#f97316;border:1px solid #fdba74;" href="{{ route('petty-cash.report.pdf', request()->query()) }}" target="_blank">View PDF</a>
            <a class="btn-primary" style="background:#fff;color:#f97316;border:1px solid #fdba74;" href="{{ route('petty-cash.report.pdf.download', request()->query()) }}">Download PDF</a>
        </div>

        <div class="table-wrap" style="margin-top:10px; overflow:auto;">
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
                        <td>
                            <span class="type-badge {{ strtolower($entry->type) === 'spend' ? 'spend' : '' }}">
                                {{ $entry->type }}
                            </span>
                        </td>
                        <td>₹ {{ number_format((float) $entry->amount, 2) }}</td>
                        <td>{{ $entry->note ?: '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" style="color:#94a3b8;">No petty cash entries match your filters.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    const tabs = document.querySelectorAll('.tab');
    const issue = document.getElementById('tab-issue');
    const ledger = document.getElementById('tab-ledger');

    tabs.forEach((tab) => {
        tab.addEventListener('click', () => {
            tabs.forEach(t => t.classList.remove('active'));
            tab.classList.add('active');
            const target = tab.dataset.tab;
            issue.classList.toggle('hidden', target !== 'issue');
            ledger.classList.toggle('hidden', target !== 'ledger');
        });
    });
</script>
@endpush
