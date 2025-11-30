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
                <li class="breadcrumb-item active" aria-current="page">User Profiles</li>
            </ol>
        </nav>

        <!-- Header Section -->
        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-start align-items-lg-center mb-5">
            <div class="mb-3 mb-lg-0">
                <h1 class="h2 fw-bold text-dark mb-2">User Profiles Management</h1>
                <p class="text-muted mb-0">Manage and monitor all user accounts and profiles</p>
            </div>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                <i class="fas fa-user-plus me-2"></i>Add New User
            </button>
        </div>

        <!-- Stats Cards -->
        <div class="row g-4 mb-5">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon bg-primary bg-opacity-10 text-white rounded-2 p-3 me-3">
                                <i class="fas fa-users fa-lg"></i>
                            </div>
                            <div>
                                <p class="text-muted text-uppercase small fw-semibold mb-1">Total Users</p>
                                <h3 class="fw-bold text-dark mb-0">{{ $users->count() }}</h3>
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
                                <i class="fas fa-user-check fa-lg"></i>
                            </div>
                            <div>
                                <p class="text-muted text-uppercase small fw-semibold mb-1">Active Today</p>
                                <h3 class="fw-bold text-success mb-0">{{ $users->where('last_login_at', '>=', today())->count() }}</h3>
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
                                <i class="fas fa-globe-americas fa-lg"></i>
                            </div>
                            <div>
                                <p class="text-muted text-uppercase small fw-semibold mb-1">Countries</p>
                                <h3 class="fw-bold text-warning mb-0">{{ $users->pluck('country_of_residence')->unique()->count() }}</h3>
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
                                <i class="fas fa-user-clock fa-lg"></i>
                            </div>
                            <div>
                                <p class="text-muted text-uppercase small fw-semibold mb-1">New This Month</p>
                                <h3 class="fw-bold text-info mb-0">{{ $users->where('created_at', '>=', now()->startOfMonth())->count() }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters Section -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-0 pb-0 pt-4 px-4">
                <h5 class="card-title fw-bold text-dark mb-1">
                    <i class="fas fa-filter me-2 text-primary"></i>Filter Users
                </h5>
                <p class="text-muted small mb-0">Refine user list by specific criteria</p>
            </div>
            <div class="card-body px-4 pb-4">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label small fw-semibold text-muted text-uppercase">Country</label>
                        <select class="form-select" id="countryFilter">
                            <option value="">All Countries</option>
                            @foreach($users->pluck('country_of_residence')->unique()->filter() as $country)
                                <option value="{{ $country }}">{{ $country }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-semibold text-muted text-uppercase">Gender</label>
                        <select class="form-select" id="genderFilter">
                            <option value="">All Genders</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-semibold text-muted text-uppercase">Status</label>
                        <select class="form-select" id="statusFilter">
                            <option value="">All Status</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                            <option value="pending">Pending</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-semibold text-muted text-uppercase">Registration Date</label>
                        <input type="date" class="form-control" id="dateFilter">
                    </div>
                </div>
            </div>
        </div>

        <!-- Users Table -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 pb-0 pt-4 px-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title fw-bold text-dark mb-1">
                            <i class="fas fa-users me-2 text-primary"></i>User Profiles
                        </h5>
                        <p class="text-muted small mb-0">All registered users and their profile information</p>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <div class="input-group input-group-sm" style="width: 250px;">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            <input type="text" class="form-control border-start-0" placeholder="Search users..." id="searchInput">
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body px-0 pb-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" id="usersTable">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4 small fw-semibold text-uppercase text-muted" style="width: 20%">User</th>
                                <th class="small fw-semibold text-uppercase text-muted" style="width: 15%">Gender</th>
                                <th class="small fw-semibold text-uppercase text-muted" style="width: 20%">Location</th>
                                <th class="small fw-semibold text-uppercase text-muted" style="width: 15%">Status</th>
                                <th class="small fw-semibold text-uppercase text-muted" style="width: 15%">Registered</th>
                                <th class="pe-4 small fw-semibold text-uppercase text-muted" style="width: 15%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar bg-primary bg-opacity-10 text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <h6 class="fw-bold text-dark mb-1">{{ $user->name }}</h6>
                                            <small class="text-muted">{{ $user->email }}</small>
                                            @if($user->phone)
                                                <small class="text-muted d-block">{{ $user->phone }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge rounded-pill py-2 px-3 fw-semibold
                                        @if($user->gender == 'Male') bg-primary bg-opacity-10 text-white border border-primary border-opacity-25
                                        @elseif($user->gender == 'Female') bg-pink bg-opacity-10 text-white border border-pink border-opacity-25
                                        @else bg-secondary bg-opacity-10 text-white border border-secondary border-opacity-25 @endif">
                                        <i class="fas @if($user->gender == 'Male') fa-mars 
                                                    @elseif($user->gender == 'Female') fa-venus 
                                                    @else fa-genderless @endif me-1"></i>
                                        {{ $user->gender ?? 'Not specified' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="location-info">
                                        <div class="d-flex align-items-center mb-1">
                                            <i class="fas fa-map-marker-alt text-muted me-2 fa-sm"></i>
                                            <span class="fw-medium text-dark">{{ $user->country_of_residence ?? 'Unknown' }}</span>
                                        </div>
                                        @if($user->nationality)
                                        <small class="text-muted">
                                            Nationality: {{ $user->nationality }}
                                        </small>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <span class="badge rounded-pill py-2 px-3 fw-semibold
                                        @if($user->email_verified_at) bg-success bg-opacity-10 text-white border border-success border-opacity-25
                                        @elseif($user->deleted_at) bg-danger bg-opacity-10 text-white border border-danger border-opacity-25
                                        @else bg-warning bg-opacity-10 text-white border border-warning border-opacity-25 @endif">
                                        <i class="fas @if($user->email_verified_at) fa-check-circle 
                                                    @elseif($user->deleted_at) fa-times-circle 
                                                    @else fa-clock @endif me-1"></i>
                                        @if($user->email_verified_at) Verified
                                        @elseif($user->deleted_at) Inactive
                                        @else Pending @endif
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="fw-medium text-dark">
                                            {{ $user->created_at->format('M d, Y') }}
                                        </span>
                                        <small class="text-muted">
                                            {{ $user->created_at->diffForHumans() }}
                                        </small>
                                    </div>
                                </td>
                                <td class="pe-4">
                                    <div class="d-flex gap-1">
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-primary d-flex align-items-center"
                                                data-bs-toggle="tooltip" 
                                                title="View Profile"
                                                onclick="viewUserProfile({{ $user->id }})">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-warning d-flex align-items-center"
                                                data-bs-toggle="tooltip" 
                                                title="Edit User"
                                                onclick="editUserProfile({{ $user->id }})">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-info d-flex align-items-center"
                                                data-bs-toggle="tooltip" 
                                                title="Send Message">
                                            <i class="fas fa-envelope"></i>
                                        </button>
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-danger d-flex align-items-center delete-user-btn"
                                                data-id="{{ $user->id }}"
                                                data-name="{{ $user->name }}"
                                                data-bs-toggle="tooltip" 
                                                title="Delete User">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-5">
                                    <div class="empty-state">
                                        <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                        <h5 class="text-muted mb-2">No Users Found</h5>
                                        <p class="text-muted mb-3">Get started by adding your first user</p>
                                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                                            <i class="fas fa-user-plus me-2"></i>Add First User
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($users->hasPages())
            <div class="card-footer bg-white border-0 py-3 px-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="text-muted small">
                        Showing {{ $users->firstItem() ?? 0 }} to {{ $users->lastItem() ?? 0 }} of {{ $users->total() }} entries
                    </div>
                    {{ $users->links('pagination::bootstrap-4') }}
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-light border-0 py-4">
                <div>
                    <h5 class="modal-title fw-bold text-dark mb-1" id="addUserModalLabel">
                        <i class="fas fa-user-plus me-2 text-primary"></i>Add New User
                    </h5>
                    <p class="text-muted small mb-0">Create a new user account with profile information</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form>
                <div class="modal-body py-4">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="userName" class="form-label small fw-semibold text-muted text-uppercase">Full Name</label>
                                <input type="text" 
                                       class="form-control" 
                                       id="userName" 
                                       placeholder="Enter full name"
                                       required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="userEmail" class="form-label small fw-semibold text-muted text-uppercase">Email Address</label>
                                <input type="email" 
                                       class="form-control" 
                                       id="userEmail" 
                                       placeholder="Enter email address"
                                       required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="userPhone" class="form-label small fw-semibold text-muted text-uppercase">Phone Number</label>
                                <input type="tel" 
                                       class="form-control" 
                                       id="userPhone" 
                                       placeholder="Enter phone number">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="userGender" class="form-label small fw-semibold text-muted text-uppercase">Gender</label>
                                <select class="form-select" id="userGender">
                                    <option value="">Select Gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="userCountry" class="form-label small fw-semibold text-muted text-uppercase">Country of Residence</label>
                                <input type="text" 
                                       class="form-control" 
                                       id="userCountry" 
                                       placeholder="Enter country">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="userNationality" class="form-label small fw-semibold text-muted text-uppercase">Nationality</label>
                                <input type="text" 
                                       class="form-control" 
                                       id="userNationality" 
                                       placeholder="Enter nationality">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="userPassword" class="form-label small fw-semibold text-muted text-uppercase">Password</label>
                                <input type="password" 
                                       class="form-control" 
                                       id="userPassword" 
                                       placeholder="Enter password"
                                       required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="userConfirmPassword" class="form-label small fw-semibold text-muted text-uppercase">Confirm Password</label>
                                <input type="password" 
                                       class="form-control" 
                                       id="userConfirmPassword" 
                                       placeholder="Confirm password"
                                       required>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="sendWelcomeEmail" checked>
                                <label class="form-check-label small fw-medium" for="sendWelcomeEmail">
                                    Send welcome email with login instructions
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 bg-light py-3">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Cancel
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Create User
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

.bg-pink {
    background-color: #ec4899 !important;
}

.text-pink {
    color: #ec4899 !important;
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

.location-info {
    max-width: 150px;
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
    
    .location-info {
        max-width: 120px;
    }
    
    .btn-sm {
        padding: 0.25rem 0.375rem;
    }
}
</style>

<script>
function viewUserProfile(userId) {
    fetch(`/admin-profiles/${userId}/view`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const user = data.data;
                document.getElementById('viewUserName').textContent = user.name;
                document.getElementById('viewUserEmail').textContent = user.email;
                document.getElementById('viewUserGender').textContent = user.gender || 'Not specified';
                document.getElementById('viewUserCountry').textContent = user.country_of_residence || 'Not specified';
                document.getElementById('viewUserNationality').textContent = user.nationality || 'Not specified';
                document.getElementById('viewUserStatus').innerHTML = user.status == '1' 
                    ? '<span class="badge bg-success">Active</span>' 
                    : '<span class="badge bg-danger">Inactive</span>';
                document.getElementById('viewUserCreated').textContent = new Date(user.created_at).toLocaleDateString();
                
                const viewModal = new bootstrap.Modal(document.getElementById('viewUserModal'));
                viewModal.show();
            } else {
                alert('Error loading user details');
            }
        })
        .catch(error => alert('Error: ' + error.message));
}

function editUserProfile(userId) {
    fetch(`/admin-profiles/${userId}/edit`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const user = data.data;
                document.getElementById('editUserId').value = user.id;
                document.getElementById('editUserName').value = user.name;
                document.getElementById('editUserEmail').value = user.email;
                document.getElementById('editUserGender').value = user.gender || '';
                document.getElementById('editUserCountry').value = user.country_of_residence || '';
                document.getElementById('editUserNationality').value = user.nationality || '';
                document.getElementById('editUserStatus').value = user.status;
                document.getElementById('editMessage').style.display = 'none';
                
                const editModal = new bootstrap.Modal(document.getElementById('editUserModal'));
                editModal.show();
            } else {
                alert('Error loading user details');
            }
        })
        .catch(error => alert('Error: ' + error.message));
}

// Initialize filters and search
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const countryFilter = document.getElementById('countryFilter');
    const genderFilter = document.getElementById('genderFilter');
    const statusFilter = document.getElementById('statusFilter');
    const dateFilter = document.getElementById('dateFilter');
    
    const filters = [searchInput, countryFilter, genderFilter, statusFilter, dateFilter];
    
    filters.forEach(filter => {
        if (filter) {
            filter.addEventListener('input', filterUsers);
            filter.addEventListener('change', filterUsers);
        }
    });
    
    function filterUsers() {
        const searchTerm = searchInput.value.toLowerCase();
        const country = countryFilter.value.toLowerCase();
        const gender = genderFilter.value.toLowerCase();
        const status = statusFilter.value.toLowerCase();
        const selectedDate = dateFilter.value;
        
        const rows = document.querySelectorAll('#usersTable tbody tr');
        
        rows.forEach(row => {
            const name = row.cells[0].textContent.toLowerCase();
            const email = row.cells[0].querySelector('small').textContent.toLowerCase();
            const userGender = row.cells[1].textContent.toLowerCase();
            const location = row.cells[2].textContent.toLowerCase();
            const userStatus = row.cells[3].textContent.toLowerCase();
            const regDate = row.cells[4].textContent.toLowerCase();
            
            let showRow = true;
            
            // Search filter
            if (searchTerm && !name.includes(searchTerm) && !email.includes(searchTerm)) {
                showRow = false;
            }
            
            // Country filter
            if (country && !location.includes(country)) {
                showRow = false;
            }
            
            // Gender filter
            if (gender && !userGender.includes(gender)) {
                showRow = false;
            }
            
            // Status filter
            if (status && !userStatus.includes(status)) {
                showRow = false;
            }
            
            row.style.display = showRow ? '' : 'none';
        });
    }
    
    // Initialize tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    const tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Edit form submission
    const editUserForm = document.getElementById('editUserForm');
    if (editUserForm) {
        editUserForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const submitBtn = document.getElementById('editSubmitBtn');
            submitBtn.disabled = true;
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Updating...';
            
            const userId = document.getElementById('editUserId').value;
            const formData = new FormData(editUserForm);
            
            try {
                const response = await fetch(`/admin-profiles/${userId}`, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                
                const data = await response.json();
                const editMessage = document.getElementById('editMessage');
                const editAlert = document.getElementById('editAlert');
                
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
                const editMessage = document.getElementById('editMessage');
                const editAlert = document.getElementById('editAlert');
                editMessage.style.display = 'block';
                editAlert.className = 'alert alert-danger';
                editAlert.innerHTML = '<i class="fas fa-exclamation-circle me-2"></i>Error: ' + error.message;
            } finally {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            }
        });
    }

    // Delete user functionality
    const deleteButtons = document.querySelectorAll('.delete-user-btn');
    deleteButtons.forEach(button => {
        button.addEventListener('click', async function() {
            const userId = this.dataset.id;
            const userName = this.dataset.name;
            
            if (!confirm(`Are you sure you want to delete ${userName}? This action cannot be undone.`)) {
                return;
            }
            
            try {
                const response = await fetch(`/admin-profiles/${userId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                
                const data = await response.json();
                
                if (response.ok) {
                    alert(data.message);
                    window.location.reload();
                } else {
                    alert('Error: ' + data.message);
                }
            } catch (error) {
                alert('Error: ' + error.message);
            }
        });
    });
});
</script>

<!-- View User Modal -->
<div class="modal fade" id="viewUserModal" tabindex="-1" aria-labelledby="viewUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-light border-0 py-4">
                <div>
                    <h5 class="modal-title fw-bold text-dark mb-1" id="viewUserModalLabel">
                        <i class="fas fa-user me-2 text-primary"></i>User Details
                    </h5>
                    <p class="text-muted small mb-0">View user information</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-4">
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label small fw-semibold text-muted">Name</label>
                        <p class="fw-bold" id="viewUserName"></p>
                    </div>
                    <div class="col-12">
                        <label class="form-label small fw-semibold text-muted">Email</label>
                        <p id="viewUserEmail"></p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold text-muted">Gender</label>
                        <p id="viewUserGender"></p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold text-muted">Status</label>
                        <p id="viewUserStatus"></p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold text-muted">Country</label>
                        <p id="viewUserCountry"></p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold text-muted">Nationality</label>
                        <p id="viewUserNationality"></p>
                    </div>
                    <div class="col-12">
                        <label class="form-label small fw-semibold text-muted">Registered</label>
                        <p id="viewUserCreated"></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 bg-light py-3">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Close
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-light border-0 py-4">
                <div>
                    <h5 class="modal-title fw-bold text-dark mb-1" id="editUserModalLabel">
                        <i class="fas fa-edit me-2 text-warning"></i>Edit User
                    </h5>
                    <p class="text-muted small mb-0">Update user information</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editUserForm">
                @csrf
                <input type="hidden" id="editUserId">
                <div class="modal-body py-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="editUserName" class="form-label small fw-semibold text-muted text-uppercase">Name</label>
                            <input type="text" class="form-control" id="editUserName" name="name" required>
                        </div>
                        <div class="col-md-6">
                            <label for="editUserEmail" class="form-label small fw-semibold text-muted text-uppercase">Email</label>
                            <input type="email" class="form-control" id="editUserEmail" name="email" required>
                        </div>
                        <div class="col-md-4">
                            <label for="editUserGender" class="form-label small fw-semibold text-muted text-uppercase">Gender</label>
                            <select class="form-select" id="editUserGender" name="gender">
                                <option value="">Select Gender</option>
                                <option value="MALE">Male</option>
                                <option value="FEMALE">Female</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="editUserCountry" class="form-label small fw-semibold text-muted text-uppercase">Country</label>
                            <input type="text" class="form-control" id="editUserCountry" name="country_of_residence">
                        </div>
                        <div class="col-md-4">
                            <label for="editUserNationality" class="form-label small fw-semibold text-muted text-uppercase">Nationality</label>
                            <input type="text" class="form-control" id="editUserNationality" name="nationality">
                        </div>
                        <div class="col-12">
                            <label for="editUserStatus" class="form-label small fw-semibold text-muted text-uppercase">Status</label>
                            <select class="form-select" id="editUserStatus" name="status" required>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
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
                        <i class="fas fa-save me-2"></i>Update User
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@include('adminPortal.layout.footer')