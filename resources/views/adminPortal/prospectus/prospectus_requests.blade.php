@include('adminPortal.layout.header')

<div class="container">
    <div class="page-inner">
        <!-- Breadcrumbs -->
        <div class="page-header">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h2 class="text-dark font-weight-bold mb-0">Prospectus Requests</h2>
                    <p class="text-muted mb-0">Manage all prospectus download requests</p>
                </div>
                <ul class="breadcrumbs">
                    <li class="nav-home">
                        <a href="{{url('/')}}">
                            <i class="icon-home text-primary"></i>
                        </a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right text-muted"></i>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('admin.home.dashboard')}}" class="text-primary">Dashboard</a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right text-muted"></i>
                    </li>
                    <li class="nav-item">
                        <span class="text-muted">Prospectus Requests</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="icon-box bg-primary bg-gradient">
                                <i class="fas fa-envelope text-white"></i>
                            </div>
                            <div class="ml-3">
                                <h3 class="mb-0">{{ $prospectus_request->count() }}</h3>
                                <p class="text-muted mb-0">Total Requests</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="icon-box bg-success bg-gradient">
                                <i class="fas fa-calendar-day text-white"></i>
                            </div>
                            <div class="ml-3">
                                <h3 class="mb-0">{{ $prospectus_request->filter(function($item) { return $item->created_at->isToday(); })->count() }}</h3>
                                <p class="text-muted mb-0">Today</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="icon-box bg-info bg-gradient">
                                <i class="fas fa-calendar-week text-white"></i>
                            </div>
                            <div class="ml-3">
                                <h3 class="mb-0">{{ $prospectus_request->filter(function($item) { return $item->created_at->isCurrentWeek(); })->count() }}</h3>
                                <p class="text-muted mb-0">This Week</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="icon-box bg-warning bg-gradient">
                                <i class="fas fa-download text-white"></i>
                            </div>
                            <div class="ml-3">
                                <h3 class="mb-0">{{ $prospectus_request->whereNotNull('downloaded_at')->count() }}</h3>
                                <p class="text-muted mb-0">Downloaded</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Card -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center justify-content-between">
                            <h4 class="card-title">All Prospectus Requests</h4>
                            <div class="d-flex gap-2">
                                <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#filterModal">
                                    <i class="fas fa-filter"></i> Filter
                                </button>
                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addRequestModal">
                                    <i class="fas fa-plus"></i> Add Request
                                </button>
                                <button class="btn btn-success btn-sm" id="exportBtn">
                                    <i class="fas fa-file-export"></i> Export
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Filter Modal -->
                        <div class="modal fade" id="filterModal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Filter Requests</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label">Date Range</label>
                                            <div class="input-daterange input-group" id="dateRangePicker">
                                                <input type="text" class="form-control" name="start" placeholder="Start Date">
                                                <span class="input-group-text">to</span>
                                                <input type="text" class="form-control" name="end" placeholder="End Date">
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Country</label>
                                            <input type="text" class="form-control" id="countryFilter" placeholder="Filter by country">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Status</label>
                                            <select class="form-select" id="statusFilter">
                                                <option value="">All Status</option>
                                                <option value="pending">Pending</option>
                                                <option value="contacted">Contacted</option>
                                                <option value="completed">Completed</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button type="button" class="btn btn-primary" id="applyFilter">Apply Filter</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Add Request Modal -->
                        <div class="modal fade" id="addRequestModal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header bg-gradient-primary">
                                        <h5 class="modal-title text-white">Add New Prospectus Request</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form id="addRequestForm">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-12 mb-3">
                                                    <label class="form-label required">Email Address</label>
                                                    <input type="email" class="form-control" name="email" placeholder="Enter email address" required>
                                                </div>
                                                <div class="col-md-12 mb-3">
                                                    <label class="form-label">Country (Auto Detected)</label>
                                                    <input type="text" class="form-control" name="country" placeholder="Enter country">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-primary">Add Request</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Requests Table -->
                        <div class="table-responsive">
                            <table id="prospectusRequestsTable" class="display table table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>
                                            <input type="checkbox" id="selectAll" class="form-check-input">
                                        </th>
                                        <th>Email</th>
                                        <th>Country</th>
                                        <th>Requested On</th>
                                        <th>Status</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($prospectus_request as $request)
                                    <tr data-id="{{ $request->id }}">
                                        <td>
                                            <input type="checkbox" class="form-check-input row-checkbox">
                                        </td>
                                        <td>
                                            <div>
                                                <h6 class="mb-0">{{ $request->email }}</h6>
                                                <small class="text-muted">ID: {{ $request->id }}</small>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="country-cell text-muted" data-id="{{ $request->id }}">
                                                {{ $request->country ?? 'Not specified' }}
                                            </span>
                                        </td>
                                        <td>
                                            <div>
                                                <div class="fw-medium">{{ $request->created_at->format('M d, Y') }}</div>
                                                <small class="text-muted">{{ $request->created_at->format('h:i A') }}</small>
                                            </div>
                                        </td>
                                        <td>
                                            @php
                                                $status = $request->status ?? 'pending';
                                                $statusColors = [
                                                    'pending' => 'warning',
                                                    'contacted' => 'info',
                                                    'completed' => 'success'
                                                ];
                                                $statusLabels = [
                                                    'pending' => 'Pending',
                                                    'contacted' => 'Contacted',
                                                    'completed' => 'Completed'
                                                ];
                                            @endphp
                                            <span class="badge bg-{{ $statusColors[$status] }} bg-gradient">
                                                <i class="fas fa-circle me-1" style="font-size: 8px;"></i>
                                                {{ $statusLabels[$status] }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center gap-1">
                                                <button class="btn btn-sm btn-outline-info btn-action" 
                                                        data-bs-toggle="tooltip" 
                                                        title="Send Prospectus"
                                                        onclick="sendProspectus({{ $request->id }})">
                                                    <i class="fas fa-paper-plane"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-danger btn-action" 
                                                        data-bs-toggle="tooltip" 
                                                        title="Delete Request"
                                                        onclick="deleteRequest({{ $request->id }})">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Bulk Actions -->
                        <div class="mt-3 d-flex align-items-center justify-content-between" id="bulkActions" style="display: none !important;">
                            <div class="d-flex align-items-center gap-2">
                                <span id="selectedCount">0</span> requests selected
                                <select class="form-select form-select-sm w-auto" id="bulkActionSelect">
                                    <option value="">Bulk Actions</option>
                                    <option value="contacted">Mark as Contacted</option>
                                    <option value="completed">Mark as Completed</option>
                                    <option value="delete">Delete Selected</option>
                                </select>
                                <button class="btn btn-sm btn-primary" id="applyBulkAction">Apply</button>
                            </div>
                            <button class="btn btn-sm btn-outline-secondary" id="clearSelection">Clear Selection</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card-stats .icon-box {
        width: 50px;
        height: 50px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }
    
    .bg-gradient {
        background: linear-gradient(45deg, transparent 0%, rgba(255,255,255,0.1) 100%);
    }
    
    .bg-gradient-primary {
        background: linear-gradient(45deg, var(--primary), #6c63ff) !important;
    }
    
    .avatar {
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
    }
    
    .btn-action {
        width: 32px;
        height: 32px;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 6px;
        transition: all 0.3s ease;
    }
    
    .btn-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    
    .badge.bg-gradient {
        background-image: linear-gradient(45deg, transparent 0%, rgba(255,255,255,0.2) 100%);
    }
    
    .required::after {
        content: " *";
        color: #dc3545;
    }
    
    #bulkActions {
        padding: 12px 20px;
        background: #f8f9fa;
        border-radius: 8px;
        border: 1px solid #dee2e6;
    }
    
    table.dataTable tbody tr.selected {
        background-color: rgba(108, 99, 255, 0.1) !important;
    }
    
    .form-check-input:checked {
        background-color: var(--primary);
        border-color: var(--primary);
    }
</style>

<script>
    // Ensure jQuery is loaded before running
    if (typeof jQuery !== 'undefined') {
        jQuery(document).ready(function($) {
            // Initialize DataTable
            const table = $('#prospectusRequestsTable').DataTable({
                pageLength: 25,
                order: [[3, 'desc']],
                language: {
                    search: "",
                    searchPlaceholder: "Search requests...",
                    lengthMenu: "Show _MENU_ entries"
                },
                dom: '<"top"<"d-flex justify-content-between align-items-center"f<"ms-3"l>>>rt<"bottom"<"d-flex justify-content-between align-items-center"ip>>',
                columnDefs: [
                    { orderable: false, targets: [0, 5] }
                ]
            });
            
            // Initialize date picker
            $('#dateRangePicker').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true
            });
            
            // Tooltip initialization
            $('[data-bs-toggle="tooltip"]').tooltip();
            
            // Apply filter functionality
            $('#applyFilter').on('click', function() {
                const startDate = $('input[name="start"]').val();
                const endDate = $('input[name="end"]').val();
                const country = $('#countryFilter').val().toLowerCase();
                const status = $('#statusFilter').val();
                
                $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
                    // data[2] is the Country column
                    // data[3] is the Date column
                    // data[4] is the Status column
                    
                    const rowCountry = data[2].toLowerCase();
                    const rowDate = data[3];
                    const rowStatus = data[4];
                    
                    // Filter by country
                    if (country && !rowCountry.includes(country)) {
                        return false;
                    }
                    
                    // Filter by status
                    if (status) {
                        const statusCell = $(rowStatus);
                        const statusValue = statusCell.text().toLowerCase().trim();
                        if (!statusValue.includes(status)) {
                            return false;
                        }
                    }
                    
                    // Filter by date range
                    if (startDate || endDate) {
                        const dateMatch = rowDate.match(/([A-Za-z]+\s+\d+,\s+\d+)/);
                        if (dateMatch) {
                            const rowDateObj = new Date(dateMatch[1]);
                            const start = startDate ? new Date(startDate) : null;
                            const end = endDate ? new Date(endDate) : null;
                            
                            if (start && rowDateObj < start) return false;
                            if (end && rowDateObj > end) return false;
                        }
                    }
                    
                    return true;
                });
                
                table.draw();
                $('#filterModal').modal('hide');
            });
            
            // Select all functionality
            $('#selectAll').on('change', function() {
                const isChecked = $(this).is(':checked');
                $('.row-checkbox').prop('checked', isChecked).trigger('change');
                updateBulkActions();
            });
            
            // Row checkbox functionality
            $('.row-checkbox').on('change', function() {
                const row = $(this).closest('tr');
                if ($(this).is(':checked')) {
                    row.addClass('selected');
                } else {
                    row.removeClass('selected');
                    $('#selectAll').prop('checked', false);
                }
                updateBulkActions();
            });
            
            // Update bulk actions
            function updateBulkActions() {
                const selectedCount = $('.row-checkbox:checked').length;
                if (selectedCount > 0) {
                    $('#bulkActions').show();
                    $('#selectedCount').text(selectedCount);
                } else {
                    $('#bulkActions').hide();
                }
            }
            
            // Clear selection
            $('#clearSelection').on('click', function() {
                $('.row-checkbox').prop('checked', false).trigger('change');
            });
            
            // Apply bulk action
            $('#applyBulkAction').on('click', function() {
                const action = $('#bulkActionSelect').val();
                const selectedIds = [];
                
                $('.row-checkbox:checked').each(function() {
                    selectedIds.push($(this).closest('tr').data('id'));
                });
                
                if (action && selectedIds.length > 0) {
                    if (confirm(`Are you sure you want to ${action} ${selectedIds.length} request(s)?`)) {
                        $.ajax({
                            url: '{{ route("admin.prospectus.bulk-action") }}',
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                action: action,
                                ids: selectedIds
                            },
                            success: function(response) {
                                if (response.success) {
                                    alert('Action completed successfully');
                                    location.reload();
                                } else {
                                    alert('Error: ' + response.message);
                                }
                            },
                            error: function() {
                                alert('Error performing bulk action');
                            }
                        });
                    }
                }
            });
            
            // Export functionality
            $('#exportBtn').on('click', function() {
                window.location.href = '{{ route("admin.prospectus.export") }}';
            });
            
            // Form submission
            $('#addRequestForm').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: '{{ route("admin.prospectus.store") }}',
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response.success) {
                            alert('Prospectus request added successfully');
                            $('#addRequestModal').modal('hide');
                            location.reload();
                        } else {
                            alert('Error: ' + response.message);
                        }
                    },
                    error: function() {
                        alert('Error adding prospectus request');
                    }
                });
            });
        });
    } else {
        console.warn('jQuery not loaded');
    }
    
    // View request details
    function viewRequest(id) {
        if (typeof $ === 'undefined') return;
        $.ajax({
            url: `/admin-prospectus-requests/${id}`,
            type: 'GET',
            success: function(response) {
                if (response.success) {
                    const data = response.data;
                    alert(`
Email: ${data.email}
Country: ${data.country || 'Not specified'}
Status: ${data.status}
Requested: ${data.created_at}
                    `);
                }
            },
            error: function() {
                alert('Error loading request details');
            }
        });
    }
    
    
    
    // Update request status (not used currently)
    function updateStatus(id, status) {
        if (typeof $ === 'undefined') return;
        if (confirm(`Mark this request as ${status}?`)) {
            $.ajax({
                url: `/admin-prospectus-requests/${id}/status`,
                type: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
                data: JSON.stringify({ status: status }),
                success: function(response) {
                    if (response.success) {
                        alert('Status updated successfully');
                        location.reload();
                    } else {
                        alert('Error: ' + response.message);
                    }
                },
                error: function() {
                    alert('Error updating status');
                }
            });
        }
    }
    
    // Send prospectus
    function sendProspectus(id) {
        if (typeof $ === 'undefined') {
            fetch(`/admin-prospectus-requests/${id}/send`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            })
            .then(r => r.json())
            .then(response => {
                if (response.success) {
                    alert(response.message || 'Prospectus sent successfully');
                    setTimeout(() => location.reload(), 500);
                } else {
                    alert('Error: ' + (response.message || 'Unknown error'));
                }
            })
            .catch(() => alert('Failed to send prospectus'));
            return;
        }
        
        if (confirm('Send prospectus to this email?')) {
            $.ajax({
                url: `/admin-prospectus-requests/${id}/send`,
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
                success: function(response) {
                    if (response.success) {
                        alert(response.message || 'Prospectus sent successfully');
                        // Reload page to show updated status
                        setTimeout(function() {
                            location.reload();
                        }, 500);
                    } else {
                        alert('Error: ' + (response.message || 'Unknown error'));
                    }
                },
                error: function(xhr) {
                    const response = xhr.responseJSON;
                    alert('Error: ' + (response?.message || 'Failed to send prospectus'));
                }
            });
        }
    }
    
    // Delete request
    function deleteRequest(id) {
        if (typeof $ === 'undefined') {
            fetch(`/admin-prospectus-requests/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            })
            .then(r => r.json())
            .then(response => {
                if (response.success) {
                    alert('Request deleted successfully');
                    location.reload();
                } else {
                    alert('Error: ' + response.message);
                }
            })
            .catch(() => alert('Error deleting request'));
            return;
        }
        
        if (confirm('Are you sure you want to delete this request?')) {
            $.ajax({
                url: `/admin-prospectus-requests/${id}`,
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
                success: function(response) {
                    if (response.success) {
                        alert('Request deleted successfully');
                        location.reload();
                    } else {
                        alert('Error: ' + response.message);
                    }
                },
                error: function() {
                    alert('Error deleting request');
                }
            });
        }
    }
    
    // Auto-detect country for records showing "Detecting..."
    function autoDetectCountry() {
        if (typeof $ === 'undefined') {
            console.warn('jQuery not loaded, skipping country detection');
            return;
        }
        
        $('.country-cell').each(function() {
            const cell = $(this);
            const id = cell.data('id');
            const currentText = cell.text().trim();
            
            if (currentText === 'Detecting...' || currentText === '') {
                fetch(`/prospectus-request/${id}/detect-country`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.country) {
                            cell.text(data.country);
                        } else {
                            cell.text('Unknown');
                        }
                    })
                    .catch(error => {
                        console.error('Country detection error:', error);
                        cell.text('Unknown');
                    });
            }
        });
    }
    
    // Run auto-detection on page load (using native JavaScript to avoid jQuery dependency)
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(autoDetectCountry, 500);
            // Retry every 5 seconds for any still-detecting entries
            setInterval(autoDetectCountry, 5000);
        });
    } else {
        setTimeout(autoDetectCountry, 500);
        // Retry every 5 seconds for any still-detecting entries
        setInterval(autoDetectCountry, 5000);
    }
</script>

@include('adminPortal.layout.footer')