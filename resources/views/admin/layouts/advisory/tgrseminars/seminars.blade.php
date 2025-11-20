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
                        <h2 class="card-title">Upload Seminar Video</h2>
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
                            {{-- <div class="col-lg-12">
                                <label for="video">Upload Video</label>
                                <input type="file" class="form-control" name="video" accept="video/*">
                                @error('video')
                                    <span class="btn btn-danger">{{ $message }}</span>
                                @enderror
                            </div> --}}

                            <div class="col-lg-12">
                                <label for="video">Upload Video</label>
                                <input type="file" class="form-control" name="video" accept="video/*" id="video-input">
                                @error('video')
                                    <span class="btn btn-danger">{{ $message }}</span>
                                @enderror
                                <div id="video-preview" class="mt-3">
                                    <video width="320" height="240" controls style="display: none;">
                                        <source id="video-source">
                                        Your browser does not support the video tag.
                                    </video>
                                </div>
                            </div>
                        </div>
                    </div>
                    <footer class="card-footer text-end" style="display: block;">
                        <button class="btn btn-primary" type="submit">Upload Seminar</button>
                    </footer>
                </section>
            </form>
        </div>
    </div>
    <script>
        document.getElementById('video-input').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const videoPreview = document.getElementById('video-preview');
                const videoSource = document.getElementById('video-source');
                const videoElement = videoPreview.querySelector('video');

                videoSource.src = URL.createObjectURL(file);
                videoElement.style.display = 'block';
                videoElement.load();
            }
        });
    </script>
@endsection
