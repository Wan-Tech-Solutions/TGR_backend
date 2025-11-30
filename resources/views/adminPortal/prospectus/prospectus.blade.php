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
                <li class="breadcrumb-item active" aria-current="page">Prospectus</li>
            </ol>
        </nav>

        <!-- Header Section -->
        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-start align-items-lg-center mb-5">
            <div class="mb-3 mb-lg-0">
                <h1 class="h2 fw-bold text-dark mb-2">Prospectus Management</h1>
                <p class="text-muted mb-0">Manage and publish institutional prospectus documents</p>
            </div>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProspectusModal">
                <i class="fas fa-plus-circle me-2"></i>Add Prospectus
            </button>
        </div>

        <!-- Stats Cards -->
        <div class="row g-4 mb-5">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon bg-primary bg-opacity-10 text-white rounded-2 p-3 me-3">
                                <i class="fas fa-file-pdf fa-lg"></i>
                            </div>
                            <div>
                                <p class="text-muted text-uppercase small fw-semibold mb-1">Total Files</p>
                                <h3 class="fw-bold text-dark mb-0">{{ $prospectus->count() }}</h3>
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
                                <h3 class="fw-bold text-success mb-0">{{ $prospectus->count() }}</h3>
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
                                <i class="fas fa-download fa-lg"></i>
                            </div>
                            <div>
                                <p class="text-muted text-uppercase small fw-semibold mb-1">Total Downloads</p>
                                <h3 class="fw-bold text-info mb-0">{{ $prospectus->sum('download_count') }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Prospectus Table -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 pb-0 pt-4 px-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title fw-bold text-dark mb-1">
                            <i class="fas fa-file-alt me-2 text-primary"></i>Published Prospectus
                        </h5>
                        <p class="text-muted small mb-0">All available prospectus documents</p>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <div class="input-group input-group-sm" style="width: 250px;">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            <input type="text" class="form-control border-start-0" placeholder="Search prospectus...">
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body px-0 pb-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4 small fw-semibold text-uppercase text-muted" style="width: 60%">Prospectus</th>
                                <th class="small fw-semibold text-uppercase text-muted" style="width: 25%">Published On</th>
                                <th class="pe-4 small fw-semibold text-uppercase text-muted" style="width: 15%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($prospectus as $item)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <div class="file-icon bg-danger bg-opacity-10 text-white rounded-2 p-3 me-3">
                                            <i class="fas fa-file-pdf fa-lg"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-bold text-dark mb-1">{{ $item->prospectus_title ?? 'Untitled' }}</h6>
                                            <small class="text-muted text-truncate" style="max-width: 300px; display: block;">
                                                {{ $item->prospectus_description ?? 'No description' }}
                                            </small>
                                            <div class="d-flex align-items-center gap-3 mt-2">
                                                <small class="text-muted">
                                                    <i class="fas fa-file me-1"></i>PDF Document
                                                </small>
                                                @if($item->is_published)
                                                    <span class="badge bg-success">Published</span>
                                                @else
                                                    <span class="badge bg-secondary">Draft</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="fw-medium text-dark">
                                            {{ $item->created_at->format('M d, Y') }}
                                        </span>
                                        <small class="text-muted">
                                            {{ $item->created_at->format('h:i A') }}
                                        </small>
                                    </div>
                                </td>
                                <td class="pe-4">
                                    <div class="d-flex gap-2">
                                        @if($item->prospectus_file)
                                        <a href="{{ route('admin.prospectus.download', $item->id) }}" 
                                           class="btn btn-sm btn-outline-primary d-flex align-items-center"
                                           data-bs-toggle="tooltip" 
                                           title="Download Prospectus ({{ $item->download_count }} downloads)">
                                            <i class="fas fa-download me-1"></i> Download
                                            @if($item->download_count > 0)
                                                <span class="badge bg-primary ms-1">{{ $item->download_count }}</span>
                                            @endif
                                        </a>
                                        @else
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-secondary d-flex align-items-center" disabled>
                                            <i class="fas fa-download me-1"></i> Download
                                        </button>
                                        @endif
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-warning d-flex align-items-center edit-prospectus-btn"
                                                data-id="{{ $item->id }}"
                                                data-bs-toggle="tooltip" 
                                                title="Edit Prospectus">
                                            <i class="fas fa-edit me-1"></i> Edit
                                        </button>
                                        <form action="{{ route('admin.prospectus.destroy', $item->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-sm btn-outline-danger d-flex align-items-center"
                                                    data-bs-toggle="tooltip" 
                                                    title="Delete Prospectus"
                                                    onclick="return confirm('Are you sure you want to delete this prospectus?')">
                                                <i class="fas fa-trash me-1"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted py-5">
                                    <div class="empty-state">
                                        <i class="fas fa-file-pdf fa-3x text-muted mb-3"></i>
                                        <h5 class="text-muted mb-2">No Prospectus Found</h5>
                                        <p class="text-muted mb-3">Get started by uploading your first prospectus document</p>
                                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProspectusModal">
                                            <i class="fas fa-plus-circle me-2"></i>Upload First Prospectus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($prospectus->hasPages())
            <div class="card-footer bg-white border-0 py-3 px-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="text-muted small">
                        Showing {{ $prospectus->firstItem() ?? 0 }} to {{ $prospectus->lastItem() ?? 0 }} of {{ $prospectus->total() }} entries
                    </div>
                    {{ $prospectus->links('pagination::bootstrap-4') }}
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Edit Prospectus Modal -->
<div class="modal fade" id="editProspectusModal" tabindex="-1" aria-labelledby="editProspectusModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-light border-0 py-4">
                <div>
                    <h5 class="modal-title fw-bold text-dark mb-1" id="editProspectusModalLabel">
                        <i class="fas fa-edit me-2 text-warning"></i>Edit Prospectus
                    </h5>
                    <p class="text-muted small mb-0">Update prospectus information</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editProspectusForm" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="editProspectusId" name="prospectus_id">
                <div class="modal-body py-4">
                    <div class="row g-4">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="editProspectusTitle" class="form-label small fw-semibold text-muted text-uppercase">Prospectus Title</label>
                                <input type="text" 
                                       name="prospectus_title"
                                       class="form-control form-control-lg" 
                                       id="editProspectusTitle" 
                                       required>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="editProspectusFile" class="form-label small fw-semibold text-muted text-uppercase">PDF File (Optional)</label>
                                <div class="file-upload-area border rounded-2 p-4 text-center">
                                    <i class="fas fa-cloud-upload-alt fa-2x text-muted mb-3"></i>
                                    <h6 class="text-dark mb-2">Upload new PDF file (leave empty to keep current file)</h6>
                                    <p class="text-muted small mb-3">Maximum file size: 10MB</p>
                                    <input type="file" 
                                           name="prospectus_file"
                                           class="form-control d-none" 
                                           id="editProspectusFile" 
                                           accept=".pdf">
                                    <button type="button" class="btn btn-outline-primary" onclick="document.getElementById('editProspectusFile').click()">
                                        <i class="fas fa-folder-open me-2"></i>Choose File
                                    </button>
                                    <div id="editFileName" class="mt-2 small text-muted"></div>
                                    <div id="currentFileName" class="mt-2 small text-info"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="editProspectusDescription" class="form-label small fw-semibold text-muted text-uppercase">Description</label>
                                <textarea class="form-control" 
                                          name="prospectus_description"
                                          id="editProspectusDescription" 
                                          rows="4" 
                                          required></textarea>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="publish_immediately" id="editPublishImmediately">
                                <label class="form-check-label small fw-medium" for="editPublishImmediately">
                                    Published
                                </label>
                            </div>
                        </div>
                        <div class="col-12" id="editUploadMessage" style="display: none;">
                            <div class="alert" id="editUploadAlert" role="alert"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 bg-light py-3">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Cancel
                    </button>
                    <button type="submit" class="btn btn-warning" id="editSubmitBtn">
                        <i class="fas fa-save me-2"></i>Update Prospectus
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add Prospectus Modal -->
<div class="modal fade" id="addProspectusModal" tabindex="-1" aria-labelledby="addProspectusModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-light border-0 py-4">
                <div>
                    <h5 class="modal-title fw-bold text-dark mb-1" id="addProspectusModalLabel">
                        <i class="fas fa-plus-circle me-2 text-primary"></i>Add New Prospectus
                    </h5>
                    <p class="text-muted small mb-0">Upload a new prospectus document</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="prospectusForm" method="POST" action="{{ route('admin.prospectus.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body py-4">
                    <div class="row g-4">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="prospectusTitle" class="form-label small fw-semibold text-muted text-uppercase">Prospectus Title</label>
                                <input type="text" 
                                       name="prospectus_title"
                                       class="form-control form-control-lg" 
                                       id="prospectusTitle" 
                                       placeholder="Enter prospectus title (e.g., Academic Year 2024 Prospectus)"
                                       required>
                                <div class="form-text text-muted">Choose a descriptive title for easy identification</div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="prospectusFile" class="form-label small fw-semibold text-muted text-uppercase">PDF File</label>
                                <div class="file-upload-area border rounded-2 p-4 text-center">
                                    <i class="fas fa-cloud-upload-alt fa-2x text-muted mb-3"></i>
                                    <h6 class="text-dark mb-2">Drop your PDF file here or click to browse</h6>
                                    <p class="text-muted small mb-3">Maximum file size: 10MB</p>
                                    <input type="file" 
                                           name="prospectus_file"
                                           class="form-control d-none" 
                                           id="prospectusFile" 
                                           accept=".pdf"
                                           required>
                                    <button type="button" class="btn btn-outline-primary" onclick="document.getElementById('prospectusFile').click()">
                                        <i class="fas fa-folder-open me-2"></i>Choose File
                                    </button>
                                    <div id="fileName" class="mt-2 small text-muted"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="prospectusDescription" class="form-label small fw-semibold text-muted text-uppercase">Description</label>
                                <textarea class="form-control" 
                                          name="prospectus_description"
                                          id="prospectusDescription" 
                                          rows="4" 
                                          placeholder="Enter a brief description of this prospectus..."
                                          required></textarea>
                                <div class="form-text text-muted">Provide context about what this prospectus contains</div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="publish_immediately" id="publishImmediately" checked>
                                <label class="form-check-label small fw-medium" for="publishImmediately">
                                    Publish immediately
                                </label>
                                <div class="form-text text-muted">If unchecked, the prospectus will be saved as a draft</div>
                            </div>
                        </div>
                        <div class="col-12" id="uploadMessage" style="display: none;">
                            <div class="alert" id="uploadAlert" role="alert"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 bg-light py-3">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Cancel
                    </button>
                    <button type="submit" class="btn btn-primary" id="submitBtn">
                        <i class="fas fa-upload me-2"></i>Upload Prospectus
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

.file-icon {
    width: 60px;
    height: 60px;
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

.file-upload-area {
    border: 2px dashed #e2e8f0;
    background-color: #fafbfc;
    transition: all 0.3s ease;
}

.file-upload-area:hover {
    border-color: #3b82f6;
    background-color: #f0f7ff;
}

.file-upload-area.dragover {
    border-color: #3b82f6;
    background-color: #e0f2fe;
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
    padding: 0.375rem 0.75rem;
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
    
    .file-icon {
        width: 50px;
        height: 50px;
        margin-right: 1rem;
    }
    
    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
    }
}
</style>

<script>
// File upload handling
document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('prospectusFile');
    const fileName = document.getElementById('fileName');
    const uploadArea = document.querySelector('.file-upload-area');
    const prospectusForm = document.getElementById('prospectusForm');
    const submitBtn = document.getElementById('submitBtn');
    const uploadMessage = document.getElementById('uploadMessage');
    const uploadAlert = document.getElementById('uploadAlert');
    
    fileInput.addEventListener('change', function(e) {
        if (this.files.length > 0) {
            fileName.textContent = `Selected file: ${this.files[0].name}`;
            fileName.className = 'mt-2 small text-success fw-medium';
        }
    });
    
    // Drag and drop functionality
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        uploadArea.addEventListener(eventName, preventDefaults, false);
    });
    
    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }
    
    ['dragenter', 'dragover'].forEach(eventName => {
        uploadArea.addEventListener(eventName, highlight, false);
    });
    
    ['dragleave', 'drop'].forEach(eventName => {
        uploadArea.addEventListener(eventName, unhighlight, false);
    });
    
    function highlight() {
        uploadArea.classList.add('dragover');
    }
    
    function unhighlight() {
        uploadArea.classList.remove('dragover');
    }
    
    uploadArea.addEventListener('drop', handleDrop, false);
    
    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        fileInput.files = files;
        
        if (files.length > 0) {
            fileName.textContent = `Selected file: ${files[0].name}`;
            fileName.className = 'mt-2 small text-success fw-medium';
        }
    }

    // Form submission handler
    prospectusForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        // Show loading state
        submitBtn.disabled = true;
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Uploading...';
        
        try {
            const formData = new FormData(prospectusForm);
            const response = await fetch(prospectusForm.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            
            const data = await response.json();
            
            if (response.ok) {
                uploadMessage.style.display = 'block';
                uploadAlert.className = 'alert alert-success alert-dismissible fade show';
                uploadAlert.innerHTML = `
                    <i class="fas fa-check-circle me-2"></i>${data.message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                `;
                
                // Reset form
                prospectusForm.reset();
                fileName.textContent = '';
                fileName.className = 'mt-2 small text-muted';
                
                // Reload prospectus list after 2 seconds
                setTimeout(() => {
                    window.location.reload();
                }, 2000);
            } else {
                uploadMessage.style.display = 'block';
                uploadAlert.className = 'alert alert-danger alert-dismissible fade show';
                const errorMsg = data.errors ? Object.values(data.errors).flat().join('<br>') : data.message;
                uploadAlert.innerHTML = `
                    <i class="fas fa-exclamation-circle me-2"></i>${errorMsg}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                `;
            }
        } catch (error) {
            uploadMessage.style.display = 'block';
            uploadAlert.className = 'alert alert-danger alert-dismissible fade show';
            uploadAlert.innerHTML = `
                <i class="fas fa-exclamation-circle me-2"></i>Error: ${error.message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            `;
        } finally {
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        }
    });

    // Edit prospectus functionality
    const editButtons = document.querySelectorAll('.edit-prospectus-btn');
    const editModal = new bootstrap.Modal(document.getElementById('editProspectusModal'));
    const editProspectusForm = document.getElementById('editProspectusForm');
    const editFileInput = document.getElementById('editProspectusFile');
    const editFileName = document.getElementById('editFileName');
    const currentFileName = document.getElementById('currentFileName');
    const editSubmitBtn = document.getElementById('editSubmitBtn');
    const editUploadMessage = document.getElementById('editUploadMessage');
    const editUploadAlert = document.getElementById('editUploadAlert');

    editButtons.forEach(button => {
        button.addEventListener('click', async function() {
            const prospectusId = this.dataset.id;
            
            try {
                const response = await fetch(`/admin-prospectus/${prospectusId}/edit`);
                const data = await response.json();
                
                if (data.success) {
                    const prospectus = data.data;
                    document.getElementById('editProspectusId').value = prospectus.id;
                    document.getElementById('editProspectusTitle').value = prospectus.prospectus_title;
                    document.getElementById('editProspectusDescription').value = prospectus.prospectus_description;
                    document.getElementById('editPublishImmediately').checked = prospectus.is_published == 1;
                    currentFileName.textContent = `Current file: ${prospectus.prospectus_file}`;
                    editFileName.textContent = '';
                    editProspectusForm.action = `/admin-prospectus/${prospectus.id}`;
                    
                    editModal.show();
                } else {
                    alert('Error loading prospectus data');
                }
            } catch (error) {
                alert('Error: ' + error.message);
            }
        });
    });

    // Handle file change in edit modal
    editFileInput.addEventListener('change', function(e) {
        if (this.files.length > 0) {
            editFileName.textContent = `New file: ${this.files[0].name}`;
            editFileName.className = 'mt-2 small text-success fw-medium';
        }
    });

    // Edit form submission
    editProspectusForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        editSubmitBtn.disabled = true;
        const originalText = editSubmitBtn.innerHTML;
        editSubmitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Updating...';
        
        try {
            const formData = new FormData(editProspectusForm);
            const response = await fetch(editProspectusForm.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            
            const data = await response.json();
            
            if (response.ok) {
                editUploadMessage.style.display = 'block';
                editUploadAlert.className = 'alert alert-success alert-dismissible fade show';
                editUploadAlert.innerHTML = `
                    <i class="fas fa-check-circle me-2"></i>${data.message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                `;
                
                setTimeout(() => {
                    window.location.reload();
                }, 2000);
            } else {
                editUploadMessage.style.display = 'block';
                editUploadAlert.className = 'alert alert-danger alert-dismissible fade show';
                const errorMsg = data.errors ? Object.values(data.errors).flat().join('<br>') : data.message;
                editUploadAlert.innerHTML = `
                    <i class="fas fa-exclamation-circle me-2"></i>${errorMsg}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                `;
            }
        } catch (error) {
            editUploadMessage.style.display = 'block';
            editUploadAlert.className = 'alert alert-danger alert-dismissible fade show';
            editUploadAlert.innerHTML = `
                <i class="fas fa-exclamation-circle me-2"></i>Error: ${error.message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            `;
        } finally {
            editSubmitBtn.disabled = false;
            editSubmitBtn.innerHTML = originalText;
        }
    });
});
</script>

@include('adminPortal.layout.footer')