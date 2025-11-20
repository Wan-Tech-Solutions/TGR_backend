@extends('admin.layouts.admin_master')
@section('title')
    Users
@endsection
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <header class="page-header">
        <h2>User Profile</h2>
        <div class="right-wrapper text-end">
            <ol class="breadcrumbs">
                <li>
                    <a href="index.html">
                        <i class="bx bx-home-alt"></i>
                    </a>
                </li>
                <li><span>Pages</span></li>
                <li><span>User Profile</span></li>
            </ol>
            <a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fas fa-chevron-left"></i></a>
        </div>
    </header>

    <div class="row">
        <div class="col-lg-4 col-xl-3 mb-4 mb-xl-0">
            <form method="POST" action="{{ route('profile.store') }}" enctype="multipart/form-data">
                @csrf
                <section class="card">
                    <div class="card-body">
                        <div class="thumb-info mb-3">
                            <img id="showImage"
                                src="{{ !empty($editData->profile_photo_path) ? asset($editData->profile_photo_path) : asset('upload/user.jpeg') }}"
                                class="rounded img-fluid">
                            <div class="thumb-info-title">
                                <span class="thumb-info-inner">{{ Auth::user()->name }}</span>
                            </div>
                        </div>
                        <div class="widget-toggle-expand mb-3">
                            <div class="widget-header">
                                <h5 class="mb-2 font-weight-semibold text-dark">Profile Completion</h5>
                                <div class="widget-toggle">+</div>
                                <input type="file" name="profile_photo_path" class="form-control" id="image">
                            </div>
                            <div class="widget-content-collapsed">
                                <div class="progress progress-xs light">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0"
                                        aria-valuemax="100" style="width: 100%;">
                                        100%
                                    </div>
                                </div>
                            </div>
                            <div class="widget-content-expanded">
                                <ul class="simple-todo-list mt-3">
                                    <li class="completed">Name: <b>{{ $editData->name }}</b></li>
                                    <li class="completed">Gender: <b>{{ $editData->gender }}</b></li>
                                    <li class="completed">Email: <b>{{ $editData->email }}</b></li>
                                    <li class="completed">Status: @if ($editData->status == 1)
                                            <span class="badge badge-success">ACTIVE</span>
                                        @endif
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </section>
        </div>
        <div class="col-lg-8 col-xl-9">
            <div class="tabs">
                <ul class="nav nav-tabs tabs-primary">
                    <li class="nav-item">
                        <button class="nav-link" data-bs-target="#edit" data-bs-toggle="tab">Edit</button>
                    </li>
                </ul>
                <div class="tab-content">
                    <div id="edit" class="tab-pane active">
                        <h4 class="mb-3 font-weight-semibold text-dark">Personal Information</h4>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="inputCity">Name</label>
                                <input type="text" class="form-control" name="name" value="{{ $editData->name }}"
                                    id="inputCity">
                            </div>
                            <div class="form-group col-md-4 border-top-0 pt-0">
                                <label for="inputState">Gender</label>
                                <select id="inputState" class="form-control" name="gender">
                                    <option selected>Choose...</option>
                                    <option value="Male" {{ $editData->gender == 'MALE' ? 'selected' : '' }}>MALE
                                    </option>
                                    <option value="Female" {{ $editData->gender == 'FEMALE' ? 'selected' : '' }}>
                                        FEMALE</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4 border-top-0 pt-0">
                                <label for="inputZip">Email</label>
                                <input type="email" class="form-control" name="email" value="{{ $editData->email }}"
                                    id="inputZip">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-end mt-3">
                                <button class="btn btn-primary modal-confirm">Save</button>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#image').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#showImage').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });
        });
    </script>
@endsection
