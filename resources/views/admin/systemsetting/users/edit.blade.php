@extends('admin.layouts.admin_master')
@section('title')
    Users
@endsection
@section('admin')
    <header class="page-header page-header-left-inline-breadcrumb">
        <h2 class="font-weight-bold text-6">Product Name</h2>
        <div class="right-wrapper">
            <ol class="breadcrumbs">
                <li><span>Home</span></li>
                <li><span>eCommerce</span></li>
                <li><span>Products</span></li>
            </ol>
            <a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fas fa-chevron-left"></i></a>
        </div>
    </header>

    <form class="ecommerce-form action-buttons-fixed" action="{{ route('update-user') }}" method="POST">
        @csrf
        <input type="hidden" name="uuid" value="{{ $user->uuid }}">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Edit User - {{ $user->name }}</h4>
                        @include('admin.systemsetting.users.part.message')
                        {{-- <form action="{{ route('update-user') }}" method="POST">
                            @csrf --}}

                        <div class="form-row">
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="name">User Name</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    placeholder="Enter Name" value="{{ $user->name }}">
                            </div>
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="email">User Email</label>
                                <input type="text" class="form-control" id="email" name="email"
                                    placeholder="Enter Email" value="{{ $user->email }}">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="password">Assign Roles</label>
                                <select name="roles[]" id="roles" class="form-control select2" multiple>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->name }}"
                                            {{ $user->hasRole($role->name) ? 'selected' : '' }}>{{ $role->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">Save User</button>
                        {{-- </form> --}}
                    </div>
                </div>
            </div>
        </div>

    </form>
    <!-- end: page -->
@endsection
