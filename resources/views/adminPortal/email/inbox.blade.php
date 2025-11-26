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
                <li class="breadcrumb-item active" aria-current="page">Inbox</li>
            </ol>
        </nav>

        <div class="row">
            <!-- Sidebar Navigation -->
            <div class="col-lg-3 mb-4">
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-body p-3">
                        <a href="{{ route('admin.email.compose') }}" class="btn btn-primary w-100 mb-3">
                            <i class="fas fa-pen me-2"></i>Compose
                        </a>
                        <div class="list-group list-group-flush">
                            <!-- Inbox Unread -->
                            <a href="{{ route('admin.email.inbox') }}" 
                               class="list-group-item list-group-item-action d-flex justify-content-between align-items-center {{ !$status || $status === 'inbox' ? 'active' : '' }}">
                                <div>
                                    <i class="fas fa-inbox me-2 text-primary"></i>
                                    <span>Inbox</span>
                                </div>
                                @if($stats['inbox_unread'] > 0)
                                    <span class="badge bg-danger rounded-pill">{{ $stats['inbox_unread'] }}</span>
                                @endif
                            </a>

                            <!-- Read -->
                            <a href="{{ route('admin.email.inbox', ['status' => 'read']) }}" 
                               class="list-group-item list-group-item-action d-flex justify-content-between align-items-center {{ $status === 'read' ? 'active' : '' }}">
                                <div>
                                    <i class="fas fa-envelope-open me-2 text-success"></i>
                                    <span>Read</span>
                                </div>
                                <span class="badge bg-success rounded-pill">{{ $stats['inbox_read'] }}</span>
                            </a>

                            <!-- Sent -->
                            <a href="{{ route('admin.email.inbox', ['status' => 'sent']) }}" 
                               class="list-group-item list-group-item-action d-flex justify-content-between align-items-center {{ $status === 'sent' ? 'active' : '' }}">
                                <div>
                                    <i class="fas fa-paper-plane me-2 text-info"></i>
                                    <span>Sent</span>
                                </div>
                                <span class="badge bg-info rounded-pill">{{ $stats['sent'] }}</span>
                            </a>

                            <!-- Drafts -->
                            <a href="{{ route('admin.email.inbox', ['status' => 'draft']) }}" 
                               class="list-group-item list-group-item-action d-flex justify-content-between align-items-center {{ $status === 'draft' ? 'active' : '' }}">
                                <div>
                                    <i class="fas fa-file-alt me-2 text-warning"></i>
                                    <span>Drafts</span>
                                </div>
                                <span class="badge bg-warning text-dark rounded-pill">{{ $stats['draft'] }}</span>
                            </a>

                            <!-- Starred -->
                            <a href="{{ route('admin.email.inbox', ['status' => 'starred']) }}" 
                               class="list-group-item list-group-item-action d-flex justify-content-between align-items-center {{ $status === 'starred' ? 'active' : '' }}">
                                <div>
                                    <i class="fas fa-star me-2 text-warning"></i>
                                    <span>Starred</span>
                                </div>
                                <span class="badge bg-warning text-dark rounded-pill">{{ $stats['starred'] }}</span>
                            </a>

                            <!-- Spam -->
                            <a href="{{ route('admin.email.inbox', ['status' => 'spam']) }}" 
                               class="list-group-item list-group-item-action d-flex justify-content-between align-items-center {{ $status === 'spam' ? 'active' : '' }}">
                                <div>
                                    <i class="fas fa-exclamation-triangle me-2 text-danger"></i>
                                    <span>Spam</span>
                                </div>
                                <span class="badge bg-danger rounded-pill">{{ $stats['spam'] }}</span>
                            </a>

                            <!-- Trash -->
                            <a href="{{ route('admin.email.inbox', ['status' => 'trash']) }}" 
                               class="list-group-item list-group-item-action d-flex justify-content-between align-items-center {{ $status === 'trash' ? 'active' : '' }}">
                                <div>
                                    <i class="fas fa-trash me-2 text-secondary"></i>
                                    <span>Trash</span>
                                </div>
                                <span class="badge bg-secondary rounded-pill">{{ $stats['trash'] }}</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Storage Info -->
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <h6 class="card-title mb-3">Storage</h6>
                        <div class="progress mb-2">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 35%"></div>
                        </div>
                        <small class="text-muted">3.5 GB of 15 GB used</small>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-lg-9">
                <!-- Search and Actions -->
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-body p-3">
                        <div class="row g-2 align-items-center">
                            <div class="col-md-6">
                                <form action="{{ route('admin.email.inbox') }}" method="GET" class="d-flex gap-2">
                                    <input type="text" name="search" class="form-control form-control-sm" 
                                           placeholder="Search emails..." value="{{ $search ?? '' }}">
                                    <button type="submit" class="btn btn-sm btn-primary">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </form>
                            </div>
                            <div class="col-md-6 text-end">
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-sm btn-outline-secondary" title="Refresh">
                                        <i class="fas fa-sync"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-secondary" title="Settings">
                                        <i class="fas fa-cog"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Success/Error Messages -->
                @if($message = Session::get('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ $message }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                @if($message = Session::get('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ $message }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                <!-- Emails List -->
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-0">
                        <div class="email-list">
                            @forelse($emails as $email)
                            <div class="email-item p-3 border-bottom {{ !$email->is_read ? 'email-unread' : '' }}" style="background-color: {{ !$email->is_read ? '#f0f7ff' : 'white' }}">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="{{ $email->uuid }}" id="email_{{ $email->id }}">
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <button type="button" class="btn btn-sm btn-link toggle-starred {{ $email->is_starred ? 'text-warning' : 'text-muted' }}" 
                                                data-uuid="{{ $email->uuid }}" title="Star">
                                            <i class="fas fa-star"></i>
                                        </button>
                                    </div>
                                    <div class="col">
                                        <a href="{{ route('admin.email.inbox.show', $email->uuid) }}" class="text-decoration-none">
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <h6 class="mb-1 {{ $email->is_read ? 'fw-normal text-muted' : 'fw-bold text-dark' }}">
                                                        {{ $email->from_name ?? $email->from_email }}
                                                    </h6>
                                                    <p class="mb-0 {{ $email->is_read ? 'text-muted' : 'text-dark' }}">
                                                        <span class="fw-500">{{ $email->subject }}</span>
                                                        <span class="text-muted ms-2">{{ $email->getPreviewText(50) }}</span>
                                                    </p>
                                                </div>
                                                <div class="text-end ms-3">
                                                    <small class="text-muted">{{ $email->received_at->format('M d') }}</small>
                                                    @if($email->attachment_count > 0)
                                                        <br><i class="fas fa-paperclip text-muted" title="Has attachments"></i>
                                                    @endif
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="p-5 text-center text-muted">
                                <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                                <h5>No emails found</h5>
                                <p>No emails to display for this folder</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                    @if($emails->count() > 0)
                    <div class="card-footer bg-white border-0 py-3 px-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-muted small">
                                Showing {{ $emails->firstItem() }} to {{ $emails->lastItem() }} of {{ $emails->total() }} emails
                            </div>
                            {{ $emails->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.email-item {
    cursor: pointer;
    transition: background-color 0.2s ease;
}

.email-item:hover {
    background-color: #f5f5f5 !important;
}

.email-unread {
    font-weight: 500;
}

.list-group-item.active {
    background-color: #007bff;
    border-color: #007bff;
}

.toggle-starred {
    cursor: pointer;
    transition: color 0.2s ease;
}

.toggle-starred:hover {
    color: #ffc107 !important;
}

.form-check-input {
    cursor: pointer;
}

@media (max-width: 768px) {
    .col-lg-3, .col-lg-9 {
        min-height: auto;
    }
}
</style>

<script>
document.querySelectorAll('.toggle-starred').forEach(button => {
    button.addEventListener('click', function(e) {
        e.preventDefault();
        const uuid = this.dataset.uuid;
        fetch(`/admin-email-inbox/${uuid}/toggle-starred`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            }
        }).then(response => response.json()).then(data => {
            if (data.success) {
                this.classList.toggle('text-warning');
                this.classList.toggle('text-muted');
            }
        });
    });
});
</script>

@include('adminPortal.layout.footer')
