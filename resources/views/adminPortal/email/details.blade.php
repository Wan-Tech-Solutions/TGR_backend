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
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.email.tracking') }}" class="text-muted text-decoration-none">Email Tracking</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Email Details</li>
            </ol>
        </nav>

        <!-- Header Section -->
        <div class="d-flex justify-content-between align-items-start mb-5">
            <div>
                <h1 class="h2 fw-bold text-dark mb-2">Email Details</h1>
                <p class="text-muted mb-0">View complete information about this email</p>
            </div>
            <a href="{{ route('admin.email.tracking') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back to Tracking
            </a>
        </div>

        <!-- Main Content -->
        <div class="row g-4">
            <!-- Email Information Card -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-light border-0 py-4 px-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title fw-bold text-dark mb-0">
                                <i class="fas fa-envelope me-2 text-primary"></i>Email Information
                            </h5>
                            <span class="badge bg-{{ $email->status_color }} bg-opacity-10 text-{{ $email->white }} border border-{{ $email->status_color }} border-opacity-25 px-3 py-2">
                                <i class="{{ $email->status_icon }} me-1"></i>{{ ucfirst($email->status) }}
                            </span>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <!-- Subject -->
                        <div class="mb-4">
                            <label class="form-label small fw-semibold text-muted text-uppercase">Subject</label>
                            <p class="mb-0 fw-medium text-dark">{{ $email->subject }}</p>
                        </div>

                        <!-- To -->
                        <div class="mb-4">
                            <label class="form-label small fw-semibold text-muted text-uppercase">To</label>
                            <p class="mb-0 fw-medium text-dark">
                                <i class="fas fa-envelope me-2 text-primary"></i>{{ $email->recipient_email }}
                                @if($email->recipient_name)
                                    <br><small class="text-muted">({{ $email->recipient_name }})</small>
                                @endif
                            </p>
                        </div>

                        <!-- CC -->
                        @if($email->cc)
                        <div class="mb-4">
                            <label class="form-label small fw-semibold text-muted text-uppercase">CC</label>
                            <p class="mb-0 fw-medium text-dark">
                                <i class="fas fa-copy me-2 text-primary"></i>{{ $email->cc }}
                            </p>
                        </div>
                        @endif

                        <!-- BCC -->
                        @if($email->bcc)
                        <div class="mb-4">
                            <label class="form-label small fw-semibold text-muted text-uppercase">BCC</label>
                            <p class="mb-0 fw-medium text-dark">
                                <i class="fas fa-copy me-2 text-primary"></i>{{ $email->bcc }}
                            </p>
                        </div>
                        @endif

                        <!-- Message -->
                        <div class="mb-4">
                            <label class="form-label small fw-semibold text-muted text-uppercase">Message</label>
                            <div class="bg-light p-4 rounded">
                                <p class="mb-0 text-dark lh-base" style="white-space: pre-wrap; word-wrap: break-word;">{{ $email->message }}</p>
                            </div>
                        </div>

                        <!-- Error Message (if failed) -->
                        @if($email->status === 'failed' && $email->error_message)
                        <div class="mb-4">
                            <label class="form-label small fw-semibold text-muted text-uppercase">Error Details</label>
                            <div class="bg-danger bg-opacity-10 border border-danger border-opacity-25 p-4 rounded">
                                <p class="mb-0 text-danger">
                                    <i class="fas fa-exclamation-triangle me-2"></i>{{ $email->error_message }}
                                </p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Sidebar - Meta Information -->
            <div class="col-lg-4">
                <!-- Timeline Card -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-light border-0 py-4 px-4">
                        <h5 class="card-title fw-bold text-dark mb-0">
                            <i class="fas fa-clock me-2 text-primary"></i>Timeline
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="timeline">
                            <!-- Created -->
                            <div class="timeline-item mb-4">
                                <div class="d-flex">
                                    <div class="timeline-marker bg-primary bg-opacity-10 text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; min-width: 40px;">
                                        <i class="fas fa-plus-circle"></i>
                                    </div>
                                    <div class="ms-3">
                                        <p class="text-muted small fw-semibold mb-1">Created</p>
                                        <p class="fw-medium text-dark mb-0">{{ $email->created_at->format('M d, Y h:i A') }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Sent -->
                            @if($email->sent_at)
                            <div class="timeline-item">
                                <div class="d-flex">
                                    <div class="timeline-marker bg-success bg-opacity-10 text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; min-width: 40px;">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                    <div class="ms-3">
                                        <p class="text-muted small fw-semibold mb-1">Sent Successfully</p>
                                        <p class="fw-medium text-dark mb-0">{{ $email->sent_at->format('M d, Y h:i A') }}</p>
                                        <p class="text-muted small mb-0">{{ $email->sent_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                            </div>
                            @elseif($email->status === 'failed')
                            <div class="timeline-item">
                                <div class="d-flex">
                                    <div class="timeline-marker bg-danger bg-opacity-10 text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; min-width: 40px;">
                                        <i class="fas fa-times-circle"></i>
                                    </div>
                                    <div class="ms-3">
                                        <p class="text-muted small fw-semibold mb-1">Failed</p>
                                        <p class="fw-medium text-dark mb-0">{{ $email->updated_at->format('M d, Y h:i A') }}</p>
                                    </div>
                                </div>
                            </div>
                            @else
                            <div class="timeline-item">
                                <div class="d-flex">
                                    <div class="timeline-marker bg-warning bg-opacity-10 text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; min-width: 40px;">
                                        <i class="fas fa-hourglass-half"></i>
                                    </div>
                                    <div class="ms-3">
                                        <p class="text-muted small fw-semibold mb-1">Pending</p>
                                        <p class="fw-medium text-dark mb-0">Waiting to be sent...</p>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Sender Information Card -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-light border-0 py-4 px-4">
                        <h5 class="card-title fw-bold text-dark mb-0">
                            <i class="fas fa-user me-2 text-primary"></i>Sender Information
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        @if($email->sender)
                        <div class="mb-3">
                            <p class="text-muted small fw-semibold text-uppercase mb-1">Name</p>
                            <p class="fw-medium text-dark mb-0">{{ $email->sender->name }}</p>
                        </div>
                        <div class="mb-3">
                            <p class="text-muted small fw-semibold text-uppercase mb-1">Email</p>
                            <p class="fw-medium text-dark mb-0">{{ $email->sender->email }}</p>
                        </div>
                        <div class="mb-0">
                            <p class="text-muted small fw-semibold text-uppercase mb-1">Role</p>
                            <p class="fw-medium text-dark mb-0">
                                @if($email->sender->roles->count())
                                    {{ $email->sender->roles->pluck('name')->join(', ') }}
                                @else
                                    No role assigned
                                @endif
                            </p>
                        </div>
                        @else
                        <p class="text-muted mb-0"><i class="fas fa-info-circle me-2"></i>System User</p>
                        @endif
                    </div>
                </div>

                <!-- Actions Card -->
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-light border-0 py-4 px-4">
                        <h5 class="card-title fw-bold text-dark mb-0">
                            <i class="fas fa-cog me-2 text-primary"></i>Actions
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        @if($email->status === 'failed')
                        <form action="{{ route('admin.email.retry', $email->uuid) }}" method="POST" class="mb-2">
                            @csrf
                            <button type="submit" class="btn btn-warning w-100 btn-sm">
                                <i class="fas fa-redo me-2"></i>Retry Sending
                            </button>
                        </form>
                        @endif
                        <form action="{{ route('admin.email.destroy', $email->uuid) }}" method="POST" class="mb-0">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100 btn-sm" onclick="return confirm('Delete this email record?')">
                                <i class="fas fa-trash me-2"></i>Delete Record
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.timeline {
    position: relative;
}

.timeline-item {
    position: relative;
    padding-bottom: 1rem;
}

.timeline-item:not(:last-child)::before {
    content: '';
    position: absolute;
    left: 19px;
    top: 40px;
    bottom: -20px;
    width: 2px;
    background-color: #e0e0e0;
}

.timeline-marker {
    border: 2px solid white;
    box-shadow: 0 0 0 2px #e0e0e0;
}

.card {
    transition: transform 0.2s ease;
}

.card:hover {
    transform: translateY(-2px);
}

.btn {
    border-radius: 6px;
    font-weight: 500;
}
</style>

@include('adminPortal.layout.footer')
