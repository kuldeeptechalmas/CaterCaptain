<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'CaterCaptain')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg: #f6f7fb;
            --card: #ffffff;
            --ink: #0f172a;
            --muted: #64748b;
            --line: #e2e8f0;
            --orange: #f97316;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Manrope', sans-serif;
            background: var(--bg);
            color: var(--ink);
        }

        .app {
            min-height: 100vh;
            display: grid;
            grid-template-columns: 260px 1fr;
        }

        .sidebar {
            background: #fff;
            border-right: 1px solid var(--line);
            padding: 18px 14px;
            position: sticky;
            top: 0;
            height: 100vh;
            overflow: auto;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 10px 18px;
            font-weight: 800;
            color: var(--orange);
        }

        .brand .logo {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            display: grid;
            place-items: center;
            color: #fff;
            background: linear-gradient(135deg, #f97316, #7c3aed);
        }

        .nav-group {
            margin-top: 14px;
        }

        .nav-title {
            font-size: 11px;
            font-weight: 800;
            color: #94a3b8;
            padding: 6px 12px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .nav a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            margin: 4px 6px;
            border-radius: 10px;
            color: #475569;
            text-decoration: none;
            font-size: 14px;
        }

        .nav a.active {
            background: #fff3e8;
            color: #f97316;
            font-weight: 700;
        }

        .content {
            display: grid;
            grid-template-rows: auto 1fr;
        }

        .topbar {
            background: #fff;
            border-bottom: 1px solid var(--line);
            padding: 12px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }

        .crumbs {
            color: #64748b;
            font-size: 14px;
        }

        .top-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .chip {
            width: 34px;
            height: 34px;
            border: 0;
            border-radius: 10px;
            background: #f1f5f9;
            display: grid;
            place-items: center;
            font-weight: 700;
            cursor: pointer;
        }

        .notification-shell {
            position: relative;
        }

        .notification-bell {
            position: relative;
        }

        .notification-bell.is-open {
            background: #fff3e8;
            color: #f97316;
        }

        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            min-width: 18px;
            height: 18px;
            padding: 0 5px;
            border-radius: 999px;
            background: #ef4444;
            color: #fff;
            font-size: 11px;
            font-weight: 800;
            display: grid;
            place-items: center;
            border: 2px solid #fff;
        }

        .notification-panel {
            position: absolute;
            top: calc(100% + 12px);
            right: 0;
            width: min(640px, calc(100vw - 32px));
            background: #fff;
            border: 1px solid var(--line);
            border-radius: 18px;
            box-shadow: 0 24px 60px rgba(15, 23, 42, 0.18);
            overflow: hidden;
            z-index: 1200;
        }

        .notification-panel[hidden] {
            display: none;
        }

        .notification-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 16px 18px;
            border-bottom: 1px solid #eef2f7;
            background: linear-gradient(135deg, #fff7ed, #ffffff);
        }

        .notification-title {
            font-size: 15px;
            font-weight: 800;
        }

        .notification-subtitle {
            margin-top: 4px;
            color: var(--muted);
            font-size: 12px;
        }

        .notification-body {
            display: grid;
            grid-template-columns: minmax(240px, 280px) minmax(0, 1fr);
            min-height: 280px;
        }

        .notification-list {
            padding: 10px;
            border-right: 1px solid #eef2f7;
            background: #fbfdff;
            overflow-y: auto;
            max-height: 360px;
        }

        .notification-empty {
            padding: 18px;
            color: var(--muted);
            font-size: 13px;
            line-height: 1.6;
        }

        .notification-item {
            width: 100%;
            border: 1px solid transparent;
            border-radius: 14px;
            background: transparent;
            padding: 12px;
            text-align: left;
            display: grid;
            gap: 6px;
            cursor: pointer;
            transition: background 0.18s ease, border-color 0.18s ease, transform 0.18s ease;
        }

        .notification-item+.notification-item {
            margin-top: 8px;
        }

        .notification-item:hover,
        .notification-item.is-active {
            background: #fff3e8;
            border-color: #fed7aa;
            transform: translateY(-1px);
        }

        .notification-item.is-unread .notification-item-title::before {
            content: "";
            width: 8px;
            height: 8px;
            border-radius: 999px;
            background: #f97316;
            display: inline-block;
            margin-right: 8px;
            vertical-align: middle;
        }

        .notification-item-title {
            font-size: 13px;
            font-weight: 700;
            color: #0f172a;
        }

        .notification-item-message {
            color: #475569;
            font-size: 12px;
            line-height: 1.5;
        }

        .notification-item-time {
            color: #94a3b8;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .notification-detail {
            padding: 20px;
            display: grid;
            align-content: start;
            gap: 14px;
        }

        .notification-detail-card {
            background: linear-gradient(180deg, #fff7ed 0%, #ffffff 100%);
            border: 1px solid #fed7aa;
            border-radius: 18px;
            padding: 18px;
        }

        .notification-detail-label {
            font-size: 11px;
            font-weight: 800;
            color: #9a3412;
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }

        .notification-detail-title {
            margin-top: 8px;
            font-size: 20px;
            font-weight: 800;
            line-height: 1.3;
        }

        .notification-detail-message {
            margin-top: 10px;
            font-size: 14px;
            line-height: 1.7;
            color: #475569;
        }

        .notification-meta {
            display: grid;
            gap: 10px;
        }

        .notification-meta-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            padding: 12px 14px;
            border: 1px solid #eef2f7;
            border-radius: 14px;
            background: #fff;
            font-size: 13px;
        }

        .notification-meta-key {
            color: #64748b;
            font-weight: 700;
        }

        .notification-meta-value {
            color: #0f172a;
            font-weight: 700;
            text-align: right;
        }

        .user {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 6px 10px;
            border-radius: 12px;
            background: #f8fafc;
        }

        .user .avatar {
            width: 34px;
            height: 34px;
            border-radius: 10px;
            background: linear-gradient(135deg, #f97316, #7c3aed);
            color: #fff;
            display: grid;
            place-items: center;
            font-weight: 800;
        }

        .page {
            padding: 20px;
        }

        .btn-link {
            border: 0;
            background: transparent;
            color: #f97316;
            font-weight: 700;
            cursor: pointer;
        }

        .modal {
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.6);
            display: none;
            align-items: center;
            justify-content: center;
            padding: 16px;
            z-index: 1000;
        }

        .modal.show {
            display: flex;
        }

        .modal-card {
            width: min(480px, 100%);
            background: #ffffff;
            border-radius: 14px;
            border: 1px solid #e2e8f0;
            padding: 18px;
        }

        .modal-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 8px;
        }

        .modal-title {
            margin: 0;
            font-size: 18px;
        }

        .x-btn {
            border: 0;
            background: #e2e8f0;
            color: #0f172a;
            width: 34px;
            height: 34px;
            border-radius: 8px;
            cursor: pointer;
        }

        .modal label {
            display: block;
            font-size: 13px;
            font-weight: 700;
            margin: 10px 0 6px;
        }

        .modal input {
            width: 100%;
            border: 1px solid #cbd5e1;
            border-radius: 10px;
            padding: 10px 12px;
            font: inherit;
        }

        .modal input:focus {
            outline: none;
            border-color: #f97316;
            box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.15);
        }

        .submit-btn {
            width: 100%;
            margin-top: 14px;
            border: 0;
            border-radius: 10px;
            padding: 11px;
            font: inherit;
            font-weight: 700;
            color: #fff;
            background: #f97316;
            cursor: pointer;
        }

        @media (max-width: 1100px) {
            .app {
                grid-template-columns: 1fr;
            }

            .sidebar {
                position: relative;
                height: auto;
            }

            .notification-panel {
                right: -60px;
            }
        }

        @media (max-width: 760px) {
            .topbar {
                align-items: flex-start;
                flex-direction: column;
            }

            .top-actions {
                width: 100%;
                justify-content: flex-end;
                flex-wrap: wrap;
            }

            .notification-panel {
                right: 0;
                width: min(100vw - 32px, 100%);
            }

            .notification-body {
                grid-template-columns: 1fr;
            }

            .notification-list {
                border-right: 0;
                border-bottom: 1px solid #eef2f7;
                max-height: 220px;
            }
        }

    </style>
    @stack('styles')
</head>
<body>
    <div class="app">
        <aside class="sidebar">
            <div class="brand">
                <span class="logo">🍴</span>
                CaterCaptain
            </div>

            <div class="nav-group">
                <div class="nav-title">Main</div>
                <nav class="nav">
                    <a class="{{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">Dashboard</a>
                </nav>
            </div>

            @if (Auth::user()->hasRole('superadmin'))

            <div class="nav-group">
                <div class="nav-title">HQ Setup</div>
                <nav class="nav">

                    <a class="{{ request()->routeIs('hq.profile') ? 'active' : '' }}" href="{{ route('hq.profile') }}">HQ Profile</a>
                    <a class="{{ request()->routeIs('gst.settings') ? 'active' : '' }}" href="{{ route('gst.settings') }}">GST Settings</a>

                    <a class="{{ request()->routeIs('staff.management') ? 'active' : '' }}" href="{{ route('staff.management') }}">Staff Management</a>

                    <a class="{{ request()->routeIs('inventory.management') ? 'active' : '' }}" href="{{ route('inventory.management') }}">Inventory</a>
                    <a class="{{ request()->routeIs('material.pricing') ? 'active' : '' }}" href="{{ route('material.pricing') }}">Material Pricing</a>
                </nav>
            </div>

            @elseif (Auth::user()->hasRole('manager'))

            <div class="nav-group">
                <div class="nav-title">Inventory</div>
                <nav class="nav">
                    <a class="{{ request()->routeIs('inventory.management') ? 'active' : '' }}" href="{{ route('inventory.management') }}">Inventory</a>
                    <a class="{{ request()->routeIs('material.pricing') ? 'active' : '' }}" href="{{ route('material.pricing') }}">Material Pricing</a>
                </nav>
            </div>

            @elseif (Auth::user()->hasRole('catercaptain'))

            <div class="nav-group">
                <div class="nav-title">Inventory</div>
                <nav class="nav">
                    <a class="{{ request()->routeIs('inventory.management') ? 'active' : '' }}" href="{{ route('inventory.management') }}">Inventory</a>
                </nav>
            </div>

            @endif

            <div class="nav-group">
                <div class="nav-title">Operations</div>
                <nav class="nav">
                    <a href="#">Events</a>
                    <a class="{{ request()->routeIs('material.request') ? 'active' : '' }}" href="{{ route('material.request') }}">Material Request</a>
                    <a class="{{ request()->routeIs('petty-cash.report') ? 'active' : '' }}" href="{{ route('petty-cash.report') }}">Petty Cash</a>
                    <a class="{{ request()->routeIs('wastege.record') ? 'active' : '' }}" href="{{ route('wastege.record') }}">Wastage Entry</a>
                </nav>
            </div>

            @if (Auth::user()->hasRole('superadmin'))
            <div class="nav-group">
                <div class="nav-title">Masters</div>
                <nav class="nav">
                    <a class="{{ request()->routeIs('masters.dishes') ? 'active' : '' }}" href="{{ route('masters.dishes') }}">Dishes</a>
                    <a class="{{ request()->routeIs('masters.categories') ? 'active' : '' }}" href="{{ route('masters.categories') }}">Categories</a>
                    <a class="{{ request()->routeIs('masters.units') ? 'active' : '' }}" href="{{ route('masters.units') }}">Units</a>
                    <a class="{{ request()->routeIs('masters.event-types') ? 'active' : '' }}" href="{{ route('masters.event-types') }}">Event Types</a>
                </nav>
            </div>
            @endif
        </aside>

        <div class="content">
            <div class="topbar">
                <div class="crumbs">@yield('crumbs')</div>
                <div class="top-actions">
                    <button class="btn-link" type="button" id="open-change-password">Change Password</button>
                    <div class="chip" id="clip">🔔</div>
                    <div class="showclip" id="showclip" style="max-height: 275px;z-index: 999;background: var(--card);border: 1px solid var(--line);border-radius: 14px;padding: 14px;overflow: hidden;display: none;position: absolute;top: 10%;right: 8%;width: 255px;overflow: auto;">
                        <div id="dataofnotification">
                            {{-- data of notification add --}}
                        </div>
                    </div>
                    <div class="user">
                        <div class="avatar">{{ strtoupper(substr(auth()->user()->first_name, 0, 1)) }}</div>
                        <div>
                            <div style="font-weight:700;">{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</div>
                            <div style="font-size:12px;color:#64748b;">HQ</div>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="chip" type="submit"><i class="fa-solid fa-arrow-right-from-bracket" style="color: rgb(231, 19, 62);"></i></button>
                    </form>
                </div>
            </div>

            <main class="page">
                @yield('content')
            </main>
        </div>
    </div>

    <div class="modal {{ $errors->any() ? 'show' : '' }}" id="change-password-modal">
        <div class="modal-card">
            <div class="modal-head">
                <h2 class="modal-title">Change Password</h2>
                <button type="button" class="x-btn" id="close-change-password">X</button>
            </div>

            <form method="POST" action="{{ route('change-password.submit') }}">
                @csrf

                <label for="current_password">Current Password</label>
                <input id="current_password" type="password" name="current_password">

                <label for="password">New Password</label>
                <input id="password" type="password" name="password">

                <label for="password_confirmation">Confirm New Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation">

                <button class="submit-btn" type="submit">Update Password</button>
            </form>
        </div>
    </div>
    @stack('scripts')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://ajax.googleapis.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(document).ready(function() {
            $.ajax({
                url: '/notifications', // your route or file
                type: 'GET'
                , success: function(response) {
                    $('#dataofnotification').html(response);

                }
                , error: function(error) {
                    console.log(error);
                }
            });
        });

        const clip = document.getElementById('clip');
        const showclip = document.getElementById('showclip');
        const modal = document.getElementById('change-password-modal');
        const openBtn = document.getElementById('open-change-password');
        const closeBtn = document.getElementById('close-change-password');

        clip.addEventListener('click', () => {
            if (showclip.style.display === "none") {
                showclip.style.display = "block";
            } else {
                showclip.style.display = "none";
            }
        });

        if (openBtn && modal) {
            openBtn.addEventListener('click', function() {
                modal.classList.add('show');
            });
        }

        if (closeBtn && modal) {
            closeBtn.addEventListener('click', function() {
                modal.classList.remove('show');
            });
        }

        if (modal) {
            modal.addEventListener('click', function(event) {
                if (event.target === modal) {
                    modal.classList.remove('show');
                }
            });
        }

    </script>
</body>
</html>
