@extends('admin.layouts.admin_master')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="my-0">Newsletter Subscribers</h3>
        <div class="d-flex align-items-center">
            <form method="GET" action="{{ route('admin.newsletter.export') }}" class="d-flex align-items-center me-2">
                <label for="export_filter" class="me-2 mb-0">Export:</label>
                <select id="export_filter" name="active" class="form-select form-select-sm me-2" style="width:180px">
                    <option value="">All subscribers</option>
                    <option value="1">Active subscribers only</option>
                </select>
                <button type="submit" class="btn btn-outline-secondary btn-sm">Export CSV</button>
            </form>
            <a href="{{ route('admin.email.compose') }}" class="btn btn-primary">Compose Email</a>
        </div>
    </div>

    @if(session('newsletter_sent'))
        <div class="alert alert-success">{{ session('newsletter_sent') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.newsletter.send') }}">
        @csrf
        <div class="card mb-3">
            <div class="card-body">
                <div class="mb-2">
                    <label class="form-label">Subject</label>
                    <input type="text" name="subject" class="form-control" required>
                </div>
                <div class="mb-2">
                    <label class="form-label">Message</label>
                    <textarea name="body" class="form-control" rows="6" required></textarea>
                </div>
                <div class="mb-2">
                    <label class="form-label">Send To</label>
                    <select name="send_to" class="form-select mb-2">
                        <option value="all">All Subscribers</option>
                        <option value="selected">Selected Subscribers</option>
                    </select>
                </div>
                <button class="btn btn-primary" type="submit">Queue Newsletter</button>
            </div>
        </div>

        <div class="card">
            <div class="card-header">Subscriber List</div>
            <div class="card-body p-0">
                <table class="table table-striped mb-0">
                    <thead>
                        <tr>
                            <th style="width:40px"><input type="checkbox" id="selectAll"></th>
                            <th>Email</th>
                            <th>Active</th>
                            <th>Subscribed At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($subscribers as $sub)
                        <tr>
                            <td><input type="checkbox" name="selected[]" value="{{ $sub->id }}"></td>
                            <td>{{ $sub->email }}</td>
                            <td>{!! $sub->active ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-secondary">Unsubscribed</span>' !!}</td>
                            <td>{{ $sub->created_at->toDayDateTimeString() }}</td>
                            <td>
                                @if(!$sub->active)
                                    <form method="POST" action="{{ route('admin.newsletter.reactivate', $sub->id) }}" style="display:inline-block">
                                        @csrf
                                        <button class="btn btn-sm btn-success" type="submit">Reactivate</button>
                                    </form>
                                @else
                                    <form method="POST" action="{{ route('admin.newsletter.unsubscribe', $sub->id) }}" style="display:inline-block">
                                        @csrf
                                        <button class="btn btn-sm btn-warning" type="submit">Unsubscribe</button>
                                    </form>
                                @endif
                                <form method="POST" action="{{ route('admin.newsletter.delete', $sub->id) }}" style="display:inline-block" onsubmit="return confirm('Delete this subscriber?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" type="submit">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                {{ $subscribers->links() }}
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
document.getElementById('selectAll')?.addEventListener('change', function(e){
    document.querySelectorAll('input[name="selected[]"]').forEach(function(cb){ cb.checked = e.target.checked; });
});
</script>
@endpush

@endsection
