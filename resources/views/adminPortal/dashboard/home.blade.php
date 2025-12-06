@include('adminPortal.layout.header')

@push('styles')
<style>
  .dashboard-hero {
    background: linear-gradient(135deg, #fef2f2, #f8fafc);
    border: 1px solid #f3f4f6;
    border-radius: 14px;
    padding: 18px 20px;
    box-shadow: 0 12px 30px rgba(15, 23, 42, 0.08);
  }
  .stat-card {
    border: 1px solid #f3f4f6;
    border-radius: 12px;
    box-shadow: 0 10px 24px rgba(15, 23, 42, 0.05);
  }
  .stat-card .progress {
    height: 6px;
    border-radius: 8px;
    background: #f5f6f7;
  }
  .card-modern {
    border: 1px solid #f1f5f9;
    border-radius: 14px;
    box-shadow: 0 14px 32px rgba(15, 23, 42, 0.06);
  }
  .card-modern .card-header {
    border-bottom: 1px solid #f1f5f9;
    padding: 16px 18px;
  }
  .table-modern thead {
    background: #f8fafc;
  }
  .table-modern th, .table-modern td {
    vertical-align: middle;
  }
  .geo-filter input[type="date"] {
    min-width: 140px;
  }
</style>
@endpush

        <div class="container">
          <div class="page-inner">
            <div class="dashboard-hero d-flex align-items-left align-items-md-center flex-column flex-md-row mb-4">
              <div>
                @php
                    $hour = date('H');
                    if ($hour >= 5 && $hour < 12) {
                        $greeting = "Good Morning";
                    } elseif ($hour >= 12 && $hour < 18) {
                        $greeting = "Good Afternoon";
                    } else {
                        $greeting = "Good Evening";
                    }
                @endphp

                <h3 class="fw-bold mb-3">{{ $greeting }}, Super Admin</h3>

                <h6 class="op-7 mb-2">Welcome to the TGR Africa Dashboard</h6>
              </div>
              <div class="ms-md-auto py-2 py-md-0">
                <a href="{{route('admin.blogs')}}" class="btn btn-label-info btn-round me-2">News Portal</a>
                {{-- <a href="#" class="btn btn-primary btn-round">Report</a> --}}
              </div>
            </div>
            <div class="row row-card-no-pd">
              <div class="col-12 col-sm-6 col-md-6 col-xl-3">
                <div class="card stat-card card-modern">
                  <div class="card-body">
                    <div class="d-flex justify-content-between">
                      <div>
                        <h6><b>Blog Post</b></h6>
                        <p class="text-muted">Overall posted blogs</p>
                      </div>
                      <h4 class="text-info fw-bold">{{$count_blogs}}</h4>
                    </div>
                    <div class="progress progress-sm">
                      <div
                        class="progress-bar bg-info w-75"
                        role="progressbar"
                        aria-valuenow="{{$count_blogs}}"
                      ></div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-12 col-sm-6 col-md-6 col-xl-3">
                <div class="card stat-card card-modern">
                  <div class="card-body">
                    <div class="d-flex justify-content-between">
                      <div>
                        <h6><b>Contact Response</b></h6>
                        <p class="text-muted">Contact feedback</p>
                      </div>
                      <h4 class="text-success fw-bold">{{$contact_count}}</h4>
                    </div>
                    <div class="progress progress-sm">
                      <div
                        class="progress-bar bg-success w-25"
                        role="progressbar"
                        aria-valuenow="{{$contact_count}}"
                      ></div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-12 col-sm-6 col-md-6 col-xl-3">
                <div class="card stat-card card-modern">
                  <div class="card-body">
                    <div class="d-flex justify-content-between">
                      <div>
                        <h6><b>Prospectus</b></h6>
                        <p class="text-muted">Overall Prospectus</p>
                      </div>
                      <h4 class="text-danger fw-bold">{{$prospectus_count }}</h4>
                    </div>
                    <div class="progress progress-sm">
                      <div
                        class="progress-bar bg-danger w-50"
                        role="progressbar"
                        aria-valuenow="{{$prospectus_count }}"
                      ></div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-12 col-sm-6 col-md-6 col-xl-3">
                <div class="card stat-card card-modern">
                  <div class="card-body">
                    <div class="d-flex justify-content-between">
                      <div>
                        <h6><b>Consultations</b></h6>
                        <p class="text-muted">Overall Consultations</p>
                      </div>
                      <h4 class="text-secondary fw-bold">{{$consultation_count}}</h4>
                    </div>
                    <div class="progress progress-sm">
                      <div
                        class="progress-bar bg-secondary w-25"
                        role="progressbar"
                        aria-valuenow="{{$consultation_count}}"
                      ></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-8">
                <div class="card card-modern">
                  <div class="card-header">
                    <div class="card-head-row">
                      <div class="card-title">Traffic Summary</div>
                      <div class="card-tools">
                        <a
                          href="{{ route('admin.traffic.export.csv') }}"
                          class="btn btn-label-success btn-round btn-sm me-2"
                        >
                          <span class="btn-label">
                            <i class="fa fa-pencil"></i>
                          </span>
                          Export
                        </a>
                        <a href="#" class="btn btn-label-info btn-round btn-sm">
                          <span class="btn-label">
                            <i class="fa fa-print"></i>
                          </span>
                          Print
                        </a>
                      </div>
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="chart-container" style="min-height: 375px">
                      <canvas id="statisticsChart"></canvas>
                    </div>
                    <div id="myChartLegend"></div>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="card card-primary card-modern">
                  <div class="card-header">
                    <div class="card-head-row">
                      <div class="card-title">Upcoming Consultations</div>
                      <div class="card-tools">
                        <div class="dropdown">
                          <button
                            class="btn btn-sm btn-label-light dropdown-toggle"
                            type="button"
                            id="dropdownMenuButton"
                            data-bs-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false"
                          >
                            Export
                          </button>
                          <div
                            class="dropdown-menu"
                            aria-labelledby="dropdownMenuButton"
                          >
                            <a class="dropdown-item" href="{{ route('admin.consultations.export.csv') }}">Excel (CSV)</a>
                            <a class="dropdown-item" href="{{ route('admin.consultations.export.pdf') }}">PDF</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="card-category">
                      @foreach($consultation_dates as $consultation_dates)
                      <b>{{$consultation_dates->created_at}},</b>
                      @endforeach
                    </div>
                  </div>
                  <div class="card-body pb-0">
                    <div class="mb-4 mt-2">
                      <h1>{{$consultation_count}}</h1>
                    </div>
                    <div class="pull-in">
                      <canvas id="dailySalesChart"></canvas>
                    </div>
                  </div>
                </div>
                <div class="card card-modern">
                  <div class="card-header">
                    <div class="card-title">Users Online</div>
                    <p class="card-category mb-0">
                      <span class="badge badge-success">{{ $usersOnline ?? 0 }}</span> {{ $usersOnline == 1 ? 'user' : 'users' }} active now
                    </p>
                  </div>
                  <div class="card-body pb-2" style="max-height: 300px; overflow-y: auto;">
                    @php
                      $onlineUsers = $onlineUsersList ?? collect();
                    @endphp

                    @forelse($onlineUsers as $user)
                      @php
                        $lastActivity = \Carbon\Carbon::parse($user->last_activity);
                        $now = now();
                        $diffInSeconds = $now->diffInSeconds($lastActivity);

                        if ($diffInSeconds < 60) {
                          $timeOnline = 'Just now';
                        } elseif ($diffInSeconds < 120) {
                          $timeOnline = '1 min ago';
                        } elseif ($diffInSeconds < 3600) {
                          $timeOnline = floor($diffInSeconds / 60) . ' mins ago';
                        } else {
                          $timeOnline = floor($diffInSeconds / 3600) . ' hrs ago';
                        }
                      @endphp

                      <div class="d-flex align-items-center mb-3">
                        <div class="avatar avatar-online me-3">
                          <span class="avatar-title rounded-circle border border-white bg-success text-white">
                            {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
                          </span>
                        </div>
                        <div class="flex-1">
                          <h6 class="mb-0 fw-bold">{{ $user->name ?? 'Unknown User' }}</h6>
                          <small class="text-muted d-block">{{ $user->email }}</small>
                          <small class="text-success">
                            <i class="fas fa-circle" style="font-size: 8px;"></i> {{ $timeOnline }}
                          </small>
                        </div>
                      </div>
                      <div class="separator-dashed"></div>
                    @empty
                      <div class="text-center text-muted py-4">
                        <i class="fas fa-user-slash fa-2x mb-2"></i>
                        <p class="mb-0">No users currently online</p>
                      </div>
                    @endforelse
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-8">
                <div class="card card-modern">
                  <div class="card-header">
                    <div class="card-title">Page visits</div>
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <!-- Projects table -->
                      <table class="table align-items-center mb-0">
                        <thead class="thead-light">
                          <tr>
                            <th scope="col">Page name</th>
                            <th scope="col">Visitors</th>
                            <th scope="col">Unique users</th>
                            <th scope="col">Bounce rate</th>
                          </tr>
                        </thead>
                        <tbody>
                          @php
                            $pageRows = $pageVisits ?? collect();
                          @endphp

                          @forelse($pageRows as $row)
                            <tr>
                              <th scope="row">/{{ ltrim($row->path ?? 'unknown', '/') }}</th>
                              <td>{{ $row->visits }}</td>
                              <td>{{ $row->unique_users }}</td>
                              <td>
                                <i class="fas fa-minus text-muted me-2"></i>
                                --
                              </td>
                            </tr>
                          @empty
                            <tr>
                              <td colspan="4" class="text-center text-muted py-3">No page visit data yet</td>
                            </tr>
                          @endforelse
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="card card-modern">
                  <div class="card-header">
                    <div class="card-title">Top Blogs</div>
                  </div>
                  <div class="card-body pb-0">
                    @foreach($top_blog as $top_blog)
                    <div class="d-flex">
                      <div class="avatar">
                        <img
                          src="logo.png"
                          alt="..."
                          class="avatar-img rounded-circle"
                        />
                      </div>
                      <div class="flex-1 pt-1 ms-2">
                        <h6 class="fw-bold mb-1">{{$top_blog->title}}</h6>
                        <small class="text-muted">{{ Str::limit($top_blog->content, 10) }}</small>
                      </div>
                      <div class="d-flex ms-auto align-items-center">
                        <h4 class="text-info fw-bold">+0</h4>
                      </div>
                    </div>
                    <div class="separator-dashed"></div>
                    @endforeach
                  </div>
                </div>
              </div>
            </div>
            <div class="row row-card-no-pd">
              <div class="col-md-12">
                <div class="card card-modern">
          <div class="card-header">
            <div class="card-head-row card-tools-still-right">
              <h4 class="card-title">Geolocation Visits</h4>
              <div class="card-tools">
                <form method="GET" class="d-flex align-items-center gap-2">
                  <input type="date" name="geo_start" class="form-control form-control-sm" value="{{ request('geo_start') }}">
                  <input type="date" name="geo_end" class="form-control form-control-sm" value="{{ request('geo_end') }}">
                  <button type="submit" class="btn btn-sm btn-outline-primary">Filter</button>
                </form>
                <button
                  class="btn btn-icon btn-link btn-primary btn-xs"
                >
                  <span class="fa fa-angle-down"></span>
                </button>
                        <button
                          class="btn btn-icon btn-link btn-primary btn-xs btn-refresh-card"
                        >
                          <span class="fa fa-sync-alt"></span>
                        </button>
                        <button
                          class="btn btn-icon btn-link btn-primary btn-xs"
                        >
                          <span class="fa fa-times"></span>
                        </button>
                      </div>
                    </div>
                    <p class="card-category">
                      Map of the distribution of users around the world
                    </p>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="table-responsive table-hover table-sales">
                          <table class="table">
                            <tbody>
                              @php
                                  $geoData = $geoCountries ?? collect();
                                  $totalGeoVisits = $totalVisits ?? 0;
                              @endphp

                              @forelse($geoData as $country)
                                @php
                                    $code = strtolower($country->country_code ?? '');
                                    $flagUrl = $code ? "https://flagcdn.com/24x18/{$code}.png" : null;
                                    $percentage = $totalGeoVisits > 0 ? number_format(($country->total / $totalGeoVisits) * 100, 1) : 0;
                                @endphp
                                <tr>
                                  <td>
                                    @if($flagUrl)
                                      <div class="flag">
                                        <img src="{{ $flagUrl }}" alt="{{ $country->country_name ?? 'Unknown' }} flag" onerror="this.style.display='none';" />
                                      </div>
                                    @endif
                                  </td>
                                  <td>{{ $country->country_name ?? 'Unknown' }}</td>
                                  <td class="text-end">{{ $country->total }}</td>
                                  <td class="text-end">{{ $percentage }}%</td>
                                </tr>
                              @empty
                                <tr>
                                  <td colspan="4" class="text-muted text-center">No visitor data yet</td>
                                </tr>
                              @endforelse
                            </tbody>
                          </table>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="mapcontainer">
                          <div
                            id="world-map"
                            class="w-100"
                            style="height: 300px"
                          ></div>
                        </div>
                      </div>
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
      // Traffic summary chart
      const statsCtx = document.getElementById('statisticsChart');
      if (statsCtx && window.Chart) {
        const labels = @json($trafficLabels ?? []);
        const visits = @json($trafficVisits ?? []);
        const uniques = @json($trafficUnique ?? []);

        new Chart(statsCtx, {
          type: 'line',
          data: {
            labels,
            datasets: [
              {
                label: 'Visits',
                data: visits,
                backgroundColor: 'rgba(239,68,68,0.12)',
                borderColor: '#ef4444',
                pointBackgroundColor: '#ef4444',
                borderWidth: 2,
                tension: 0.35
              },
              {
                label: 'Unique Users',
                data: uniques,
                backgroundColor: 'rgba(59,130,246,0.12)',
                borderColor: '#3b82f6',
                pointBackgroundColor: '#3b82f6',
                borderWidth: 2,
                tension: 0.35
              }
            ]
          },
          options: {
            responsive: true,
            plugins: {
              legend: { display: true, position: 'top' },
              tooltip: { mode: 'index', intersect: false }
            },
            interaction: { mode: 'nearest', intersect: false },
            scales: {
              y: { beginAtZero: true, ticks: { precision: 0 } }
            }
          }
        });
      }

      const countrySeries = @json($countrySeries ?? []);
      const mapEl = document.querySelector('#world-map');

    if (!mapEl || typeof jsVectorMap === 'undefined') {
      return;
    }

    const hasData = Object.keys(countrySeries || {}).length > 0;

    if (!hasData) {
      mapEl.innerHTML = '<div class="text-muted text-center py-4">No visitor data yet</div>';
      return;
    }

    mapEl.innerHTML = '';

    new jsVectorMap({
      selector: '#world-map',
      map: 'world',
      zoomOnScroll: false,
      regionStyle: {
        initial: { fill: '#e5e7eb' },
        hover: { fill: '#435ebe' },
      },
      series: {
        regions: [{
          values: countrySeries,
          scale: ['#c7d2fe', '#1d4ed8'],
          normalizeFunction: 'polynomial',
        }],
      },
      onRegionTooltipShow(event, tooltip, code) {
        const total = countrySeries[code] || 0;
        tooltip.css({ backgroundColor: '#435ebe', color: '#fff' });
        tooltip.text(`${tooltip.text()} — ${total} visit${total === 1 ? '' : 's'}`);
      },
    });
  });
  </script>
  @endpush

          @include('adminPortal.layout.footer')
