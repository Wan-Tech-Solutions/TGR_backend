<!DOCTYPE html>
<html lang="en"
    data-style-switcher-options="{'showBordersStyle': true, 'showLayoutStyle': true, 'showBackgroundColor': true}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <meta name="keywords" content="TGR Africa, The Great Return, Wan Tech Solutions Co. Ltd." />
    <meta name="description" content="TGR Africa, The Great Return, Wan Tech Solutions Co. Ltd.">
    <meta name="Wan Tech Solutions Co.Ltd." content="wantechsolutions">

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('img/favicon.ico') }}" type="image/x-icon" />
    <link rel="apple-touch-icon" href="{{ asset('img/apple-touch-icon.png') }}">
    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1.0, shrink-to-fit=no">
    <!-- Web Fonts  -->
    <link id="googleFonts"
        href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800%7CShadows+Into+Light&amp;display=swap"
        rel="stylesheet" type="text/css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <!-- Vendor CSS -->

    <!-- Dashboard MIX (removed broken favicon paths) -->
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/animate/animate.compat.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/simple-line-icons/css/simple-line-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/owl.carousel/assets/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/owl.carousel/assets/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/magnific-popup/magnific-popup.min.css') }}">
    <!-- Theme CSS -->
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}">
    <link rel="stylesheet" href="{{ asset('css/theme-elements.css') }}">
    <link rel="stylesheet" href="{{ asset('css/theme-blog.css') }}">
    <link rel="stylesheet" href="{{ asset('css/theme-shop.css') }}">
    <link id="skinCSS" rel="stylesheet" href="{{ asset('css/skins/default.css') }}">
    <!-- Theme Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-42715764-11"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', 'UA-42715764-11');
    </script>

</head>


<body data-plugin-page-transition class="site-shell">
    <div class="body">
        @include('website.layouts.header')
        <div role="main" class="main">
            @yield('content')
        </div>
    </div>


    @include('website.layouts.footer')
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>


    <style>
        /* Whatsapp */
        .float {
            position: fixed;
            width: 60px;
            height: 60px;
            bottom: 50%;
            right: 10px;
            background-color: #25d366;
            color: #FFF;
            border-radius: 50px;
            text-align: center;
            font-size: 30px;
            /* box-shadow: 2px 2px 3px #ff7e7e; */
            z-index: 100;
        }

        .my-float {
            margin-top: 16px;
        }

        /* End of whatsapp */
    </style>
    <!-- Whatsapp Button -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <a href="https://api.whatsapp.com/send?phone=+233500200335&text=Welcome to TGR Africa Official WhatsApp Platform."
        class="float" target="_blank">
        <i class="fa fa-whatsapp my-float"></i>
    </a>

    <!-- End of whatsapp Button -->
    <!-- Vendor -->
    <!-- Removed broken Cloudflare email-decode script to avoid 404 -->
    <script src="{{ asset('vendor/plugins/js/plugins.min.js') }}"></script>
    <script src="{{ asset('js/theme.js') }}"></script>
    <script src="{{ asset('js/views/view.contact.js') }}"></script>
    <script src="{{ asset('js/theme.init.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const nav = document.getElementById('mobileNav');
            const toggleBtn = document.querySelector('.header-btn-collapse-nav');
            if (!nav || !toggleBtn) return;

            // Use Bootstrap Collapse when available, otherwise fall back to manual toggling
            const navCollapse = window.bootstrap?.Collapse ? new bootstrap.Collapse(nav, { toggle: false }) : null;
            const setMenuState = (isOpen) => {
                toggleBtn.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
                document.body.classList.toggle('menu-open', isOpen);
                document.documentElement.classList.toggle('mobile-menu-opened', isOpen);
                if (!navCollapse) {
                    nav.classList.toggle('show', isOpen);
                }
            };

            // Ensure a clean start
            setMenuState(false);
            nav.classList.remove('collapsing');

            if (navCollapse) {
                nav.addEventListener('shown.bs.collapse', () => setMenuState(true));
                nav.addEventListener('hidden.bs.collapse', () => setMenuState(false));
            }

            toggleBtn.addEventListener('click', (e) => {
                e.preventDefault();
                const isOpen = nav.classList.contains('show');
                if (navCollapse) {
                    isOpen ? navCollapse.hide() : navCollapse.show();
                } else {
                    setMenuState(!isOpen);
                }
            });

            nav.querySelectorAll('a').forEach((link) => {
                link.addEventListener('click', (e) => {
                    const isDropdownToggle = link.classList.contains('dropdown-toggle') || link.parentElement?.classList.contains('dropdown-submenu');
                    const submenu = link.nextElementSibling;

                    if (isDropdownToggle && submenu) {
                        e.preventDefault();
                        // toggle this submenu and close siblings
                        const parentLi = link.closest('li.dropdown, li.dropdown-submenu');
                        parentLi?.parentElement?.querySelectorAll(':scope > li > .dropdown-menu.show').forEach((openMenu) => {
                            if (openMenu !== submenu) {
                                openMenu.classList.remove('show');
                                openMenu.closest('li.dropdown, li.dropdown-submenu')?.classList.remove('open');
                            }
                        });
                        submenu.classList.toggle('show');
                        parentLi?.classList.toggle('open', submenu.classList.contains('show'));
                        return;
                    }

                    if (navCollapse) {
                        navCollapse.hide();
                    } else {
                        setMenuState(false);
                    }
                });
            });

            window.addEventListener('resize', () => {
                if (window.innerWidth >= 992 && nav.classList.contains('show')) {
                    if (navCollapse) {
                        navCollapse.hide();
                    } else {
                        setMenuState(false);
                    }
                }
            });
        });
    </script>
    <!-- Google Maps -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const mapEl = document.getElementById('googlemaps');
            if (!mapEl) {
                return; // no map on this page
            }

            (g => {
                let h, a, k,
                    p = 'The Google Maps JavaScript API',
                    c = 'google',
                    l = 'importLibrary',
                    q = '__ib__',
                    m = document,
                    b = window;
                b = b[c] || (b[c] = {});
                const d = b.maps || (b.maps = {}),
                    r = new Set,
                    e = new URLSearchParams,
                    u = () => h || (h = new Promise(async (f, n) => {
                        a = m.createElement('script');
                        e.set('libraries', [...r] + '');
                        for (k in g) e.set(k.replace(/[A-Z]/g, t => '_' + t[0].toLowerCase()), g[k]);
                        e.set('callback', c + '.maps.' + q);
                        a.src = `https://maps.${c}apis.com/maps/api/js?` + e;
                        d[q] = f;
                        a.onerror = () => h = n(Error(p + ' could not load.'));
                        a.nonce = m.querySelector('script[nonce]')?.nonce || '';
                        m.head.append(a);
                    }));
                d[l] ? console.warn(p + ' only loads once. Ignoring:', g) : d[l] = (f, ...n) => r.add(f) && u().then(() => d[l](f, ...n));
            })({ key: 'AIzaSyAhpYHdYRY2U6V_VfyyNtkPHhywLjDkhfg', v: 'weekly' });

            async function initMap() {
                const { Map, InfoWindow } = await google.maps.importLibrary('maps');
                const { AdvancedMarkerElement, PinElement } = await google.maps.importLibrary('marker');
                const map = new Map(mapEl, {
                    zoom: 14,
                    center: { lat: -37.817240, lng: 144.955820 },
                    mapId: 'bacc27c8c034b32e',
                });
                const markers = [
                    {
                        position: { lat: -37.817240, lng: 144.955820 },
                        title: 'Office 1<br>Melbourne, 121 King St, Australia<br>Phone: 123-456-1234',
                    },
                ];
                const infoWindow = new InfoWindow();
                markers.forEach(({ position, title }) => {
                    const pin = new PinElement({ background: '#e36159', borderColor: '#e36159', glyphColor: '#FFF' });
                    const marker = new AdvancedMarkerElement({ position, map, title: `${title}`, content: pin.element });
                    marker.addListener('click', () => {
                        infoWindow.close();
                        infoWindow.setContent(marker.title);
                        infoWindow.open(marker.map, marker);
                    });
                });
            }

            initMap().catch(err => console.error('Map init failed:', err));
        });
    </script>
</body>

</html>
