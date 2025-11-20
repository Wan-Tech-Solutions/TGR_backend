@extends('admin.layouts.admin_master')
@section('title')
Seminars
@endsection
@section('admin')
<div class="row">
    <div class="col">
        <section class="card">
            <header class="card-header">
                <div class="card-actions">
                    <a href="#" class="card-action card-action-toggle" data-card-toggle=""></a>
                    <a href="#" class="card-action card-action-dismiss" data-card-dismiss=""></a>
                </div>
                <h2 class="card-title">Seminars</h2>
            </header>
            <div class="card-body">
                <div class="container">
                    <h1>{{ $seminar->title }}</h1>
                    @if ($isSubscribed)
                    <video width="320" height="240" controls>
                        <source src="{{ asset($seminar->video) }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                    <p>{{ $seminar->description }}</p>
                    @else
                    <p>Kindly subscribe to get access to our seminar videos.</p>
                    <a href="{{ route('seminars.subscribe', $seminar->id) }}" class="btn btn-primary">Subscribe</a>
                    @endif
                </div>
            </div>
        </section>
    </div>
</div>
@endsection