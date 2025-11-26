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
                <li class="breadcrumb-item active" aria-current="page">Blogs</li>
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
                <h1 class="h2 fw-bold text-dark mb-2">Blog Management</h1>
                <p class="text-muted mb-0">Create, edit, and manage your blog posts</p>
            </div>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBlogModal">
                <i class="fas fa-plus-circle me-2"></i>Add New Blog
            </button>
        </div>

        <!-- Stats Cards -->
        <div class="row g-4 mb-5">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon bg-primary bg-opacity-10 text-white rounded-2 p-3 me-3">
                                <i class="fas fa-file-alt fa-lg"></i>
                            </div>
                            <div>
                                <p class="text-muted text-uppercase small fw-semibold mb-1">Total Blogs</p>
                                <h3 class="fw-bold text-dark mb-0">{{ $all_blogs->count() }}</h3>
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
                                <i class="fas fa-eye fa-lg"></i>
                            </div>
                            <div>
                                <p class="text-muted text-uppercase small fw-semibold mb-1">Published</p>
                                <h3 class="fw-bold text-success mb-0">{{ $all_blogs->count() }}</h3>
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
                                <i class="fas fa-clock fa-lg"></i>
                            </div>
                            <div>
                                <p class="text-muted text-uppercase small fw-semibold mb-1">Drafts</p>
                                <h3 class="fw-bold text-warning mb-0">0</h3>
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
                                <i class="fas fa-calendar-alt fa-lg"></i>
                            </div>
                            <div>
                                <p class="text-muted text-uppercase small fw-semibold mb-1">This Month</p>
                                <h3 class="fw-bold text-info mb-0">0</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Blogs Table -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 pb-0 pt-4 px-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title fw-bold text-dark mb-1">
                            <i class="fas fa-newspaper me-2 text-primary"></i>Published Blogs
                        </h5>
                        <p class="text-muted small mb-0">Manage all your blog posts in one place</p>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <div class="input-group input-group-sm" style="width: 250px;">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            <input type="text" class="form-control border-start-0" placeholder="Search blogs...">
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body px-0 pb-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4 small fw-semibold text-uppercase text-muted" style="width: 8%">#</th>
                                <th class="small fw-semibold text-uppercase text-muted" style="width: 25%">Title</th>
                                <th class="small fw-semibold text-uppercase text-muted" style="width: 52%">Content Preview</th>
                                <th class="pe-4 small fw-semibold text-uppercase text-muted" style="width: 15%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($all_blogs as $blog)
                            <tr>
                                <td class="ps-4">
                                    <span class="badge bg-light text-dark rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                        {{ $loop->index + 1 }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="blog-icon bg-primary bg-opacity-10 text-white rounded-2 p-2 me-3">
                                            <i class="fas fa-file-alt"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-bold text-dark mb-1">{{ Str::limit($blog->title, 50) }}</h6>
                                            <small class="text-muted">Last updated: {{ $blog->updated_at->format('M d, Y') }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <p class="text-muted mb-0 small lh-base">
                                        {{ Str::limit(strip_tags($blog->content), 120) }}
                                    </p>
                                </td>
                                <td class="pe-4">
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('admin.blogs.edit', $blog->uuid) }}" 
                                           class="btn btn-sm btn-outline-primary d-flex align-items-center"
                                           data-bs-toggle="tooltip" title="Edit Blog">
                                            <i class="fas fa-edit me-1"></i> Edit
                                        </a>
                                        <form action="{{ route('admin.blogs.destroy', $blog->uuid) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-sm btn-outline-danger d-flex align-items-center"
                                                    data-bs-toggle="tooltip" 
                                                    title="Delete Blog"
                                                    onclick="return confirm('Are you sure you want to delete this blog?')">
                                                <i class="fas fa-trash me-1"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-5">
                                    <div class="empty-state">
                                        <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
                                        <h5 class="text-muted mb-2">No Blogs Found</h5>
                                        <p class="text-muted mb-3">Get started by creating your first blog post</p>
                                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBlogModal">
                                            <i class="fas fa-plus-circle me-2"></i>Create First Blog
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($all_blogs->count() > 0)
            <div class="card-footer bg-white border-0 py-3 px-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="text-muted small">
                        Showing {{ $all_blogs->firstItem() ?? 0 }} to {{ $all_blogs->lastItem() ?? 0 }} of {{ $all_blogs->total() }} entries
                    </div>
                    {{ $all_blogs->links('pagination::bootstrap-4') }}
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Add Blog Modal -->
<div class="modal fade" id="addBlogModal" tabindex="-1" aria-labelledby="addBlogModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-light border-0 py-4">
                <div>
                    <h5 class="modal-title fw-bold text-dark mb-1" id="addBlogModalLabel">
                        <i class="fas fa-plus-circle me-2 text-primary"></i>Create New Blog
                    </h5>
                    <p class="text-muted small mb-0">Fill in the details to create a new blog post</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.blogs.store') }}" method="POST">
                @csrf
                <div class="modal-body py-4">
                    <div class="row g-4">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="blogTitle" class="form-label small fw-semibold text-muted text-uppercase">Blog Title</label>
                                <input type="text" 
                                       class="form-control form-control-lg" 
                                       id="blogTitle" 
                                       name="title" 
                                       placeholder="Enter a compelling title for your blog post"
                                       required>
                                <div class="form-text text-muted">Make it catchy and descriptive</div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="blogContent" class="form-label small fw-semibold text-muted text-uppercase">Blog Content</label>
                                <textarea class="form-control" 
                                          id="blogContent" 
                                          name="content" 
                                          rows="8" 
                                          placeholder="Write your blog content here..."
                                          required></textarea>
                                <div class="form-text text-muted">You can use rich text formatting</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 bg-light py-3">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Cancel
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Create Blog
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

.stat-icon {
    width: 56px;
    height: 56px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.blog-icon {
    width: 44px;
    height: 44px;
    display: flex;
    align-items-center;
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
    font-weight: 600;
}

.form-control-lg {
    border-radius: 8px;
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
    
    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
    }
}
</style>

@include('adminPortal.layout.footer')