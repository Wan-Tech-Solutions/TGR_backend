@extends('website.layouts.main')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 text-center">
                <h3>Newsletter</h3>
                <p>{{ $message ?? 'Your subscription status has been updated.' }}</p>
                <a href="{{ route('home') }}" class="btn btn-primary">Return to home</a>
            </div>
        </div>
    </div>
@endsection
