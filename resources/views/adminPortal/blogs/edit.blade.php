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
                    <a href="{{ route('admin.blogs') }}" class="text-muted text-decoration-none">Blogs</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Edit Blog</li>
            </ol>
        </nav>

        <!-- Success Message -->
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center mb-4" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            <div>{{ session('success') }}</div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <!-- Error Message -->
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
                    <i class="fas fa-edit me-2 text-primary"></i>Edit Blog Post
                </h1>
                <p class="text-muted mb-0">Update your blog content and details</p>
            </div>
            <a href="{{ route('admin.blogs') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back to Blogs
            </a>
        </div>

        <!-- Edit Blog Form -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-light border-0 py-4">
                <div>
                    <h5 class="card-title fw-bold text-dark mb-1">
                        <i class="fas fa-pencil-alt me-2 text-primary"></i>Blog Details
                    </h5>
                    <p class="text-muted small mb-0">Modify the blog title and content</p>
                </div>
            </div>

            <form action="{{ route('admin.blogs.update', $blog->uuid) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="card-body py-4">
                    <div class="row g-4">
                        <!-- Blog Title -->
                        <div class="col-12">
                            <div class="form-group">
                                <label for="blogTitle" class="form-label fw-semibold text-dark mb-2">
                                    <i class="fas fa-heading me-2 text-primary"></i>Blog Title
                                </label>
                                <input type="text" 
                                       class="form-control form-control-lg @error('title') is-invalid @enderror" 
                                       id="blogTitle" 
                                       name="title" 
                                       value="{{ old('title', $blog->title) }}"
                                       placeholder="Enter blog title"
                                       required>
                                @error('title')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                <div class="form-text text-muted">
                                    <small><i class="fas fa-info-circle me-1"></i>Make it catchy and descriptive (max 255 characters)</small>
                                </div>
                            </div>
                        </div>

                        <!-- Blog Content -->
                        <div class="col-12">
                            <div class="form-group">
                                <label for="blogContent" class="form-label fw-semibold text-dark mb-2">
                                    <i class="fas fa-file-alt me-2 text-primary"></i>Blog Content
                                </label>
                                <textarea class="form-control @error('content') is-invalid @enderror" 
                                          id="blogContent" 
                                          name="content" 
                                          rows="12" 
                                          placeholder="Write your blog content here..."
                                          required>{{ old('content', $blog->content) }}</textarea>
                                @error('content')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                <div class="form-text text-muted">
                                    <small><i class="fas fa-info-circle me-1"></i>Enter detailed blog content (required)</small>
                                </div>
                            </div>
                        </div>

                        <!-- Blog Metadata -->
                        <div class="col-12">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="bg-light p-3 rounded-2">
                                        <small class="text-muted fw-semibold text-uppercase d-block mb-2">
                                            <i class="fas fa-calendar me-1"></i>Created
                                        </small>
                                        <p class="mb-0 fw-medium">{{ $blog->created_at->format('M d, Y H:i A') }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="bg-light p-3 rounded-2">
                                        <small class="text-muted fw-semibold text-uppercase d-block mb-2">
                                            <i class="fas fa-clock me-1"></i>Last Updated
                                        </small>
                                        <p class="mb-0 fw-medium">{{ $blog->updated_at->format('M d, Y H:i A') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="card-footer bg-light border-0 py-3 px-4">
                    <div class="d-flex justify-content-between gap-2">
                        <a href="{{ route('admin.blogs') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-2"></i>Cancel
                        </a>
                        <div class="d-flex gap-2">
                            <button type="reset" class="btn btn-outline-secondary">
                                <i class="fas fa-redo me-2"></i>Reset
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Update Blog
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Danger Zone -->
        <div class="card border-0 shadow-sm mt-5">
            <div class="card-header bg-danger bg-opacity-10 border-0 py-4">
                <h5 class="card-title fw-bold text-danger mb-1">
                    <i class="fas fa-exclamation-triangle me-2"></i>Danger Zone
                </h5>
                <p class="text-muted small mb-0">Irreversible actions</p>
            </div>
            <div class="card-body py-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="fw-bold text-dark mb-1">Delete This Blog</h6>
                        <p class="text-muted small mb-0">Once deleted, this blog post cannot be recovered</p>
                    </div>
                    <form action="{{ route('admin.blogs.destroy', $blog->uuid) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="btn btn-danger"
                                onclick="return confirm('Are you sure you want to delete this blog? This action cannot be undone.')">
                            <i class="fas fa-trash me-2"></i>Delete Blog
                        </button>
                    </form>
                </div>
            </div>
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

@media (max-width: 768px) {
    .d-flex.flex-lg-row {
        flex-direction: column !important;
    }
    
    .form-control-lg {
        font-size: 1rem;
    }
}
</style>

@include('adminPortal.layout.footer')
