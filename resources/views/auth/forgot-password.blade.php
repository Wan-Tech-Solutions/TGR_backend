<!doctype html>
<html lang="en">

<head>
    <title>{{ config('app.name') }} | Forgot Password</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="shortcut icon" type="image/png" href="{{ asset('img/favicon.ico') }}" />

    <style>
        :root {
            --bg: #0a0a0a;
            --card: rgba(255, 255, 255, 0.97);
            --primary: #ef4444;
            --primary-2: #111827;
            --text: #0f172a;
            --muted: #4b5563;
            --stroke: #e5e7eb;
            --shadow: 0 26px 60px rgba(0, 0, 0, 0.32);
        }

        * { font-family: 'Space Grotesk', 'Segoe UI', sans-serif; }

        body {
            margin: 0;
            background:
                radial-gradient(circle at 15% 20%, rgba(239, 68, 68, 0.16), transparent 24%),
                radial-gradient(circle at 85% 10%, rgba(17, 24, 39, 0.16), transparent 22%),
                linear-gradient(135deg, #0b0b0b, #111827 50%, #0b0b0b);
            color: var(--text);
            min-height: 100vh;
            display: grid;
            place-items: center;
            padding: 20px;
        }

        .auth-card {
            width: 100%;
            max-width: 420px;
            position: relative;
            border: 1px solid rgba(0, 0, 0, 0.06);
            border-radius: 18px;
            box-shadow: var(--shadow);
            background: var(--card);
            backdrop-filter: blur(10px);
            overflow: hidden;
        }

        .auth-card::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.08), rgba(0, 0, 0, 0.06));
            opacity: 0.9;
            pointer-events: none;
        }

        .accent-bar {
            height: 4px;
            width: 100%;
            background: linear-gradient(90deg, #b91c1c, #ef4444, #111827);
            border-radius: 999px;
            margin-bottom: 14px;
        }

        .card-body {
            position: relative;
            z-index: 1;
            padding: 22px 20px 20px;
        }

        .logo {
            text-align: center;
            margin-bottom: 16px;
        }

        h1 {
            margin: 6px 0 4px;
            font-size: 1.45rem;
            font-weight: 700;
            color: var(--text);
            text-align: center;
        }

        p.subtitle {
            margin: 0 0 14px;
            text-align: center;
            color: var(--muted);
            font-size: 0.95rem;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-weight: 600;
            color: var(--text);
            text-align: center;
        }

        input[type="email"],
        input[type="password"],
        input[type="text"] {
            width: 100%;
            border-radius: 12px;
            border: 1.4px solid var(--stroke);
            padding: 10px 14px;
            background: #fff;
            transition: border-color 0.2s ease, box-shadow 0.2s ease, transform 0.1s ease;
            box-sizing: border-box;
        }

        input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.18rem rgba(239, 68, 68, 0.18);
            outline: none;
            transform: translateY(-1px);
        }

        .btn-primary {
            width: 78%;
            border-radius: 12px;
            background: linear-gradient(120deg, var(--primary), #b91c1c);
            border: none;
            color: #fff;
            padding: 10px 14px;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 12px 28px rgba(239, 68, 68, 0.35);
            transition: transform 0.12s ease, box-shadow 0.18s ease;
            display: block;
            margin: 8px auto 0;
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 16px 40px rgba(239, 68, 68, 0.4);
        }

        .btn-link {
            display: block;
            width: 78%;
            margin: 14px auto 0;
            color: var(--primary);
            font-weight: 600;
            text-decoration: none;
            font-size: 0.95rem;
            text-align: center;
        }

        .helper {
            font-size: 0.85rem;
            color: var(--muted);
            margin-top: 6px;
        }

        .status, .errors {
            margin: 10px 0;
            padding: 10px 12px;
            border-radius: 10px;
            font-size: 0.95rem;
        }

        .status { background: rgba(16, 185, 129, 0.12); color: #047857; }
        .errors { background: rgba(239, 68, 68, 0.12); color: #b91c1c; }

        ul { margin: 0; padding-left: 18px; }

        .field {
            width: 92%;
            margin: 0 auto 14px;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="auth-card">
        <div class="card-body">
            <div class="accent-bar"></div>
            <div class="logo">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('backend/images/logos/dark-logo.png') }}" alt="Logo" style="height: 54px;">
                </a>
            </div>
            <h1>Forgot Password</h1>
            <p class="subtitle">Enter your email to receive a reset link.</p>

            @if (session('status'))
                <div class="status">{{ session('status') }}</div>
            @endif

            @if ($errors->any())
                <div class="errors">
                    <strong>Whoops!</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <div class="field">
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="email" placeholder="you@example.com">
                    <div class="helper">We’ll send a secure reset link to your registered email.</div>
                </div>
                <button type="submit" class="btn-primary">Send Reset Link</button>
            </form>

            <a class="btn-link" href="{{ route('login') }}">Back to login</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if (session('status'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'success',
                    title: 'Reset link sent',
                    text: @json(session('status') . ' Please check your email.'),
                    confirmButtonColor: '#ef4444',
                });
            });
        </script>
    @endif
</body>

</html>
