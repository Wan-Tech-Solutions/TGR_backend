@extends('admin.layouts.admin_master')
@section('title', 'Blogs')
@section('admin')
<div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
  <div class="card-body px-4 py-3">
    <div class="row align-items-center">
      <div class="col-9"> <!-- Adjusted width for breadcrumb -->
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb mb-0"> <!-- Remove margin-bottom -->
            <li class="breadcrumb-item">
                            <a class="text-muted text-decoration-none" href="{{ route('dashboard') }}">Home</a> <!-- Link to dashboard -->
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            <a class="text-muted text-decoration-none" href="{{ route('admin.blogs.index') }}">All Blogs</a> <!-- Link to admin dashboard -->
                        </li>
          </ol>
        </nav>
      </div>
      <div class="col-3 text-end"> <!-- Adjusted for right alignment -->
        <div class="text-center">
          <img src="../backend/images/breadcrumb/ChatBc.png" alt="modernize-img" class="img-fluid" style="max-height: 100px;"/> <!-- Adjust size as needed -->
        </div>
      </div>
    </div>
  </div>
</div>
    <div class="row">
        <div class="col">
            <div class="card card-modern">
                <div class="card-body">
                    <div class="datatables-header-footer-wrapper mt-2">
                        <div class="datatable-header">
                            <div class="row align-items-center mb-3">
                                <div class="col-12 col-lg-auto mb-3 mb-lg-0">
                                    <a href="{{ route('admin.blogs.create') }}"
                                        class="btn btn-success btn-md font-weight-semibold btn-py-2 px-4">+ Add Blog</a>
                                </div>
                            </div>
                        </div>
                        <table class="table table-ecommerce-simple table-striped mb-0" id="datatable-ecommerce-list"
                            style="min-width: 550px;">
                            <thead>
                                <tr>
                                    <th width="5%">ID</th>
                                    <th width="15%">Title</th>
                                    <th width="70%">Content</th>
                                    <th width="1O%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($all_blogs as $blog)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $blog->title }}</td>
                                        <td>{{ $blog->content }}</td>
                                        <td>
                                            <a href="{{ route('admin.blogs.edit', $blog->uuid) }}"
                                                class="badge badge-primary text-white">Edit</a>

                                            <a class="badge badge-danger text-white" id="delete"
                                                href="{{ route('admin.blogs.destroy', $blog->uuid) }}">
                                                Delete
                                            </a>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
