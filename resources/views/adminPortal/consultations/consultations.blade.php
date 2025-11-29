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
        <li class="breadcrumb-item active" aria-current="page">Consultation Bookings</li>
      </ol>
    </nav>

    <!-- Header Section -->
    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-start align-items-lg-center mb-5">
      <div class="mb-3 mb-lg-0">
        <h1 class="h2 fw-bold text-dark mb-2">Consultation Performance</h1>
        <p class="text-muted mb-0">Monitor bookings, revenue, and engagement metrics</p>
      </div>
      <div class="d-flex flex-wrap gap-2 align-items-center">
        <span class="badge bg-light text-dark border px-3 py-2">
          <span class="badge-dot bg-warning me-1"></span>
          Pending: {{ $pending_consultations }}
        </span>
        <span class="badge bg-light text-dark border px-3 py-2">
          <span class="badge-dot bg-success me-1"></span>
          Confirmed: {{ $confirmed_consultations }}
        </span>
        <span class="badge bg-light text-dark border px-3 py-2">
          <span class="badge-dot bg-primary me-1"></span>
          Completed: {{ $completed_consultations }}
        </span>
        <span class="badge bg-light text-dark border px-3 py-2">
          <span class="badge-dot bg-danger me-1"></span>
          Cancelled: {{ $cancelled_consultations }}
        </span>
        <a href="{{ route('admin.consultations.rebook-reminders') }}" class="btn btn-sm btn-outline-primary d-flex align-items-center">
          <i class="fas fa-redo me-2"></i> Rebook Reminders
        </a>
      </div>
    </div>

    <!-- Analytics Cards -->
    <div class="row g-4 mb-5">
      <div class="col-md-6 col-xl-3">
        <div class="card card-statistic h-100 border-0 shadow-sm">
          <div class="card-body p-4">
            <div class="d-flex align-items-center">
              <div class="statistic-icon bg-primary bg-opacity-10 text-primary rounded-2 p-3 me-3">
                <i class="fas fa-calendar-check fa-lg text-white"></i>
              </div>
              <div>
                <p class="text-muted text-uppercase small fw-semibold mb-1">Total Bookings</p>
                <h3 class="fw-bold text-dark mb-0">{{ number_format($total_consultations) }}</h3>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-xl-3">
        <div class="card card-statistic h-100 border-0 shadow-sm">
          <div class="card-body p-4">
            <div class="d-flex align-items-center">
              <div class="statistic-icon bg-success bg-opacity-10 text-success rounded-2 p-3 me-3">
                <i class="fas fa-check-circle fa-lg text-white"></i>
              </div>
              <div>
                <p class="text-muted text-uppercase small fw-semibold mb-1">Confirmed</p>
                <h3 class="fw-bold text-success mb-0">{{ number_format($confirmed_consultations) }}</h3>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-xl-3">
        <div class="card card-statistic h-100 border-0 shadow-sm">
          <div class="card-body p-4">
            <div class="d-flex align-items-center">
              <div class="statistic-icon bg-info bg-opacity-10 text-info rounded-2 p-3 me-3">
                <i class="fas fa-clock fa-lg text-white"></i>
              </div>
              <div>
                <p class="text-muted text-uppercase small fw-semibold mb-1">Upcoming</p>
                <h3 class="fw-bold text-primary mb-0">{{ number_format($pending_consultations) }}</h3>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-xl-3">
        <div class="card card-statistic h-100 border-0 shadow-sm">
          <div class="card-body p-4">
            <div class="d-flex align-items-center">
              <div class="statistic-icon bg-warning bg-opacity-10 text-warning rounded-2 p-3 me-3">
                <i class="fas fa-dollar-sign fa-lg text-white"></i>
              </div>
              <div>
                <p class="text-muted text-uppercase small fw-semibold mb-1">Revenue (USD)</p>
                <h3 class="fw-bold text-dark mb-0">${{ number_format($revenue / 100, 2) }}</h3>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Trends and Countries Section -->
    <div class="row g-4 mb-5">
      <div class="col-lg-6">
        <div class="card border-0 shadow-sm h-100">
          <div class="card-header bg-white border-0 pb-0 pt-4 px-4">
            <h5 class="card-title fw-bold text-dark mb-1">Bookings Trend (Last 6 Months)</h5>
            <p class="text-muted small mb-0">Monthly consultation volume</p>
          </div>
          <div class="card-body px-4 pb-4">
            @if ($monthlyBookings->isEmpty())
              <div class="text-center py-5">
                <i class="fas fa-chart-line fa-2x text-muted mb-3"></i>
                <p class="text-muted mb-0">No consultation bookings recorded yet.</p>
              </div>
            @else
              <div class="trend-chart">
                @foreach ($monthlyBookings as $monthData)
                  <div class="trend-item d-flex align-items-center mb-3">
                    <div class="flex-grow-1">
                      <div class="d-flex justify-content-between mb-1">
                        <span class="fw-medium">{{ Carbon\Carbon::createFromFormat('Y-m', $monthData->month)->format('M Y') }}</span>
                        <span class="fw-bold text-dark">{{ $monthData->total }}</span>
                      </div>
                      <div class="progress" style="height: 8px;">
                        @php
                          $maxValue = $monthlyBookings->max('total');
                          $percentage = $maxValue > 0 ? ($monthData->total / $maxValue) * 100 : 0;
                        @endphp
                        <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $percentage }}%" 
                             aria-valuenow="{{ $monthData->total }}" aria-valuemin="0" aria-valuemax="{{ $maxValue }}"></div>
                      </div>
                    </div>
                  </div>
                @endforeach
              </div>
            @endif
          </div>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="card border-0 shadow-sm h-100">
          <div class="card-header bg-white border-0 pb-0 pt-4 px-4">
            <h5 class="card-title fw-bold text-dark mb-1">Top Countries of Residence</h5>
            <p class="text-muted small mb-0">Client geographic distribution</p>
          </div>
          <div class="card-body px-4 pb-4">
            @if ($topCountries->isEmpty())
              <div class="text-center py-5">
                <i class="fas fa-globe-americas fa-2x text-muted mb-3"></i>
                <p class="text-muted mb-0">Bookings by country will appear here once data is available.</p>
              </div>
            @else
              <ul class="list-unstyled mb-0">
                @foreach ($topCountries as $country)
                  <li class="d-flex align-items-center justify-content-between py-2 border-bottom">
                    <div class="d-flex align-items-center">
                      <span class="flag-icon me-2">🌍</span>
                      <span class="fw-medium">{{ $country->country ?: 'Unknown' }}</span>
                    </div>
                    <span class="badge bg-dark rounded-pill px-3">{{ $country->total }}</span>
                  </li>
                @endforeach
              </ul>
            @endif
          </div>
        </div>
      </div>
    </div>

    <!-- Filtering Section -->
    <div class="card border-0 shadow-sm mb-5">
      <div class="card-header bg-white border-0 pb-0 pt-4 px-4">
        <h5 class="card-title fw-bold text-dark mb-1">Filter Consultations</h5>
        <p class="text-muted small mb-0">Refine results by specific criteria</p>
      </div>
      <form method="GET" action="{{ route('admin.consultations') }}">
        <div class="card-body px-4 pb-4">
          <div class="row g-3">
            <div class="col-md-3">
              <label for="search" class="form-label fw-semibold text-muted text-uppercase small">Search Client</label>
              <div class="input-group">
                <span class="input-group-text bg-light border-end-0"><i class="fas fa-search text-muted"></i></span>
                <input type="text" name="search" id="search" class="form-control border-start-0" 
                       placeholder="Name, email, or phone" 
                       value="{{ $filters['search'] ?? '' }}">
              </div>
            </div>
            <div class="col-md-2">
              <label for="status" class="form-label fw-semibold text-muted text-uppercase small">Status</label>
              <select name="status" id="status" class="form-select">
                <option value="">All Statuses</option>
                @foreach (['pending', 'confirmed', 'completed', 'cancelled'] as $statusOption)
                  <option value="{{ $statusOption }}" @selected(($filters['status'] ?? '') === $statusOption)>
                    {{ ucfirst($statusOption) }}
                  </option>
                @endforeach
              </select>
            </div>
            <div class="col-md-2">
              <label for="payment_status" class="form-label fw-semibold text-muted text-uppercase small">Payment</label>
              <select name="payment_status" id="payment_status" class="form-select">
                <option value="">All Payments</option>
                @foreach (['unpaid', 'pending', 'paid'] as $paymentOption)
                  <option value="{{ $paymentOption }}" @selected(($filters['payment_status'] ?? '') === $paymentOption)>
                    {{ ucfirst($paymentOption) }}
                  </option>
                @endforeach
              </select>
            </div>
            <div class="col-md-3 d-flex align-items-end gap-2">
              <button type="submit" class="btn btn-primary flex-fill d-flex align-items-center justify-content-center">
                <i class="fas fa-filter me-2"></i> Apply Filters
              </button>
              <a href="{{ route('admin.consultations') }}" class="btn btn-outline-secondary d-flex align-items-center justify-content-center">
                <i class="fas fa-redo me-2"></i> Reset
              </a>
            </div>
          </div>
        </div>
      </form>
    </div>

    @if (session('success'))
      <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
        <i class="fas fa-check-circle me-2"></i>
        <div>{{ session('success') }}</div>
        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    <!-- Recent Consultations Table -->
    <div class="card border-0 shadow-sm">
      <div class="card-header bg-white border-0 pt-4 px-4">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3">
          <div class="mb-2 mb-md-0">
            <h5 class="card-title fw-bold text-dark mb-1">Recent Consultations</h5>
            <p class="text-muted small mb-0">Latest activity across the pipeline</p>
          </div>
          <div class="d-flex align-items-center">
            <span class="badge bg-light text-dark border px-3 py-2">
              <i class="fas fa-clock me-1 text-primary"></i>
              Avg Duration: {{ number_format($averageHours, 1) }} hrs
            </span>
          </div>
        </div>
      </div>
      <div class="card-body px-0 pb-0">
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
              <tr>
                <th class="ps-4">Client</th>
                <th>Status</th>
                <th>Payment</th>
                <th>Country</th>
                <th>Booked Date</th>
                <th class="text-end pe-4">Actions</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($consultation as $item)
                @php
                  $latestPayment = $item->payments->first();
                @endphp
                <tr>
                  <td class="ps-4">
                    <div class="d-flex align-items-center">
                      <div class="avatar bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                        {{ substr($item->name, 0, 1) }}
                      </div>
                      <div>
                        <div class="fw-semibold text-dark">{{ $item->name }}</div>
                        <div class="text-muted small">{{ $item->email }}</div>
                        <div class="text-muted small">{{ $item->dial_code }} {{ $item->phone }}</div>
                      </div>
                    </div>
                  </td>
                  <td>
                    <span class="badge rounded-pill py-2 px-3 text-uppercase fw-semibold text-white
                      @if($item->status === 'pending') bg-warning
                      @elseif($item->status === 'confirmed') bg-success
                      @elseif($item->status === 'completed') bg-info
                      @elseif($item->status === 'cancelled') bg-danger
                      @else bg-secondary @endif">
                      {{ $item->status }}
                    </span>
                  </td>
                  <td>
                    <div class="d-flex flex-column">
                      <span class="badge rounded-pill py-2 px-3 mb-1 text-white
                        @if($item->payment_status === 'paid') bg-success
                        @elseif(in_array($item->payment_status, ['pending', 'unpaid'])) bg-warning
                        @elseif($item->payment_status === 'failed') bg-danger
                        @else bg-secondary @endif">
                        {{ $item->payment_status ?? 'unpaid' }}
                      </span>
                      <small class="text-dark fw-semibold">${{ number_format(($latestPayment->amount ?? 0) / 100, 2) }}</small>
                    </div>
                  </td>
                  <td>
                    <div class="d-flex align-items-center">
                      <span class="flag-icon me-2">🌍</span>
                      <span>{{ $item->country_of_residence ?: 'Unknown' }}</span>
                    </div>
                  </td>
                  <td>
                    <div class="text-dark fw-medium">{{ $item->created_at->format('M j, Y') }}</div>
                    <div class="text-muted small">{{ $item->created_at->format('g:i A') }}</div>
                  </td>
                  <td class="text-end pe-4">
                    <div class="dropdown">
                      <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Actions
                      </button>
                      <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                          <a class="dropdown-item d-flex align-items-center" href="{{ route('admin.consultations.show', $item->id) }}">
                            <i class="fas fa-eye text-primary me-2"></i> View Details
                          </a>
                        </li>
                        @php
                          $canSendRebook = $item->scheduled_for && \Carbon\Carbon::parse($item->scheduled_for)->startOfDay()->lte(\Carbon\Carbon::now()->startOfDay()) && ($item->rebook_count ?? 0) < 2;
                        @endphp
                        @if ($canSendRebook)
                          <li><hr class="dropdown-divider"></li>
                          <li>
                            <form action="{{ route('admin.consultations.send-rebook', $item->id) }}" method="POST" class="d-inline">
                              @csrf
                              <button type="submit" class="dropdown-item d-flex align-items-center" onclick="return confirm('Send rebook reminder to {{ $item->email }}?')">
                                <i class="fas fa-redo text-warning me-2"></i> Send Rebook
                              </button>
                            </form>
                          </li>
                        @endif
                      </ul>
                    </div>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="7" class="text-center text-muted py-5">
                    <i class="fas fa-inbox fa-2x mb-3"></i>
                    <p class="mb-0">No consultations match the current filters.</p>
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
      <div class="card-footer bg-white border-0 py-3 px-4">
        {{ $consultation->links('pagination::bootstrap-4') }}
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

.card-statistic .statistic-icon {
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

.trend-chart .progress {
  background-color: #f0f0f0;
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

@include('adminPortal.layout.footer')