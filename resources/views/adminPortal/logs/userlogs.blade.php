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
                  <a href="#">Log Activities</a>
                </li>
              </ul>
            </div>
            <div class="row">
              
              <div class="col-md-12">
                <div class="card">
                  <div class="card-header">
                    <div class="d-flex align-items-center">
                      <h4 class="card-title">Log Activities</h4>
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
                            <th>Activity</th>
                            <td>Date/Time</td>
                          </tr>
                        </thead>
                        <tfoot>
                          <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Activity</th>
                            <td>Date/Time</td>
                          </tr>
                        </tfoot>
                        <tbody>
                          @foreach($activity as $activity)
                          <tr>
                            <td>{{$activity->name }}</td>
                            <td>{{$activity->email }}</td>
                            <td>{{$activity->description }}</td>
                            <td>{{$activity->date_time }}</td>
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
