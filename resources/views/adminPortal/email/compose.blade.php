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
                <li class="breadcrumb-item active" aria-current="page">Compose Email</li>
            </ol>
        </nav>

        <!-- Success/Error Messages -->
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center mb-4" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            <div>{{ session('success') }}</div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            <div>
                <strong>Please fix the following errors:</strong>
                <ul class="mb-0 mt-2">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <!-- Header Section -->
        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-start align-items-lg-center mb-5">
            <div class="mb-3 mb-lg-0">
                <h1 class="h2 fw-bold text-dark mb-2">
                    <i class="fas fa-envelope me-2 text-primary"></i>Compose Email
                </h1>
                <p class="text-muted mb-0">Draft and send emails to contacts</p>
            </div>
            <a href="{{ route('admin.email.tracking') }}" class="btn btn-outline-primary">
                <i class="fas fa-history me-2"></i>Email Tracking
            </a>
        </div>

        <!-- Compose Email Form -->
        <div class="card border-0 shadow-sm">
            <form action="{{ route('admin.email.send') }}" method="POST">
                @csrf

                <!-- Email To -->
                <div class="card-body py-4">
                    <div class="row g-4">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="recipientEmail" class="form-label fw-semibold text-dark mb-2">
                                    <i class="fas fa-envelope me-2 text-primary"></i>Recipient Email
                                </label>
                                <input type="email" 
                                       class="form-control form-control-lg @error('to') is-invalid @enderror" 
                                       id="recipientEmail" 
                                       name="to" 
                                       value="{{ old('to', $recipientEmail ?? '') }}"
                                       placeholder="Enter recipient email address"
                                       required>
                                @error('to')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                <div class="form-text text-muted">
                                    <small><i class="fas fa-info-circle me-1"></i>The recipient's email address</small>
                                </div>
                            </div>
                        </div>

                        <!-- Subject -->
                        <div class="col-12">
                            <div class="form-group">
                                <label for="emailSubject" class="form-label fw-semibold text-dark mb-2">
                                    <i class="fas fa-heading me-2 text-primary"></i>Subject
                                </label>
                                <input type="text" 
                                       class="form-control form-control-lg @error('subject') is-invalid @enderror" 
                                       id="emailSubject" 
                                       name="subject" 
                                       value="{{ old('subject', $subject ?? '') }}"
                                       placeholder="Enter email subject"
                                       required>
                                @error('subject')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                <div class="form-text text-muted">
                                    <small><i class="fas fa-info-circle me-1"></i>Make it clear and descriptive</small>
                                </div>
                            </div>
                        </div>

                        <!-- Email Body -->
                        <div class="col-12">
                            <div class="form-group">
                                <label for="emailBody" class="form-label fw-semibold text-dark mb-2">
                                    <i class="fas fa-file-alt me-2 text-primary"></i>Message
                                </label>
                                <textarea class="form-control @error('body') is-invalid @enderror" 
                                          id="emailBody" 
                                          name="body" 
                                          rows="15" 
                                          placeholder="Compose your email message here..."
                                          required>{{ old('body', $body ?? '') }}</textarea>
                                @error('body')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                <div class="form-text text-muted">
                                    <small><i class="fas fa-info-circle me-1"></i>Enter your complete message (required)</small>
                                </div>
                            </div>
                        </div>

                        <!-- CC and BCC (Optional) -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="emailCc" class="form-label fw-semibold text-dark mb-2">
                                    <i class="fas fa-copy me-2 text-primary"></i>CC (Optional)
                                </label>
                                <input type="email" 
                                       class="form-control @error('cc') is-invalid @enderror" 
                                       id="emailCc" 
                                       name="cc" 
                                       value="{{ old('cc', '') }}"
                                       placeholder="Add CC recipients">
                                @error('cc')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="emailBcc" class="form-label fw-semibold text-dark mb-2">
                                    <i class="fas fa-eye-slash me-2 text-primary"></i>BCC (Optional)
                                </label>
                                <input type="email" 
                                       class="form-control @error('bcc') is-invalid @enderror" 
                                       id="emailBcc" 
                                       name="bcc" 
                                       value="{{ old('bcc', '') }}"
                                       placeholder="Add BCC recipients">
                                @error('bcc')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Original Contact Info (if from reply) -->
                        @if($showOriginal ?? false)
                        <div class="col-12">
                            <div class="card bg-light border-0">
                                <div class="card-header bg-light border-bottom">
                                    <h6 class="fw-bold text-dark mb-0">
                                        <i class="fas fa-history me-2"></i>Original Contact Message
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        @if($originalName ?? null)
                                        <div class="col-md-6">
                                            <small class="text-muted fw-semibold d-block">From:</small>
                                            <p class="mb-0">{{ $originalName }}</p>
                                        </div>
                                        @endif
                                        @if($originalDate ?? null)
                                        <div class="col-md-6">
                                            <small class="text-muted fw-semibold d-block">Date:</small>
                                            <p class="mb-0">{{ $originalDate }}</p>
                                        </div>
                                        @endif
                                        @if($originalSubject ?? null)
                                        <div class="col-12">
                                            <small class="text-muted fw-semibold d-block">Original Subject:</small>
                                            <p class="mb-0">{{ $originalSubject }}</p>
                                        </div>
                                        @endif
                                        @if($originalMessage ?? null)
                                        <div class="col-12">
                                            <small class="text-muted fw-semibold d-block">Original Message:</small>
                                            <div class="bg-white p-3 rounded border-start border-3 border-primary">
                                                <p class="mb-0 text-muted">{{ $originalMessage }}</p>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="card-footer bg-light border-0 py-3 px-4">
                    <div class="d-flex justify-content-between gap-2">
                        <a href="{{ route('admin.tgr.mail') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-2"></i>Discard
                        </a>
                        <div class="d-flex gap-2">
                            <button type="reset" class="btn btn-outline-secondary">
                                <i class="fas fa-redo me-2"></i>Clear
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane me-2"></i>Send Email
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.form-control-lg {
    border-radius: 8px;
    border: 1px solid #e2e8f0;
    padding: 0.75rem 1rem;
}

.form-control-lg:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.1);
}

.form-control {
    border-radius: 6px;
    border: 1px solid #e2e8f0;
}

.form-control:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.1);
}

.form-control.is-invalid {
    border-color: #dc2626;
}

.form-control.is-invalid:focus {
    border-color: #dc2626;
    box-shadow: 0 0 0 0.2rem rgba(220, 38, 38, 0.1);
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

.form-text {
    font-size: 0.875rem;
    margin-top: 0.5rem;
}

textarea.form-control {
    resize: vertical;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

@media (max-width: 768px) {
    .d-flex.flex-lg-row {
        flex-direction: column !important;
    }
    
    .form-control-lg {
        font-size: 1rem;
    }
    
    textarea.form-control {
        min-height: 300px;
    }
}
</style>

@include('adminPortal.layout.footer')
