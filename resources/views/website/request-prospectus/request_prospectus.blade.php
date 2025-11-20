@extends('website.layouts.main')

@section('title')
Request Prospectus
@endsection

@section('content')
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<style>
    /* Background color for the contact form wrapper */
    .slider-contact-form-wrapper {
        background-color: #ed5348 !important;
    }

    /* Styling the button to appear blue */
    .slider-contact-form-wrapper .btn-danger {
        background-color: white !important;
        border-color: #000000 !important;
        color: #000000;
    }

    /* Optional: Modify button hover effect */
    .slider-contact-form-wrapper .btn-danger:hover {
        background-color: grey !important;
        border-color: white !important;
    }
</style>


<!-- <section
        class="page-header page-header-modern page-header-background page-header-background-md overlay overlay-color-dark overlay-show overlay-op-5"
        style="background-image: url(img/page-header/page-header-background.jpg);">
        <div class="container">
            <div class="row">
                <div class="col-md-8 order-2 order-md-1 align-self-center p-static">
                    <h1>Request <strong>Propectus</strong></h1>
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
    </section> -->

<div role="main" class="main">
    <section class="section section-overlay-opacity section-overlay-opacity-scale-7 border-0 m-0">
        <div class="container py-5">
            <div class="row align-items-center justify-content-center">
                <div class="col-lg-6 text-center mb-5 mb-lg-0">
                    <div class="d-flex flex-column align-items-center justify-content-center h-100">
                        <h3 class="position-relative text-color-light text-5 line-height-5 font-weight-medium px-4 mb-2 appear-animation"
                            data-appear-animation="fadeInDownShorterPlus" data-plugin-options="{'minWindowWidth': 0}">
                            <span class="position-absolute right-100pct top-50pct transform3dy-n50 opacity-3">
                                <img src="img/slides/slide-title-border.png" class="w-auto appear-animation"
                                    data-appear-animation="fadeInRightShorter" data-appear-animation-delay="250"
                                    data-plugin-options="{'minWindowWidth': 0}" alt="" />
                            </span>
                            The Great Return <span class="position-relative">Africa<span
                                    class="position-absolute left-50pct transform3dx-n50 top-0 mt-3"></span></span>
                            <span class="position-absolute left-100pct top-50pct transform3dy-n50 opacity-3">
                                <img src="img/slides/slide-title-border.png" class="w-auto appear-animation"
                                    data-appear-animation="fadeInLeftShorter" data-appear-animation-delay="250"
                                    data-plugin-options="{'minWindowWidth': 0}" alt="" />
                            </span>
                        </h3>
                        <h1 class="text-color-light font-weight-extra-bold text-12 mb-2 appear-animation"
                            data-appear-animation="blurIn" data-appear-animation-delay="1300"
                            data-plugin-options="{'minWindowWidth': 0}">Investors Community Prospectus</h1>
                        <!-- <p class="text-4 text-color-light font-weight-light opacity-7 mb-0" data-plugin-animated-letters
                            data-plugin-options="{'startDelay': 3500, 'minWindowWidth': 0}">Dedicated to Rebuilding, Reconnecting and Revitalising the African Diasporas</p> -->
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="slider-contact-form-wrapper bg-primary rounded p-5 appear-animation"
                        data-appear-animation="fadeInLeftShorter" data-appear-animation-delay="3000"
                        data-appear-animation-duration="1s" style="background-color: #ed5348;">
                        <div class="row">
                            <div class="col text-center">
                                <h2 class="font-weight-semi-bold text-color-light text-6 mb-2">Download our Prospectus</h2>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <form id="prospectusForm" action="{{ route('prospectus.store') }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="emailInput" class="form-label text-white">Enter your Email address to download</label>
                                        <input type="email" name="email" class="form-control" id="emailInput"
                                            placeholder="Enter your email">
                                    </div>
                                    @error('email')
                                    <span class="badge badge-danger">{{ $message }}</span>
                                    @enderror
                                    <button type="submit" class="btn btn-danger" style="">Receive</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="successModalLabel">Success</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Prospectus have been sent to your email successfully. <br> If you haven't receive yet, kindly check spam box.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Check if there is a success message in the session and the modal element exists
        @if(session('success'))
        const successModalElement = document.getElementById('successModal');
        if (successModalElement) {
            const successModal = new bootstrap.Modal(successModalElement);
            successModal.show();

            // Clean up any modal-related overlays or classes after closing
            successModalElement.addEventListener('hidden.bs.modal', function() {
                document.body.classList.remove('modal-open'); // Remove 'modal-open' class
                document.querySelector('.modal-backdrop')?.remove(); // Remove any remaining backdrop
            });
        }
        @endif
    });
</script>

@endsection