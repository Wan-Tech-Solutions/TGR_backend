<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>TGR Africa - The Great Return</title>
    <meta
      content="width=device-width, initial-scale=1.0, shrink-to-fit=no"
      name="viewport"
    />
    <link
      rel="icon"
      href="logo.png"
      type="image/x-icon"
    />

    <!-- Fonts and icons -->
    <script src="{{ asset('assets/js/plugin/webfont/webfont.min.js') }}"></script>
    <script>
      WebFont.load({
        google: { families: ["Public Sans:300,400,500,600,700"] },
        custom: {
          families: [
            "Font Awesome 5 Solid",
            "Font Awesome 5 Regular",
            "Font Awesome 5 Brands",
            "simple-line-icons",
          ],
          urls: ["{{ asset('assets/css/fonts.min.css') }}"],
        },
        active: function () {
          sessionStorage.fonts = true;
        },
      });
    </script>

    <!-- Font Awesome Direct Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/plugins.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/kaiadmin.min.css') }}" />

    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />
  </head>
  <body>
    <div class="wrapper">
      <!-- Sidebar -->
      <div class="sidebar sidebar-style-2" data-background-color="dark">
        <div class="sidebar-logo">
          <!-- Logo Header -->
          <div class="logo-header" data-background-color="dark">
            <a href="index.html" class="logo">
              <img
                src="logo.png"
                alt="navbar brand"
                class="navbar-brand"
                height="90"
              />
            </a>
            <div class="nav-toggle">
              <button class="btn btn-toggle toggle-sidebar">
                <i class="gg-menu-right"></i>
              </button>
              <button class="btn btn-toggle sidenav-toggler">
                <i class="gg-menu-left"></i>
              </button>
            </div>
            <button class="topbar-toggler more">
              <i class="gg-more-vertical-alt"></i>
            </button>
          </div>
          <!-- End Logo Header -->
        </div>
        <div class="sidebar-wrapper scrollbar scrollbar-inner">
          <div class="sidebar-content">
            <ul class="nav nav-secondary">
              <li class="nav-item active">
                <a href="{{route('admin.home.dashboard')}}">
                  <i class="fas fa-home"></i>
                  <p>Home</p>
                </a>
              </li>
              <li class="nav-section">
                <span class="sidebar-mini-icon">
                  <i class="fa fa-ellipsis-h"></i>
                </span>
                <h4 class="text-section">Features</h4>
              </li>
              <li class="nav-item">
                <a data-bs-toggle="collapse" href="#base">
                  <i class="fas fa-layer-group"></i>
                  <p>TGR Advisors</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="base">
                  <ul class="nav nav-collapse">
                    <li>
                      <a href="{{route('admin.subscribers')}}">
                        <span class="sub-item">Subscribers</span>
                      </a>
                    </li>
                    <li>
                      <a href="{{route('admin.consultations')}}">
                        <span class="sub-item">Consultations</span>
                      </a>
                    </li>
                    <li>
                      <a href="{{route('admin.prospectus.requests')}}">
                        <span class="sub-item">Prospectus Requests</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </li>
              <li class="nav-item">
                <a href="{{route('admin.blogs')}}">
                  <i class="fas fa-book"></i>
                  <p>Blogs</p>
                  <span class="badge badge-success">{{$count_blogs}}</span>
                </a>
              </li>
              {{-- <li class="nav-item">
                <a href="{{route('admin.founders')}}">
                  <i class="fas fa-users"></i>
                  <p>Founders</p>
                  <span class="badge badge-success">{{$founder_count}}</span>
                </a>
              </li> --}}
              <li class="nav-item">
                <a href="{{route('administration.contact.response')}}">
                  <i class="fas fa-phone"></i>
                  <p>Contact Response</p>
                  <span class="badge badge-success">{{$contact_count}}</span>
                </a>
              </li>
              {{-- <li class="nav-item">
                <a href="{{route('admin.feedbacks')}}">
                  <i class="fas fa-users"></i>
                  <p>Client Feedback</p>
                  <span class="badge badge-success">1</span>
                </a>
              </li> --}}
              <li class="nav-item">
                <a href="{{route('admin.email.tracking')}}">
                  <i class="fas fa-paper-plane"></i>
                  <p>Email Tracking</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('admin.email.inbox')}}">
                  <i class="fas fa-inbox"></i>
                  <p>Inbox</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('admin.email-addresses.index')}}">
                  <i class="fas fa-envelope"></i>
                  <p>Email Addresses</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('admin.prospectus')}}">
                  <i class="fas fa-users"></i>
                  <p>Prospectus</p>
                  <span class="badge badge-success">{{$prospectus_count}}</span>
                </a>
              </li>
              <li class="nav-item submenu">
                <a data-bs-toggle="collapse" href="#sidebarLayouts">
                  <i class="fas fa-th-list"></i>
                  <p>Settings</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="sidebarLayouts">
                  <ul class="nav nav-collapse">
                    <li>
                      <a href="{{route('admin.roles')}}">
                        <span class="sub-item">Roles</span>
                      </a>
                    </li>
                    <li>
                      <a href="{{route('admin.profiles')}}">
                        <span class="sub-item">Profiles</span>
                      </a>
                    </li>
                    {{-- <li>
                      <a href="{{route('admin.password.reset')}}">
                        <span class="sub-item">Password Update</span>
                      </a>
                    </li> --}}
                    <li>
                      <a href="{{route('admin.audit.trails')}}">
                        <span class="sub-item">Audit Trail</span>
                      </a>
                    </li>
                    <li>
                      <a href="{{route('admin.user.logs')}}">
                        <span class="sub-item">User Log Activity</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <!-- End Sidebar -->

      <div class="main-panel">
        <div class="main-header">
          <div class="main-header-logo">
            <!-- Logo Header -->
            <div class="logo-header" data-background-color="dark">
              <a href="{{url('/')}}" class="logo">
                <img
                  src="logo.png"
                  alt="navbar brand"
                  class="navbar-brand"
                  height="20"
                />
              </a>
              <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                  <i class="gg-menu-right"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler">
                  <i class="gg-menu-left"></i>
                </button>
              </div>
              <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt"></i>
              </button>
            </div>
            <!-- End Logo Header -->
          </div>
          <!-- Navbar Header -->
          <nav
            class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom"
          >
            <div class="container-fluid">
              <div class="col text-right">
                <h6 class="text-white">
                    <a href="#" id="time-date" style="color:black"></a>
                </h6>
            </div>
              <script>
                function updateTimeDate() {
                    const now = new Date();
                    const options = { 
                        weekday: 'long', 
                        year: 'numeric', 
                        month: 'long', 
                        day: 'numeric', 
                        hour: '2-digit', 
                        minute: '2-digit', 
                        second: '2-digit' 
                    };
                    document.getElementById("time-date").textContent = now.toLocaleDateString("en-US", options);
                }
            
                // Update the time and date every second
                setInterval(updateTimeDate, 1000);
            
                // Set initial time and date
                updateTimeDate();
            </script>

              <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
                <!-- Messages Dropdown -->
                <li class="nav-item topbar-icon dropdown hidden-caret">
                  <a
                    class="nav-link dropdown-toggle"
                    href="#"
                    id="messageDropdown"
                    role="button"
                    data-bs-toggle="dropdown"
                    aria-haspopup="true"
                    aria-expanded="false"
                  >
                    <i class="fa fa-envelope"></i>
                    @if(isset($unread_messages) && $unread_messages > 0)
                      <span class="notification">{{ $unread_messages }}</span>
                    @endif
                  </a>
                  <ul
                    class="dropdown-menu messages-notif-box animated fadeIn"
                    aria-labelledby="messageDropdown"
                  >
                    <li>
                      <div
                        class="dropdown-title d-flex justify-content-between align-items-center"
                      >
                        Mails
                        @if(isset($unread_messages) && $unread_messages > 0)
                          <span class="badge badge-primary">{{ $unread_messages }}</span>
                        @endif
                      </div>
                    </li>
                    <li>
                      <div class="message-notif-scroll scrollbar-outer">
                        <div class="notif-center">
                          @if(isset($recent_messages) && count($recent_messages) > 0)
                            @foreach($recent_messages as $message)
                              <div class="notif-item simpler-notif">
                                <div class="notif-text">
                                  <span class="block">
                                    <strong>{{ $message->subject ?? 'No Subject' }}</strong>
                                  </span>
                                  <span class="time">{{ $message->created_at?->diffForHumans() ?? 'Recently' }}</span>
                                </div>
                              </div>
                            @endforeach
                          @else
                            <div class="notif-item simpler-notif text-center py-3">
                              <span class="text-muted">No new messages</span>
                            </div>
                          @endif
                        </div>
                      </div>
                    </li>
                    <li>
                      <a class="see-all" href="{{route('admin.tgr.mail')}}"
                        >See all messages<i class="fa fa-angle-right"></i>
                      </a>
                    </li>
                  </ul>
                </li>

                <!-- Notifications Dropdown -->
                <li class="nav-item topbar-icon dropdown hidden-caret">
                  <a
                    class="nav-link dropdown-toggle"
                    href="#"
                    id="notifDropdown"
                    role="button"
                    data-bs-toggle="dropdown"
                    aria-haspopup="true"
                    aria-expanded="false"
                  >
                    <i class="fa fa-bell"></i>
                    @if(isset($unread_notifications) && $unread_notifications > 0)
                      <span class="notification">{{ $unread_notifications }}</span>
                    @endif
                  </a>
                  <ul
                    class="dropdown-menu notif-box animated fadeIn"
                    aria-labelledby="notifDropdown"
                  >
                    <li>
                      <div class="dropdown-title d-flex justify-content-between align-items-center">
                        Notifications
                        @if(isset($unread_notifications) && $unread_notifications > 0)
                          <span class="badge badge-warning">{{ $unread_notifications }}</span>
                        @endif
                      </div>
                    </li>
                    <li>
                      <div class="notif-scroll scrollbar-outer">
                        <div class="notif-center">
                          @if(isset($recent_notifications) && count($recent_notifications) > 0)
                            @foreach($recent_notifications as $notif)
                              <div class="notif-item simpler-notif">
                                <div class="notif-text">
                                  <span class="block">{{ $notif->message ?? 'New notification' }}</span>
                                  <span class="time">{{ $notif->created_at?->diffForHumans() ?? 'Recently' }}</span>
                                </div>
                              </div>
                            @endforeach
                          @else
                            <div class="notif-item simpler-notif text-center py-3">
                              <span class="text-muted">No new notifications</span>
                            </div>
                          @endif
                        </div>
                      </div>
                    </li>
                    <li>
                      <a class="see-all" href="{{route('admin.tgr.chat')}}"
                        >See all notifications<i class="fa fa-angle-right"></i>
                      </a>
                    </li>
                  </ul>
                </li>

                <!-- Quick Apps -->
                <li class="nav-item topbar-icon dropdown hidden-caret">
                  <a
                    class="nav-link"
                    data-bs-toggle="dropdown"
                    href="#"
                    aria-expanded="false"
                  >
                    <i class="fas fa-layer-group"></i>
                  </a>
                  <div class="dropdown-menu quick-actions animated fadeIn">
                    <div class="quick-actions-header">
                      <span class="title mb-1">TGR Apps</span>
                      <span class="subtitle op-7">Quick Access</span>
                    </div>
                    <div class="quick-actions-scroll scrollbar-outer">
                      <div class="quick-actions-items">
                        <div class="row m-0">
                          <a class="col-6 col-md-4 p-0" href="{{route('admin.tgr.calender')}}">
                            <div class="quick-actions-item">
                              <div class="avatar-item bg-danger rounded-circle">
                                <i class="far fa-calendar-alt"></i>
                              </div>
                              <span class="text">Calendar</span>
                            </div>
                          </a>
                          <a class="col-6 col-md-4 p-0" href="{{route('admin.tgr.phone')}}">
                            <div class="quick-actions-item">
                              <div
                                class="avatar-item bg-warning rounded-circle"
                              >
                                <i class="fas fa-phone"></i>
                              </div>
                              <span class="text">Phone Book</span>
                            </div>
                          </a>
                          <a class="col-6 col-md-4 p-0" href="{{route('admin.tgr.notes')}}">
                            <div class="quick-actions-item">
                              <div class="avatar-item bg-info rounded-circle">
                                <i class="fas fa-file-excel"></i>
                              </div>
                              <span class="text">Notes</span>
                            </div>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </li>

                <!-- User Profile Dropdown -->
                <li class="nav-item topbar-user dropdown hidden-caret">
                  <a
                    class="dropdown-toggle profile-pic"
                    data-bs-toggle="dropdown"
                    href="#"
                    aria-expanded="false"
                  >
                    <div class="avatar-sm">
                      <img
                        src="{{ asset('logo.png') }}"
                        alt="User Avatar"
                        class="avatar-img rounded-circle"
                      />
                    </div>
                    <span class="profile-username">
                      <span class="op-7">Hi,</span>
                      <span class="fw-bold">{{ auth()->user()->name ?? 'Admin' }}</span>
                    </span>
                  </a>
                  <ul class="dropdown-menu dropdown-user animated fadeIn">
                    <div class="dropdown-user-scroll scrollbar-outer">
                      <li>
                        <div class="user-box">
                          <div class="avatar-lg">
                            <img
                              src="{{ asset('logo.png') }}"
                              alt="User Profile"
                              class="avatar-img rounded"
                            />
                          </div>
                          <div class="u-text">
                            <h4>{{ auth()->user()->name ?? 'Admin User' }}</h4>
                            <p class="text-muted">{{ auth()->user()->email ?? 'admin@tgrafrica.com' }}</p>
                            <a
                              href="{{ route('admin.profiles') }}"
                              class="btn btn-xs btn-secondary btn-sm"
                              >View Profile</a
                            >
                          </div>
                        </div>
                      </li>
                      <li>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('admin.my.profile') }}">My Profile</a>
                        <a class="dropdown-item" href="{{ route('admin.audit.trails') }}">Activity Log</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('admin.roles') }}">Settings</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                          Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                          @csrf
                        </form>
                      </li>
                    </div>
                  </ul>
                </li>
              </ul>
            </div>
          </nav>
          <!-- End Navbar -->
        </div>