@extends('admin.layouts.admin_master')
@section('title')
    Subscribe Seminar
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
                    {{-- <div class="container">
                        <h1>Seminars</h1>
                        @foreach ($seminars as $seminar)
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h2>{{ $seminar->title }}</h2>
                                </div>
                                <div class="card-body">
                                    <p>{{ $seminar->description }}</p>
                                    <a href="{{ route('seminars.subscribe', $seminar->id) }}"
                                        class="btn btn-primary">Subscribe</a>
                                </div>
                            </div>
                        @endforeach
                    </div> --}}

                    <div class="container">
                        <h1>Seminars</h1>
                        @foreach ($seminars as $seminar)
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h2>{{ $seminar->title }}</h2>
                                </div>
                                <div class="card-body">
                                    <p>{{ $seminar->description }}</p>
                                    @if ($seminar->isSubscribed)
                                        <span class="btn btn-success">Subscribed</span>
                                    @else
                                        <a href="{{ route('seminars.subscribe', $seminar->id) }}"
                                            class="btn btn-primary">Subscribe</a>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
