@extends('website.layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 text-center">
                <h3>Check your email</h3>
                <p>If an account with that email exists, we have sent a confirmation link to unsubscribe.</p>
                <a href="{{ route('home') }}" class="btn btn-primary">Return to home</a>
            </div>
        </div>
    </div>
@endsection
