@include('adminPortal.layout.header')

<div class="container-fluid px-4">
    <div class="page-inner py-4">
        
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.home.dashboard') }}" class="text-muted text-decoration-none">
                        <i class="fas fa-home me-1"></i> Dashboard
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Profile</li>
            </ol>
        </nav>

        <div class="row">
            <!-- Left Column: Profile & Account Info -->
            <div class="col-lg-4">
                <!-- Profile Card -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-cover position-relative" style="height: 140px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                        <div class="profile-avatar position-absolute top-100 start-50 translate-middle">
                            <div class="avatar avatar-xxl border border-4 border-white shadow">
                                <img src="{{ asset('logo.png') }}" alt="User Avatar" class="avatar-img rounded-circle">
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-5 text-center">
                        <div class="user-profile">
                            <h3 class="fw-bold text-dark mb-2">{{ $user->name }}</h3>
                            <div class="badge bg-primary text-white px-3 py-2 mb-3">Administrator</div>
                            <p class="text-muted mb-4">{{ $user->email }}</p>
                            
                            <!-- Status Badge -->
                            <div class="status-badge mb-4">
                                <span class="badge bg-success bg-opacity-10 text-white border border-success border-opacity-25 px-3 py-2">
                                    <i class="fas fa-circle me-2" style="font-size: 8px;"></i>
                                    Status: Active
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-white border-0 pt-0">
                        <div class="row user-stats text-center g-0">
                            <div class="col border-end">
                                <div class="p-3">
                                    <div class="h4 fw-bold text-dark mb-1">{{ $totalLogins }}</div>
                                    <div class="text-muted small fw-semibold">Total Logins</div>
                                </div>
                            </div>
                            <div class="col border-end">
                                <div class="p-3">
                                    <div class="h4 fw-bold text-primary mb-1">{{ $thisMonthLogins }}</div>
                                    <div class="text-muted small fw-semibold">This Month</div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="p-3">
                                    <div class="h4 fw-bold text-success mb-1">{{ $todayLogins }}</div>
                                    <div class="text-muted small fw-semibold">Today</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Account Info Card -->
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0 pb-0 pt-4 px-4">
                        <h5 class="card-title fw-bold text-dark mb-1">
                            <i class="fas fa-info-circle me-2 text-primary"></i>Account Information
                        </h5>
                        <p class="text-muted small mb-0">Account details and metadata</p>
                    </div>
                    <div class="card-body px-4 pb-4">
                        <div class="account-info">
                            <div class="info-item mb-3">
                                <label class="text-muted small fw-semibold text-uppercase d-block mb-1">Email Address</label>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-envelope text-muted me-2"></i>
                                    <span class="text-dark fw-medium">{{ $user->email }}</span>
                                </div>
                            </div>
                            
                            <div class="info-item mb-3">
                                <label class="text-muted small fw-semibold text-uppercase d-block mb-1">Account Created</label>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-calendar-plus text-muted me-2"></i>
                                    <span class="text-dark fw-medium">
                                        @if($user->created_at)
                                            {{ is_string($user->created_at) ? \Carbon\Carbon::parse($user->created_at)->format('M d, Y') : $user->created_at->format('M d, Y') }}
                                        @else
                                            N/A
                                        @endif
                                    </span>
                                </div>
                            </div>
                            
                            <div class="info-item mb-3">
                                <label class="text-muted small fw-semibold text-uppercase d-block mb-1">Last Updated</label>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-sync-alt text-muted me-2"></i>
                                    <span class="text-dark fw-medium">
                                        @if($user->updated_at)
                                            {{ is_string($user->updated_at) ? \Carbon\Carbon::parse($user->updated_at)->format('M d, Y H:i') : $user->updated_at->format('M d, Y H:i') }}
                                        @else
                                            N/A
                                        @endif
                                    </span>
                                </div>
                            </div>
                            
                            @if($lastLogin)
                            <div class="info-item">
                                <label class="text-muted small fw-semibold text-uppercase d-block mb-1">Last Login</label>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-sign-in-alt text-muted me-2"></i>
                                    <span class="text-dark fw-medium">
                                        @if(is_string($lastLogin->date_time))
                                            {{ \Carbon\Carbon::parse($lastLogin->date_time)->format('M d, Y H:i:s') }}
                                        @else
                                            {{ $lastLogin->date_time->format('M d, Y H:i:s') }}
                                        @endif
                                    </span>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Activity & History -->
            <div class="col-lg-8">
                <!-- Activity Timeline -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-0 pb-0 pt-4 px-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title fw-bold text-dark mb-1">
                                    <i class="fas fa-history me-2 text-primary"></i>Recent Activity
                                </h5>
                                <p class="text-muted small mb-0">Last 20 activities and events</p>
                            </div>
                            <span class="badge bg-light text-dark border">{{ $recentActivity->count() }} activities</span>
                        </div>
                    </div>
                    <div class="card-body px-4 pb-4">
                        <div class="activity-timeline">
                            @forelse($recentActivity as $activity)
                            <div class="timeline-item d-flex position-relative mb-4">
                                <div class="timeline-icon flex-shrink-0 me-3">
                                    <div class="icon-wrapper bg-{{ $activity->description == 'has logged in' ? 'success' : 'danger' }} bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" 
                                         style="width: 40px; height: 40px;">
                                        <i class="fas fa-{{ $activity->description == 'has logged in' ? 'sign-in-alt text-white' : 'sign-out-alt text-white' }}"></i>
                                    </div>
                                </div>
                                <div class="timeline-content flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-start mb-1">
                                        <h6 class="fw-bold text-dark mb-0">{{ ucfirst(str_replace('has ', '', $activity->description)) }}</h6>
                                        <small class="text-muted">
                                            @if(is_string($activity->date_time))
                                                {{ \Carbon\Carbon::parse($activity->date_time)->format('H:i') }}
                                            @else
                                                {{ $activity->date_time->format('H:i') }}
                                            @endif
                                        </small>
                                    </div>
                                    <p class="text-muted small mb-0">
                                        @if(is_string($activity->date_time))
                                            {{ \Carbon\Carbon::parse($activity->date_time)->format('M d, Y') }} at {{ \Carbon\Carbon::parse($activity->date_time)->format('H:i:s') }}
                                        @else
                                            {{ $activity->date_time->format('M d, Y') }} at {{ $activity->date_time->format('H:i:s') }}
                                        @endif
                                    </p>
                                </div>
                            </div>
                            @empty
                            <div class="text-center py-4">
                                <div class="empty-state">
                                    <i class="fas fa-history fa-2x text-muted mb-3"></i>
                                    <p class="text-muted mb-0">No recent activity recorded</p>
                                </div>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Login History -->
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0 pb-0 pt-4 px-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title fw-bold text-dark mb-1">
                                    <i class="fas fa-clipboard-list me-2 text-primary"></i>Login History
                                </h5>
                                <p class="text-muted small mb-0">Recent authentication events</p>
                            </div>
                            <span class="badge bg-light text-dark border">Last 10 entries</span>
                        </div>
                    </div>
                    <div class="card-body px-0 pb-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4 small fw-semibold text-uppercase text-muted">Date & Time</th>
                                        <th class="small fw-semibold text-uppercase text-muted">Action</th>
                                        <th class="small fw-semibold text-uppercase text-muted">Device</th>
                                        <th class="pe-4 small fw-semibold text-uppercase text-muted">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($activityLogs as $log)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="d-flex flex-column">
                                                <span class="fw-medium text-dark">
                                                    @if(is_string($log->date_time))
                                                        {{ \Carbon\Carbon::parse($log->date_time)->format('M d, Y') }}
                                                    @else
                                                        {{ $log->date_time->format('M d, Y') }}
                                                    @endif
                                                </span>
                                                <small class="text-muted">
                                                    @if(is_string($log->date_time))
                                                        {{ \Carbon\Carbon::parse($log->date_time)->format('H:i:s') }}
                                                    @else
                                                        {{ $log->date_time->format('H:i:s') }}
                                                    @endif
                                                </small>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge rounded-pill py-2 px-3 
                                                @if($log->description == 'has logged in') 
                                                    bg-success text-white
                                                @else
                                                    bg-secondary text-white
                                                @endif">
                                                <i class="fas fa-{{ $log->description == 'has logged in' ? 'sign-in-alt' : 'sign-out-alt' }} me-1"></i>
                                                {{ ucfirst(str_replace('has ', '', $log->description)) }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-desktop text-muted me-2"></i>
                                                <small class="text-muted">System</small>
                                            </div>
                                        </td>
                                        <td class="pe-4">
                                            <span class="badge rounded-pill py-2 px-3
                                                @if($log->description == 'has logged in') 
                                                    bg-success text-white
                                                @else
                                                    bg-warning text-white
                                                @endif">
                                                {{ $log->description == 'has logged in' ? 'Active' : 'Logged Out' }}
                                            </span>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-5">
                                            <div class="empty-state">
                                                <i class="fas fa-clipboard-list fa-2x text-muted mb-3"></i>
                                                <p class="mb-0">No login history available</p>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card-cover {
    border-radius: 8px 8px 0 0;
}

.profile-avatar {
    z-index: 2;
}

.avatar-xxl {
    width: 100px;
    height: 100px;
}

.avatar-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.user-stats .border-end:last-child {
    border-right: none !important;
}

.timeline-item:not(:last-child):after {
    content: '';
    position: absolute;
    left: 20px;
    top: 60px;
    bottom: -20px;
    width: 2px;
    background: #f0f0f0;
    z-index: 1;
}

.timeline-icon .icon-wrapper {
    z-index: 2;
    position: relative;
}

.info-item {
    padding: 8px 0;
}

.table th {
    border-top: none;
    font-weight: 600;
    font-size: 0.85rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #6c757d;
}

.empty-state {
    padding: 2rem 0;
}

.card {
    transition: transform 0.2s ease;
}

.card:hover {
    transform: translateY(-2px);
}

.badge {
    font-size: 0.75rem;
}

.user-stats .h4 {
    font-size: 1.5rem;
}

@media (max-width: 768px) {
    .profile-avatar {
        position: static;
        transform: none;
        margin-top: -60px;
        margin-bottom: 20px;
    }
    
    .user-stats .col {
        border-right: none !important;
        border-bottom: 1px solid #eee;
    }
    
    .user-stats .col:last-child {
        border-bottom: none !important;
    }
}
</style>

@include('adminPortal.layout.footer')