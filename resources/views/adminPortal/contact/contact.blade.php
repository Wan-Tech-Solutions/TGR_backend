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
                <li class="breadcrumb-item active" aria-current="page">Contact Responses</li>
            </ol>
        </nav>

        <!-- Header Section -->
        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-start align-items-lg-center mb-5">
            <div class="mb-3 mb-lg-0">
                <h1 class="h2 fw-bold text-dark mb-2">Contact Responses</h1>
                <p class="text-muted mb-0">Manage and review all client inquiries and feedback</p>
            </div>
            <a href="{{ route('admin.email.compose') }}" class="btn btn-primary">
                <i class="fas fa-envelope me-2"></i>Compose Email
            </a>
        </div>

        <!-- Stats Cards -->
        <div class="row g-4 mb-5">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon bg-primary bg-opacity-10 text-primary rounded-2 p-3 me-3">
                                <i class="fas fa-envelope fa-lg"></i>
                            </div>
                            <div>
                                <p class="text-muted text-uppercase small fw-semibold mb-1">Total Responses</p>
                                <h3 class="fw-bold text-dark mb-0">{{ $contact->count() }}</h3>
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
                                <p class="text-muted text-uppercase small fw-semibold mb-1">Responded</p>
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
                            <div class="stat-icon bg-warning bg-opacity-10 text-warning rounded-2 p-3 me-3">
                                <i class="fas fa-clock fa-lg"></i>
                            </div>
                            <div>
                                <p class="text-muted text-uppercase small fw-semibold mb-1">Pending</p>
                                <h3 class="fw-bold text-warning mb-0">{{ $contact->count() }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon bg-info bg-opacity-10 text-info rounded-2 p-3 me-3">
                                <i class="fas fa-calendar-alt fa-lg"></i>
                            </div>
                            <div>
                                <p class="text-muted text-uppercase small fw-semibold mb-1">This Month</p>
                                <h3 class="fw-bold text-info mb-0">{{ $contact->where('created_at', '>=', now()->startOfMonth())->count() }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Responses Table -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 pb-0 pt-4 px-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title fw-bold text-dark mb-1">
                            <i class="fas fa-inbox me-2 text-primary"></i>Contact Responses
                        </h5>
                        <p class="text-muted small mb-0">All client inquiries and feedback messages</p>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <div class="input-group input-group-sm" style="width: 250px;">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            <input type="text" class="form-control border-start-0" placeholder="Search responses...">
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body px-0 pb-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4 small fw-semibold text-uppercase text-muted" style="width: 12%">Contact</th>
                                <th class="small fw-semibold text-uppercase text-muted" style="width: 10%">Location</th>
                                <th class="small fw-semibold text-uppercase text-muted" style="width: 12%">Subject</th>
                                <th class="small fw-semibold text-uppercase text-muted" style="width: 38%">Message</th>
                                <th class="small fw-semibold text-uppercase text-muted" style="width: 10%">Received</th>
                                <th class="pe-4 small fw-semibold text-uppercase text-muted" style="width: 8%">Status</th>
                                <th class="pe-4 small fw-semibold text-uppercase text-muted" style="width: 10%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($contact as $response)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                            {{ substr($response->full_name, 0, 1) }}
                                        </div>
                                        <div>
                                            <h6 class="fw-bold text-dark mb-1">{{ $response->full_name }}</h6>
                                            <small class="text-muted">{{ $response->email }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <small class="fw-medium text-dark">{{ $response->country_of_residence }}</small>
                                        <small class="text-muted">{{ $response->nationality }}</small>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border px-2 py-1">
                                        {{ Str::limit($response->subject, 20) }}
                                    </span>
                                </td>
                                <td>
                                    <p class="text-muted mb-0 small lh-base">
                                        {{ Str::limit($response->message, 80) }}
                                    </p>
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <small class="fw-medium text-dark">
                                            {{ $response->created_at->format('M d, Y') }}
                                        </small>
                                        <small class="text-muted">
                                            {{ $response->created_at->format('h:i A') }}
                                        </small>
                                    </div>
                                </td>
                                <td class="pe-4">
                                    <span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 px-2 py-1">
                                        Pending
                                    </span>
                                </td>
                                <td class="pe-4">
                                    <div class="d-flex gap-1">
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-primary d-flex align-items-center"
                                                title="View Details"
                                                data-bs-toggle="modal" 
                                                data-bs-target="#viewResponseModal"
                                                onclick="viewResponse({{ $response->id }}, '{{ addslashes($response->full_name) }}', '{{ $response->email }}', '{{ addslashes($response->subject) }}', '{{ addslashes($response->message) }}', '{{ $response->country_of_residence }}', '{{ $response->nationality }}', '{{ $response->created_at->format('M d, Y h:i A') }}')">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-success d-flex align-items-center"
                                                data-bs-toggle="tooltip" 
                                                title="Mark as Responded">
                                            <i class="fas fa-check"></i>
                                        </button>
                                        <form action="#" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-sm btn-outline-danger d-flex align-items-center"
                                                    data-bs-toggle="tooltip" 
                                                    title="Delete Response"
                                                    onclick="return confirm('Are you sure you want to delete this response?')">
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
                                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                        <h5 class="text-muted mb-2">No Contact Responses</h5>
                                        <p class="text-muted mb-3">All contact form responses will appear here</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($contact->count() > 0)
            <div class="card-footer bg-white border-0 py-3 px-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="text-muted small">
                        Showing {{ $contact->firstItem() ?? 0 }} to {{ $contact->lastItem() ?? 0 }} of {{ $contact->total() }} entries
                    </div>
                    {{ $contact->links('pagination::bootstrap-4') }}
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Add Feedback Modal -->
<div class="modal fade" id="addFeedbackModal" tabindex="-1" aria-labelledby="addFeedbackModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-light border-0 py-4">
                <div>
                    <h5 class="modal-title fw-bold text-dark mb-1" id="addFeedbackModalLabel">
                        <i class="fas fa-plus-circle me-2 text-primary"></i>Add Client Feedback
                    </h5>
                    <p class="text-muted small mb-0">Create a new client feedback entry</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form>
                <div class="modal-body py-4">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="clientName" class="form-label small fw-semibold text-muted text-uppercase">Full Name</label>
                                <input type="text" 
                                       class="form-control" 
                                       id="clientName" 
                                       placeholder="Enter client's full name"
                                       required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="clientEmail" class="form-label small fw-semibold text-muted text-uppercase">Email Address</label>
                                <input type="email" 
                                       class="form-control" 
                                       id="clientEmail" 
                                       placeholder="Enter client's email"
                                       required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="clientPhone" class="form-label small fw-semibold text-muted text-uppercase">Phone Number</label>
                                <input type="tel" 
                                       class="form-control" 
                                       id="clientPhone" 
                                       placeholder="Enter phone number">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="clientCountry" class="form-label small fw-semibold text-muted text-uppercase">Country</label>
                                <input type="text" 
                                       class="form-control" 
                                       id="clientCountry" 
                                       placeholder="Enter country of residence">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="feedbackSubject" class="form-label small fw-semibold text-muted text-uppercase">Subject</label>
                                <input type="text" 
                                       class="form-control" 
                                       id="feedbackSubject" 
                                       placeholder="Enter feedback subject"
                                       required>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="feedbackComment" class="form-label small fw-semibold text-muted text-uppercase">Comments</label>
                                <textarea class="form-control" 
                                          id="feedbackComment" 
                                          rows="5" 
                                          placeholder="Enter detailed comments or feedback..."
                                          required></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 bg-light py-3">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Cancel
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Add Feedback
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- View Response Modal -->
<div class="modal fade" id="viewResponseModal" tabindex="-1" aria-labelledby="viewResponseModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-light border-0 py-4">
                <div>
                    <h5 class="modal-title fw-bold text-dark mb-1" id="viewResponseModalLabel">
                        <i class="fas fa-eye me-2 text-primary"></i>Contact Response Details
                    </h5>
                    <p class="text-muted small mb-0">Complete information about this contact response</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-4">
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-muted text-uppercase">Full Name</label>
                            <p id="modalFullName" class="mb-0 fw-medium text-dark">-</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-muted text-uppercase">Email</label>
                            <p id="modalEmail" class="mb-0 fw-medium text-dark">-</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-muted text-uppercase">Country of Residence</label>
                            <p id="modalCountry" class="mb-0 fw-medium text-dark">-</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-muted text-uppercase">Nationality</label>
                            <p id="modalNationality" class="mb-0 fw-medium text-dark">-</p>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-muted text-uppercase">Subject</label>
                            <p id="modalSubject" class="mb-0 fw-medium text-dark">-</p>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-muted text-uppercase">Message</label>
                            <div class="bg-light p-3 rounded">
                                <p id="modalMessage" class="mb-0 text-dark lh-base">-</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mb-0">
                            <label class="form-label small fw-semibold text-muted text-uppercase">Received Date</label>
                            <p id="modalDate" class="mb-0 fw-medium text-dark">-</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 bg-light py-3">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Close
                </button>
                <button type="button" class="btn btn-success" id="sendResponseBtn" onclick="sendResponse()">
                    <i class="fas fa-reply me-2"></i>Send Response
                </button>
            </div>
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
    
    .btn-sm {
        padding: 0.25rem 0.375rem;
    }
}
</style>

<script>
let currentResponseEmail = '';

function viewResponse(responseId, fullName, email, subject, message, country, nationality, date) {
    currentResponseEmail = email;
    
    // Populate modal with contact details
    document.getElementById('modalFullName').textContent = fullName;
    document.getElementById('modalEmail').textContent = email;
    document.getElementById('modalCountry').textContent = country;
    document.getElementById('modalNationality').textContent = nationality;
    document.getElementById('modalSubject').textContent = subject;
    document.getElementById('modalMessage').textContent = message;
    document.getElementById('modalDate').textContent = date;
}

function sendResponse() {
    if (!currentResponseEmail) {
        alert('Error: No email address found.');
        return;
    }
    
    // Redirect to email compose page with pre-filled parameters
    const subject = document.getElementById('modalSubject').textContent;
    const composeUrl = `{{ route('admin.email.compose') }}?to=${encodeURIComponent(currentResponseEmail)}&subject=${encodeURIComponent('Re: ' + subject)}`;
    
    window.location.href = composeUrl;
}
</script>

@include('adminPortal.layout.footer')