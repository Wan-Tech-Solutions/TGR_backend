@extends('admin.layouts.admin_master')

@section('content')
<div class="container-fluid">
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="page-title">Consultation Details</h1>
                <div class="page-subtitle">Reference: {{ $consultation->uuid }}</div>
            </div>
            <div class="col-auto">
                <a href="{{ route('admin.consultations.index') }}" class="btn btn-secondary">Back to List</a>
            </div>
        </div>
    </div>
</div>

<div class="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <!-- Client Information -->
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <h3 class="card-title">Clientt Information</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm">
                            <tr>
                                <td><strong>Name:</strong></td>
                                <td>{{ $consultation->name }}</td>
                            </tr>
                            <tr>
                                <td><strong>Email:</strong></td>
                                <td><a href="mailto:{{ $consultation->email }}">{{ $consultation->email }}</a></td>
                            </tr>
                            <tr>
                                <td><strong>Phone:</strong></td>
                                <td>{{ $consultation->dial_code }} {{ $consultation->phone }}</td>
                            </tr>
                            <tr>
                                <td><strong>Nationality:</strong></td>
                                <td>{{ $consultation->nationality ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Country of Residence:</strong></td>
                                <td>{{ $consultation->country_of_residence }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Consultation Details -->
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <h3 class="card-title">Consultation Details</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm">
                            <tr>
                                <td><strong>Scheduled Date:</strong></td>
                                <td>{{ $consultation->scheduled_for?->format('l, M d, Y') ?? 'Not scheduled' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Consultation Hours:</strong></td>
                                <td>{{ $consultation->consultation_hours }} hours</td>
                            </tr>
                            <tr>
                                <td><strong>Quoted Amount:</strong></td>
                                <td>${{ number_format($consultation->quoted_amount / 100, 2) }}</td>
                            </tr>
                            <tr>
                                <td><strong>Status:</strong></td>
                                <td>
                                    <span class="badge badge-{{ $consultation->status === 'confirmed' ? 'success' : ($consultation->status === 'pending' ? 'warning' : 'secondary') }}">
                                        {{ ucfirst($consultation->status) }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Payment Status:</strong></td>
                                <td>
                                    <span class="badge badge-{{ $consultation->payment_status === 'paid' ? 'success' : ($consultation->payment_status === 'initiated' ? 'info' : 'warning') }}">
                                        {{ ucfirst($consultation->payment_status) }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Booked On:</strong></td>
                                <td>{{ $consultation->created_at->format('M d, Y \a\t H:i') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Assessment Results -->
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <h3 class="card-title">Self-Assessment Results</h3>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h5>Assessment Score</h5>
                                <div class="d-flex align-items-center">
                                    <div style="flex: 1;">
                                        <div class="progress" style="height: 30px;">
                                            <div class="progress-bar {{ $consultation->assessment_percentage >= 70 ? 'bg-success' : ($consultation->assessment_percentage >= 50 ? 'bg-warning' : 'bg-danger') }}" 
                                                 role="progressbar" 
                                                 style="width: {{ $consultation->assessment_percentage }}%"
                                                 aria-valuenow="{{ $consultation->assessment_percentage }}" 
                                                 aria-valuemin="0" 
                                                 aria-valuemax="100">
                                                {{ round($consultation->assessment_percentage, 2) }}%
                                            </div>
                                        </div>
                                    </div>
                                    <div style="margin-left: 1rem; text-align: right;">
                                        <strong>{{ $consultation->assessment_score }}/340</strong>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h5>Readiness Level</h5>
                                <p>
                                    @if($consultation->assessment_percentage >= 75)
                                        <span class="badge badge-success" style="font-size: 1rem; padding: 0.75rem 1.5rem;">
                                            <i class="fas fa-check-circle"></i> Highly Ready
                                        </span>
                                    @elseif($consultation->assessment_percentage >= 60)
                                        <span class="badge badge-info" style="font-size: 1rem; padding: 0.75rem 1.5rem;">
                                            <i class="fas fa-arrow-circle-up"></i> Moderately Ready
                                        </span>
                                    @elseif($consultation->assessment_percentage >= 40)
                                        <span class="badge badge-warning" style="font-size: 1rem; padding: 0.75rem 1.5rem;">
                                            <i class="fas fa-exclamation-circle"></i> Development Needed
                                        </span>
                                    @else
                                        <span class="badge badge-danger" style="font-size: 1rem; padding: 0.75rem 1.5rem;">
                                            <i class="fas fa-times-circle"></i> Significant Support Needed
                                        </span>
                                    @endif
                                </p>
                            </div>
                        </div>

                        <h5 class="mt-4 mb-3">Question-by-Question Responses</h5>
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th width="5%">#</th>
                                        <th width="75%">Question</th>
                                        <th width="20%" class="text-center">Response</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Information -->
        @if($consultation->payments->isNotEmpty())
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <h3 class="card-title">Payment Transactions</h3>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th>Reference</th>
                                    <th>Provider</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($consultation->payments as $payment)
                                    <tr>
                                        <td>{{ $payment->uuid }}</td>
                                        <td>{{ ucfirst($payment->provider) }}</td>
                                        <td>${{ number_format($payment->amount / 100, 2) }}</td>
                                        <td>
                                            <span class="badge badge-{{ $payment->status === 'paid' ? 'success' : ($payment->status === 'initialized' ? 'info' : 'warning') }}">
                                                {{ ucfirst($payment->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $payment->created_at->format('M d, Y H:i') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Actions -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Admin Actions</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.consultations.update-status', $consultation) }}" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="status">Update Status</label>
                                        <select name="status" id="status" class="form-control">
                                            <option value="pending" {{ $consultation->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="confirmed" {{ $consultation->status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                            <option value="completed" {{ $consultation->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                            <option value="cancelled" {{ $consultation->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-primary mt-4">Update Status</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.badge {
    padding: 0.5rem 0.75rem;
    font-weight: 600;
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

.badge-primary {
    background-color: #3b82f6;
    color: white;
}

.badge-secondary {
    background-color: #6c757d;
    color: white;
}

.badge-danger {
    background-color: #ef4444;
    color: white;
}
</style>
@endsection
