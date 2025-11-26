@include('adminPortal.layout.header')

<div class="container-fluid">
    <div class="page-inner">
        {{-- Title Section --}}
        <div class="page-header">
            <h4 class="page-title">Email Addresses Management</h4>
            <ul class="breadcrumbs">
                <li class="nav-home">
                    <a href="{{ route('dashboard') }}">
                        <i class="fas fa-home"></i>
                    </a>
                </li>
                <li class="separator">
                    <i class="fas fa-chevron-right"></i>
                </li>
                <li class="nav-item">
                    <a href="#">Email</a>
                </li>
                <li class="separator">
                    <i class="fas fa-chevron-right"></i>
                </li>
                <li class="nav-item">
                    <a href="#">Email Addresses</a>
                </li>
            </ul>
        </div>

        {{-- Alert Messages --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <strong>Success!</strong> {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <strong>Error!</strong> {{ session('error') }}
            </div>
        @endif

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="card-title">Active Email Addresses</h5>
                        <a href="{{ route('admin.email-addresses.create') }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus"></i> Add Email Address
                        </a>
                    </div>
                    <div class="card-body">
                        {{-- Search Form --}}
                        <div class="mb-3">
                            <form method="GET" class="d-flex gap-2">
                                <input type="text" name="search" class="form-control" 
                                       placeholder="Search by email or label..." 
                                       value="{{ $search ?? '' }}">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search"></i> Search
                                </button>
                                @if($search)
                                    <a href="{{ route('admin.email-addresses.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-times"></i> Clear
                                    </a>
                                @endif
                            </form>
                        </div>

                        {{-- Stats --}}
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <div class="alert alert-info mb-0">
                                    <strong>Total:</strong> {{ $emailAddresses->total() }}
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="alert alert-success mb-0">
                                    <strong>Active:</strong> {{ \App\Models\EmailAddress::active()->count() }}
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="alert alert-warning mb-0">
                                    <strong>Inactive:</strong> {{ \App\Models\EmailAddress::where('is_active', false)->count() }}
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="alert alert-primary mb-0">
                                    <strong>Auto-Sync:</strong> {{ \App\Models\EmailAddress::withAutoSync()->count() }}
                                </div>
                            </div>
                        </div>

                        {{-- Table --}}
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Email Address</th>
                                        <th>Label</th>
                                        <th>Status</th>
                                        <th>Auto-Sync</th>
                                        <th>Last Synced</th>
                                        <th>Emails Count</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($emailAddresses as $address)
                                        <tr>
                                            <td>
                                                <strong>{{ $address->email }}</strong>
                                            </td>
                                            <td>
                                                <span class="badge bg-secondary">{{ $address->label }}</span>
                                            </td>
                                            <td>
                                                @if($address->is_active)
                                                    <span class="badge bg-success">Active</span>
                                                @else
                                                    <span class="badge bg-danger">Inactive</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($address->auto_sync)
                                                    <span class="badge bg-primary">Enabled</span>
                                                @else
                                                    <span class="badge bg-secondary">Disabled</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($address->last_synced_at)
                                                    {{ $address->last_synced_at->format('M d, Y H:i') }}
                                                @else
                                                    <em class="text-muted">Never</em>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge bg-info">
                                                    {{ $address->incomingEmails()->count() }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('admin.email-addresses.edit', $address) }}" 
                                                       class="btn btn-sm btn-warning" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    
                                                    <form method="POST" 
                                                          action="{{ route('admin.email-addresses.toggle-active', $address) }}" 
                                                          style="display: inline;">
                                                        @csrf
                                                        <button type="submit" 
                                                                class="btn btn-sm {{ $address->is_active ? 'btn-secondary' : 'btn-success' }}"
                                                                title="{{ $address->is_active ? 'Deactivate' : 'Activate' }}">
                                                            <i class="fas {{ $address->is_active ? 'fa-ban' : 'fa-check' }}"></i>
                                                        </button>
                                                    </form>
                                                    
                                                    <form method="POST" 
                                                          action="{{ route('admin.email-addresses.toggle-auto-sync', $address) }}" 
                                                          style="display: inline;">
                                                        @csrf
                                                        <button type="submit" 
                                                                class="btn btn-sm {{ $address->auto_sync ? 'btn-primary' : 'btn-outline-primary' }}"
                                                                title="{{ $address->auto_sync ? 'Disable auto-sync' : 'Enable auto-sync' }}">
                                                            <i class="fas fa-sync"></i>
                                                        </button>
                                                    </form>
                                                    
                                                    <button type="button" 
                                                            class="btn btn-sm btn-danger" 
                                                            onclick="confirmDelete('{{ route('admin.email-addresses.destroy', $address) }}', '{{ $address->email }}')"
                                                            title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center text-muted">
                                                <em>No email addresses found. <a href="{{ route('admin.email-addresses.create') }}">Add one now</a></em>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        {{-- Pagination --}}
                        <nav aria-label="Page navigation">
                            {{ $emailAddresses->links('pagination::bootstrap-5') }}
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Delete Confirmation Modal --}}
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete the email address <strong id="deleteEmail"></strong>?</p>
                <p class="text-warning"><small>This action cannot be undone.</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete(actionUrl, email) {
    document.getElementById('deleteEmail').textContent = email;
    document.getElementById('deleteForm').action = actionUrl;
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}
</script>

@include('adminPortal.layout.footer')
