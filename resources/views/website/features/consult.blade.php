@extends('website.layouts.main')

@section('title')
    Consultation
@endsection

@section('content')
    <section
        class="page-header page-header-modern page-header-background page-header-background-md overlay overlay-color-dark overlay-show overlay-op-5"
        style="background-image: url({{ asset('img/page-header/page-header-background.jpg') }});">
        <div class="container">
            <div class="row">
                <div class="col-md-8 order-2 order-md-1 align-self-center p-static">
                    <h1>TGR <strong>Consultation</strong></h1>
                </div>
                <div class="col-md-4 order-1 order-md-2 align-self-center">
                    <ul class="breadcrumb breadcrumb-light d-block text-md-end">
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li>Advisory</li>
                        <li class="active">Consultation</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <div class="container py-5 mt-3">
        <div class="row">
            <div class="col-lg-8">
                <div class="overflow-hidden mb-2">
                    <h2 class="font-weight-normal text-7 mb-2 appear-animation" data-appear-animation="maskUp"
                        data-appear-animation-delay="200"><strong class="font-weight-extra-bold">
                            What we do </strong></h2>
                </div>
                <div class="overflow-hidden mb-4">
                    <p class="lead mb-0 appear-animation" style="text-align: justify" data-appear-animation="maskUp"
                        data-appear-animation-delay="400">At TGR Africa our goal is to offer valuable information advice and guidance on doing business and investing in Africa.</p>

                    <h5 class="mt-4 mb-3 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="500"><strong>How we can support:</strong></h5>
                    <ul class="list mt-2 mb-3 text-2 appear-animation" style="text-align: justify" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="600">
                        <li>Provide useful information, advice and guidance</li>
                        <li>Signposting to reputable local organizations and institutions</li>
                        <li>Conduct a diagnostic assessment to evaluate your entrepreneurial competency, business idea business plan and strategy</li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="testimonial testimonial-secondary appear-animation" data-appear-animation="fadeIn"
                    data-appear-animation-delay="800">
                    <blockquote>
                        <p class="mb-0">Book a consultation and speak to one of our advisors.
                        </p>
                        <hr>
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if ($errors->has('payment'))
                            <div class="alert alert-danger">
                                {{ $errors->first('payment') }}
                            </div>
                        @endif

                        <a href="{{ route('features.consult.book') }}"
                            class="btn btn-dark font-weight-semibold btn-px-4 btn-py-2 text-2">Book a Consultation</a>
                    </blockquote>
                </div>
            </div>
        </div>
    </div>
    <section class="section section-default border-0 m-0">
        <div class="container py-4">
            <div class="row pb-4">
                <div class="col-md-8">
                    <div class="appear-animation" data-appear-animation="fadeIn" data-appear-animation-delay="200">
                        {{-- <h4 class="mt-2 mb-2">We hope <strong> to achieve this by;</strong></h4> --}}
                        <div class="accordion accordion-modern accordion-modern-grey-scale-1 without-bg mt-4"
                            id="accordion11">
                            <div class="card card-default mb-2">
                                <div class="card-header">
                                    <h4 class="card-title m-0">
                                        <a class="accordion-toggle text-3" data-bs-toggle="collapse"
                                            data-bs-parent="#accordion11" href="#collapse11One">
                                            We aim to achieve this by:
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapse11One" class="collapse show">
                                    <div class="card-body mt-3">
                                        <ul class="list mt-4 mb-3 text-2">
                                            <li>
                                                Giving you a chance to ask any questions pertaining to joining the great
                                                return.
                                            </li>
                                            <li>
                                                Giving you advice on which advisory services will best suit your needs
                                                giving your
                                                current circumstance.
                                            </li>
                                            <li>
                                                Provide clarification about our advisory process, fees and expectations.
                                            </li>
                                            <li>
                                                Sign post you to relevant agencies and organisations who are part of the
                                                diaspora support services.
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="card card-default mb-2">
                                <div class="card-header">
                                    <h4 class="card-title m-0">
                                        <a class="accordion-toggle text-3" data-bs-toggle="collapse"
                                            data-bs-parent="#accordion11" href="#collapse11Two">
                                            Process
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapse11Two" class="collapse">
                                    <div class="card-body mt-3" style="text-align: justify">
                                        <p>All you need to do is choose a date and time which suits you. To ensure we can
                                            give you
                                            the best advice and provide you with relevant support that caters to your unique
                                            circumstances and needs. Our team is dedicated to supporting your journey back home.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-md-4">
                    <div class="appear-animation" data-appear-animation="fadeIn" data-appear-animation-delay="400">
                        <div class="owl-carousel owl-theme dots-inside mb-0 pb-0"
                            data-plugin-options="{'items': 1, 'autoplay': true, 'autoplayTimeout': 4000, 'margin': 10, 'animateOut': 'fadeOut', 'dots': false}">
                            <div class="pb-5">
                                <img alt="" class="img-fluid rounded" src="{{ asset('img/generic/gc.jpg') }}">
                            </div>
                            <div class="pb-5">
                                <img alt="" class="img-fluid rounded" src="{{ asset('img/generic/gc2.jpg') }}">
                            </div>
                        </div>
    </section>
@endsection
