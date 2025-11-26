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
                <li class="breadcrumb-item active" aria-current="page">Email Tracking</li>
            </ol>
        </nav>

        <!-- Header Section -->
        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-start align-items-lg-center mb-5">
            <div class="mb-3 mb-lg-0">
                <h1 class="h2 fw-bold text-dark mb-2">Email Tracking</h1>
                <p class="text-muted mb-0">Monitor all sent, pending, and failed emails</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.email.compose') }}" class="btn btn-primary">
                    <i class="fas fa-envelope me-2"></i>Compose Email
                </a>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row g-4 mb-5">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon bg-primary bg-opacity-10 text-primary rounded-2 p-3 me-3">
                                <i class="fas fa-envelope fa-lg"></i>
                            </div>
                            <div>
                                <p class="text-muted text-uppercase small fw-semibold mb-1">Total Emails</p>
                                <h3 class="fw-bold text-dark mb-0">{{ $stats['total'] }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon bg-success bg-opacity-10 text-success rounded-2 p-3 me-3">
                                <i class="fas fa-check-circle fa-lg"></i>
                            </div>
                            <div>
                                <p class="text-muted text-uppercase small fw-semibold mb-1">Sent</p>
                                <h3 class="fw-bold text-success mb-0">{{ $stats['sent'] }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon bg-warning bg-opacity-10 text-warning rounded-2 p-3 me-3">
                                <i class="fas fa-hourglass-half fa-lg"></i>
                            </div>
                            <div>
                                <p class="text-muted text-uppercase small fw-semibold mb-1">Pending</p>
                                <h3 class="fw-bold text-warning mb-0">{{ $stats['pending'] }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon bg-danger bg-opacity-10 text-danger rounded-2 p-3 me-3">
                                <i class="fas fa-times-circle fa-lg"></i>
                            </div>
                            <div>
                                <p class="text-muted text-uppercase small fw-semibold mb-1">Failed</p>
                                <h3 class="fw-bold text-danger mb-0">{{ $stats['failed'] }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Success/Error Messages -->
        @if($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            <strong>Success!</strong> {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if($message = Session::get('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            <strong>Error!</strong> {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <!-- Email Tracking Table -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 pb-0 pt-4 px-4">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <div>
                        <h5 class="card-title fw-bold text-dark mb-1">
                            <i class="fas fa-paper-plane me-2 text-primary"></i>Email History
                        </h5>
                        <p class="text-muted small mb-0">All email communications with delivery status</p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.email.tracking') }}" class="btn btn-sm btn-outline-secondary {{ !$status ? 'active' : '' }}">
                            <i class="fas fa-list me-1"></i> All
                        </a>
                        <a href="{{ route('admin.email.tracking', ['status' => 'sent']) }}" class="btn btn-sm btn-outline-success {{ $status === 'sent' ? 'active' : '' }}">
                            <i class="fas fa-check me-1"></i> Sent
                        </a>
                        <a href="{{ route('admin.email.tracking', ['status' => 'pending']) }}" class="btn btn-sm btn-outline-warning {{ $status === 'pending' ? 'active' : '' }}">
                            <i class="fas fa-hourglass me-1"></i> Pending
                        </a>
                        <a href="{{ route('admin.email.tracking', ['status' => 'failed']) }}" class="btn btn-sm btn-outline-danger {{ $status === 'failed' ? 'active' : '' }}">
                            <i class="fas fa-times me-1"></i> Failed
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body px-0 pb-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4 small fw-semibold text-uppercase text-muted" style="width: 15%">Recipient</th>
                                <th class="small fw-semibold text-uppercase text-muted" style="width: 20%">Subject</th>
                                <th class="small fw-semibold text-uppercase text-muted" style="width: 10%">Sender</th>
                                <th class="small fw-semibold text-uppercase text-muted" style="width: 10%">Status</th>
                                <th class="small fw-semibold text-uppercase text-muted" style="width: 12%">Sent Date</th>
                                <th class="small fw-semibold text-uppercase text-muted" style="width: 10%">Created</th>
                                <th class="pe-4 small fw-semibold text-uppercase text-muted" style="width: 13%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($emails as $email)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex flex-column">
                                        <small class="fw-medium text-dark">{{ $email->recipient_email }}</small>
                                        @if($email->recipient_name)
                                            <small class="text-muted">{{ $email->recipient_name }}</small>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <small class="fw-medium text-dark">{{ Str::limit($email->subject, 30) }}</small>
                                    </div>
                                </td>
                                <td>
                                    <small class="text-muted">
                                        @if($email->sender)
                                            {{ $email->sender->name }}
                                        @else
                                            System
                                        @endif
                                    </small>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $email->status_color }} bg-opacity-10 text-{{ $email->status_color }} border border-{{ $email->status_color }} border-opacity-25 px-2 py-1">
                                        <i class="{{ $email->status_icon }} me-1"></i>{{ ucfirst($email->status) }}
                                    </span>
                                </td>
                                <td>
                                    <small class="text-muted">
                                        @if($email->sent_at)
                                            {{ $email->sent_at->format('M d, Y h:i A') }}
                                        @else
                                            -
                                        @endif
                                    </small>
                                </td>
                                <td>
                                    <small class="text-muted">{{ $email->created_at->format('M d, Y h:i A') }}</small>
                                </td>
                                <td class="pe-4">
                                    <div class="d-flex gap-1">
                                        <a href="{{ route('admin.email.details', $email->uuid) }}" 
                                           class="btn btn-sm btn-outline-primary" 
                                           title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if($email->status === 'failed')
                                        <form action="{{ route('admin.email.retry', $email->uuid) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" 
                                                    class="btn btn-sm btn-outline-warning" 
                                                    title="Retry Email"
                                                    onclick="return confirm('Retry sending this email?')">
                                                <i class="fas fa-redo"></i>
                                            </button>
                                        </form>
                                        @endif
                                        <form action="{{ route('admin.email.destroy', $email->uuid) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-sm btn-outline-danger" 
                                                    title="Delete Record"
                                                    onclick="return confirm('Delete this email record?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-5">
                                    <div class="empty-state">
                                        <i class="fas fa-envelope-open-text fa-3x text-muted mb-3"></i>
                                        <h5 class="text-muted mb-2">No Emails Found</h5>
                                        <p class="text-muted mb-3">No emails to display for the selected filter</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($emails->count() > 0)
            <div class="card-footer bg-white border-0 py-3 px-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="text-muted small">
                        Showing {{ $emails->firstItem() ?? 0 }} to {{ $emails->lastItem() ?? 0 }} of {{ $emails->total() }} entries
                    </div>
                    {{ $emails->links('pagination::bootstrap-4') }}
                </div>
            </div>
            @endif
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

.btn {
    border-radius: 6px;
    font-weight: 500;
}

.btn-sm {
    padding: 0.375rem 0.5rem;
}

.btn-outline-secondary.active,
.btn-outline-success.active,
.btn-outline-warning.active,
.btn-outline-danger.active {
    background-color: currentColor;
    color: white;
}

@media (max-width: 768px) {
    .d-flex.flex-lg-row {
        flex-direction: column !important;
    }
    
    .table-responsive {
        font-size: 0.875rem;
    }
    
    .btn-sm {
        padding: 0.25rem 0.375rem;
    }
}
</style>

@include('adminPortal.layout.footer')
