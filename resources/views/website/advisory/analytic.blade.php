@extends('website.layouts.main')

@section('title')
Analytics
@endsection

@section('content')
<section
    class="page-header page-header-modern page-header-background page-header-background-md overlay overlay-color-dark overlay-show overlay-op-5"
    style="background-image: url({{ asset('img/page-header/page-header-backgrounda.jpg') }});">
    <div class="container">
        <div class="row">
            <div class="col-md-8 order-2 order-md-1 align-self-center p-static">
                <h1>TGR <strong>Analytics</strong></h1>
                {{-- <span class="sub-title">Get in touch with us</span> --}}
            </div>
            <div class="col-md-4 order-1 order-md-2 align-self-center">
                <ul class="breadcrumb breadcrumb-light d-block text-md-end">
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li>Advisory</li>
                    <li class="active">Analytics</li>
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
                    data-appear-animation-delay="200">TGR <strong class="font-weight-extra-bold">Analytics</strong></h2>
            </div>
            <div class="overflow-hidden mb-4">
                <p class="lead mb-0 appear-animation" style="text-align: justify" data-appear-animation="maskUp"
                    data-appear-animation-delay="400">You might find yourself at the stage of your transition
                    journey where you may have
                    finally discovered potential business ideas which you would like to purse upon return.
                    However, you lack the adequate research and market intelligence needed to assess the
                    viability of your business idea. We understand that It’s very difficult to take time off
                    from your busy schedule just travel to Ghana. The financial costs involved over an
                    extensive period of time to conduct your own independent investigation may also be
                    another barrier preventing you from doing so.
                </p>
            </div>
            <p class="text-color-light-3 mb-4 appear-animation" style="text-align: justify"
                data-appear-animation="fadeInUpShorter" data-appear-animation-delay="600">Depending on family
                and friends to
                conduct market research could be very risky and could potentially lead to poor quality
                research. What we do with TGR Analytics is to make it our responsibility to conduct the
                necessary market research and intelligence on your behalf. Our goal is to provide you
                with accurate information which would allow you to assess the viability of your business
                idea.</p>
        </div>
        <div class="col-lg-4">
            <div class="testimonial testimonial-secondary appear-animation" data-appear-animation="fadeIn"
                data-appear-animation-delay="800">
                <blockquote>
                    <p class="mb-0">If you would like more information on TGR Analytics, please book a consultation to
                        speak to one of our advisors.</p>
                    <hr>
                    <a href="{{ route('contact') }}"
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
                    {{-- <h4 class="mt-2 mb-2">Opening <strong>Sections</strong></h4> --}}

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
                                            Providing you with a report and recommendations on our findings.
                                        </li>

                                        <li>
                                            Providing you with a business plan
                                        </li>

                                        <li>
                                            Providing you with results from shadow testing your idea
                                        </li>

                                        <li>
                                            Providing you with an implementation road map.
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
                                    <p>We begin by arranging a telephone discussion with you to talk about your business idea.
                                        Once we have the relevant information, we will then carry out our own investigative
                                        research. Our findings, recommendations, business plan, shadow test and
                                        implementation road map will be presented to you over scheduled consultations. This
                                        would give you a chance to ask any relevant ques4ons pertaining to our findings.
                                    </p>
                                    <P>Additionally, we shall consolidate the en4re research project into a documented format
                                        for you to review in your own 4me. TGR Analytics will take place over a 4 to 8 week
                                        period. During this period we will keep you notified on any progress during our research.</P>
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
                            <img alt="" class="img-fluid rounded"
                                src="{{ asset('img/generic/g-analytic.jpg') }}">
                        </div>
                        <div class="pb-5">
                            <img alt="" class="img-fluid rounded"
                                src="{{ asset('img/generic/g-analytic2.jpg') }}">
                        </div>
                    </div>

                    <div class="toggle toggle-secondary toggle-simple" data-plugin-toggle>

                        <!-- <section class="toggle">
                            <a class="toggle-title">TGR Seminars</a>
                            <div class="toggle-content" style="text-align: justify">
                                <p>If you find yourself in a position where you identify with the TGR Philosophy but
                                    require further information so that you can become
                                    better educated on some of the opportunities available to you, then TGR Seminars
                                    will be perfect for you as part of your pre-transition preparation.</p>
                                <a href="{{ route('advisory.seminar') }}" class="btn btn-modern btn-dark">Read more</a>
                            </div>
                        </section> -->
                        <section class="toggle">
                            <a class="toggle-title">TGR Brainstorm</a>
                            <div class="toggle-content" style="text-align: justify">
                                <p>It is likely that you may find yourself at a stage of your transition journey where you
                                    know you want to be a part of the great return but are currently struggling to figure out
                                    how you can get involved. You may be s5ll trying to work out what you can do, how you
                                    can utilise your skill sets and expertise and how you can contribute towards the
                                    development of Africa.</p>
                                <a href="{{ route('advisory.brainstorm') }}" class="btn btn-modern btn-dark">Read
                                    more</a>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
@endsection