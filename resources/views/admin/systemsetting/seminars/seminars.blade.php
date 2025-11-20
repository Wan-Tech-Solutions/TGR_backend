@extends('admin.layouts.admin_master')
@section('title')
Seminars
@endsection
@section('admin')
<style>
    .input-group {
        margin-bottom: 10px;
    }
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<div class="row">
    <div class="col-lg-12">
        <form action="{{ route('seminars.store') }}" method="POST" id="myForm" enctype="multipart/form-data">
            @csrf
            <section class="card">
                <header class="card-header">
                    <h2 class="card-title">Upload a Seminar Video</h2>
                </header>
                <div class="card-body" style="display: block;">
                    <div class="row">
                        <div class="col-lg-12">
                            <label for="title">Title</label>
                            <input class="form-control" name="title" placeholder="Title">
                            @error('title')
                            <span class="btn btn-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-lg-12">
                            <label for="description">Description</label>
                            <textarea class="form-control" name="description" rows="4" placeholder="Description"></textarea>
                            @error('description')
                            <span class="btn btn-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-lg-12">
                            <label for="video">Upload a Video</label>
                            <input type="file" class="form-control" name="video">
                            @error('video')
                            <span class="btn btn-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <footer class="card-footer text-end" style="display: block;">
                    <button class="btn btn-primary" type="submit">Upload a Seminar</button>
                </footer>
            </section>
        </form>
    </div>
</div>
@endsection