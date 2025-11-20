<header class="topbar">
    <nav class="navbar navbar-expand-lg p-0">
        <ul class="navbar-nav align-items-center">
            <!-- Sidebar Toggle -->
            <li class="nav-item nav-icon-hover-bg rounded-circle ms-n2">
                <a class="nav-link sidebartoggler" id="headerCollapse" href="javascript:void(0)" onclick="toggleNav()">
                    <i class="ti ti-menu-2"></i>
                </a>
            </li>

            <!-- Apps Dropdown -->
            <li class="nav-item ms-3">
                <a class="nav-link dropdown-toggle" href="#navbar-layout" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="ti ti-grid fs-5 me-2"></i>
                    <span>Apps</span>
                    <i class="ri-arrow-down-s-fill ms-2"></i>
                </a>
                <div class="dropdown-menu p-3">
                    <div class="dropdown-menu-columns">
                        <div class="dropdown-menu-column">
                            <a class="dropdown-item" href="{{ route('contactapp') }}">
                                <i class="ti ti-address-book fs-5 me-3"></i> Contact App
                                <span class="badge custom-badge ms-auto">3</span>
                            </a>
                            <a class="dropdown-item" href="{{ route('notesapp') }}">
                                <i class="ti ti-notebook fs-5 me-3"></i> Note App
                                <span class="badge custom-badge ms-auto">7</span>
                            </a>
                        </div>
                        <div class="dropdown-menu-column">
                            <a class="dropdown-item" href="{{ route('calenderapp') }}">
                                <i class="ti ti-calendar fs-5 me-3"></i> Calendar
                                <span class="badge custom-badge ms-auto">4</span>
                            </a>
                            <a class="dropdown-item" href="{{ route('contactlist') }}">
                                <i class="ti ti-list fs-5 me-3"></i> Contact List
                                <span class="badge custom-badge ms-auto">1</span>
                            </a>
                        </div>
                    </div>
                </div>
            </li>

            <!-- Email App -->
            <li class="nav-item ms-3">
                <a class="nav-link" href="{{ route('emailapp') }}">
                    <i class="ti ti-mail fs-4 me-2"></i> Email App
                    <span class="badge custom-badge ms-auto">5</span>
                </a>
            </li>

            <!-- Chat App -->
            <li class="nav-item ms-3">
                <a class="nav-link" href="{{ route('chatapp') }}">
                    <i class="ti ti-message-circle fs-4 me-2"></i> Chat App
                    <span class="badge custom-badge ms-auto">8</span>
                </a>
            </li>
        </ul>

        <!-- Right-Side Features -->
        <ul class="navbar-nav ms-auto align-items-center">
            <div class="d-block d-lg-none py-4">
                <a href="{{ route('home') }}" class="text-nowrap logo-img">
                    <img src="{{ asset('img/logo-default-slim.png') }}" class="dark-logo" width="120" height="60" alt="TGR Admin" />
                    <img src="{{ asset('img/logo-default-slim.png') }}" class="light-logo" width="120" height="60" alt="TGR Admin" />
                </a>
            </div>
            <a class="navbar-toggler nav-icon-hover-bg rounded-circle p-0 mx-0 border-0" href="javascript:void(0)" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <i class="ti ti-dots fs-7"></i>
            </a>

            <!-- Theme Change Icons -->
            <div class="d-none d-md-flex align-items-center">
                <a href="?theme=dark" class="nav-link px-0 hide-theme-dark" title="Enable dark mode" data-bs-toggle="tooltip" data-bs-placement="bottom" onclick="setActiveTheme('dark')">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M12 3c.132 0 .263 0 .393 0a7.5 7.5 0 0 0 7.92 12.446a9 9 0 1 1 -8.313 -12.454z" />
                    </svg>
                </a>
                <a href="?theme=light" class="nav-link px-0 hide-theme-light" title="Enable light mode" data-bs-toggle="tooltip" data-bs-placement="bottom" onclick="setActiveTheme('light')">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M12 12m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                        <path d="M3 12h1m8 -9v1m8 8h1m-9 8v1m-6.4 -15.4l.7 .7m12.1 -.7l-.7 .7m0 11.4l.7 .7m-12.1 -.7l-.7 .7" />
                    </svg>
                </a>
            </div>

            <!-- Notification Icon -->
            <div class="nav-item dropdown d-none d-md-flex me-3">
                <a href="#" class="nav-link px-0" data-bs-toggle="dropdown" tabindex="-1" aria-label="Show notifications">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M10 5a2 2 0 1 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6" />
                        <path d="M9 17v1a3 3 0 0 0 6 0v-1" />
                    </svg>
                    <span class="badge bg-red"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-end dropdown-menu-card">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Notifications</h3>
                        </div>
                        <div class="list-group list-group-flush list-group-hoverable">
                            <div class="list-group-item">
                                <div class="row align-items-center">
                                    <div class="col-auto"><span class="status-dot status-dot-animated bg-red d-block"></span></div>
                                    <div class="col text-truncate">
                                        <a href="#" class="text-body d-block">Example 1</a>
                                        <div class="d-block text-secondary text-truncate mt-n1">
                                            Change deprecated html tags to text decoration classes (#29604)
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <a href="#" class="list-group-item-actions">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon text-muted" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <!-- More notifications here -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- Profile Dropdown -->
            <div class="nav-item dropdown">
                <a href="{{ route('index-user') }}" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
                    <span class="avatar avatar-sm" style="background-image: url('{{ !empty($user->profile_photo_path) ? asset($user->profile_photo_path) : asset('upload/user.jpeg') }}')"></span>
                    <div class="d-none d-xl-block ps-2">
                        <div>{{ $user->name }}</div>
                        <div class="mt-1 small text-secondary">{{ $user->email }}</div>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <a href="#" class="dropdown-item">Status</a>
                    <a href="{{ route('index-user') }}" class="dropdown-item">Profile</a>
                    <div class="dropdown-divider"></div>
                    <a href="./settings.html" class="dropdown-item">Settings</a>
                    <a href="{{ route('logout') }}" class="dropdown-item">Logout</a>
                </div>
            </div>
        </ul>
    </nav>
</header>

<script>
    // Your existing JavaScript functions
</script>

<style>
    .custom-badge {
        background-color: rgba(255, 99, 71, 0.6); /* Light red */
        color: white; /* White text */
        border-radius: 50%; /* Make it round */
        padding: 0.25em 0.5em; /* Adjust padding for better appearance */
        font-size: 0.875rem; /* Adjust font size if needed */
        min-width: 24px; /* Minimum width to keep it round */
        height: 24px; /* Fixed height for round shape */
        display: flex; /* Center content */
        align-items: center; /* Center vertically */
        justify-content: center; /* Center horizontally */
    }
    .hidden {
        top: -100px; /* Adjust based on header height */
    }
</style>