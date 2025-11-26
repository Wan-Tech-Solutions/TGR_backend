@extends('admin.layouts.admin_master')

@section('content')
<div class="container-fluid">
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="page-title">Consultation Management</h1>
            </div>
        </div>
    </div>
</div>

<div class="page-wrapper">
    <div class="container-fluid">
        
        <!-- Analytics Overview -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Consultation Analytics Overview</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="stat-card">
                                    <div class="stat-value">{{ $stats['total_consultations'] ?? 0 }}</div>
                                    <div class="stat-label">Total Consultations</div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="stat-card">
                                    <div class="stat-value text-warning">{{ $stats['pending_consultations'] ?? 0 }}</div>
                                    <div class="stat-label">Pending</div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="stat-card">
                                    <div class="stat-value text-info">{{ $stats['confirmed_consultations'] ?? 0 }}</div>
                                    <div class="stat-label">Confirmed</div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="stat-card">
                                    <div class="stat-value text-success">{{ $stats['completed_consultations'] ?? 0 }}</div>
                                    <div class="stat-label">Completed</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="row mb-3">
            <div class="col-12">
                <form method="GET" class="form-inline">
                    <input type="text" name="search" class="form-control mr-2" placeholder="Search by name, email, or phone..." value="{{ request('search') }}">
                    <select name="status" class="form-control mr-2">
                        <option value="">All Statuses</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="confirmed" {{ request('status') === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                    <select name="payment_status" class="form-control mr-2">
                        <option value="">All Payment Statuses</option>
                        <option value="pending" {{ request('payment_status') === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="initiated" {{ request('payment_status') === 'initiated' ? 'selected' : '' }}>Initiated</option>
                        <option value="paid" {{ request('payment_status') === 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="failed" {{ request('payment_status') === 'failed' ? 'selected' : '' }}>Failed</option>
                    </select>
                    <button type="submit" class="btn btn-primary mr-2">Filter</button>
                    <a href="{{ route('admin.consultations.index') }}" class="btn btn-secondary">Reset</a>
                </form>
            </div>
        </div>

        <!-- Consultations Table -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Recent Bookings</h3>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>Client Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Country</th>
                                    <th>Scheduled Date</th>
                                    <th>Hours</th>
                                    <th>Assessment %</th>
                                    <th>Status</th>
                                    <th>Payment</th>
                                    <th>Amount</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($consultations as $consultation)
                                    <tr>
                                        <td>
                                            <strong>{{ $consultation->name }}</strong>
                                        </td>
                                        <td>{{ $consultation->email }}</td>
                                        <td>{{ $consultation->dial_code }} {{ $consultation->phone }}</td>
                                        <td>{{ $consultation->country_of_residence }}</td>
                                        <td>{{ $consultation->scheduled_for?->format('M d, Y') ?? 'N/A' }}</td>
                                        <td>{{ $consultation->consultation_hours }} hrs</td>
                                        <td>
                                            <div class="progress" style="height: 20px;">
                                                <div class="progress-bar {{ $consultation->assessment_percentage >= 70 ? 'bg-success' : ($consultation->assessment_percentage >= 50 ? 'bg-warning' : 'bg-danger') }}" 
                                                     role="progressbar" 
                                                     style="width: {{ $consultation->assessment_percentage }}%"
                                                     aria-valuenow="{{ $consultation->assessment_percentage }}" 
                                                     aria-valuemin="0" 
                                                     aria-valuemax="100">
                                                    {{ round($consultation->assessment_percentage, 1) }}%
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge badge-{{ $consultation->status === 'confirmed' ? 'success' : ($consultation->status === 'pending' ? 'warning' : 'secondary') }}">
                                                {{ ucfirst($consultation->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge badge-{{ $consultation->payment_status === 'paid' ? 'success' : ($consultation->payment_status === 'initiated' ? 'info' : 'warning') }}">
                                                {{ ucfirst($consultation->payment_status) }}
                                            </span>
                                        </td>
                                        <td>${{ number_format($consultation->quoted_amount / 100, 2) }}</td>
                                        <td>
                                            <a href="{{ route('admin.consultations.show', $consultation) }}" class="btn btn-sm btn-info">View</a>
                                            <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#statusModal" data-id="{{ $consultation->id }}">Update</button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="11" class="text-center text-muted">No consultations found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        {{ $consultations->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Status Update Modal -->
<div class="modal fade" id="statusModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="" id="statusForm">
                @csrf
                @method('PATCH')
                <div class="modal-header">
                    <h5 class="modal-title">Update Consultation Status</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-control" required>
                            <option value="pending">Pending</option>
                            <option value="confirmed">Confirmed</option>
                            <option value="completed">Completed</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update Status</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.stat-card {
    padding: 1.5rem;
    border: 1px solid #e3e6f0;
    border-radius: 0.35rem;
    background: #f8f9fa;
}

.stat-value {
    font-size: 2rem;
    font-weight: bold;
    color: #2c3e50;
}

.stat-label {
    font-size: 0.875rem;
    color: #6c757d;
    margin-top: 0.5rem;
}

.text-warning {
    color: #f59f00 !important;
}

.text-info {
    color: #3b82f6 !important;
}

.text-success {
    color: #10b981 !important;
}

.badge {
    padding: 0.5rem 0.75rem;
}

.badge-success {
    background-color: #10b981;
    color: white;
}

.badge-warning {
    background-color: #f59f00;
    color: white;
}

.badge-info {
    background-color: #3b82f6;
    color: white;
}

.badge-secondary {
    background-color: #6c757d;
    color: white;
}
</style>

<script>
$('#statusModal').on('show.bs.modal', function(e) {
    var consultationId = $(e.relatedTarget).data('id');
    $('#statusForm').attr('action', '/admin/consultations/' + consultationId + '/status');
});
</script>
@endsection
