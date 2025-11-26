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
                    <a href="{{ route('admin.email.inbox') }}" class="text-muted text-decoration-none">Inbox</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Email Details</li>
            </ol>
        </nav>

        <!-- Back Button -->
        <div class="mb-3">
            <a href="{{ route('admin.email.inbox') }}" class="btn btn-outline-secondary btn-sm">
                <i class="fas fa-arrow-left me-2"></i>Back to Inbox
            </a>
        </div>

        <!-- Email Content Card -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-bottom">
                <div class="d-flex justify-content-between align-items-start">
                    <div class="flex-grow-1">
                        <h5 class="mb-3">{{ $email->subject }}</h5>
                        <div class="email-header-info">
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="mb-2">
                                        <strong>From:</strong><br>
                                        <span class="text-muted">{{ $email->from_name ?? $email->from_email }} ({{ $email->from_email }})</span>
                                    </p>
                                    <p class="mb-2">
                                        <strong>To:</strong><br>
                                        <span class="text-muted">{{ $email->to_email }}</span>
                                    </p>
                                    @if($email->cc)
                                    <p class="mb-2">
                                        <strong>CC:</strong><br>
                                        <span class="text-muted">{{ $email->cc }}</span>
                                    </p>
                                    @endif
                                </div>
                                <div class="col-md-6 text-md-end">
                                    <p class="text-muted mb-2">
                                        <i class="fas fa-calendar me-1"></i>
                                        {{ $email->received_at->format('M d, Y h:i A') }}
                                    </p>
                                    <p class="mb-2">
                                        <span class="badge bg-{{ $email->priority_badge }}">
                                            <i class="{{ $email->priority_icon }} me-1"></i>{{ ucfirst($email->priority) }} Priority
                                        </span>
                                    </p>
                                    <p class="mb-0">
                                        <span class="badge bg-{{ $email->status_badge }}">
                                            {{ ucfirst($email->status) }}
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            @if($email->is_read)
                            <li>
                                <a class="dropdown-item" href="{{ route('admin.email.inbox.mark-unread', $email->uuid) }}">
                                    <i class="fas fa-envelope me-2"></i>Mark as Unread
                                </a>
                            </li>
                            @else
                            <li>
                                <a class="dropdown-item" href="{{ route('admin.email.inbox.mark-read', $email->uuid) }}">
                                    <i class="fas fa-envelope-open me-2"></i>Mark as Read
                                </a>
                            </li>
                            @endif
                            <li>
                                <a class="dropdown-item" href="{{ route('admin.email.inbox.toggle-starred', $email->uuid) }}">
                                    <i class="fas fa-star me-2"></i>{{ $email->is_starred ? 'Unstar' : 'Star' }}
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            @if($email->status !== 'trash')
                            <li>
                                <a class="dropdown-item" href="{{ route('admin.email.inbox.move-trash', $email->uuid) }}">
                                    <i class="fas fa-trash me-2"></i>Move to Trash
                                </a>
                            </li>
                            @else
                            <li>
                                <a class="dropdown-item" href="{{ route('admin.email.inbox.restore-trash', $email->uuid) }}">
                                    <i class="fas fa-undo me-2"></i>Restore
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item text-danger" href="{{ route('admin.email.inbox.destroy', $email->uuid) }}" 
                                   onclick="return confirm('Permanently delete this email?')">
                                    <i class="fas fa-times me-2"></i>Delete Permanently
                                </a>
                            </li>
                            @endif
                            <li>
                                <a class="dropdown-item" href="{{ route('admin.email.inbox.mark-spam', $email->uuid) }}">
                                    <i class="fas fa-exclamation-triangle me-2"></i>Mark as Spam
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Email Body -->
            <div class="card-body">
                <div class="email-body bg-light p-4 rounded mb-4" style="min-height: 300px;">
                    @if($email->html_message)
                        {!! $email->html_message !!}
                    @else
                        <pre style="white-space: pre-wrap; word-wrap: break-word;">{{ $email->message }}</pre>
                    @endif
                </div>

                <!-- Attachments -->
                @if($email->attachments->count() > 0)
                <div class="attachments-section">
                    <h6 class="mb-3">
                        <i class="fas fa-paperclip me-2"></i>Attachments ({{ $email->attachments->count() }})
                    </h6>
                    <div class="row g-3">
                        @foreach($email->attachments as $attachment)
                        <div class="col-md-6">
                            <div class="card border-1">
                                <div class="card-body p-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <i class="fas fa-file me-2"></i>
                                            <span>{{ $attachment->filename }}</span>
                                            <br>
                                            <small class="text-muted">{{ $attachment->file_size }}</small>
                                        </div>
                                        <a href="{{ route('admin.email.attachment.download', $attachment->uuid) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-download"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <!-- Action Buttons -->
            <div class="card-footer bg-white border-top">
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.email.compose') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-reply me-2"></i>Reply
                    </a>
                    <a href="{{ route('admin.email.compose') }}" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-reply-all me-2"></i>Reply All
                    </a>
                    <a href="{{ route('admin.email.compose') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-share me-2"></i>Forward
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.email-body {
    font-family: Arial, sans-serif;
    line-height: 1.6;
}

.email-body img {
    max-width: 100%;
    height: auto;
}

.attachments-section {
    padding-top: 2rem;
    border-top: 1px solid #dee2e6;
}
</style>

@include('adminPortal.layout.footer')
