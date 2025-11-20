@extends('admin.layouts.admin_master')
@section('title')
Users
@endsection
@section('admin')
<header class="page-header page-header-left-inline-breadcrumb">
    <h2 class="font-weight-bold text-6">Users</h2>
    <div class="right-wrapper">
        <ol class="breadcrumbs">
            <li><span>Home</span></li>
            <li><span>Users</span></li>
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
                                <a href="{{ route('create-user') }}" class="btn btn-success btn-md font-weight-semibold btn-py-2 px-4">+ Add User</a>
                            </div>
                            <div class="col-8 col-lg-auto ms-auto ml-auto mb-3 mb-lg-0">
                                <div class="d-flex align-items-lg-center flex-column flex-lg-row">
                                    <label class="ws-nowrap me-3 mb-0">Filter By:</label>
                                    <select class="form-control select-style-1 filter-by" name="filter-by">
                                        <option value="all" selected>All</option>
                                        <option value="1">ID</option>
                                        <option value="2">Sur Name</option>
                                        <option value="3">Slug</option>
                                        <option value="4">Last name</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-4 col-lg-auto ps-lg-1 mb-3 mb-lg-0">
                                <div class="d-flex align-items-lg-center flex-column flex-lg-row">
                                    <label class="ws-nowrap me-3 mb-0">Show:</label>
                                    <select class="form-control select-style-1 results-per-page" name="results-per-page">
                                        <option value="12" selected>12</option>
                                        <option value="24">24</option>
                                        <option value="36">36</option>
                                        <option value="100">100</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-lg-auto ps-lg-1">
                                <div class="search search-style-1 search-style-1-lg mx-lg-auto">
                                    <div class="input-group">
                                        <input type="text" class="search-term form-control" name="search-term" id="search-term" placeholder="Search Category">
                                        <button class="btn btn-default" type="submit"><i class="bx bx-search"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <table class="table table-ecommerce-simple table-striped mb-0" id="datatable-ecommerce-list" style="min-width: 550px;">
                        <thead>
                            <tr>
                                <th width="5%">ID</th>
                                <th width="10%">Name</th>
                                <th width="10%">Email</th>
                                <th width="10%">Code</th>
                                <th width="10%">Status</th>
                                <th width="15%">Roles</th>
                                <th width="15%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->code }}</td>
                                <td>
                                    @if ($user->status == 0)
                                    <a href="{{ route('user.inactive', $user->id) }}" class="badge badge-danger sm" title="Inactive" id="InactiveBtn">-Inactive</a>
                                    @elseif ($user->status == 1)
                                    <a href="{{ route('user.active', $user->id) }}" class="badge badge-success sm" title="Active" id="ActiveBtn">
                                        - Active</a>
                                    @endif
                                </td>
                                <td>
                                    @foreach ($user->roles as $role)
                                    <span class="badge badge-info mr-1">
                                        {{ $role->name }}
                                    </span>
                                    @endforeach
                                </td>

                                <td>

                                    <a class="badge badge-success text-white" href="{{ route('edit-user', $user->uuid) }}">Edit</a>

                                    @if (Auth::guard('web')->user()->can('superadmin.delete'))
                                    <a class="badge badge-danger text-white" id="delete" href="{{ route('destroy-user', $user->uuid) }}">
                                        Delete
                                    </a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <hr class="solid mt-5 opacity-4">
                    <div class="datatable-footer">
                        <div class="row align-items-center justify-content-between mt-3">

                            <div class="col-lg-auto text-center order-3 order-lg-2">
                                <div class="results-info-wrapper"></div>
                            </div>
                            <div class="col-lg-auto order-2 order-lg-3 mb-3 mb-lg-0">
                                <div class="pagination-wrapper"></div>
                            </div>
                        </div>
                    </div>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection