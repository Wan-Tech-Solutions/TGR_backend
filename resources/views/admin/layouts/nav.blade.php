<aside class="left-sidebar with-vertical">
  <div>
    <!-- Start Vertical Layout Sidebar -->
    <div class="brand-logo d-flex align-items-center justify-content-between">
      <a href="{{ route('home') }}" class="text-nowrap logo-img">
        <img src="{{ asset('img/logo-default-slim.png') }}" class="dark-logo" width="150" height="60" alt="TGR Admin" />
        <img src="{{ asset('img/logo-default-slim.png') }}" class="light-logo" width="150" height="60" alt="TGR Admin" />
      </a>
      <a href="javascript:void(0)" class="sidebartoggler ms-auto text-decoration-none fs-5 d-block d-xl-none" onclick="toggleNav()">
        <i class="ti ti-x"></i>
      </a>
    </div>

    <nav class="sidebar-nav scroll-sidebar" data-simplebar>
      <ul id="sidebarnav">
        <!-- Home -->
        <li class="nav-small-cap">
          <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
          <span class="hide-menu">Homee</span>
        </li>
        <!-- Dashboard -->
        @role('superadmin')
        <li class="sidebar-item">
          <a class="sidebar-link" href="{{ route('dashboard') }}" aria-expanded="true">
            <span>
              <i class="ti ti-shopping-cart"></i>
            </span>
            <span class="hide-menu">Dashboard</span>
          </a>
        </li>
        @endrole

        @role('superadmin')
        <li class="sidebar-item">
          <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="true">
            <span class="d-flex">
              <i class="ti ti-layout-grid"></i>
            </span>
            <span class="hide-menu">TGR Advisory</span>
          </a>
          <ul aria-expanded="true" class="collapse first-level">
            <li class="sidebar-item">
              <a href="{{ route('users-subscribed-semiars') }}" class="sidebar-link">
                <div class="round-16 d-flex align-items-center justify-content-center">
                  <i class="ti ti-circle"></i>
                </div>
                <span class="hide-menu">Subscribers</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a href="{{ route('admin.consultations.index') }}" class="sidebar-link">
                <div class="round-16 d-flex align-items-center justify-content-center">
                  <i class="ti ti-circle"></i>
                </div>
                <span class="hide-menu">Consultation Bookings</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="{{ route('requested-list') }}" aria-expanded="true">
                <span>
                  <i class="ti ti-message-dots"></i>
                </span>
                <span class="hide-menu">Prospectus Requests</span>
              </a>
            </li>
          </ul>
        </li>
        @endrole

        <li class="sidebar-item">
          <a href="{{ route('admin.blogs.index') }}" class="sidebar-link">
            <div class="round-16 d-flex align-items-center justify-content-center">
              <i class="ti ti-pencil"></i>
            </div>
            <span class="hide-menu">Blogs</span>
          </a>
        </li>

        <li class="nav-small-cap">
          <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
          <span class="hide-menu">Others</span>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link" href="{{ route('contact-us') }}" aria-expanded="true">
            <span>
              <i class="ti ti-calendar"></i>
            </span>
            <span class="hide-menu">Contact Page</span>
          </a>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link" href="{{ route('prospectus-index') }}" aria-expanded="true">
            <span>
              <i class="ti ti-layout-kanban"></i>
            </span>
            <span class="hide-menu">Prospectus</span>
          </a>
        </li>

        <li class="sidebar-item">
          <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="true">
            <span class="d-flex">
              <i class="ti ti-layout-grid"></i>
            </span>
            <span class="hide-menu">Settings</span>
          </a>
          <ul aria-expanded="false" class="collapse first-level">
            <li class="sidebar-item">
              <a href="{{ route('index-roles') }}" class="sidebar-link">
                <div class="round-16 d-flex align-items-center justify-content-center">
                  <i class="ti ti-circle"></i>
                </div>
                <span class="hide-menu">Roles</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a href="{{ route('profileview') }}" class="sidebar-link">
                <div class="round-16 d-flex align-items-center justify-content-center">
                  <i class="ti ti-circle"></i>
                </div>
                <span class="hide-menu">Profile</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a href="../main/frontend-contactpage.html" class="sidebar-link">
                <div class="round-16 d-flex align-items-center justify-content-center">
                  <i class="ti ti-circle"></i>
                </div>
                <span class="hide-menu">Password Update</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a href="{{ route('index-user') }}" class="sidebar-link">
                <div class="round-16 d-flex align-items-center justify-content-center">
                  <i class="ti ti-circle"></i>
                </div>
                <span class="hide-menu">User Account</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a href="../main/frontend-blogdetailpage.html" class="sidebar-link">
                <div class="round-16 d-flex align-items-center justify-content-center">
                  <i class="ti ti-circle"></i>
                </div>
                <span class="hide-menu">Audit Trail</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a href="../main/frontend-blogdetailpage.html" class="sidebar-link">
                <div class="round-16 d-flex align-items-center justify-content-center">
                  <i class="ti ti-circle"></i>
                </div>
                <span class="hide-menu">User Log Activities</span>
              </a>
            </li>
          </ul>
        </li>
      </ul>
    </nav>

    <div class="fixed-profile p-3 mx-4 mb-2 bg-secondary-subtle rounded mt-3">
      <div class="hstack gap-3">
        <div class="john-img">
          <img src="{{ !empty($user->profile_photo_path) ? asset($user->profile_photo_path) : asset('upload/user.jpeg') }}" class="rounded-circle" width="40" height="40" alt="modernize-img" />
        </div>
        <div class="john-title">
          <h6 class="mb-0 fs-4 fw-semibold">{{ $user->name }}</h6>
        </div>
        <button class="border-0 bg-transparent text-primary ms-auto" tabindex="0" type="button" aria-label="logout" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="logout" onclick="if(confirm('Are you sure you want to log out?')) { window.location.href='{{ route('logout') }}'; }">
          <i class="ti ti-power fs-6"></i>
        </button>
      </div>
    </div>
  </div>
</aside>