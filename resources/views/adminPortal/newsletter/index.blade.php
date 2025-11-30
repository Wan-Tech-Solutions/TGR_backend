@include('adminPortal.layout.header')

        <div class="container">
          <div class="page-inner">
            <div class="page-header">
              <ul class="breadcrumbs mb-3">
                <li class="nav-home">
                  <a href="{{url('/')}}">
                    <i class="icon-home"></i>
                  </a>
                </li>
                <li class="separator">
                  <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                  <a href="{{route('admin.home.dashboard')}}">Dashboard</a>
                </li>
                <li class="separator">
                  <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                  <a href="#">Newsletter</a>
                </li>
              </ul>
            </div>

            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-body">
                    @if(session('newsletter_sent'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>{{ session('newsletter_sent') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    @if(session('newsletter_admin_action'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>{{ session('newsletter_admin_action') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form id="newsletter-form" method="POST" action="{{ route('admin.newsletter.send') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Subject</label>
                            <input type="text" name="subject" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Message</label>
                            <textarea name="body" class="form-control" rows="6" required></textarea>
                        </div>
                      <div class="mb-3">
                        <label class="form-label">Reply-To (optional)</label>
                        <input type="email" name="reply_to" class="form-control" placeholder="reply@example.com">
                      </div>
                      <div class="mb-3">
                        <label class="form-label">Attachments (optional)</label>
                        <input type="file" name="attachments[]" class="form-control" multiple>
                        <small class="form-text text-muted">Allowed types: pdf, doc, docx, jpg, png, zip. Max 5MB each.</small>
                      </div>
                        <div class="mb-3">
                            <label class="form-label">Send To</label>
                            <select name="send_to" class="form-select mb-2">
                                <option value="all">All Subscribers</option>
                                <option value="selected">Selected Subscribers</option>
                            </select>
                        </div>
                        <div class="table-responsive">
                          <table class="display table table-striped table-hover">
                            <thead>
                              <tr>
                                <th><input type="checkbox" id="selectAll"></th>
                                <th>Email</th>
                                <th>Active</th>
                                <th>Subscribed On</th>
                              </tr>
                            </thead>
                            <tbody>
                              @foreach($subscribers as $sub)
                                <tr>
                                  <td><input type="checkbox" name="selected[]" value="{{ $sub->id }}" form="newsletter-form"></td>
                                  <td>{{ $sub->email }}</td>
                                  <td>{!! $sub->active ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-secondary">Unsubscribed</span>' !!}</td>
                                  <td>{{ $sub->created_at }}</td>
                                </tr>
                              @endforeach
                            </tbody>
                          </table>
                        </div>
                        
                        <button class="btn btn-primary mt-3" type="submit">Queue Newsletter</button>
                    </form>

                    <hr class="my-4">
                    
                    <h5 class="mb-3">Subscriber Actions</h5>
                    <div class="table-responsive">
                      <table class="display table table-striped table-hover">
                        <thead>
                          <tr>
                            <th>Email</th>
                            <th>Active</th>
                            <th>Subscribed On</th>
                            <th>Actions</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($subscribers as $sub)
                            <tr>
                              <td>{{ $sub->email }}</td>
                              <td>{!! $sub->active ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-secondary">Unsubscribed</span>' !!}</td>
                              <td>{{ $sub->created_at }}</td>
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

                    <div class="mt-3">
                        {{ $subscribers->links() }}
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

@include('adminPortal.layout.footer')

@push('scripts')
<script>
document.getElementById('selectAll')?.addEventListener('change', function(e){
    document.querySelectorAll('input[name="selected[]"]').forEach(function(cb){ cb.checked = e.target.checked; });
});
</script>
@endpush
