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
                <li class="breadcrumb-item active" aria-current="page">Audit Trails</li>
            </ol>
        </nav>

        <!-- Header Section -->
        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-start align-items-lg-center mb-5">
            <div class="mb-3 mb-lg-0">
                <h1 class="h2 fw-bold text-dark mb-2">Audit Trails</h1>
                <p class="text-muted mb-0">Monitor and track all system activities and user actions</p>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#exportModal">
                    <i class="fas fa-download me-2"></i>Export
                </button>
                <button class="btn btn-outline-secondary" onclick="refreshAuditLogs()">
                    <i class="fas fa-sync-alt me-2"></i>Refresh
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
                                <p class="text-muted text-uppercase small fw-semibold mb-1">Total Events</p>
                                <h3 class="fw-bold text-dark mb-0">{{ $audits->count() }}</h3>
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
                                <h3 class="fw-bold text-success mb-0">{{ $audits->pluck('user_id')->unique()->count() }}</h3>
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
                                <i class="fas fa-exclamation-triangle fa-lg"></i>
                            </div>
                            <div>
                                <p class="text-muted text-uppercase small fw-semibold mb-1">Security Events</p>
                                <h3 class="fw-bold text-warning mb-0">{{ $audits->where('event', 'like', '%failed%')->count() }}</h3>
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
                                <p class="text-muted text-uppercase small fw-semibold mb-1">Today's Events</p>
                                <h3 class="fw-bold text-info mb-0">{{ $audits->where('created_at', '>=', today())->count() }}</h3>
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
                    <i class="fas fa-filter me-2 text-primary"></i>Filter Logs
                </h5>
                <p class="text-muted small mb-0">Refine audit trail results by specific criteria</p>
            </div>
            <div class="card-body px-4 pb-4">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label small fw-semibold text-muted text-uppercase">Event Type</label>
                        <select class="form-select" id="eventFilter">
                            <option value="">All Events</option>
                            <option value="login">Login</option>
                            <option value="logout">Logout</option>
                            <option value="created">Created</option>
                            <option value="updated">Updated</option>
                            <option value="deleted">Deleted</option>
                            <option value="failed">Failed Attempts</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-semibold text-muted text-uppercase">User</label>
                        <select class="form-select" id="userFilter">
                            <option value="">All Users</option>
                            @foreach($audits->pluck('user')->unique()->filter() as $user)
                                @if($user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-semibold text-muted text-uppercase">Date Range</label>
                        <input type="date" class="form-control" id="dateFilter">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-semibold text-muted text-uppercase">IP Address</label>
                        <input type="text" class="form-control" placeholder="Filter by IP" id="ipFilter">
                    </div>
                </div>
            </div>
        </div>

        <!-- Audit Trails Table -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 pb-0 pt-4 px-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title fw-bold text-dark mb-1">
                            <i class="fas fa-clipboard-list me-2 text-primary"></i>Audit Trail Logs
                        </h5>
                        <p class="text-muted small mb-0">Detailed record of all system activities</p>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <div class="input-group input-group-sm" style="width: 250px;">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            <input type="text" class="form-control border-start-0" placeholder="Search logs..." id="searchInput">
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body px-0 pb-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" id="auditTable">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4 small fw-semibold text-uppercase text-muted" style="width: 15%">User</th>
                                <th class="small fw-semibold text-uppercase text-muted" style="width: 10%">Event</th>
                                <th class="small fw-semibold text-uppercase text-muted" style="width: 20%">URL</th>
                                <th class="small fw-semibold text-uppercase text-muted" style="width: 12%">IP Address</th>
                                <th class="small fw-semibold text-uppercase text-muted" style="width: 18%">Browser</th>
                                <th class="pe-4 small fw-semibold text-uppercase text-muted" style="width: 15%">Date/Time</th>
                                <th class="pe-4 small fw-semibold text-uppercase text-muted" style="width: 10%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($audits as $audit)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar bg-{{ $audit->user ? 'primary' : 'secondary' }} bg-opacity-10 text-{{ $audit->user ? 'white' : 'secondary' }} rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                            {{ $audit->user ? substr($audit->user->name, 0, 1) : 'N' }}
                                        </div>
                                        <div>
                                            <h6 class="fw-bold text-dark mb-1">{{ $audit->user?->name ?? 'System' }}</h6>
                                            <small class="text-muted">{{ $audit->user?->email ?? 'N/A' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge rounded-pill py-2 px-3 fw-semibold
                                        @if(str_contains($audit->event, 'login')) bg-success bg-opacity-10 text-white border border-success border-opacity-25
                                        @elseif(str_contains($audit->event, 'logout')) bg-secondary bg-opacity-10 text-white border border-secondary border-opacity-25
                                        @elseif(str_contains($audit->event, 'create')) bg-info bg-opacity-10 text-white border border-info border-opacity-25
                                        @elseif(str_contains($audit->event, 'update')) bg-warning bg-opacity-10 text-white border border-warning border-opacity-25
                                        @elseif(str_contains($audit->event, 'delete')) bg-danger bg-opacity-10 text-white border border-danger border-opacity-25
                                        @elseif(str_contains($audit->event, 'failed')) bg-dark bg-opacity-10 text-white border border-dark border-opacity-25
                                        @else bg-primary bg-opacity-10 text-white border border-primary border-opacity-25 @endif">
                                        <i class="fas @if(str_contains($audit->event, 'login')) fa-sign-in-alt 
                                                    @elseif(str_contains($audit->event, 'logout')) fa-sign-out-alt 
                                                    @elseif(str_contains($audit->event, 'create')) fa-plus-circle 
                                                    @elseif(str_contains($audit->event, 'update')) fa-edit 
                                                    @elseif(str_contains($audit->event, 'delete')) fa-trash 
                                                    @elseif(str_contains($audit->event, 'failed')) fa-exclamation-triangle 
                                                    @else fa-history @endif me-1"></i>
                                        {{ ucfirst($audit->event) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="url-truncate">
                                        <small class="text-muted font-monospace">{{ Str::limit($audit->url, 40) }}</small>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border font-monospace">
                                        {{ $audit->ip_address }}
                                    </span>
                                </td>
                                <td>
                                    <div class="browser-info">
                                        <small class="text-muted">{{ Str::limit($audit->user_agent, 50) }}</small>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="fw-medium text-dark">
                                            {{ $audit->created_at->format('M d, Y') }}
                                        </span>
                                        <small class="text-muted">
                                            {{ $audit->created_at->format('h:i:s A') }}
                                        </small>
                                    </div>
                                </td>
                                <td class="pe-4">
                                    <div class="d-flex gap-1">
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-primary d-flex align-items-center"
                                                data-bs-toggle="tooltip" 
                                                title="View Details"
                                                onclick="viewAuditDetails({{ $audit->id }})">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-info d-flex align-items-center"
                                                data-bs-toggle="tooltip" 
                                                title="Export Entry">
                                            <i class="fas fa-download"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-5">
                                    <div class="empty-state">
                                        <i class="fas fa-clipboard-list fa-3x text-muted mb-3"></i>
                                        <h5 class="text-muted mb-2">No Audit Logs Found</h5>
                                        <p class="text-muted mb-3">System activities will appear here once recorded</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($audits->hasPages())
            <div class="card-footer bg-white border-0 py-3 px-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="text-muted small">
                        Showing {{ $audits->firstItem() ?? 0 }} to {{ $audits->lastItem() ?? 0 }} of {{ $audits->total() }} entries
                    </div>
                    {{ $audits->links('pagination::bootstrap-4') }}
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Audit Details Modal -->
<div class="modal fade" id="auditDetailsModal" tabindex="-1" aria-labelledby="auditDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-light border-0 py-4">
                <div>
                    <h5 class="modal-title fw-bold text-dark mb-1" id="auditDetailsModalLabel">
                        <i class="fas fa-search me-2 text-primary"></i>Audit Log Details
                    </h5>
                    <p class="text-muted small mb-0">Complete information about this audit entry</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-4" id="auditDetailsContent">
                <!-- Audit details will be loaded here -->
            </div>
            <div class="modal-footer border-0 bg-light py-3">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Close
                </button>
                <button type="button" class="btn btn-primary" onclick="exportAuditEntry()">
                    <i class="fas fa-download me-2"></i>Export Entry
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Export Modal -->
<div class="modal fade" id="exportModal" tabindex="-1" aria-labelledby="exportModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-light border-0 py-4">
                <h5 class="modal-title fw-bold text-dark mb-0" id="exportModalLabel">
                    <i class="fas fa-download me-2 text-primary"></i>Export Audit Logs
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
                </div>
            </div>
            <div class="modal-footer border-0 bg-light py-3">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    Cancel
                </button>
                <button type="button" class="btn btn-primary" onclick="exportAuditLogs()">
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

.url-truncate {
    max-width: 200px;
}

.browser-info {
    max-width: 250px;
}

.badge {
    font-weight: 500;
}

.font-monospace {
    font-family: 'SFMono-Regular', 'Menlo', 'Monaco', 'Consolas', monospace;
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

.btn-sm {
    padding: 0.375rem 0.5rem;
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
    
    .url-truncate,
    .browser-info {
        max-width: 150px;
    }
    
    .btn-sm {
        padding: 0.25rem 0.375rem;
    }
}
</style>

<script>
function viewAuditDetails(auditId) {
    // In a real application, you would fetch the audit details via AJAX
    console.log('Viewing audit details:', auditId);
    
    // For demo purposes, show the modal with sample content
    const sampleContent = `
        <div class="row g-4">
            <div class="col-md-6">
                <div class="info-item">
                    <label class="text-muted small fw-semibold text-uppercase d-block mb-1">User Information</label>
                    <div class="d-flex align-items-center mb-2">
                        <div class="avatar bg-primary bg-opacity-10 text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                            U
                        </div>
                        <div>
                            <h6 class="fw-bold text-dark mb-0">User Name</h6>
                            <small class="text-muted">user@example.com</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="info-item">
                    <label class="text-muted small fw-semibold text-uppercase d-block mb-1">Event Details</label>
                    <span class="badge bg-success bg-opacity-10 text-white border border-success border-opacity-25 px-3 py-2">
                        <i class="fas fa-sign-in-alt me-1"></i>Login
                    </span>
                </div>
            </div>
            <div class="col-12">
                <div class="info-item">
                    <label class="text-muted small fw-semibold text-uppercase d-block mb-1">Full URL</label>
                    <code class="bg-light p-2 rounded d-block">https://example.com/admin/login</code>
                </div>
            </div>
            <div class="col-md-6">
                <div class="info-item">
                    <label class="text-muted small fw-semibold text-uppercase d-block mb-1">IP Address</label>
                    <span class="fw-medium text-dark">192.168.1.1</span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="info-item">
                    <label class="text-muted small fw-semibold text-uppercase d-block mb-1">Timestamp</label>
                    <span class="fw-medium text-dark">Dec 15, 2024 14:30:25 UTC</span>
                </div>
            </div>
            <div class="col-12">
                <div class="info-item">
                    <label class="text-muted small fw-semibold text-uppercase d-block mb-1">User Agent</label>
                    <small class="text-muted font-monospace">Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36...</small>
                </div>
            </div>
        </div>
    `;
    
    document.getElementById('auditDetailsContent').innerHTML = sampleContent;
    $('#auditDetailsModal').modal('show');
}

function refreshAuditLogs() {
    // In a real application, you would refresh the data via AJAX
    location.reload();
}

function exportAuditLogs() {
    // In a real application, you would handle the export logic
    const format = document.getElementById('exportFormat').value;
    const startDate = document.getElementById('exportStartDate').value;
    const endDate = document.getElementById('exportEndDate').value;
    
    console.log('Exporting logs:', { format, startDate, endDate });
    alert(`Exporting audit logs in ${format.toUpperCase()} format...`);
    $('#exportModal').modal('hide');
}

function exportAuditEntry() {
    // Export single audit entry
    alert('Exporting single audit entry...');
    $('#auditDetailsModal').modal('hide');
}

// Initialize tooltips and filters
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Bootstrap tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    const tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Simple table filtering
    const searchInput = document.getElementById('searchInput');
    const eventFilter = document.getElementById('eventFilter');
    const userFilter = document.getElementById('userFilter');
    const dateFilter = document.getElementById('dateFilter');
    const ipFilter = document.getElementById('ipFilter');
    
    const filters = [searchInput, eventFilter, userFilter, dateFilter, ipFilter];
    
    filters.forEach(filter => {
        if (filter) {
            filter.addEventListener('input', filterTable);
        }
    });
    
    function filterTable() {
        // In a real application, you would implement proper filtering logic
        console.log('Filtering table...');
    }
});
</script>

@include('adminPortal.layout.footer')