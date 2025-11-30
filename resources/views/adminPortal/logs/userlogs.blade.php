@include('adminPortal.layout.header')

<div class="container-fluid px-4">
    <div class="page-inner py-4">
        
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ url('/') }}" class="text-muted text-decoration-none">
                        <i class="fas fa-home me-1"></i> Home
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.home.dashboard') }}" class="text-muted text-decoration-none">Dashboard</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Log Activities</li>
            </ol>
        </nav>

        <!-- Header Section -->
        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-start align-items-lg-center mb-5">
            <div class="mb-3 mb-lg-0">
                <h1 class="h2 fw-bold text-dark mb-2">User Activity Logs</h1>
                <p class="text-muted mb-0">Monitor and track all user activities and system interactions</p>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#exportModal">
                    <i class="fas fa-download me-2"></i>Export Logs
                </button>
                <button class="btn btn-outline-secondary" onclick="refreshActivityLogs()">
                    <i class="fas fa-sync-alt me-2"></i>Refresh
                </button>
                <button class="btn btn-outline-danger" onclick="clearOldLogs()">
                    <i class="fas fa-trash me-2"></i>Clear Old
                </button>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row g-4 mb-5">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon bg-primary bg-opacity-10 text-white rounded-2 p-3 me-3">
                                <i class="fas fa-history fa-lg"></i>
                            </div>
                            <div>
                                <p class="text-muted text-uppercase small fw-semibold mb-1">Total Activities</p>
                                <h3 class="fw-bold text-dark mb-0">{{ $activity->count() }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon bg-success bg-opacity-10 text-white rounded-2 p-3 me-3">
                                <i class="fas fa-user-check fa-lg"></i>
                            </div>
                            <div>
                                <p class="text-muted text-uppercase small fw-semibold mb-1">Active Users</p>
                                <h3 class="fw-bold text-success mb-0">{{ $activity->pluck('email')->unique()->count() }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon bg-warning bg-opacity-10 text-white rounded-2 p-3 me-3">
                                <i class="fas fa-sign-in-alt fa-lg"></i>
                            </div>
                            <div>
                                <p class="text-muted text-uppercase small fw-semibold mb-1">Today's Logins</p>
                                <h3 class="fw-bold text-warning mb-0">{{ $activity->where('description', 'like', '%login%')->where('date_time', '>=', today())->count() }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon bg-info bg-opacity-10 text-white rounded-2 p-3 me-3">
                                <i class="fas fa-clock fa-lg"></i>
                            </div>
                            <div>
                                <p class="text-muted text-uppercase small fw-semibold mb-1">Recent Activity</p>
                                <h6 class="fw-bold text-info mb-0">
                                    @if($activity->count() > 0)
                                        {{ $activity->first()->date_time ? \Carbon\Carbon::parse($activity->first()->date_time)->diffForHumans() : $activity->first()->created_at->diffForHumans() }}
                                    @else
                                        No activity
                                    @endif
                                </h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters Section -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-0 pb-0 pt-4 px-4">
                <h5 class="card-title fw-bold text-dark mb-1">
                    <i class="fas fa-filter me-2 text-primary"></i>Filter Activities
                </h5>
                <p class="text-muted small mb-0">Refine activity logs by specific criteria</p>
            </div>
            <div class="card-body px-4 pb-4">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label small fw-semibold text-muted text-uppercase">Activity Type</label>
                        <select class="form-select" id="activityFilter">
                            <option value="">All Activities</option>
                            <option value="login">Login Events</option>
                            <option value="logout">Logout Events</option>
                            <option value="created">Create Events</option>
                            <option value="updated">Update Events</option>
                            <option value="deleted">Delete Events</option>
                            <option value="viewed">View Events</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-semibold text-muted text-uppercase">User</label>
                        <select class="form-select" id="userFilter">
                            <option value="">All Users</option>
                            @foreach($activity->pluck('email')->unique() as $email)
                                <option value="{{ $email }}">{{ $email }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-semibold text-muted text-uppercase">Date Range</label>
                        <input type="date" class="form-control" id="dateFilter">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-semibold text-muted text-uppercase">Time Period</label>
                        <select class="form-select" id="periodFilter">
                            <option value="">All Time</option>
                            <option value="today">Today</option>
                            <option value="yesterday">Yesterday</option>
                            <option value="week">This Week</option>
                            <option value="month">This Month</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Activity Logs Table -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 pb-0 pt-4 px-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title fw-bold text-dark mb-1">
                            <i class="fas fa-list-alt me-2 text-primary"></i>Activity Logs
                        </h5>
                        <p class="text-muted small mb-0">Detailed record of all user activities and system events</p>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <div class="input-group input-group-sm" style="width: 250px;">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            <input type="text" class="form-control border-start-0" placeholder="Search activities..." id="searchInput">
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body px-0 pb-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" id="activityTable">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4 small fw-semibold text-uppercase text-muted" style="width: 20%">User</th>
                                <th class="small fw-semibold text-uppercase text-muted" style="width: 25%">Activity</th>
                                <th class="small fw-semibold text-uppercase text-muted" style="width: 30%">Description</th>
                                <th class="pe-4 small fw-semibold text-uppercase text-muted" style="width: 25%">Date/Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($activity as $log)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar bg-primary bg-opacity-10 text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                            {{ substr($log->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <h6 class="fw-bold text-dark mb-1">{{ $log->name }}</h6>
                                            <small class="text-muted">{{ $log->email }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge rounded-pill py-2 px-3 fw-semibold
                                        @if(str_contains(strtolower($log->description), 'login')) bg-success bg-opacity-10 text-success border border-success border-opacity-25
                                        @elseif(str_contains(strtolower($log->description), 'logout')) bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25
                                        @elseif(str_contains(strtolower($log->description), 'create') || str_contains(strtolower($log->description), 'add')) bg-info bg-opacity-10 text-info border border-info border-opacity-25
                                        @elseif(str_contains(strtolower($log->description), 'update') || str_contains(strtolower($log->description), 'edit')) bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25
                                        @elseif(str_contains(strtolower($log->description), 'delete') || str_contains(strtolower($log->description), 'remove')) bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25
                                        @elseif(str_contains(strtolower($log->description), 'view') || str_contains(strtolower($log->description), 'access')) bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25
                                        @else bg-dark bg-opacity-10 text-dark border border-dark border-opacity-25 @endif">
                                        <i class="fas @if(str_contains(strtolower($log->description), 'login')) fa-sign-in-alt 
                                                    @elseif(str_contains(strtolower($log->description), 'logout')) fa-sign-out-alt 
                                                    @elseif(str_contains(strtolower($log->description), 'create') || str_contains(strtolower($log->description), 'add')) fa-plus-circle 
                                                    @elseif(str_contains(strtolower($log->description), 'update') || str_contains(strtolower($log->description), 'edit')) fa-edit 
                                                    @elseif(str_contains(strtolower($log->description), 'delete') || str_contains(strtolower($log->description), 'remove')) fa-trash 
                                                    @elseif(str_contains(strtolower($log->description), 'view') || str_contains(strtolower($log->description), 'access')) fa-eye 
                                                    @else fa-history @endif me-1"></i>
                                        {{ ucfirst(explode(' ', $log->description)[0] ?? 'Activity') }}
                                    </span>
                                </td>
                                <td>
                                    <div class="activity-description">
                                        <p class="text-dark mb-0 small lh-sm">{{ $log->description }}</p>
                                        @if(str_contains(strtolower($log->description), 'login'))
                                            <small class="text-muted">User authentication event</small>
                                        @elseif(str_contains(strtolower($log->description), 'logout'))
                                            <small class="text-muted">User session ended</small>
                                        @elseif(str_contains(strtolower($log->description), 'create'))
                                            <small class="text-muted">New resource created</small>
                                        @elseif(str_contains(strtolower($log->description), 'update'))
                                            <small class="text-muted">Resource modified</small>
                                        @elseif(str_contains(strtolower($log->description), 'delete'))
                                            <small class="text-muted">Resource removed</small>
                                        @endif
                                    </div>
                                </td>
                                <td class="pe-4">
                                    <div class="d-flex flex-column">
                                        <span class="fw-medium text-dark">
                                            @if($log->date_time instanceof \Carbon\Carbon)
                                                {{ $log->date_time->format('M d, Y') }}
                                            @else
                                                {{ \Carbon\Carbon::parse($log->date_time)->format('M d, Y') }}
                                            @endif
                                        </span>
                                        <div class="d-flex align-items-center gap-2">
                                            <small class="text-muted">
                                                @if($log->date_time instanceof \Carbon\Carbon)
                                                    {{ $log->date_time->format('h:i:s A') }}
                                                @else
                                                    {{ \Carbon\Carbon::parse($log->date_time)->format('h:i:s A') }}
                                                @endif
                                            </small>
                                            <small class="badge bg-light text-dark border-0">
                                                @if($log->date_time instanceof \Carbon\Carbon)
                                                    {{ $log->date_time->diffForHumans() }}
                                                @else
                                                    {{ \Carbon\Carbon::parse($log->date_time)->diffForHumans() }}
                                                @endif
                                            </small>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-5">
                                    <div class="empty-state">
                                        <i class="fas fa-list-alt fa-3x text-muted mb-3"></i>
                                        <h5 class="text-muted mb-2">No Activity Logs Found</h5>
                                        <p class="text-muted mb-3">User activities will appear here once recorded</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($activity->hasPages())
            <div class="card-footer bg-white border-0 py-3 px-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="text-muted small">
                        Showing {{ $activity->firstItem() ?? 0 }} to {{ $activity->lastItem() ?? 0 }} of {{ $activity->total() }} entries
                    </div>
                    {{ $activity->links('pagination::bootstrap-4') }}
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Export Modal -->
<div class="modal fade" id="exportModal" tabindex="-1" aria-labelledby="exportModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-light border-0 py-4">
                <h5 class="modal-title fw-bold text-dark mb-0" id="exportModalLabel">
                    <i class="fas fa-download me-2 text-primary"></i>Export Activity Logs
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-4">
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label small fw-semibold text-muted text-uppercase">Export Format</label>
                        <select class="form-select" id="exportFormat">
                            <option value="csv">CSV Format</option>
                            <option value="excel">Excel Format</option>
                            <option value="pdf">PDF Format</option>
                            <option value="json">JSON Format</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label small fw-semibold text-muted text-uppercase">Date Range</label>
                        <div class="input-group">
                            <input type="date" class="form-control" id="exportStartDate">
                            <span class="input-group-text">to</span>
                            <input type="date" class="form-control" id="exportEndDate">
                        </div>
                    </div>
                    <div class="col-12">
                        <label class="form-label small fw-semibold text-muted text-uppercase">Include Fields</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="includeUser" checked>
                            <label class="form-check-label small" for="includeUser">User Information</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="includeActivity" checked>
                            <label class="form-check-label small" for="includeActivity">Activity Details</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="includeTimestamp" checked>
                            <label class="form-check-label small" for="includeTimestamp">Timestamps</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 bg-light py-3">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    Cancel
                </button>
                <button type="button" class="btn btn-primary" onclick="exportActivityLogs()">
                    <i class="fas fa-download me-2"></i>Export
                </button>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    transition: transform 0.2s ease;
}

.card:hover {
    transform: translateY(-2px);
}

.stat-icon {
    width: 56px;
    height: 56px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.avatar {
    font-weight: 600;
    font-size: 14px;
}

.table th {
    border-top: none;
    font-weight: 600;
    font-size: 0.85rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #6c757d;
}

.table td {
    vertical-align: middle;
    padding: 1rem 0.75rem;
}

.empty-state {
    padding: 3rem 1rem;
}

.activity-description {
    max-width: 300px;
}

.badge {
    font-weight: 500;
}

.form-control {
    border-radius: 6px;
    border: 1px solid #e2e8f0;
}

.form-control:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.1);
}

.modal-header {
    border-radius: 8px 8px 0 0;
}

.modal-footer {
    border-radius: 0 0 8px 8px;
}

.btn {
    border-radius: 6px;
    font-weight: 500;
}

@media (max-width: 768px) {
    .d-flex.flex-lg-row {
        flex-direction: column !important;
    }
    
    .input-group {
        width: 100% !important;
        margin-top: 1rem;
    }
    
    .table-responsive {
        font-size: 0.875rem;
    }
    
    .activity-description {
        max-width: 200px;
    }
    
    .avatar {
        margin-right: 0.5rem;
    }
}
</style>

<script>
function refreshActivityLogs() {
    // In a real application, you would refresh the data via AJAX
    location.reload();
}

function clearOldLogs() {
    if (confirm('Are you sure you want to clear activity logs older than 30 days? This action cannot be undone.')) {
        // In a real application, you would make an AJAX call to clear old logs
        console.log('Clearing old activity logs...');
        // Show loading state
        const btn = event.target;
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Clearing...';
        btn.disabled = true;
        
        // Simulate API call
        setTimeout(() => {
            btn.innerHTML = originalText;
            btn.disabled = false;
            alert('Old activity logs cleared successfully!');
            refreshActivityLogs();
        }, 1500);
    }
}

function exportActivityLogs() {
    const format = document.getElementById('exportFormat').value;
    const startDate = document.getElementById('exportStartDate').value;
    const endDate = document.getElementById('exportEndDate').value;
    
    console.log('Exporting activity logs:', { format, startDate, endDate });
    
    // Show success message
    alert(`Activity logs exported successfully in ${format.toUpperCase()} format!`);
    $('#exportModal').modal('hide');
}

// Initialize filters and search
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const activityFilter = document.getElementById('activityFilter');
    const userFilter = document.getElementById('userFilter');
    const dateFilter = document.getElementById('dateFilter');
    const periodFilter = document.getElementById('periodFilter');
    
    const filters = [searchInput, activityFilter, userFilter, dateFilter, periodFilter];
    
    filters.forEach(filter => {
        if (filter) {
            filter.addEventListener('input', filterActivities);
            filter.addEventListener('change', filterActivities);
        }
    });
    
    function filterActivities() {
        const searchTerm = searchInput.value.toLowerCase();
        const activityType = activityFilter.value.toLowerCase();
        const userEmail = userFilter.value.toLowerCase();
        const selectedDate = dateFilter.value;
        const period = periodFilter.value;
        
        const rows = document.querySelectorAll('#activityTable tbody tr');
        
        rows.forEach(row => {
            const name = row.cells[0].textContent.toLowerCase();
            const email = row.cells[0].querySelector('small').textContent.toLowerCase();
            const activity = row.cells[1].textContent.toLowerCase();
            const description = row.cells[2].textContent.toLowerCase();
            const date = row.cells[3].textContent.toLowerCase();
            
            let showRow = true;
            
            // Search filter
            if (searchTerm && !name.includes(searchTerm) && !email.includes(searchTerm) && 
                !activity.includes(searchTerm) && !description.includes(searchTerm)) {
                showRow = false;
            }
            
            // Activity type filter
            if (activityType && !description.includes(activityType)) {
                showRow = false;
            }
            
            // User filter
            if (userEmail && !email.includes(userEmail)) {
                showRow = false;
            }
            
            row.style.display = showRow ? '' : 'none';
        });
    }
    
    // Initialize tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    const tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>

@include('adminPortal.layout.footer')