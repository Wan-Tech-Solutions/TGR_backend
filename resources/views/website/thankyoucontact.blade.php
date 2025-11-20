@extends('website.layouts.main')
@section('title')
Thank You
@endsection
@section('content')
<section
    class="page-header page-header-modern page-header-background page-header-background-md overlay overlay-color-dark overlay-show overlay-op-5"
    style="background-image: url(img/page-header/page-header-background.jpg);">
    <div class="container">
        <div class="row">
            <div class="col-md-8 order-2 order-md-1 align-self-center p-static">
                <h1>Read<strong> Our News</strong></h1>
                <span class="sub-title">Read more about us</span>
            </div>
            <div class="col-md-4 order-1 order-md-2 align-self-center">
                <ul class="breadcrumb breadcrumb-light d-block text-md-end">
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li class="active">News</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<div role="main" class="main">
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8 text-center">
                <img src="{{ asset('frontend/img/correct.png') }}" alt="Thank You" class="img-fluid mb-2 small-image">
                <br>
                <br>
                <p class="thanks">Thank You !</p>
                <br>
                <p class="lead">
                    for contacting TGR Africa. An adivisor will contact you soon...
                </p>
                <!-- <a href="{{ route('home') }}" class="btn btn-primary mt-3">Homepage</a> -->

                <div class="container py-4">
                    <div class="row">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card mb-4 card-hover">
                                    <div class="card-body">
                                        <h3 class="font-weight-bold">Connect With Us</h3>
                                        <div class="social-icons">
                                            <a href="https://www.facebook.com" target="_blank" class="btn btn-link" style="color: blue;">
                                                <i class="fab fa-facebook fa-2x"></i>
                                            </a>
                                            <a href="https://www.youtube.com" target="_blank" class="btn btn-link" style="color: red;">
                                                <i class="fab fa-youtube fa-2x"></i>
                                            </a>
                                            <a href="https://wa.me/yourwhatsappnumber" target="_blank" class="btn btn-link" style="color: green;">
                                                <i class="fab fa-whatsapp fa-2x"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card mb-4 card-hover">
                                    <div class="card-body">
                                        <h3 class="font-weight-bold">Back Home</h3>
                                        <a href="{{ route('home') }}" class="btn btn-primary mt-3" style="background-color: #ed5348; border: none;">Homepage</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .thanks {
        color: #000000;
        font-size: 5rem;
        /* Large font size for emphasis */
        font-weight: bold;
        /* Bold text */
        margin: 1rem 0;
        /* Margin for spacing */
    }

    .small-image {
        width: 50px;
        /* Set a specific width for the image */
        height: auto;
        /* Maintain aspect ratio */
    }

    .social-icons {
        display: flex;
        justify-content: space-around;
        /* Space the icons evenly */
        margin-top: 20px;
        /* Space between title and icons */
    }

    .btn-link {
        color: inherit;
        /* Use the default color of the icon */
        text-decoration: none;
        /* Remove underline */
    }

    .btn-link:hover {
        color: #007bff;
        /* Change color on hover */
    }

    /* Card Hover Effect */
    .card-hover {
        transition: transform 0.3s, box-shadow 0.3s;
        /* Smooth transition */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        /* Initial shadow */
    }

    .card-hover:hover {
        transform: translateY(-5px);
        /* Slightly lift the card on hover */
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
        /* Increased shadow on hover */
    }
</style>
@endsection