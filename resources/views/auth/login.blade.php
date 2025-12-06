<!doctype html>
<html lang="en" class="fixed">

<head>
    <title>{{ config('app.name') }}</title>
   <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') | {{ config('app.name') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="{{ config('app.name') }}" name="description" />
    <meta content="{{ config('app.name') }}" name="author" />
    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <!-- Web Fonts  -->
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet" type="text/css">

    <!-- Favicon icon-->
    <link rel="shortcut icon" type="image/png" href="{{ asset('img/favicon.ico') }}" />

    <!-- Core Css -->
    <link rel="stylesheet" href="{{ asset('backend/css/styles.css') }}" />

    <!-- Owl Carousel  -->
    <link rel="stylesheet" href="{{ asset('backend/libs/owl.carousel/dist/assets/owl.carousel.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">
    <link rel="stylesheet" type="text/css" href=" https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css"
        href=" https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css">

    <style>
      :root {
        --bg: #0a0a0a;
        --card: rgba(255, 255, 255, 0.97);
        --primary: #ef4444; /* red */
        --primary-2: #111827; /* near-black */
        --text: #0f172a;
        --muted: #4b5563;
        --stroke: #e5e7eb;
        --shadow: 0 26px 60px rgba(0, 0, 0, 0.32);
      }

      * { font-family: 'Space Grotesk', 'Segoe UI', sans-serif; }

      body {
        background:
          radial-gradient(circle at 15% 20%, rgba(239, 68, 68, 0.16), transparent 24%),
          radial-gradient(circle at 85% 10%, rgba(17, 24, 39, 0.16), transparent 22%),
          linear-gradient(135deg, #0b0b0b, #111827 50%, #0b0b0b);
        color: var(--text);
        min-height: 100vh;
      }

      .floating-orb {
        position: absolute;
        width: 180px;
        height: 180px;
        border-radius: 50%;
        filter: blur(70px);
        opacity: 0.45;
        z-index: 0;
      }

      .orb-1 { background: #ef4444; top: 8%; left: 8%; }
      .orb-2 { background: #111827; bottom: 12%; right: 8%; }

      .auth-card .card {
        position: relative;
        border: 1px solid rgba(0, 0, 0, 0.06);
        border-radius: 18px;
        box-shadow: var(--shadow);
        background: var(--card);
        backdrop-filter: blur(10px);
        overflow: hidden;
      }

      .auth-card .card::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, rgba(239, 68, 68, 0.08), rgba(0, 0, 0, 0.06));
        opacity: 0.9;
        pointer-events: none;
      }

      .auth-card .card-body { position: relative; z-index: 1; padding: 20px 18px; }

      .auth-card .form-label {
        font-weight: 600;
        color: var(--text);
        letter-spacing: 0.01em;
      }

      .auth-card .form-control {
        border-radius: 12px;
        border: 1.4px solid var(--stroke);
        padding: 10px 14px;
        background: #fff;
        transition: border-color 0.2s ease, box-shadow 0.2s ease, transform 0.1s ease;
      }

      .auth-card .form-control:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 0.18rem rgba(99, 102, 241, 0.25);
        transform: translateY(-1px);
      }

      .auth-card .btn-primary {
        border-radius: 12px;
        background: linear-gradient(120deg, var(--primary), #b91c1c);
        border: none;
        box-shadow: 0 12px 28px rgba(239, 68, 68, 0.35);
        transition: transform 0.12s ease, box-shadow 0.18s ease;
      }

      .auth-card .btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 16px 40px rgba(239, 68, 68, 0.4);
      }

      .auth-card .btn-primary:active {
        transform: translateY(0);
        box-shadow: 0 10px 26px rgba(239, 68, 68, 0.32);
      }

      .input-help {
        font-size: 0.82rem;
        color: var(--muted);
        margin-top: 4px;
      }

      .text-muted a { color: var(--primary); }

      .logo-img img { filter: drop-shadow(0 6px 18px rgba(15, 23, 42, 0.2)); }

      .toggle-password-btn {
        color: var(--muted);
        border-radius: 50%;
        width: 38px;
        height: 38px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: background-color 0.15s ease, color 0.15s ease;
      }

      .toggle-password-btn:hover { background: #eef2ff; color: #4338ca; }

      .radial-gradient::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at 50% 18%, rgba(255, 255, 255, 0.12), transparent 46%);
        pointer-events: none;
      }

      .badge-soft {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 10px;
        border-radius: 10px;
        background: rgba(239, 68, 68, 0.12);
        color: var(--primary);
        font-weight: 600;
        font-size: 0.85rem;
      }
    </style>
</head>

<body>
  <!-- Preloader -->
  <div class="preloader">
    <img src="{{ asset('backend/images/logos/dark-logo.png') }}" alt="loader" class="lds-ripple img-fluid" />
  </div>
  <div id="main-wrapper" class="auth-customizer-none">
    <div class="position-relative overflow-hidden radial-gradient min-vh-100 w-100 d-flex align-items-center justify-content-center">
      <div class="d-flex align-items-center justify-content-center w-100">
        <div class="row justify-content-center w-100">
          <div class="col-md-8 col-lg-6 col-xxl-3 auth-card">
            <div class="card mb-0">
              <div class="card-body">
                <div class="floating-orb orb-1"></div>
                <div class="floating-orb orb-2"></div>
                <a href="{{route('home')}}" class="text-nowrap logo-img text-center d-block mb-4 w-100">
                  <img src="{{asset('backend/images/logos/dark-logo.png')}}" class="dark-logo" alt="Logo-Dark" style="height: 70px; width:150px;" />
                </a>
                <div class="position-relative text-center my-3">
                  <p class="mb-1 fs-4 fw-bold text-dark">Welcome back</p>
                  <p class="text-muted mb-2">Sign in to continue</p>
                  <span class="badge-soft mx-auto">Secure sign-in</span>

                @php
                    use Carbon\Carbon;
                @endphp

                @if ($errors->any())
                <div class="alert alert-danger mt-3">
                    <strong>Whoops!</strong> Please Enter a Correct User Name and Password<br><br>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                 @if (session('success'))
                <div class="alert alert-success mt-3">
                    {{ session('success') }}
                </div>
                @endif
                </div>
                <form action="{{ route('login-user') }}" method="post">
                    @csrf
                  <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Email</label>
                    <input id="email" name="email" type="email" :value="old('email')" required autofocus class="form-control" autocomplete="email" placeholder="you@example.com">
                    <div class="input-help">Use your work email.</div>
                  </div>
                  <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Password</label>
                    <div class="position-relative">
                      <input id="password" name="password" type="password" class="form-control pe-5" autocomplete="current-password" placeholder="Enter your password">
                      <button type="button" class="btn btn-link toggle-password-btn text-decoration-none position-absolute top-50 end-0 translate-middle-y me-2 p-0" aria-label="Show password" id="toggle-password">
                        <iconify-icon icon="mdi:eye" width="24" height="24"></iconify-icon>
                      </button>
                    </div>
                    <div class="input-help">At least 8 characters.</div>
                  </div>
                  <div class="d-flex align-items-center justify-content-between mb-2">
                    <div class="form-check">
                      <input class="form-check-input primary" type="checkbox" name="remember" value="1" id="flexCheckChecked" checked>
                      <label class="form-check-label text-dark" for="flexCheckChecked">
                        Remember this device
                      </label>
                    </div>
                    <a class="text-primary fw-medium" href="{{ route('password.request') }}">Forgot Password?</a>
                  </div>
                  <button type="submit" class="btn btn-primary w-100 py-2 mb-2 rounded-2">Sign In</button>
                  <div class="d-flex align-items-center justify-content-center">
                    {{-- <p class="fs-4 mb-0 fw-medium">New to Modernize?</p>
                    <a class="text-primary fw-medium ms-2" href="../main/authentication-register.html">Create an
                      account</a> --}}
                  </div>
                </form>
                            <p class="text-center text-muted mt-3 mb-3">&copy;Copyright {{ Carbon::now()->year }}. All Rights Reserved | TGR Africa | Developed by <a href="https://www.wantechsolutions.com">Wan Tech Solutions</a></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script>
  function handleColorTheme(e) {
    document.documentElement.setAttribute("data-color-theme", e);
  }
</script>
<!-- Import Js Files -->
    <script src="{{ asset('backend/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('backend/libs/simplebar/dist/simplebar.min.js') }}"></script>
    <script src="{{ asset('backend/js/theme/app.init.js') }}"></script>
    <script src="{{ asset('backend/js/theme/theme.js') }}"></script>
    <script src="{{ asset('backend/js/theme/app.min.js') }}"></script>
    <script src="{{ asset('backend/js/theme/sidebarmenu.js') }}"></script>

    <!-- solar icons -->
    <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
    <script src="{{ asset('backend/libs/owl.carousel/dist/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('backend/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
    <script src="{{ asset('backend/js/dashboards/dashboard.js') }}"></script>

    <script>
      const togglePasswordBtn = document.getElementById('toggle-password');
      const passwordInput = document.getElementById('password');

      togglePasswordBtn?.addEventListener('click', () => {
        const isHidden = passwordInput.type === 'password';
        passwordInput.type = isHidden ? 'text' : 'password';
        togglePasswordBtn.setAttribute('aria-label', isHidden ? 'Hide password' : 'Show password');
        const icon = togglePasswordBtn.querySelector('iconify-icon');
        if (icon) {
          icon.setAttribute('icon', isHidden ? 'mdi:eye-off' : 'mdi:eye');
        }
      });
    </script>

</body>

</html>
