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

    <!-- start: page -->
    <form class="ecommerce-form action-buttons-fixed" action="{{ route('store-user') }}" method="post">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <section class="card card-modern card-big-info">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="name">User Name</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            placeholder="Enter Name">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="email">User Email</label>
                                        <input type="text" class="form-control" id="email" name="email"
                                            placeholder="Enter Email">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="password">Assign Roles</label>
                                    <select name="roles[]" id="roles" class="form-control select2" multiple>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->name }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">Save User</button>
                    </div>
                </section>
            </div>
        </div>

    </form>
@endsection
