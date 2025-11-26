@include('adminPortal.layout.header')

<div class="container-fluid px-4">
  <div class="page-inner py-4">
    
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="{{url('/')}}" class="text-muted text-decoration-none">
            <i class="fas fa-home me-1"></i> Home
          </a>
        </li>
        <li class="breadcrumb-item">
          <a href="{{route('admin.home.dashboard')}}" class="text-muted text-decoration-none">Dashboard</a>
        </li>
        <li class="breadcrumb-item">
          <a href="{{route('admin.consultations')}}" class="text-muted text-decoration-none">Consultations</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Rebook Reminders</li>
      </ol>
    </nav>

    <!-- Header Section -->
    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-start align-items-lg-center mb-5">
      <div class="mb-3 mb-lg-0">
        <h1 class="h2 fw-bold text-dark mb-2">Rebook Reminders Tracking</h1>
        <p class="text-muted mb-0">Monitor pending reminders and sent rebook notifications</p>
      </div>
      <div class="d-flex flex-wrap gap-2">
        <span class="badge bg-light text-dark border px-3 py-2">
          <span class="badge-dot bg-warning me-1"></span>
          Pending: {{ $pendingCount }}
        </span>
        <span class="badge bg-light text-dark border px-3 py-2">
          <span class="badge-dot bg-success me-1"></span>
          Sent: {{ $sentCount }}
        </span>
        <span class="badge bg-light text-dark border px-3 py-2">
          <span class="badge-dot bg-danger me-1"></span>
          Failed: {{ $failedCount }}
        </span>
      </div>
    </div>

    @if (session('success'))
      <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
        <i class="fas fa-check-circle me-2"></i>
        <div>{{ session('success') }}</div>
        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    @if (session('error'))
      <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>
        <div>{{ session('error') }}</div>
        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    <!-- Pending Reminders Section -->
    <div class="card border-0 shadow-sm mb-5">
      <div class="card-header bg-white border-0 pt-4 px-4">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3">
          <div class="mb-2 mb-md-0">
            <h5 class="card-title fw-bold text-dark mb-1">Consultations Awaiting Rebook Reminder</h5>
            <p class="text-muted small mb-0">Past consultations eligible for rebook reminders (max 2 per client)</p>
          </div>
        </div>
      </div>
      <div class="card-body px-0 pb-0">
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
              <tr>
                <th class="ps-4">Client</th>
                <th>Email</th>
                <th>Scheduled Date</th>
                <th>Reminders Sent</th>
                <th>Status</th>
                <th class="text-end pe-4">Actions</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($pendingReminders as $consultation)
                <tr>
                  <td class="ps-4">
                    <div class="d-flex align-items-center">
                      <div class="avatar bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-3 fw-bold" style="width: 40px; height: 40px;">
                        {{ substr($consultation->name, 0, 1) }}
                      </div>
                      <div>
                        <div class="fw-semibold text-dark">{{ $consultation->name }}</div>
                      </div>
                    </div>
                  </td>
                  <td>
                    <a href="mailto:{{ $consultation->email }}" class="text-primary text-decoration-none">{{ $consultation->email }}</a>
                  </td>
                  <td>
                    <div class="text-dark fw-medium">{{ $consultation->scheduled_for->format('M j, Y') }}</div>
                    <div class="text-muted small">{{ $consultation->scheduled_for->diffForHumans() }}</div>
                  </td>
                  <td>
                    <span class="badge bg-info text-white rounded-pill">{{ $consultation->rebook_count ?? 0 }}/2</span>
                  </td>
                  <td>
                    <span class="badge bg-warning text-dark rounded-pill px-3">Pending</span>
                  </td>
                  <td class="text-end pe-4">
                    <div class="dropdown">
                      <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Actions
                      </button>
                      <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                          <a class="dropdown-item d-flex align-items-center" href="{{ route('admin.consultations.show', $consultation->id) }}">
                            <i class="fas fa-eye text-primary me-2"></i> View Details
                          </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                          <form action="{{ route('admin.consultations.send-rebook', $consultation->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="dropdown-item d-flex align-items-center text-warning" onclick="return confirm('Send rebook reminder to {{ $consultation->email }}?')">
                              <i class="fas fa-paper-plane me-2"></i> Send Reminder Now
                            </button>
                          </form>
                        </li>
                      </ul>
                    </div>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="6" class="text-center text-muted py-5">
                    <i class="fas fa-inbox fa-2x mb-3"></i>
                    <p class="mb-0">No pending rebook reminders at this time.</p>
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Sent Reminders History Section -->
    <div class="card border-0 shadow-sm">
      <div class="card-header bg-white border-0 pt-4 px-4">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3">
          <div class="mb-2 mb-md-0">
            <h5 class="card-title fw-bold text-dark mb-1">Rebook Reminder Email History</h5>
            <p class="text-muted small mb-0">All sent and failed rebook reminder notifications</p>
          </div>
        </div>
      </div>
      <div class="card-body px-0 pb-0">
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
              <tr>
                <th class="ps-4">Client</th>
                <th>Email Address</th>
                <th>Sent Date & Time</th>
                <th>Status</th>
                <th>Sent By</th>
                <th class="text-end pe-4">Details</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($rebookLogs as $log)
                <tr>
                  <td class="ps-4">
                    <div class="d-flex align-items-center">
                      <div class="avatar bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-3 fw-bold" style="width: 40px; height: 40px;">
                        {{ substr($log->consultation->name, 0, 1) }}
                      </div>
                      <div>
                        <div class="fw-semibold text-dark">{{ $log->consultation->name }}</div>
                      </div>
                    </div>
                  </td>
                  <td>
                    <a href="mailto:{{ $log->email }}" class="text-primary text-decoration-none">{{ $log->email }}</a>
                  </td>
                  <td>
                    <div class="text-dark fw-medium">{{ $log->sent_at->format('M j, Y') }}</div>
                    <div class="text-muted small">{{ $log->sent_at->format('g:i A') }}</div>
                  </td>
                  <td>
                    @if($log->status === 'sent')
                      <span class="badge bg-success text-white rounded-pill px-3">
                        <i class="fas fa-check me-1"></i> Sent
                      </span>
                    @elseif($log->status === 'failed')
                      <span class="badge bg-danger text-white rounded-pill px-3">
                        <i class="fas fa-times me-1"></i> Failed
                      </span>
                    @else
                      <span class="badge bg-secondary text-white rounded-pill px-3">{{ ucfirst($log->status) }}</span>
                    @endif
                  </td>
                  <td>
                    <span class="text-dark fw-medium">{{ $log->sent_by }}</span>
                  </td>
                  <td class="text-end pe-4">
                    @if($log->error_message)
                      <button class="btn btn-sm btn-outline-danger" data-bs-toggle="popover" data-bs-trigger="hover focus" title="Error Details" data-bs-content="{{ $log->error_message }}">
                        <i class="fas fa-exclamation-triangle me-1"></i> Error
                      </button>
                    @else
                      <span class="text-muted small">-</span>
                    @endif
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="6" class="text-center text-muted py-5">
                    <i class="fas fa-history fa-2x mb-3"></i>
                    <p class="mb-0">No rebook reminder emails sent yet.</p>
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
      <div class="card-footer bg-white border-0 py-3 px-4">
        {{ $rebookLogs->links('pagination::bootstrap-4') }}
      </div>
    </div>
  </div>
</div>

<style>
  .badge-dot {
    display: inline-block;
    width: 8px;
    height: 8px;
    border-radius: 50%;
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

  .dropdown-toggle::after {
    margin-left: 0.5rem;
  }
</style>

<script>
  // Initialize popovers for error messages
  document.addEventListener('DOMContentLoaded', function() {
    const popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    popoverTriggerList.map(function (popoverTriggerEl) {
      return new bootstrap.Popover(popoverTriggerEl);
    });
  });
</script>

@include('adminPortal.layout.footer')
