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
                    <a href="{{ route('admin.consultations') }}" class="text-muted text-decoration-none">Consultation Bookings</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($consultation->name, 25) }}</li>
            </ol>
        </nav>

        <!-- Header Section -->
        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-start align-items-lg-center mb-5">
            <div class="mb-3 mb-lg-0">
                <div class="d-flex align-items-center mb-2">
                    <div class="avatar bg-primary bg-opacity-10 text-white rounded-circle d-flex align-items-center justify-content-center me-3 text-white fw-bold" style="width: 48px; height: 48px;">
                        {{ substr($consultation->name, 0, 1) }}
                    </div>
                    <div>
                        <h1 class="h2 fw-bold text-dark mb-0">{{ $consultation->name }}</h1>
                        <p class="text-muted mb-0">{{ $consultation->email }}</p>
                    </div>
                </div>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.consultations') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back to List
                </a>
            </div>
        </div>

        <div class="row g-4">
            <!-- Left Column: Main Content -->
            <div class="col-lg-8">

                <!-- Client Information Card -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-0 pb-0 pt-4 px-4">
                        <h5 class="card-title fw-bold text-dark mb-1">
                            <i class="fas fa-user-circle me-2 text-primary"></i>Client Information
                        </h5>
                        <p class="text-muted small mb-0">Personal details and contact information</p>
                    </div>
                    <div class="card-body px-4 pb-4">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="info-item">
                                    <span class="text-muted small fw-semibold text-uppercase d-block mb-1">Full Name</span>
                                    <p class="text-dark fw-medium mb-0">{{ $consultation->name }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-item">
                                    <span class="text-muted small fw-semibold text-uppercase d-block mb-1">Email Address</span>
                                    <p class="text-dark fw-medium mb-0">{{ $consultation->email }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-item">
                                    <span class="text-muted small fw-semibold text-uppercase d-block mb-1">Phone Number</span>
                                    <p class="text-dark fw-medium mb-0">{{ $consultation->dial_code }} {{ $consultation->phone }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-item">
                                    <span class="text-muted small fw-semibold text-uppercase d-block mb-1">Nationality</span>
                                    <p class="text-dark fw-medium mb-0">{{ $consultation->nationality ?? 'N/A' }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-item">
                                    <span class="text-muted small fw-semibold text-uppercase d-block mb-1">Country of Residence</span>
                                    <p class="text-dark fw-medium mb-0">{{ $consultation->country_of_residence }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-item">
                                    <span class="text-muted small fw-semibold text-uppercase d-block mb-1">Booked Date</span>
                                    <p class="text-dark fw-medium mb-0">{{ $consultation->created_at->format('M d, Y · h:i A') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Consultation Schedule Card -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-0 pb-0 pt-4 px-4">
                        <h5 class="card-title fw-bold text-dark mb-1">
                            <i class="fas fa-calendar-alt me-2 text-primary"></i>Consultation Schedule
                        </h5>
                        <p class="text-muted small mb-0">Appointment details and timing</p>
                    </div>
                    <div class="card-body px-4 pb-4">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="info-item">
                                    <span class="text-muted small fw-semibold text-uppercase d-block mb-1">Scheduled Date & Time</span>
                                    @if ($consultation->scheduled_for)
                                        <p class="text-dark fw-medium mb-0">
                                            {{ \Carbon\Carbon::parse($consultation->scheduled_for)->format('M d, Y · h:i A') }}
                                        </p>
                                    @else
                                        <span class="badge bg-light text-dark border px-3 py-2">Not scheduled yet</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-item">
                                    <span class="text-muted small fw-semibold text-uppercase d-block mb-1">Duration</span>
                                    <p class="text-dark fw-medium mb-0">{{ $consultation->consultation_hours }} hour(s)</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-item">
                                    <span class="text-muted small fw-semibold text-uppercase d-block mb-1">Quoted Amount</span>
                                    <p class="text-dark fw-medium mb-0">${{ number_format($consultation->quoted_amount / 100, 2) }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-item">
                                    <span class="text-muted small fw-semibold text-uppercase d-block mb-1">Rebook Count</span>
                                    <div class="d-flex align-items-center">
                                        <span class="text-dark fw-medium me-2">{{ $consultation->rebook_count ?? 0 }} / 2</span>
                                        <span class="badge bg-light text-dark small">
                                            {{ 2 - ($consultation->rebook_count ?? 0) }} remaining
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Consultation Interest Card -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-0 pb-0 pt-4 px-4">
                        <h5 class="card-title fw-bold text-dark mb-1">
                            <i class="fas fa-comment-dots me-2 text-primary"></i>Consultation Interest
                        </h5>
                        <p class="text-muted small mb-0">Client's expressed interests and goals</p>
                    </div>
                    <div class="card-body px-4 pb-4">
                        @if ($consultation->consultation_interest)
                            <div class="bg-light rounded-2 p-3 border-start border-primary border-4">
                                <p class="text-dark mb-0 lh-lg">{{ nl2br(e($consultation->consultation_interest)) }}</p>
                            </div>
                        @else
                            <div class="text-center text-muted py-4">
                                <i class="fas fa-inbox fa-2x mb-2 opacity-50"></i>
                                <p class="mb-0">No consultation interest provided</p>
                            </div>
                        @endif
                    </div>
                </div>

            </div>

            <!-- Right Column: Status & Actions -->
            <div class="col-lg-4">

                <!-- Status Overview Card -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-0 pb-0 pt-4 px-4">
                        <h5 class="card-title fw-bold text-dark mb-1">
                            <i class="fas fa-circle-notch me-2 text-primary"></i>Current Status
                        </h5>
                        <p class="text-muted small mb-0">Consultation and payment status</p>
                    </div>
                    <div class="card-body px-4 pb-4">
                        <div class="mb-4">
                            <span class="text-muted small fw-semibold text-uppercase d-block mb-2">Consultation Status</span>
                            <span class="badge rounded-pill py-2 px-3 fw-semibold text-white
                                @switch($consultation->status)
                                    @case('pending') bg-warning @break
                                    @case('confirmed') bg-success @break
                                    @case('completed') bg-info @break
                                    @default bg-secondary
                                @endswitch">
                                <i class="fas @switch($consultation->status)
                                    @case('pending') fa-clock @break
                                    @case('confirmed') fa-check-circle @break
                                    @case('completed') fa-flag-checkered @break
                                    @default fa-times-circle
                                @endswitch me-2"></i>
                                {{ ucfirst($consultation->status) }}
                            </span>
                        </div>
                        <div class="mb-0">
                            <span class="text-muted small fw-semibold text-uppercase d-block mb-2">Payment Status</span>
                            <span class="badge rounded-pill py-2 px-3 fw-semibold text-white
                                @switch($consultation->payment_status ?? 'unpaid')
                                    @case('paid') bg-success @break
                                    @case('pending') bg-warning @break
                                    @default bg-danger
                                @endswitch">
                                <i class="fas @switch($consultation->payment_status ?? 'unpaid')
                                    @case('paid') fa-check @break
                                    @case('pending') fa-hourglass-half @break
                                    @default fa-times
                                @endswitch me-2"></i>
                                {{ ucfirst($consultation->payment_status ?? 'unpaid') }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Payment Information Card -->
                @if ($consultation->payments && $consultation->payments->count())
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white border-0 pb-0 pt-4 px-4">
                            <h5 class="card-title fw-bold text-dark mb-1">
                                <i class="fas fa-credit-card me-2 text-primary"></i>Payment History
                            </h5>
                            <p class="text-muted small mb-0">Transaction records and amounts</p>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-sm table-hover align-middle mb-0">
                                    <thead class="table-light small">
                                        <tr>
                                            <th class="ps-4">Date</th>
                                            <th>Amount</th>
                                            <th class="pe-4">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($consultation->payments as $payment)
                                            <tr class="small">
                                                <td class="ps-4">{{ $payment->created_at->format('M d, Y') }}</td>
                                                <td class="fw-bold text-dark">${{ number_format($payment->amount / 100, 2) }}</td>
                                                <td class="pe-4">
                                                    <span class="badge text-white @switch($payment->status)
                                                            @case('paid') bg-success @break
                                                            @case('completed') bg-success @break
                                                            @case('pending') bg-warning @break
                                                            @default bg-danger
                                                        @endswitch">
                                                        {{ ucfirst($payment->status) }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Consultation Notes Card -->
                @if ($consultation->consultation_notes)
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white border-0 pb-0 pt-4 px-4">
                            <h5 class="card-title fw-bold text-dark mb-1">
                                <i class="fas fa-sticky-note me-2 text-primary"></i>Consultation Notes
                            </h5>
                            <p class="text-muted small mb-0">Internal notes and observations</p>
                        </div>
                        <div class="card-body px-4 pb-4">
                            <div class="bg-light bg-opacity-50 rounded p-3">
                                <p class="text-dark small lh-lg mb-0">{{ $consultation->consultation_notes }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Update Status Form -->
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0 pb-0 pt-4 px-4">
                        <h5 class="card-title fw-bold text-dark mb-1">
                            <i class="fas fa-edit me-2 text-primary"></i>Update Status
                        </h5>
                        <p class="text-muted small mb-0">Modify consultation details</p>
                    </div>
                    <div class="card-body px-4 pb-4">
                        <form action="{{ route('admin.consultations.update-status', $consultation->id) }}" method="POST">
                            @csrf
                            @method('PATCH')

                            <div class="mb-3">
                                <label for="status" class="form-label small fw-semibold text-muted text-uppercase">Consultation Status</label>
                                <select class="form-select" id="status" name="status" required>
                                    <option value="pending" @selected($consultation->status == 'pending')>Pending</option>
                                    <option value="confirmed" @selected($consultation->status == 'confirmed')>Confirmed</option>
                                    <option value="completed" @selected($consultation->status == 'completed')>Completed</option>
                                    <option value="cancelled" @selected($consultation->status == 'cancelled')>Cancelled</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="payment_status" class="form-label small fw-semibold text-muted text-uppercase">Payment Status</label>
                                <select class="form-select" id="payment_status" name="payment_status" required>
                                    <option value="unpaid" @selected(($consultation->payment_status ?? 'unpaid') == 'unpaid')>Unpaid</option>
                                    <option value="pending" @selected(($consultation->payment_status ?? 'unpaid') == 'pending')>Pending</option>
                                    <option value="paid" @selected(($consultation->payment_status ?? 'unpaid') == 'paid')>Paid</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="admin_notes" class="form-label small fw-semibold text-muted text-uppercase">Admin Notes</label>
                                <textarea class="form-control" id="admin_notes" name="admin_notes" rows="3"
                                    placeholder="Add internal notes about this consultation">{{ $consultation->admin_notes }}</textarea>
                                <small class="text-muted d-block mt-1">These notes are for internal use only.</small>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary fw-semibold py-2">
                                    <i class="fas fa-save me-2"></i>Save Changes
                                </button>
                            </div>
                        </form>

                        @php
                            $canSendRebook = $consultation->scheduled_for && \Carbon\Carbon::parse($consultation->scheduled_for)->startOfDay()->lte(\Carbon\Carbon::now()->startOfDay()) && ($consultation->rebook_count ?? 0) < 2;
                        @endphp
                        
                        @if ($canSendRebook)
                            <div class="mt-3 pt-3 border-top">
                                <form action="{{ route('admin.consultations.send-rebook', $consultation->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-warning w-100 fw-semibold py-2" onclick="return confirm('Send rebook reminder to {{ $consultation->email }}?')">
                                        <i class="fas fa-redo me-2"></i>Send Rebook Reminder
                                    </button>
                                </form>
                            </div>
                        @endif

                        <!-- Rebook History Section -->
                        @if($consultation->rebookLogs && $consultation->rebookLogs->count() > 0)
                            <div class="mt-4 pt-4 border-top">
                                <h6 class="fw-bold text-dark mb-3">
                                    <i class="fas fa-history text-muted me-2"></i>Rebook Reminder History
                                </h6>
                                <div class="table-responsive">
                                    <table class="table table-sm table-borderless">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="fw-semibold small">Sent Date</th>
                                                <th class="fw-semibold small">Status</th>
                                                <th class="fw-semibold small">Sent By</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($consultation->rebookLogs->sortByDesc('sent_at') as $log)
                                                <tr>
                                                    <td>
                                                        <small class="text-dark fw-medium">{{ $log->sent_at->format('M j, Y g:i A') }}</small>
                                                    </td>
                                                    <td>
                                                        @if($log->status === 'sent')
                                                            <span class="badge bg-success bg-opacity-10 text-success small">
                                                                <i class="fas fa-check me-1"></i>Sent
                                                            </span>
                                                        @elseif($log->status === 'failed')
                                                            <span class="badge bg-danger bg-opacity-10 text-danger small">
                                                                <i class="fas fa-times me-1"></i>Failed
                                                            </span>
                                                        @else
                                                            <span class="badge bg-secondary bg-opacity-10 text-secondary small">{{ ucfirst($log->status) }}</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <small class="text-muted">{{ $log->sent_by }}</small>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<style>
.avatar {
    font-weight: 600;
    font-size: 18px;
}

.stat-card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.stat-icon {
    font-size: 18px;
}

.info-item {
    padding: 8px 0;
}

.table th {
    border-top: none;
    font-weight: 600;
    font-size: 0.85rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #6c757d;
}

.progress {
    background-color: #f0f0f0;
}

.badge {
    font-size: 0.75rem;
}

.card {
    transition: transform 0.2s ease;
}

.card:hover {
    transform: translateY(-1px);
}
</style>

@include('adminPortal.layout.footer')