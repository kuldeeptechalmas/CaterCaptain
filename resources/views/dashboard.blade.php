<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | CaterCaptain</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: 'Manrope', sans-serif;
            background: #f8fafc;
            color: #0f172a;
        }

        .wrap {
            width: min(1120px, 94%);
            margin: 22px auto;
        }

        .hero {
            background: linear-gradient(130deg, #0f766e, #0f172a);
            color: #e2e8f0;
            border-radius: 16px;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
            align-items: center;
        }

        .hero h1 {
            margin: 0;
            font-size: 26px;
        }

        .hero p {
            margin: 6px 0 0;
            color: #cbd5e1;
        }

        .btn {
            border: 0;
            border-radius: 10px;
            padding: 10px 14px;
            font: inherit;
            font-weight: 700;
            background: #ef4444;
            color: #fff;
            cursor: pointer;
        }

        .btn-link {
            display: inline-flex;
            border-radius: 10px;
            padding: 10px 14px;
            font: inherit;
            font-weight: 700;
            text-decoration: none;
            background: #f59e0b;
            color: #0f172a;
            margin-right: 8px;
            border: 0;
            cursor: pointer;
        }

        .status {
            margin-top: 12px;
            border-radius: 10px;
            padding: 10px 12px;
            font-size: 13px;
            background: #dcfce7;
            border: 1px solid #86efac;
            color: #14532d;
        }

        .error-box {
            margin-top: 12px;
            border-radius: 10px;
            padding: 10px 12px;
            font-size: 13px;
            background: #fee2e2;
            border: 1px solid #fca5a5;
            color: #7f1d1d;
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
            font-size: 20px;
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
            border-color: #0f766e;
            box-shadow: 0 0 0 3px rgba(15, 118, 110, 0.15);
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
            background: linear-gradient(90deg, #0f766e, #f59e0b);
            cursor: pointer;
        }

        .cards {
            margin-top: 14px;
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 12px;
        }

        .card {
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            padding: 14px;
        }

        .k {
            color: #64748b;
            font-size: 12px;
        }

        .v {
            margin-top: 6px;
            font-size: 22px;
            font-weight: 800;
        }

        @media (max-width: 900px) {
            .cards {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 560px) {
            .cards {
                grid-template-columns: 1fr;
            }

            .hero h1 {
                font-size: 22px;
            }
        }

    </style>
</head>
<body>
    <div class="wrap">
        <section class="hero">
            <div>
                <h1>CaterCaptain Dashboard</h1>
                <p>Welcome, {{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</p>
            </div>
            <div>
                <button type="button" class="btn-link" id="open-change-password">Change Password</button>
                <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn">Logout</button>
                </form>
            </div>
        </section>

        @if (session('status'))
        <div class="status">{{ session('status') }}</div>
        @endif

        @if ($errors->any())
        <div class="error-box">{{ $errors->first() }}</div>
        @endif

        <section class="cards">
            {{-- {{ $raw_material }} --}}
            <a href="{{ route('material.report') }}" style="text-decoration-line: none;">
                <article class="card">
                    <div class="k">Raw Material Report</div>
                    <div class="v">All</div>
                </article>
            </a>

            <a href="{{ route('petty-cash.report') }}" style="text-decoration-line: none;">
                <article class="card">
                    <div class="k">Petty Cash Report</div>
                    <div class="v">All</div>
                </article>
            </a>
            <article class="card">
                <div class="k">Pending Requests</div>
                <div class="v">5</div>
            </article>
            <article class="card">
                <div class="k">Kitchen Alerts</div>
                <div class="v">3</div>
            </article>
        </section>
    </div>

    <div class="modal {{ $errors->any() ? 'show' : '' }}" id="change-password-modal">
        <div class="modal-card">
            <div class="modal-head">
                <h2 class="modal-title">Change Password</h2>
                <button type="button" class="x-btn" id="close-change-password">X</button>
            </div>

            <form method="POST" action="{{ route('change-password.submit') }}" style="margin-right: 20px;">
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

    <script>
        const modal = document.getElementById('change-password-modal');
        const openBtn = document.getElementById('open-change-password');
        const closeBtn = document.getElementById('close-change-password');

        openBtn.addEventListener('click', function() {
            modal.classList.add('show');
        });

        closeBtn.addEventListener('click', function() {
            modal.classList.remove('show');
        });

        modal.addEventListener('click', function(event) {
            if (event.target === modal) {
                modal.classList.remove('show');
            }
        });

    </script>
</body>
</html>
