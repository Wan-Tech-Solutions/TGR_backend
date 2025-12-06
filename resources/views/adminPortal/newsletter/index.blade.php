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
                <li class="breadcrumb-item active" aria-current="page">Newsletter Management</li>
            </ol>
        </nav>

        <!-- Header Section -->
        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-start align-items-lg-center mb-5">
            <div class="mb-3 mb-lg-0">
                <h1 class="h2 fw-bold text-dark mb-2">Newsletter Management</h1>
                <p class="text-muted mb-0">Manage subscribers and send email campaigns</p>
            </div>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#sendNewsletterModal">
                <i class="fas fa-paper-plane me-2"></i>Send Newsletter
            </button>
        </div>

        <!-- Alert Messages -->
        @if(session('newsletter_sent'))
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
                <i class="fas fa-check-circle fa-lg me-3"></i>
                <div class="flex-grow-1">
                    <strong>Success!</strong> {{ session('newsletter_sent') }}
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if(session('newsletter_admin_action'))
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
                <i class="fas fa-check-circle fa-lg me-3"></i>
                <div class="flex-grow-1">
                    {{ session('newsletter_admin_action') }}
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert">
                <i class="fas fa-exclamation-circle fa-lg me-3"></i>
                <div class="flex-grow-1">
                    <strong>Error!</strong> {{ session('error') }}
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Statistics Cards -->
        <div class="row g-4 mb-5">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100 stat-card stat-primary">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon bg-primary bg-opacity-10 text-primary rounded-2 p-2 me-3" style="width:46px;height:46px;display:flex;align-items:center;justify-content:center;">
                                <i class="fas fa-users fa-md text-white"></i>
                            </div>
                            <div>
                                <p class="text-muted text-uppercase small fw-semibold mb-1">Total Subscribers</p>
                                <h3 class="fw-bold text-dark mb-0">{{ $subscribers->total() ?? 0 }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100 stat-card stat-success">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon bg-success bg-opacity-10 text-success rounded-2 p-2 me-3" style="width:46px;height:46px;display:flex;align-items:center;justify-content:center;">
                                <i class="fas fa-check-circle fa-md text-white"></i>
                            </div>
                            <div>
                                <p class="text-muted text-uppercase small fw-semibold mb-1">Active Subscribers</p>
                                <h3 class="fw-bold text-success mb-0">{{ $subscribers->where('active', true)->count() ?? 0 }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100 stat-card stat-warning">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon bg-warning bg-opacity-10 text-warning rounded-2 p-2 me-3" style="width:46px;height:46px;display:flex;align-items:center;justify-content:center;">
                                <i class="fas fa-user-slash fa-md text-white"></i>
                            </div>
                            <div>
                                <p class="text-muted text-uppercase small fw-semibold mb-1">Unsubscribed</p>
                                <h3 class="fw-bold text-warning mb-0">{{ $subscribers->where('active', false)->count() ?? 0 }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100 stat-card stat-info">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon bg-info bg-opacity-10 text-info rounded-2 p-2 me-3" style="width:46px;height:46px;display:flex;align-items:center;justify-content:center;">
                                <i class="fas fa-chart-pie fa-md text-white"></i>
                            </div>
                            <div>
                                <p class="text-muted text-uppercase small fw-semibold mb-1">Active Rate</p>
                                <h3 class="fw-bold text-info mb-0">
                                    {{ $subscribers->total() > 0 ? round(($subscribers->where('active', true)->count() / $subscribers->total()) * 100, 1) : 0 }}%
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Subscribers Table -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 pb-0 pt-4 px-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title fw-bold text-dark mb-1">
                            <i class="fas fa-envelope me-2 text-primary"></i>Email Subscribers
                        </h5>
                        <p class="text-muted small mb-0">Manage all newsletter subscribers and their status</p>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <div class="input-group input-group-sm" style="width: 250px;">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            <input type="text" class="form-control border-start-0" placeholder="Search subscribers...">
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body px-0 pb-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4 small fw-semibold text-uppercase text-muted" style="width: 30%">Email Address</th>
                                <th class="small fw-semibold text-uppercase text-muted" style="width: 15%">Status</th>
                                <th class="small fw-semibold text-uppercase text-muted" style="width: 20%">Subscribed Date</th>
                                <th class="small fw-semibold text-uppercase text-muted" style="width: 20%">Active Since</th>
                                <th class="pe-4 small fw-semibold text-uppercase text-muted" style="width: 15%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($subscribers as $sub)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                            <i class="fas fa-user"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-bold text-dark mb-1">{{ $sub->email }}</h6>
                                            <small class="text-muted">Subscriber ID: #{{ $sub->id }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge status-badge rounded-pill py-2 px-3 fw-semibold @if($sub->active) status-active @else status-inactive @endif">
                                        <i class="fas @if($sub->active) fa-check-circle @else fa-times-circle @endif"></i>
                                        <span class="status-text">{{ $sub->active ? 'Active' : 'Unsubscribed' }}</span>
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="fw-medium text-dark">
                                            {{ $sub->created_at->format('M d, Y') }}
                                        </span>
                                        <small class="text-muted">
                                            {{ $sub->created_at->format('h:i A') }}
                                        </small>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border px-3 py-2">
                                        <i class="fas fa-calendar me-1"></i>
                                        {{ $sub->created_at->diffInDays(now()) }} days
                                    </span>
                                </td>
                                <td class="pe-4">
                                    <div class="d-flex gap-1">
                                        @if(!$sub->active)
                                            <form method="POST" action="{{ route('admin.newsletter.reactivate', $sub->id) }}" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-success d-flex align-items-center"
                                                        data-bs-toggle="tooltip" title="Reactivate subscriber">
                                                    <i class="fas fa-redo"></i>
                                                </button>
                                            </form>
                                        @else
                                            <form method="POST" action="{{ route('admin.newsletter.unsubscribe', $sub->id) }}" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-warning d-flex align-items-center"
                                                        data-bs-toggle="tooltip" title="Unsubscribe"
                                                        onclick="return confirm('Are you sure you want to unsubscribe this user?')">
                                                    <i class="fas fa-times-circle"></i>
                                                </button>
                                            </form>
                                        @endif
                                        <form method="POST" action="{{ route('admin.newsletter.delete', $sub->id) }}" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger d-flex align-items-center"
                                                    data-bs-toggle="tooltip" title="Delete subscriber"
                                                    onclick="return confirm('Are you sure you want to permanently delete this subscriber?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-5">
                                    <div class="empty-state">
                                        <i class="fas fa-envelope fa-3x text-muted mb-3"></i>
                                        <h5 class="text-muted mb-2">No Subscribers Found</h5>
                                        <p class="text-muted mb-3">Newsletter subscribers will appear here</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($subscribers->hasPages())
            <div class="card-footer bg-white border-0 py-3 px-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="text-muted small">
                        Showing {{ $subscribers->firstItem() ?? 0 }} to {{ $subscribers->lastItem() ?? 0 }} of {{ $subscribers->total() }} entries
                    </div>
                    {{ $subscribers->links('pagination::bootstrap-4') }}
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Send Newsletter Modal -->
<div class="modal fade" id="sendNewsletterModal" tabindex="-1" aria-labelledby="sendNewsletterModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-light border-0 py-4">
                <div>
                    <h5 class="modal-title fw-bold text-dark mb-1" id="sendNewsletterModalLabel">
                        <i class="fas fa-paper-plane me-2 text-primary"></i>Send Newsletter
                    </h5>
                    <p class="text-muted small mb-0">Create and send email campaigns to your subscribers</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('admin.newsletter.send') }}" enctype="multipart/form-data" id="newsletterForm">
                @csrf
                <div class="modal-body py-4">
                    <div class="row g-4">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="newsletterSubject" class="form-label small fw-semibold text-muted text-uppercase">Subject *</label>
                                <input type="text" name="subject" id="newsletterSubject" class="form-control"
                                       placeholder="Enter newsletter subject" required>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label for="newsletterBody" class="form-label small fw-semibold text-muted text-uppercase">Message *</label>
                                <textarea name="body" id="newsletterBody" class="form-control" rows="8"
                                          placeholder="Write your newsletter content here..." required></textarea>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="newsletterReplyTo" class="form-label small fw-semibold text-muted text-uppercase">Reply-To (Optional)</label>
                                <input type="email" name="reply_to" id="newsletterReplyTo" class="form-control"
                                       placeholder="reply@example.com">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="newsletterAttachments" class="form-label small fw-semibold text-muted text-uppercase">Attachments</label>
                                <input type="file" name="attachments[]" id="newsletterAttachments" class="form-control" multiple>
                                <small class="text-muted d-block mt-1">
                                    <i class="fas fa-info-circle me-1"></i>
                                    PDF, DOC, DOCX, JPG, PNG, ZIP | Max 5MB each
                                </small>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label for="sendToSelect" class="form-label small fw-semibold text-muted text-uppercase">Send To *</label>
                                <select name="send_to" id="sendToSelect" class="form-select" required>
                                    <option value="all">All Active Subscribers ({{ $subscribers->where('active', true)->count() }})</option>
                                    <option value="selected">Selected Subscribers Only</option>
                                </select>
                            </div>
                        </div>

                        <!-- Selected Subscribers Section -->
                        <div class="col-12" id="selectedSubscribersSection" style="display: none;">
                            <div class="card border">
                                <div class="card-header bg-light py-2">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <label class="form-label small fw-semibold text-muted text-uppercase mb-0">Select Subscribers</label>
                                        <div class="form-check">
                                            <input type="checkbox" id="selectAll" class="form-check-input">
                                            <label class="form-check-label small" for="selectAll">Select All</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">
                                        <table class="table table-sm table-hover mb-0">
                                            <thead class="table-light sticky-top">
                                                <tr>
                                                    <th style="width: 40px;"></th>
                                                    <th>Email</th>
                                                    <th style="width: 100px;">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($subscribers->where('active', true) as $sub)
                                                <tr>
                                                    <td>
                                                        <input type="checkbox" name="selected[]" value="{{ $sub->id }}"
                                                               class="form-check-input subscriber-checkbox">
                                                    </td>
                                                    <td>
                                                        <small>{{ $sub->email }}</small>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 small">
                                                            Active
                                                        </span>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 bg-light py-3">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Cancel
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane me-2"></i>Queue Newsletter
                    </button>
                </div>
            </form>
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

/* Stat cards with soft gradients and subtle borders */
.stat-card {
    border: 1px solid rgba(17, 24, 39, 0.05) !important;
    border-radius: 14px;
    background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
    box-shadow: 0 12px 30px rgba(15, 23, 42, 0.07);
}

.stat-card .card-body {
    padding: 22px;
}

.stat-card .stat-icon {
    border-radius: 12px !important;
    box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.45);
}

.stat-card .stat-icon i {
    color: currentColor;
}

.stat-card h3 {
    letter-spacing: -0.2px;
}

.stat-card p {
    letter-spacing: 0.3px;
}

.stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 16px 40px rgba(15, 23, 42, 0.12);
}

.stat-primary {
    background: linear-gradient(135deg, #eef2ff 0%, #ffffff 100%);
}

.stat-card.stat-primary .stat-icon {
    background: rgba(59, 130, 246, 0.18);
    color: #1d4ed8;
}

.stat-success {
    background: linear-gradient(135deg, #ecfdf3 0%, #ffffff 100%);
}

.stat-card.stat-success .stat-icon {
    background: rgba(34, 197, 94, 0.18);
    color: #15803d;
}

.stat-warning {
    background: linear-gradient(135deg, #fff7ed 0%, #ffffff 100%);
}

.stat-card.stat-warning .stat-icon {
    background: rgba(245, 158, 11, 0.20);
    color: #b45309;
}

.stat-info {
    background: linear-gradient(135deg, #eff6ff 0%, #ffffff 100%);
}

.stat-card.stat-info .stat-icon {
    background: rgba(59, 130, 246, 0.18);
    color: #0ea5e9;
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

.badge {
    font-weight: 500;
}

/* Explicit status badge styling to ensure visibility */
.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    border: 1px solid transparent;
    font-weight: 700;
}

.status-badge i {
    font-size: 12px;
}

.status-badge.status-active {
    background: rgba(34, 197, 94, 0.12);
    color: #166534;
    border-color: rgba(34, 197, 94, 0.35);
}

.status-badge.status-inactive {
    background: rgba(107, 114, 128, 0.14);
    color: #374151;
    border-color: rgba(107, 114, 128, 0.35);
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

    .btn-sm {
        padding: 0.25rem 0.375rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle selected subscribers section
    const sendToSelect = document.getElementById('sendToSelect');
    const selectedSection = document.getElementById('selectedSubscribersSection');

    sendToSelect.addEventListener('change', function(e) {
        if (e.target.value === 'selected') {
            selectedSection.style.display = 'block';
        } else {
            selectedSection.style.display = 'none';
        }
    });

    // Select all subscribers checkbox
    const selectAll = document.getElementById('selectAll');
    const subscriberCheckboxes = document.querySelectorAll('.subscriber-checkbox');

    if (selectAll) {
        selectAll.addEventListener('change', function(e) {
            subscriberCheckboxes.forEach(function(cb) {
                cb.checked = e.target.checked;
            });
        });
    }

    // Update select all checkbox when individual checkboxes change
    subscriberCheckboxes.forEach(function(cb) {
        cb.addEventListener('change', function() {
            const allChecked = Array.from(subscriberCheckboxes).every(cb => cb.checked);
            if (selectAll) {
                selectAll.checked = allChecked;
            }
        });
    });

    // Form validation for selected subscribers
    const newsletterForm = document.getElementById('newsletterForm');

    newsletterForm.addEventListener('submit', function(e) {
        const sendTo = sendToSelect.value;
        if (sendTo === 'selected') {
            const selectedCount = document.querySelectorAll('.subscriber-checkbox:checked').length;
            if (selectedCount === 0) {
                e.preventDefault();
                alert('Please select at least one subscriber');
                return false;
            }
        }

        // Show loading state
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Sending...';
        submitBtn.disabled = true;

        // Allow form submission
        return true;
    });

    // Initialize tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    const tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>

@include('adminPortal.layout.footer')
