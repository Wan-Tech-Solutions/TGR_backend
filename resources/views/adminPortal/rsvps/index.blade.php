@include('adminPortal.layout.header')

<div class="container">
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-3">
            <div>
                <h3 class="fw-bold mb-2">RSVP Responses</h3>
                <h6 class="op-7 mb-0">Track attendance responses across all events</h6>
            </div>
        </div>

        <style>
            /* Compact, rounded KPI icons */
            .card-stats .icon-big {
                width: 52px;
                height: 52px;
                border-radius: 14px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                font-size: 22px;
            }

            .card-stats .bubble-shadow-small {
                box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
            }
        </style>

        <div class="row mb-4 g-3">
            <div class="col-md-3 col-sm-6">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center bg-primary bubble-shadow-small">
                                    <i class="fas fa-list text-white"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Total</p>
                                    <h4 class="card-title">{{ $stats['total'] ?? 0 }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center bg-success bubble-shadow-small">
                                    <i class="fas fa-check text-white"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Yes</p>
                                    <h4 class="card-title">{{ $stats['yes'] ?? 0 }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center bg-warning bubble-shadow-small">
                                    <i class="fas fa-question text-white"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Maybe</p>
                                    <h4 class="card-title">{{ $stats['maybe'] ?? 0 }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center bg-danger bubble-shadow-small">
                                    <i class="fas fa-times text-white"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">No</p>
                                    <h4 class="card-title">{{ $stats['no'] ?? 0 }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" class="row g-3 align-items-end">
                    <div class="col-md-5">
                        <label class="form-label">Search (email or event title)</label>
                        <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="john@example.com or event name">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Response</label>
                        <select name="response" class="form-select">
                            <option value="">All</option>
                            <option value="yes" {{ request('response')==='yes' ? 'selected' : '' }}>Yes</option>
                            <option value="maybe" {{ request('response')==='maybe' ? 'selected' : '' }}>Maybe</option>
                            <option value="no" {{ request('response')==='no' ? 'selected' : '' }}>No</option>
                        </select>
                    </div>
                    <div class="col-md-4 d-flex gap-2">
                        <button type="submit" class="btn btn-primary mt-4">Filter</button>
                        <a href="{{ route('admin.rsvps') }}" class="btn btn-outline-secondary mt-4">Reset</a>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 22%">Event</th>
                                <th style="width: 14%">Date & Time</th>
                                <th style="width: 18%">Email</th>
                                <th style="width: 10%">Response</th>
                                <th style="width: 20%">Message</th>
                                <th style="width: 16%">Responded</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($rsvps as $rsvp)
                                <tr>
                                    <td>
                                        <div class="fw-semibold">{{ $rsvp->event->event_title ?? '—' }}</div>
                                        <div class="text-muted small">ID: {{ $rsvp->event_id }}</div>
                                    </td>
                                    <td>
                                        @if($rsvp->event)
                                            <div>{{ \Carbon\Carbon::parse($rsvp->event->event_date)->format('M d, Y') }}</div>
                                            <div class="text-muted small">{{ \Carbon\Carbon::parse($rsvp->event->event_time)->format('g:i A') }}</div>
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                    <td>{{ $rsvp->email }}</td>
                                    <td>
                                        <span class="badge bg-{{ $rsvp->response === 'yes' ? 'success' : ($rsvp->response === 'maybe' ? 'warning text-dark' : 'danger') }} text-uppercase">{{ $rsvp->response }}</span>
                                    </td>
                                    <td style="max-width: 240px;">
                                        <div class="text-truncate" title="{{ $rsvp->message }}">{{ $rsvp->message ?? '—' }}</div>
                                    </td>
                                    <td>
                                        <div>{{ $rsvp->responded_at?->format('M d, Y g:i A') ?? '—' }}</div>
                                        <div class="text-muted small">{{ $rsvp->created_at->diffForHumans() }}</div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">No RSVP responses yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($rsvps->hasPages())
                <div class="card-footer">
                    {{ $rsvps->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

@include('adminPortal.layout.footer')
