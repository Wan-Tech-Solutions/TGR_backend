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
                <li class="breadcrumb-item active" aria-current="page">Roles & Permissions</li>
            </ol>
        </nav>

        <!-- Header Section -->
        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-start align-items-lg-center mb-5">
            <div class="mb-3 mb-lg-0">
                <h1 class="h2 fw-bold text-dark mb-2">Roles & Permissions</h1>
                <p class="text-muted mb-0">Manage user roles and their access permissions</p>
            </div>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addRoleModal">
                <i class="fas fa-plus-circle me-2"></i>Add New Role
            </button>
        </div>

        <!-- Stats Cards -->
        <div class="row g-4 mb-5">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon bg-primary bg-opacity-10 text-white rounded-2 p-3 me-3">
                                <i class="fas fa-user-shield fa-lg"></i>
                            </div>
                            <div>
                                <p class="text-muted text-uppercase small fw-semibold mb-1">Total Roles</p>
                                <h3 class="fw-bold text-dark mb-0">{{ $roles->count() }}</h3>
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
                                <i class="fas fa-users fa-lg"></i>
                            </div>
                            <div>
                                <p class="text-muted text-uppercase small fw-semibold mb-1">Admin Users</p>
                                <h3 class="fw-bold text-success mb-0">0</h3>
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
                                <i class="fas fa-key fa-lg"></i>
                            </div>
                            <div>
                                <p class="text-muted text-uppercase small fw-semibold mb-1">Permissions</p>
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
                                <i class="fas fa-sync-alt fa-lg"></i>
                            </div>
                            <div>
                                <p class="text-muted text-uppercase small fw-semibold mb-1">Last Updated</p>
                                <h6 class="fw-bold text-info mb-0">Just now</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Roles Table -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 pb-0 pt-4 px-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title fw-bold text-dark mb-1">
                            <i class="fas fa-user-tag me-2 text-primary"></i>System Roles
                        </h5>
                        <p class="text-muted small mb-0">All defined user roles and their properties</p>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <div class="input-group input-group-sm" style="width: 250px;">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            <input type="text" class="form-control border-start-0" placeholder="Search roles...">
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body px-0 pb-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4 small fw-semibold text-uppercase text-muted" style="width: 25%">Role</th>
                                <th class="small fw-semibold text-uppercase text-muted" style="width: 20%">Guard</th>
                                <th class="small fw-semibold text-uppercase text-muted" style="width: 25%">Permissions</th>
                                <th class="small fw-semibold text-uppercase text-muted" style="width: 20%">Created</th>
                                <th class="pe-4 small fw-semibold text-uppercase text-muted" style="width: 10%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($roles as $role)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <div class="role-icon bg-primary bg-opacity-10 text-white rounded-2 p-2 me-3">
                                            <i class="fas fa-user-shield"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-bold text-dark mb-1">{{ $role->name }}</h6>
                                            <small class="text-muted">System Role</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border px-3 py-2">
                                        <i class="fas fa-shield-alt me-1"></i>
                                        {{ $role->guard_name }}
                                    </span>
                                </td>
                                <td>
                                    <div class="permissions-preview">
                                        <span class="badge bg-secondary bg-opacity-10 text-white border border-secondary border-opacity-25 me-1 mb-1">view_users</span>
                                        <span class="badge bg-secondary bg-opacity-10 text-white border border-secondary border-opacity-25 me-1 mb-1">edit_posts</span>
                                        <span class="badge bg-secondary bg-opacity-10 text-white border border-secondary border-opacity-25 me-1 mb-1">+3 more</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="fw-medium text-dark">
                                            {{ $role->created_at->format('M d, Y') }}
                                        </span>
                                        <small class="text-muted">
                                            {{ $role->created_at->format('h:i A') }}
                                        </small>
                                    </div>
                                </td>
                                <td class="pe-4">
                                    <div class="d-flex gap-1">
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-primary d-flex align-items-center edit-role-btn"
                                                data-id="{{ $role->id }}"
                                                data-bs-toggle="tooltip" 
                                                title="Edit Role">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-info d-flex align-items-center manage-permissions-btn"
                                                data-id="{{ $role->id }}"
                                                data-name="{{ $role->name }}"
                                                data-bs-toggle="tooltip" 
                                                title="Manage Permissions">
                                            <i class="fas fa-key"></i>
                                        </button>
                                        <form action="#" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-sm btn-outline-danger d-flex align-items-center"
                                                    data-bs-toggle="tooltip" 
                                                    title="Delete Role"
                                                    onclick="return confirm('Are you sure you want to delete this role? This action cannot be undone.')">
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
                                        <i class="fas fa-user-shield fa-3x text-muted mb-3"></i>
                                        <h5 class="text-muted mb-2">No Roles Found</h5>
                                        <p class="text-muted mb-3">Get started by creating your first role</p>
                                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addRoleModal">
                                            <i class="fas fa-plus-circle me-2"></i>Create First Role
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($roles->hasPages())
            <div class="card-footer bg-white border-0 py-3 px-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="text-muted small">
                        Showing {{ $roles->firstItem() ?? 0 }} to {{ $roles->lastItem() ?? 0 }} of {{ $roles->total() }} entries
                    </div>
                    {{ $roles->links('pagination::bootstrap-4') }}
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Edit Role Modal -->
<div class="modal fade" id="editRoleModal" tabindex="-1" aria-labelledby="editRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-light border-0 py-4">
                <div>
                    <h5 class="modal-title fw-bold text-dark mb-1" id="editRoleModalLabel">
                        <i class="fas fa-edit me-2 text-warning"></i>Edit Role
                    </h5>
                    <p class="text-muted small mb-0">Update role information</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editRoleForm">
                @csrf
                <input type="hidden" id="editRoleId">
                <div class="modal-body py-4">
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="editRoleName" class="form-label small fw-semibold text-muted text-uppercase">Role Name</label>
                                <input type="text" 
                                       class="form-control" 
                                       id="editRoleName" 
                                       name="name"
                                       required>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="editGuardName" class="form-label small fw-semibold text-muted text-uppercase">Guard Name</label>
                                <select class="form-select" id="editGuardName" name="guard_name" required>
                                    <option value="web">Web</option>
                                    <option value="api">API</option>
                                    <option value="admin">Admin</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12" id="editMessage" style="display: none;">
                            <div class="alert" id="editAlert" role="alert"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 bg-light py-3">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Cancel
                    </button>
                    <button type="submit" class="btn btn-warning" id="editSubmitBtn">
                        <i class="fas fa-save me-2"></i>Update Role
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Permissions Modal -->
<div class="modal fade" id="permissionsModal" tabindex="-1" aria-labelledby="permissionsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-light border-0 py-4">
                <div>
                    <h5 class="modal-title fw-bold text-dark mb-1" id="permissionsModalLabel">
                        <i class="fas fa-key me-2 text-info"></i>Manage Permissions
                    </h5>
                    <p class="text-muted small mb-0" id="permissionsRoleName"></p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-4">
                <div id="permissionsContent">
                    <!-- Permissions checkboxes will be loaded here dynamically -->
                </div>
                <div id="permissionsLoading" class="text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="text-muted mt-2">Loading permissions...</p>
                </div>
                <div id="permissionsError" style="display: none;" class="alert alert-danger">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <span id="permissionsErrorMessage"></span>
                </div>
            </div>
            <div class="modal-footer border-0 bg-light py-3">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Close
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Add Role Modal -->
<div class="modal fade" id="addRoleModal" tabindex="-1" aria-labelledby="addRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-light border-0 py-4">
                <div>
                    <h5 class="modal-title fw-bold text-dark mb-1" id="addRoleModalLabel">
                        <i class="fas fa-plus-circle me-2 text-primary"></i>Create New Role
                    </h5>
                    <p class="text-muted small mb-0">Define a new role with specific permissions</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form>
                <div class="modal-body py-4">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="roleName" class="form-label small fw-semibold text-muted text-uppercase">Role Name</label>
                                <input type="text" 
                                       class="form-control" 
                                       id="roleName" 
                                       placeholder="Enter role name (e.g., Content Manager)"
                                       required>
                                <div class="form-text text-muted">Use a descriptive name for the role</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="guardName" class="form-label small fw-semibold text-muted text-uppercase">Guard Name</label>
                                <select class="form-select" id="guardName" required>
                                    <option value="web" selected>Web</option>
                                    <option value="api">API</option>
                                    <option value="admin">Admin</option>
                                </select>
                                <div class="form-text text-muted">Select the authentication guard</div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label small fw-semibold text-muted text-uppercase mb-3">Permissions</label>
                                <div class="permissions-grid">
                                    <div class="row g-2">
                                        <!-- User Management Permissions -->
                                        <div class="col-md-6">
                                            <div class="card border">
                                                <div class="card-header bg-light py-2">
                                                    <h6 class="mb-0 fw-semibold">
                                                        <i class="fas fa-users me-2 text-primary"></i>User Management
                                                    </h6>
                                                </div>
                                                <div class="card-body py-2">
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" id="view_users">
                                                        <label class="form-check-label small" for="view_users">View Users</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" id="create_users">
                                                        <label class="form-check-label small" for="create_users">Create Users</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" id="edit_users">
                                                        <label class="form-check-label small" for="edit_users">Edit Users</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="delete_users">
                                                        <label class="form-check-label small" for="delete_users">Delete Users</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Content Management Permissions -->
                                        <div class="col-md-6">
                                            <div class="card border">
                                                <div class="card-header bg-light py-2">
                                                    <h6 class="mb-0 fw-semibold">
                                                        <i class="fas fa-file-alt me-2 text-primary"></i>Content Management
                                                    </h6>
                                                </div>
                                                <div class="card-body py-2">
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" id="view_posts">
                                                        <label class="form-check-label small" for="view_posts">View Posts</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" id="create_posts">
                                                        <label class="form-check-label small" for="create_posts">Create Posts</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" id="edit_posts">
                                                        <label class="form-check-label small" for="edit_posts">Edit Posts</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="delete_posts">
                                                        <label class="form-check-label small" for="delete_posts">Delete Posts</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- System Permissions -->
                                        <div class="col-md-6">
                                            <div class="card border">
                                                <div class="card-header bg-light py-2">
                                                    <h6 class="mb-0 fw-semibold">
                                                        <i class="fas fa-cog me-2 text-primary"></i>System
                                                    </h6>
                                                </div>
                                                <div class="card-body py-2">
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" id="view_settings">
                                                        <label class="form-check-label small" for="view_settings">View Settings</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" id="edit_settings">
                                                        <label class="form-check-label small" for="edit_settings">Edit Settings</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="manage_roles">
                                                        <label class="form-check-label small" for="manage_roles">Manage Roles</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Quick Actions -->
                                        <div class="col-md-6">
                                            <div class="card border">
                                                <div class="card-header bg-light py-2">
                                                    <h6 class="mb-0 fw-semibold">Quick Actions</h6>
                                                </div>
                                                <div class="card-body py-2">
                                                    <button type="button" class="btn btn-sm btn-outline-primary w-100 mb-2" onclick="selectAllPermissions()">
                                                        Select All
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-outline-secondary w-100" onclick="deselectAllPermissions()">
                                                        Deselect All
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
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
                        <i class="fas fa-save me-2"></i>Create Role
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

.role-icon {
    width: 44px;
    height: 44px;
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

.permissions-preview .badge {
    font-size: 0.7rem;
    padding: 0.25rem 0.5rem;
}

.permissions-grid .card {
    margin-bottom: 0;
}

.permissions-grid .card-header {
    background-color: #f8f9fa !important;
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
    
    .permissions-grid .col-md-6 {
        margin-bottom: 1rem;
    }
    
    .btn-sm {
        padding: 0.25rem 0.375rem;
    }
}
</style>

<script>
// Initialize tooltips
document.addEventListener('DOMContentLoaded', function() {
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    const tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Edit role functionality
    const editButtons = document.querySelectorAll('.edit-role-btn');
    const editModal = new bootstrap.Modal(document.getElementById('editRoleModal'));
    const editRoleForm = document.getElementById('editRoleForm');
    const editMessage = document.getElementById('editMessage');
    const editAlert = document.getElementById('editAlert');
    const editSubmitBtn = document.getElementById('editSubmitBtn');

    editButtons.forEach(button => {
        button.addEventListener('click', async function() {
            const roleId = this.dataset.id;
            
            try {
                const response = await fetch(`/admin-roles/${roleId}/edit`);
                const data = await response.json();
                
                if (data.success) {
                    const role = data.data;
                    document.getElementById('editRoleId').value = role.id;
                    document.getElementById('editRoleName').value = role.name;
                    document.getElementById('editGuardName').value = role.guard_name;
                    editRoleForm.action = `/admin-roles/${role.id}`;
                    editMessage.style.display = 'none';
                    
                    editModal.show();
                } else {
                    alert('Error loading role data');
                }
            } catch (error) {
                alert('Error: ' + error.message);
            }
        });
    });

    // Edit form submission
    editRoleForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        editSubmitBtn.disabled = true;
        const originalText = editSubmitBtn.innerHTML;
        editSubmitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Updating...';
        
        try {
            const formData = new FormData(editRoleForm);
            const roleId = document.getElementById('editRoleId').value;
            
            const response = await fetch(`/admin-roles/${roleId}`, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            
            const data = await response.json();
            
            if (response.ok) {
                editMessage.style.display = 'block';
                editAlert.className = 'alert alert-success';
                editAlert.innerHTML = '<i class="fas fa-check-circle me-2"></i>' + data.message;
                
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            } else {
                editMessage.style.display = 'block';
                editAlert.className = 'alert alert-danger';
                editAlert.innerHTML = '<i class="fas fa-exclamation-circle me-2"></i>' + data.message;
            }
        } catch (error) {
            editMessage.style.display = 'block';
            editAlert.className = 'alert alert-danger';
            editAlert.innerHTML = '<i class="fas fa-exclamation-circle me-2"></i>Error: ' + error.message;
        } finally {
            editSubmitBtn.disabled = false;
            editSubmitBtn.innerHTML = originalText;
        }
    });

    // Manage permissions functionality
    const permissionsButtons = document.querySelectorAll('.manage-permissions-btn');
    const permissionsModal = new bootstrap.Modal(document.getElementById('permissionsModal'));
    const permissionsContent = document.getElementById('permissionsContent');
    const permissionsLoading = document.getElementById('permissionsLoading');
    const permissionsError = document.getElementById('permissionsError');

    permissionsButtons.forEach(button => {
        button.addEventListener('click', async function() {
            const roleId = this.dataset.id;
            const roleName = this.dataset.name;
            
            document.getElementById('permissionsRoleName').textContent = `Role: ${roleName}`;
            permissionsContent.style.display = 'none';
            permissionsLoading.style.display = 'block';
            permissionsError.style.display = 'none';
            
            permissionsModal.show();
            
            try {
                const response = await fetch(`/admin-roles/${roleId}/permissions`);
                const data = await response.json();
                
                if (data.success) {
                    permissionsLoading.style.display = 'none';
                    
                    if (Object.keys(data.groupedPermissions).length === 0) {
                        permissionsContent.innerHTML = `
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                No permissions found in the database. Please seed permissions first.
                            </div>
                        `;
                    } else {
                        let html = '<div class="row g-3">';
                        
                        for (const [groupName, permissions] of Object.entries(data.groupedPermissions)) {
                            html += `
                                <div class="col-md-6">
                                    <div class="card border">
                                        <div class="card-header bg-light py-2">
                                            <h6 class="mb-0 fw-semibold">
                                                <i class="fas fa-shield-alt me-2 text-primary"></i>${groupName || 'General'}
                                            </h6>
                                        </div>
                                        <div class="card-body py-2">
                            `;
                            
                            permissions.forEach(permission => {
                                const isChecked = data.rolePermissionIds.includes(permission.id);
                                html += `
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" 
                                               type="checkbox" 
                                               id="perm_${permission.id}" 
                                               ${isChecked ? 'checked' : ''}
                                               disabled>
                                        <label class="form-check-label small" for="perm_${permission.id}">
                                            ${permission.name}
                                        </label>
                                    </div>
                                `;
                            });
                            
                            html += `
                                        </div>
                                    </div>
                                </div>
                            `;
                        }
                        
                        html += '</div>';
                        permissionsContent.innerHTML = html;
                    }
                    
                    permissionsContent.style.display = 'block';
                } else {
                    permissionsLoading.style.display = 'none';
                    permissionsError.style.display = 'block';
                    document.getElementById('permissionsErrorMessage').textContent = data.message || 'Error loading permissions';
                }
            } catch (error) {
                permissionsLoading.style.display = 'none';
                permissionsError.style.display = 'block';
                document.getElementById('permissionsErrorMessage').textContent = 'Error: ' + error.message;
            }
        });
    });
});

function selectAllPermissions() {
    const checkboxes = document.querySelectorAll('.permissions-grid input[type="checkbox"]');
    checkboxes.forEach(checkbox => {
        checkbox.checked = true;
    });
}

function deselectAllPermissions() {
    const checkboxes = document.querySelectorAll('.permissions-grid input[type="checkbox"]');
    checkboxes.forEach(checkbox => {
        checkbox.checked = false;
    });
}
</script>

@include('adminPortal.layout.footer')