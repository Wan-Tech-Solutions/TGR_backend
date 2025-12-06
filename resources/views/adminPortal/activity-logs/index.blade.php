@include('adminPortal.layout.header')

<div class="container">
  <div class="page-inner">
    <!-- Page Header -->
    <div class="page-header">
      <h3 class="fw-bold mb-3">Activity Logs & Analytics</h3>
      <ul class="breadcrumbs mb-3">
        <li class="nav-home">
          <a href="{{ route('admin.home.dashboard') }}">
            <i class="icon-home"></i>
          </a>
        </li>
        <li class="separator">
          <i class="icon-arrow-right"></i>
        </li>
        <li class="nav-item">
          <a href="#">Analytics</a>
        </li>
        <li class="separator">
          <i class="icon-arrow-right"></i>
        </li>
        <li class="nav-item">
          <a href="#">Activity Logs</a>
        </li>
      </ul>
    </div>

    <!-- Stats Cards -->
    <div class="row">
      <div class="col-sm-6 col-md-3">
        <div class="card card-stats card-round">
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col-icon">
                <div class="icon-big text-center icon-primary bubble-shadow-small">
                  <i class="fas fa-chart-line"></i>
                </div>
              </div>
              <div class="col col-stats ms-3 ms-sm-0">
                <div class="numbers">
                  <p class="card-category">Total Activities</p>
                  <h4 class="card-title">{{ number_format($totalActivities) }}</h4>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-md-3">
        <div class="card card-stats card-round">
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col-icon">
                <div class="icon-big text-center icon-info bubble-shadow-small">
                  <i class="fas fa-users"></i>
                </div>
              </div>
              <div class="col col-stats ms-3 ms-sm-0">
                <div class="numbers">
                  <p class="card-category">Active Users</p>
                  <h4 class="card-title">{{ number_format($uniqueUsers) }}</h4>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-md-3">
        <div class="card card-stats card-round">
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col-icon">
                <div class="icon-big text-center icon-success bubble-shadow-small">
                  <i class="fas fa-clock"></i>
                </div>
              </div>
              <div class="col col-stats ms-3 ms-sm-0">
                <div class="numbers">
                  <p class="card-category">Period</p>
                  <h4 class="card-title">{{ $period }} Days</h4>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-md-3">
        <div class="card card-stats card-round">
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col-icon">
                <div class="icon-big text-center icon-secondary bubble-shadow-small">
                  <i class="fas fa-download"></i>
                </div>
              </div>
              <div class="col col-stats ms-3 ms-sm-0">
                <div class="numbers">
                  <p class="card-category">Export</p>
                  <a href="{{ route('admin.activity.export', ['period' => $period]) }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-file-csv"></i> CSV
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Charts Row -->
    <div class="row">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">
            <div class="card-title">Activity Timeline</div>
          </div>
          <div class="card-body">
            <div style="position: relative; height: 300px;">
              <canvas id="activityTimelineChart"></canvas>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card">
          <div class="card-header">
            <div class="card-title">Request Methods</div>
          </div>
          <div class="card-body">
            <div style="position: relative; height: 300px;">
              <canvas id="methodChart"></canvas>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            <div class="card-title">Top Activities</div>
            <p class="card-category">Most performed actions</p>
          </div>
          <div class="card-body pb-0" style="max-height: 400px; overflow-y: auto;">
            @foreach($topActivities as $activity)
            <div class="d-flex align-items-center mb-3">
              <div class="flex-1">
                <h6 class="mb-1">{{ $activity->description }}</h6>
                <div class="progress progress-sm">
                  <div class="progress-bar bg-primary" style="width: {{ ($activity->count / $topActivities->first()->count) * 100 }}%"></div>
                </div>
              </div>
              <span class="badge badge-primary ms-3">{{ number_format($activity->count) }}</span>
            </div>
            @endforeach
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            <div class="card-title">Most Active Users</div>
            <p class="card-category">Users by activity count</p>
          </div>
          <div class="card-body pb-0" style="max-height: 400px; overflow-y: auto;">
            @foreach($topUsers as $user)
            <div class="d-flex align-items-center mb-3">
              <div class="avatar avatar-online me-3">
                <span class="avatar-title rounded-circle border border-white bg-info text-white">
                  {{ strtoupper(substr($user->name, 0, 1)) }}
                </span>
              </div>
              <div class="flex-1">
                <h6 class="mb-0">{{ $user->name }}</h6>
                <small class="text-muted">{{ $user->email }}</small>
              </div>
              <span class="badge badge-success">{{ number_format($user->count) }}</span>
            </div>
            <div class="separator-dashed"></div>
            @endforeach
          </div>
        </div>
      </div>
    </div>

    <!-- Filters and Logs Table -->
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <div class="card-head-row">
              <div class="card-title">Activity Logs</div>
            </div>
          </div>
          <div class="card-body">
            <!-- Filters -->
            <form method="GET" action="{{ route('admin.activity.logs') }}" class="mb-4">
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label>Period</label>
                    <select name="period" class="form-select" onchange="this.form.submit()">
                      <option value="1" {{ $period == 1 ? 'selected' : '' }}>Last 24 Hours</option>
                      <option value="7" {{ $period == 7 ? 'selected' : '' }}>Last 7 Days</option>
                      <option value="30" {{ $period == 30 ? 'selected' : '' }}>Last 30 Days</option>
                      <option value="90" {{ $period == 90 ? 'selected' : '' }}>Last 90 Days</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-8">
                  <div class="form-group">
                    <label>Search</label>
                    <div class="input-group">
                      <input type="text" name="search" class="form-control" placeholder="Search by name, email, or activity..." value="{{ $search }}">
                      <button class="btn btn-primary" type="submit">
                        <i class="fas fa-search"></i> Search
                      </button>
                      @if($search)
                      <a href="{{ route('admin.activity.logs') }}?period={{ $period }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Clear
                      </a>
                      @endif
                    </div>
                  </div>
                </div>
              </div>
            </form>

            <!-- Table -->
            <div class="table-responsive">
              <table class="table table-hover table-striped">
                <thead>
                  <tr>
                    <th>User</th>
                    <th>Activity</th>
                    <th>Method</th>
                    <th>Path</th>
                    <th>IP Address</th>
                    <th>Date/Time</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($logs as $log)
                  <tr>
                    <td>
                      <div class="d-flex align-items-center">
                        <div class="avatar avatar-sm me-2">
                          <span class="avatar-title rounded-circle bg-primary text-white">
                            {{ strtoupper(substr($log->name ?? 'U', 0, 1)) }}
                          </span>
                        </div>
                        <div>
                          <strong>{{ $log->name }}</strong><br>
                          <small class="text-muted">{{ $log->email }}</small>
                        </div>
                      </div>
                    </td>
                    <td>{{ $log->description }}</td>
                    <td>
                      @if($log->method)
                      <span class="badge badge-{{ $log->method == 'GET' ? 'info' : ($log->method == 'POST' ? 'success' : ($log->method == 'DELETE' ? 'danger' : 'warning')) }}">
                        {{ $log->method }}
                      </span>
                      @else
                      <span class="text-muted">--</span>
                      @endif
                    </td>
                    <td>
                      <small class="text-muted">{{ Str::limit($log->path ?? '--', 30) }}</small>
                    </td>
                    <td>
                      <small class="text-muted">{{ $log->ip_address ?? '--' }}</small>
                    </td>
                    <td>
                      <small>{{ \Carbon\Carbon::parse($log->date_time)->format('M d, Y') }}</small><br>
                      <small class="text-muted">{{ \Carbon\Carbon::parse($log->date_time)->format('h:i A') }}</small>
                    </td>
                  </tr>
                  @empty
                  <tr>
                    <td colspan="6" class="text-center text-muted py-4">
                      <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                      No activity logs found
                    </td>
                  </tr>
                  @endforelse
                </tbody>
              </table>
            </div>

            <!-- Pagination -->
            <div class="mt-3">
              {{ $logs->appends(['period' => $period, 'search' => $search])->links() }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@push('page-scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
  // Activity Timeline Chart
  const timelineCtx = document.getElementById('activityTimelineChart');
  if (timelineCtx && window.Chart) {
    new Chart(timelineCtx, {
      type: 'line',
      data: {
        labels: @json($timelineLabels),
        datasets: [{
          label: 'Activities',
          data: @json($timelineCounts),
          backgroundColor: 'rgba(31, 58, 147, 0.1)',
          borderColor: '#1f3a93',
          borderWidth: 2,
          fill: true,
          tension: 0.4,
          pointBackgroundColor: '#1f3a93',
          pointBorderColor: '#fff',
          pointBorderWidth: 2,
          pointRadius: 4,
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: { display: false }
        },
        scales: {
          y: {
            beginAtZero: true,
            ticks: { precision: 0 }
          }
        }
      }
    });
  }

  // Request Methods Pie Chart
  const methodCtx = document.getElementById('methodChart');
  if (methodCtx && window.Chart) {
    const methodData = @json($byMethod);
    new Chart(methodCtx, {
      type: 'doughnut',
      data: {
        labels: methodData.map(m => m.method),
        datasets: [{
          data: methodData.map(m => m.count),
          backgroundColor: ['#1f3a93', '#f3ba2f', '#2ca58d', '#e74c3c', '#9b59b6'],
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: { position: 'bottom' }
        }
      }
    });
  }
});
</script>
@endpush

@include('adminPortal.layout.footer')
