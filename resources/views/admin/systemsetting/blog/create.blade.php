@extends('admin.layouts.admin_master')
@section('title', 'Create Blog')
@section('admin')
    <header class="page-header page-header-left-inline-breadcrumb">
        <h2 class="font-weight-bold text-6">Create Blog</h2>
    </header>
    <div class="row">
        <div class="col">
            <div class="card card-modern">
                <div class="card-body">
                    <form action="{{ route('admin.blogs.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" name="title" id="title" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="content">Content</label>
                            <textarea name="content" id="content" class="form-control" rows="5" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
