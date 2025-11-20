@extends('admin.layouts.admin_master')
@section('title')
    Purpose
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
                                <div class="dataTables_length" id="datatable-default_length"><label><select
                                            name="datatable-default_length" aria-controls="datatable-default"
                                            class="form-select form-select-sm select2-hidden-accessible" data-select2-id="1"
                                            tabindex="-1" aria-hidden="true">
                                            <option value="10" data-select2-id="3">10</option>
                                            <option value="25">25</option>
                                            <option value="50">50</option>
                                            <option value="100">100</option>
                                        </select><span class="select2 select2-container select2-container--bootstrap"
                                            dir="ltr" data-select2-id="2" style="width: 60px;"><span
                                                class="selection"><span class="select2-selection select2-selection--single"
                                                    role="combobox" aria-haspopup="true" aria-expanded="false"
                                                    tabindex="0" aria-disabled="false"
                                                    aria-labelledby="select2-datatable-default_length-x1-container"><span
                                                        class="select2-selection__rendered"
                                                        id="select2-datatable-default_length-x1-container" role="textbox"
                                                        aria-readonly="true" title="10">10</span><span
                                                        class="select2-selection__arrow" role="presentation"><b
                                                            role="presentation"></b></span></span></span><span
                                                class="dropdown-wrapper" aria-hidden="true"></span></span> records per
                                        page</label></div>
                            </div>
                            <div class="col-lg-6">
                                <div id="datatable-default_filter" class="dataTables_filter"><label><input type="search"
                                            class="form-control pull-right" placeholder="Search..."
                                            aria-controls="datatable-default"></label></div>
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
                                            style="width:15%;">Image</th>
                                        <th class="sorting" tabindex="0" aria-controls="datatable-default" rowspan="1"
                                            colspan="1" aria-label="Browser: activate to sort column ascending"
                                            style="width:70%;">Profile Description</th>
                                        <th class="sorting" tabindex="0" aria-controls="datatable-default" rowspan="1"
                                            colspan="1" aria-label="Platform(s): activate to sort column ascending"
                                            style="width:10%;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $key => $list)
                                        <tr role="row" class="odd">
                                            <td>{{ $key + 1 }}</td>
                                            <td>
                                                <img src="{{ !empty($list->image) ? asset($list->image) : asset('upload/user.jpeg') }}"
                                                    alt="" class="img-radius"height="200px" width="200px">
                                            </td>
                                            <td>{{ $list->founder_profile }}</td>
                                            <td>
                                                <a class="btn btn-primary btn-sm"
                                                    href="{{ route('site-edit-founder', ['uuid' => $list->uuid]) }}"><i
                                                        class="fas fa-pencil-alt"></i></a>
                                                <a class="btn btn-danger btn-sm"
                                                    href="{{ route('site-delete-founder', $list->uuid) }}"
                                                    title="Delete Data" id="delete"><i
                                                        class="far fa-trash-alt"></i></a>
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
