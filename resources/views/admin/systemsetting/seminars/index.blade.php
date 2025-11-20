@extends('admin.layouts.admin_master')
@section('title')
Seminars
@endsection
@section('admin')
<header class="page-header page-header-left-inline-breadcrumb">
    <h2 class="font-weight-bold text-6">All Seminar Videos</h2>
    <div class="right-wrapper">
        <ol class="breadcrumbs">
            <li><span>Home</span></li>
            <li><span>Seminar</span></li>
        </ol>
        <a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fas fa-chevron-left"></i></a>
    </div>
</header>
<div class="row">
    <div class="col">
        <div class="card card-modern">
            <div class="card-body">
                <div class="datatables-header-footer-wrapper mt-2">
                    <div class="datatable-header">
                        <div class="row align-items-center mb-3">
                            <div class="col-12 col-lg-auto mb-3 mb-lg-0">
                                <a href="{{ route('tgr-seminars-add') }}" class="btn btn-success btn-md font-weight-semibold btn-py-2 px-4">+ Add Seminar</a>
                            </div>

                        </div>
                    </div>
                    <table class="table table-ecommerce-simple table-striped mb-0" id="datatable-ecommerce-list" style="min-width: 550px;">
                        <thead>
                            <tr>
                                <th width="5%">ID</th>
                                <th width="10%">Title</th>
                                <th width="60%">Description</th>
                                <th width="20%">Vidoe</th>
                                <th width="5%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($all_seminars_vidoes as $seminar)
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td>{{ $seminar->title }}</td>
                                <td>{{ $seminar->description }}</td>
                                <td><video width="120" height="120" controls>
                                        <source src="{{ asset($seminar->video) }}" type="video/mp4">
                                </td>
                                <td>
                                    <a class="badge badge-danger text-white" id="delete" href="{{ route('seminar-video-delete', $seminar->uuid) }}">
                                        Delete
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection