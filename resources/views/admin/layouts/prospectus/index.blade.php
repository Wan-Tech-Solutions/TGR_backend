@extends('admin.layouts.admin_master')
@section('title')
    Prospectus
@endsection
@section('admin')
    <div class="row">
        <div class="col">
            <section class="card">
                <header class="card-header">
                    <div class="card-actions">
                        <a href="#" class="card-action card-action-toggle" data-card-toggle=""></a>
                        <a href="#" class="card-action card-action-dismiss" data-card-dismiss=""></a>
                    </div>
                    <h2 class="card-title">Purpose</h2>
                </header>
                <div class="card-body">
                    <div id="datatable-default_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                        <div class="row">


                            <div class="col-lg-6">
                                <div id="datatable-default_filter" class="dataTables_filter">
                                    <label>
                                        <a href="{{ route('add-prospectus') }}" class="btn btn-success"
                                            style="float:right;">Click Me</a>
                                    </label>
                                </div>
                            </div>

                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped mb-0 dataTable no-footer"
                                id="datatable-default" role="grid" style="width: 852px;">
                                <thead>
                                    <tr role="row">
                                        <th class="sorting_asc" tabindex="0" aria-controls="datatable-default"
                                            rowspan="1" colspan="1" aria-sort="ascending"
                                            aria-label="Rendering engine: activate to sort column descending"
                                            style="width:5%;">No.</th>
                                        <th class="sorting" tabindex="0" aria-controls="datatable-default" rowspan="1"
                                            colspan="1" aria-label="Browser: activate to sort column ascending"
                                            style="width:85%;">Purpose</th>
                                        <th class="sorting" tabindex="0" aria-controls="datatable-default" rowspan="1"
                                            colspan="1" aria-label="Platform(s): activate to sort column ascending"
                                            style="width:10%;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($prospectusFiles as $index => $file)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ basename($file->prospectus) }}</td>
                                            <td>
                                                {{-- <a href="{{ asset($file->prospectus) }}" class="btn btn-primary"
                                                    target="_blank">View</a>
                                                <!-- You can also add a download button if needed --> --}}
                                                <a href="{{ asset($file->prospectus) }}" class="btn btn-info"
                                                    download>Download</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
