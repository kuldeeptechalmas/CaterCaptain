<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'CaterCaptain')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --navy: #0f172a;
            --teal: #0f766e;
            --amber: #f59e0b;
            --paper: #ffffff;
            --ink: #1e293b;
            --muted: #64748b;
            --line: #cbd5e1;
            --good: #15803d;
            --bad: #b91c1c;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Manrope', sans-serif;
            color: var(--ink);
            background:
                radial-gradient(circle at 15% 15%, rgba(15, 118, 110, 0.2), transparent 35%),
                radial-gradient(circle at 95% -10%, rgba(245, 158, 11, 0.2), transparent 42%),
                #f8fafc;
            min-height: 100vh;
        }

        .shell {
            width: min(1120px, 94%);
            margin: 22px auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            align-items: stretch;
        }

        .promo {
            border-radius: 22px;
            padding: 28px;
            background: linear-gradient(140deg, var(--teal), var(--navy));
            color: #e2e8f0;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 560px;
        }

        .brand {
            font-size: 32px;
            font-weight: 800;
            letter-spacing: 0.3px;
            margin: 0 0 8px;
        }

        .tag {
            margin: 0;
            color: #cbd5e1;
            max-width: 28ch;
            line-height: 1.5;
        }

        .stats {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }

        .stat {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            padding: 12px;
        }

        .stat b {
            font-size: 20px;
            display: block;
        }

        .stat span {
            color: #cbd5e1;
            font-size: 12px;
        }

        .card {
            border-radius: 22px;
            padding: 28px;
            background: var(--paper);
            border: 1px solid #e2e8f0;
            box-shadow: 0 20px 45px rgba(15, 23, 42, 0.08);
        }

        .tabs {
            display: flex;
            gap: 10px;
            margin-bottom: 18px;
        }

        .tab {
            text-decoration: none;
            font-size: 13px;
            font-weight: 700;
            padding: 9px 13px;
            border-radius: 999px;
            border: 1px solid var(--line);
            color: var(--muted);
        }

        .tab.active {
            color: #fff;
            border-color: transparent;
            background: linear-gradient(90deg, var(--teal), var(--amber));
        }

        h1 {
            margin: 0;
            font-size: 30px;
            color: #0b1220;
        }

        .sub {
            margin: 8px 0 18px;
            color: var(--muted);
            font-size: 14px;
        }

        label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 6px;
        }

        input {
            width: 100%;
            border-radius: 12px;
            border: 1px solid var(--line);
            padding: 11px 12px;
            margin-bottom: 14px;
            font: inherit;
            font-size: 14px;
        }

        input:focus {
            outline: none;
            border-color: var(--teal);
            box-shadow: 0 0 0 3px rgba(15, 118, 110, 0.15);
        }

        .grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .row-inline {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
            font-size: 13px;
            color: var(--muted);
        }

        .row-inline input[type='checkbox'] {
            width: auto;
            margin: 0 6px 0 0;
            transform: translateY(1px);
        }

        .btn {
            width: 100%;
            border: 0;
            border-radius: 12px;
            padding: 12px;
            font: inherit;
            font-size: 14px;
            font-weight: 800;
            color: white;
            background: linear-gradient(90deg, var(--teal), var(--amber));
            cursor: pointer;
        }

        .msg {
            border-radius: 10px;
            font-size: 13px;
            padding: 10px 12px;
            margin-bottom: 12px;
        }

        .msg.ok {
            color: var(--good);
            background: #dcfce7;
            border: 1px solid #86efac;
        }

        .msg.err {
            color: var(--bad);
            background: #fee2e2;
            border: 1px solid #fca5a5;
        }

        @media (max-width: 980px) {
            .shell {
                grid-template-columns: 1fr;
            }

            .promo {
                min-height: 220px;
            }
        }

        @media (max-width: 620px) {
            .grid-2 {
                grid-template-columns: 1fr;
            }

            .card,
            .promo {
                padding: 20px;
                border-radius: 16px;
            }

            h1 {
                font-size: 24px;
            }
        }

    </style>
</head>
<body>
    <div class="shell">
        <aside class="promo">
            <div>
                <p class="brand">CaterCaptain</p>
                <p class="tag">Plan events, control kitchen operations, manage materials and teams from one smart dashboard.</p>
            </div>
            <div class="stats">
                <div class="stat"><b>120+</b><span>Events Managed</span></div>
                <div class="stat"><b>45</b><span>Staff On Roll</span></div>
                <div class="stat"><b>98%</b><span>On-Time Dispatch</span></div>
                <div class="stat"><b>24x7</b><span>Operations Ready</span></div>
            </div>
        </aside>

        <main class="card">
            <div class="tabs">
                <a href="{{ route('logins') }}" class="tab {{ request()->routeIs('logins') ? 'active' : '' }}">Login</a>
                <a href="{{ route('register') }}" class="tab {{ request()->routeIs('register') ? 'active' : '' }}">Register</a>
                @guest
                <a href="{{ route('forgot-password') }}" class="tab {{ request()->routeIs('forgot-password') ? 'active' : '' }}">Forgot</a>
                @endguest
                @auth
                <a href="{{ route('change-password') }}" class="tab {{ request()->routeIs('change-password') ? 'active' : '' }}">Change Password</a>
                @endauth
            </div>

            @if (session('status'))
            <div class="msg ok">{{ session('status') }}</div>
            @endif

            @if ($errors->any())
            <div class="msg err">{{ $errors->first() }}</div>
            @endif

            @yield('content')
        </main>
    </div>
</body>
</html>
