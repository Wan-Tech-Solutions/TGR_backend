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
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,300,400,600,700,800,900" rel="stylesheet"
        type="text/css">

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
                <a href="{{route('home')}}" class="text-nowrap logo-img text-center d-block mb-5 w-100">
                  <img src="{{asset('backend/images/logos/dark-logo.png')}}" class="dark-logo" alt="Logo-Dark" style="height: 70px; width:150px;" />
                </a>
                <div class="position-relative text-center my-4">
                  <p class="mb-0 fs-4 px-3 d-inline-block bg-body text-dark z-index-5 position-relative">Enter your Email and Password
                  </p>

                @php
                    use Carbon\Carbon;
                @endphp

                @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> Please Enter a Correct User Name and Password<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                 @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif
                  <span class="border-top w-100 position-absolute top-50 start-50 translate-middle"></span>
                </div>
                <form action="{{ route('login-user') }}" method="post">
                    @csrf
                  <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Email</label>
                    <input id="email" name="email" type="email" :value="old('email')" required autofocus class="form-control form-control-lg" autocomplete="email">
                  </div>
                  <div class="mb-4">
                    <label for="exampleInputPassword1" class="form-label">Password</label>
                    <input id="password" name="password" type="password" class="form-control form-control-lg" autocomplete="current-password">
                  </div>
                  <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="form-check">
                      <input class="form-check-input primary" type="checkbox" value="" id="flexCheckChecked" checked>
                      <label class="form-check-label text-dark" for="flexCheckChecked">
                        Remeber this Device
                      </label>
                    </div>
                    <a class="text-primary fw-medium" href="#">Forgot
                      Password ?</a>
                  </div>
                  <button type="submit" class="btn btn-primary w-100 py-8 mb-4 rounded-2">Sign In</button>
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

</body>

</html>
