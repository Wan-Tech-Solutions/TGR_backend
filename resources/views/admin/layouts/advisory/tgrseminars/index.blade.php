@extends('admin.layouts.admin_master')
@section('title')
    Seminars
@endsection
@section('admin')
    <div class="container">
        <h1>Seminars</h1>
        <div class="row">
            @foreach ($seminars as $seminar)
                <div class="col-md-3 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            @if ($seminar->isSubscribed)
                                <video width="100%" height="auto" controls>
                                    <source src="{{ asset($seminar->video) }}" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                                <h2>{{ $seminar->title }}</h2>
                                <p>{{ $seminar->description }}</p>
                            @else
                            <span class="badge badge-green">You need to subscribe to access this seminar.</span>
                                {{-- <p class="text-green">You need to subscribe to access this seminar.</p> --}}
                                <a href="{{ route('seminars.subscribe', $seminar->id) }}"
                                    class="btn btn-primary">Subscribe</a>
                                <h2>{{ $seminar->title }}</h2>
                                <p>{{ $seminar->description }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
