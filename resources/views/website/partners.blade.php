@extends('website.layouts.main')

@section('title')
    Partners
@endsection

@section('content')
    <section
        class="page-header page-header-modern page-header-background page-header-background-md overlay overlay-color-dark overlay-show overlay-op-5"
        style="background-image: url({{ asset('img/page-header/bc-green.jpg') }});">
        <div class="container">
            <div class="row">
                <div class="col-md-8 order-2 order-md-1 align-self-center p-static">
                    <h1>TGR <strong>Partners</strong></h1>
                    {{-- <span class="sub-title">Get in touch with us</span> --}}
                </div>
                <div class="col-md-4 order-1 order-md-2 align-self-center">
                    <ul class="breadcrumb breadcrumb-light d-block text-md-end">
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li class="active">Partners</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <div class="container">
        <div class="row counters counters-sm py-4 mt-5">
            <div class="col-sm-6 col-lg-3 mb-5 mb-lg-0">
                <div class="counter">
                    <i class="icons icon-user text-color-dark"></i>
                    <strong class="text-color-dark font-weight-extra-bold" data-to="10" data-append="+">0</strong>
                    <label class="text-4 mt-1">Happy Clients</label>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3 mb-5 mb-lg-0">
                <div class="counter">
                    <i class="icons icon-badge text-color-dark"></i>
                    <strong class="text-color-dark font-weight-extra-bold" data-to="2">0</strong>
                    <label class="text-4 mt-1">Years In Business</label>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3 mb-5 mb-sm-0">
                <div class="counter">
                    <i class="icons icon-graph text-color-dark"></i>
                    <strong class="text-color-dark font-weight-extra-bold" data-to="178">0</strong>
                    <label class="text-4 mt-1">High Score</label>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="counter">
                    <i class="icons icon-cup text-color-dark"></i>
                    <strong class="text-color-dark font-weight-extra-bold" data-to="352">0</strong>
                    <label class="text-4 mt-1">Cups of Coffee</label>
                </div>
            </div>
        </div>

        <hr class="solid my-5">

    </div>

    <div class="container">
        <div class="row text-center pt-4 mt-5">
            <div class="col">
                <h2 class="word-rotator slide font-weight-bold text-8 mb-2">
                    <span>We're not the only ones </span>
                    <span class="word-rotator-words bg-secondary">
                        <b class="is-visible">excited</b>
                        <b>happy</b>
                    </span>
                    <span> about TGR.</span>
                </h2>
                <h4 class="text-secondary lead tall text-4">10+ CUSTOMERS IN DIFFERENT COUNTRIES. MEET OUR CUSTOMERS.</h4>
            </div>
        </div>

        <div class="row text-center mt-5 pb-5 mb-5">
            <div class="owl-carousel owl-theme carousel-center-active-item mb-0"
                data-plugin-options="{'responsive': {'0': {'items': 1}, '476': {'items': 1}, '768': {'items': 5}, '992': {'items': 7}, '1200': {'items': 7}}, 'autoplay': true, 'autoplayTimeout': 3000, 'dots': false}">
                <div>
                    <img class="img-fluid" src="{{ asset('img/logos/logo-1.png') }}" alt="">
                </div>

                <div>
                    <img class="img-fluid" src="{{ asset('img/logos/logo-3.png') }}" alt="">
                </div>
                <div>
                    <img class="img-fluid" src="{{ asset('img/logos/logo-4.png') }}" alt="">
                </div>
                <div>
                    <img class="img-fluid" src="{{ asset('img/logos/logo-5.png') }}" alt="">
                </div>
                <div>
                    <img class="img-fluid" src="{{ asset('img/logos/logo-6.png') }}" alt="">
                </div>
                <div>
                    <img class="img-fluid" src="{{ asset('img/logos/logo-4.png') }}" alt="">
                </div>
                <div>
                    <img class="img-fluid" src="{{ asset('img/logos/logo-2.png') }}" alt="">
                </div>
            </div>
        </div>
    </div>


    <section class="call-to-action call-to-action-strong-grey content-align-center call-to-action-in-footer">
        <div class="container">
            <div class="row">
                <div class="col-md-9 col-lg-9">
                    <div class="call-to-action-content">
                        <h2 class="font-weight-normal text-6 mb-0">TGR is <strong>everything</strong> you need to plan an
                            awesome <strong>return</strong> Home!</h2>
                        <p class="mb-0">Deciding on how to come back home?</p>
                    </div>
                </div>
                <div class="col-md-3 col-lg-3">
                    <div class="call-to-action-btn">
                        <a href="{{ route('contact') }}" class="btn btn-modern btn-secondary">Get in Touch!</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
