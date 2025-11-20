@extends('admin.layouts.admin_master')
@section('title')
    BrainStorm
@endsection
@section('admin')
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

    <style>
        .input-group {
            margin-bottom: 5px;
        }
    </style>

    <div class="row">
        <div class="col-lg-12">
            <!-- Button to open the modal -->
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createPostModal">
                Create a new Brainstorm idea
            </button>

            <!-- Modal -->
            <div class="modal fade" id="createPostModal" tabindex="-1" aria-labelledby="createPostModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{ route('posts.store') }}" method="POST" id="myForm"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title" id="createPostModalLabel">Create a new Post</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" class="form-control" name="title" placeholder="Title">
                                    @error('title')
                                        <span class="btn btn-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="content">Content</label>
                                    <textarea class="form-control" name="content" rows="8" placeholder="Type your message"></textarea>
                                    @error('content')
                                        <span class="btn btn-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Post</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-lg-12">
            @foreach ($posts as $post)
                <div class="card mt-4">
                    <div class="card-header">
                        <h5>{{ $post->title }}</h5>
                        <small>Posted by {{ $post->user->name }} on {{ $post->created_at->format('d M Y, H:i') }}</small>
                    </div>
                    <div class="card-body">
                        <p>{{ $post->content }}</p>
                        <h6>Replies</h6>
                        @foreach ($post->replies as $reply)
                            <div class="card mt-2">
                                <div class="card-body">
                                    <small>{{ $reply->user->name }} replied on
                                        {{ $reply->created_at->format('d M Y, H:i') }}</small>
                                    <p>{{ $reply->content }}</p>
                                </div>
                            </div>
                        @endforeach
                        <form action="{{ route('replies.store', $post) }}" method="POST" class="mt-3">
                            @csrf
                            <div class="form-group">
                                <label for="content">Reply</label>
                                <textarea class="form-control" name="content" rows="3"></textarea>
                                @error('content')
                                    <span class="btn btn-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <button class="btn btn-primary" type="submit">Reply</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
