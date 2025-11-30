@extends('website.layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h3>Unsubscribe from Newsletter</h3>
                <p>Enter your email and we'll send you a confirmation link to unsubscribe.</p>
                <form method="POST" action="{{ route('newsletter.unsubscribe.request') }}">
                    @csrf
                    <div class="mb-3">
                        <input type="email" name="email" class="form-control" placeholder="Your email" required>
                    </div>
                    <button class="btn btn-danger" type="submit">Send unsubscribe link</button>
                </form>
            </div>
        </div>
    </div>
@endsection
