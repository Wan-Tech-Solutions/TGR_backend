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
                  <a href="#">Audit Trails</a>
                </li>
              </ul>
            </div>
            <div class="row">
              
              <div class="col-md-12">
                <div class="card">
                  <div class="card-header">
                    <div class="d-flex align-items-center">
                      <h4 class="card-title">Audit Trails</h4>
                    </div>
                  </div>
                  <div class="card-body">

                    <div class="table-responsive">
                      <table
                        id="add-row"
                        class="display table table-striped table-hover"
                      >
                        <thead>
                          <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Event</th>
                            <th>URL</th>
                            <th>IP Address</th>
                            <th>Browser</th>
                            <th>Date/Time</th>
                          </tr>
                        </thead>
                        <tfoot>
                          <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Event</th>
                            <th>URL</th>
                            <th>IP Address</th>
                            <th>Browser</th>
                            <th>Date/Time</th>
                          </tr>
                        </tfoot>
                        <tbody>
                          @foreach($audits as $audit)
                          <tr>
                              <td>{{ $audit->user?->name ?? 'N/A' }}</td>
                              <td>{{ $audit->user?->email ?? 'N/A' }}</td>
                              <td>{{ $audit->event }}</td>
                              <td>{{ $audit->url }}</td>
                              <td>{{ $audit->ip_address }}</td>
                              <td>{{ $audit->user_agent }}</td>
                              <td>{{ $audit->created_at }}</td>
                          </tr>
                      @endforeach
                      
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        @include('adminPortal.layout.footer')
