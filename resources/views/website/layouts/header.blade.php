<header id="header" class="header-effect-shrink"
    data-plugin-options="{'stickyEnabled': true, 'stickyEffect': 'shrink', 'stickyEnableOnBoxed': true, 'stickyEnableOnMobile': true, 'stickyChangeLogo': true, 'stickyStartAt': 120, 'stickyHeaderContainerHeight': 70}">
    <div class="header-body border-top-0">
        <div class="header-top">
            <div class="container">
                <div class="header-row py-2">
                    <div class="header-column justify-content-end">
                        <div class="header-row">
                            <ul class="header-social-icons social-icons social-icons-clean">
                                <li class="social-icons-facebook" style="border-radius: 40%"><a
                                        href="https://www.facebook.com/profile.php?id=61559081140764" target="_blank"
                                        title="Facebook"><i class="fab fa-facebook-f"></i></a></li>
                                <li class="social-icons-twitter"><a href="http://www.twitter.com/" target="_blank"
                                        title="X"><i class="fab fa-x-twitter"></i></a></li>
                                <li class="social-icons-youtube" style="border-radius: 40%"><a
                                        href="http://www.youtube.com/@TGRAfrica" target="_blank" title="Youtube"><i
                                            class="fab fa-youtube"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-container container">
            <div class="header-row">
                <div class="header-column">
                    <div class="header-row">
                        <div class="header-logo">
                            <a href="{{ route('home') }}">
                                <img alt="TGR" width="120" data-sticky-width="100"
                                    src="{{ asset('img/logo-default-slim.png') }}">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="header-column justify-content-center">
                    <div class="header-row">
                        <div
                            class="header-nav header-nav-line header-nav-top-line header-nav-top-line-with-border order-2 order-lg-1">
                            <div
                                class="header-nav-main header-nav-main-square header-nav-main-effect-2 header-nav-main-sub-effect-1">
                                <nav class="collapse">
                                    <ul class="nav nav-pills" id="mainNav">
                                        <li> <a class="  {{ Request::is('home') ? 'active' : '' }}"
                                                href="{{ route('home') }}">Home</a>
                                        </li>
                                        <li class="dropdown"> <a
                                                class="dropdown-item dropdown-toggle  {{ Request::is('about*') ? 'active' : '' }}"
                                                href="javascript:void(0)"> About us </a>
                                            <ul class="dropdown-menu">
                                                <li> <a class="dropdown-item"
                                                        href="{{ route('about.founder') }}">Founders</a>
                                                </li>

                                                <li> <a class="dropdown-item"
                                                        href="{{ route('about.vision') }}">Vision</a>
                                                </li>

                                                <li> <a class="dropdown-item"
                                                        href="{{ route('about.mission') }}">Mission</a>
                                                </li>
                                                <li> <a class="dropdown-item"
                                                        href="{{ route('about.purpose') }}">Purpose</a>
                                                </li>
                                            </ul>
                                        </li>

                                        <li class="dropdown"> <a
                                                class="dropdown-item dropdown-toggle {{ Request::is('advisory*') ? 'active' : '' }}"
                                                href="javascript:void(0)">Advisory</a>
                                            <ul class="dropdown-menu">
                                                <li> <a class="dropdown-item"
                                                        href="{{ route('features.consult') }}">Book a Consultation</a>
                                                </li>
                                                <li> <a class="dropdown-item"
                                                        href="{{ route('advisory.brainstorm') }}">TGR Brainstorm</a>
                                                </li>

                                                <li> <a class="dropdown-item"
                                                        href="{{ route('advisory.analytic') }}">TGR Analytics</a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="dropdown"> <a class="dropdown-item dropdown-toggle" href="#">
                                                Investors Community</a>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a href="{{ route('request-prospectus') }}"
                                                        class="nav-link">Prospectus</a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="dropdown"> <a class="dropdown-item dropdown-toggle" href="#">
                                                Features </a>
                                            <ul class="dropdown-menu">
                                                <li class="dropdown-submenu"> <a class="dropdown-item"
                                                        href="javascript:void(0)">Books</a>
                                                    <ul class="dropdown-menu">
                                                        <li><a class="dropdown-item"
                                                                href="{{ route('features.book') }}">The Great
                                                                Return</a></li>
                                                    </ul>
                                                </li>
                                                {{-- <li> <a class="dropdown-item" href="#">Interviews</a>

                                                </li>

                                                <li> <a class="dropdown-item" href="#">Events</a>

                                                </li> --}}
                                            </ul>
                                        </li>
                                        {{--
                                        <li> <a class=" " href="{{ route('partners') }}"> Partners </a>

                                        </li> --}}

                                        <li> <a class=" {{ Request::is('news') ? 'active' : '' }} "
                                                href="{{ route('news') }}"> Blog </a>
                                        </li>

                                        <li> <a class="  {{ Request::is('contact') ? 'active' : '' }}"
                                                href="{{ route('contact') }}">Contact Us </a>
                                        </li>

                                    </ul>
                                </nav>
                            </div>
                            <button class="btn header-btn-collapse-nav" data-bs-toggle="collapse"
                                data-bs-target=".header-nav-main nav">
                                <i class="fas fa-bars"></i>
                            </button>
                        </div>
                        <div
                            class="header-nav-features header-nav-features-no-border header-nav-features-lg-show-border order-1 order-lg-2">
                            <div class="header-nav-feature header-nav-features-search d-inline-flex"> <a href="#"
                                    class="header-nav-features-toggle text-decoration-none" data-focus="headerSearch"
                                    aria-label="Search"><i class="fas fa-search header-nav-top-icon"></i></a>
                                <div class="header-nav-features-dropdown" id="headerTopSearchDropdown">
                                    <form role="search" action="#" method="get">
                                        <div class="simple-search input-group"> <input class="form-control text-1"
                                                id="headerSearch" name="q" type="search" value=""
                                                placeholder="Search..."> <button class="btn" type="submit"
                                                aria-label="Search"> <i class="fas fa-search header-nav-top-icon"></i>
                                            </button> </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</header>