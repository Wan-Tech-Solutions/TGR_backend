@extends('website.layouts.main')

@section('title')
Brainstorm
@endsection

@section('content')
<section
class="page-header page-header-modern page-header-background page-header-background-md overlay overlay-color-dark overlay-show overlay-op-1"
style="background-image: url({{ asset('img/page-header/bc-adv.jpg') }});">
    <div class="container">
        <div class="row">
            <div class="col-md-8 order-2 order-md-1 align-self-center p-static">
                <h1>TGR <strong>Brainstorm</strong></h1>
            </div>
            <div class="col-md-4 order-1 order-md-2 align-self-center">
                <ul class="breadcrumb breadcrumb-light d-block text-md-end">
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li>Advisory</li>
                    <li class="active">Brainstorm</li>
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
                    data-appear-animation-delay="200">TGR <strong class="font-weight-extra-bold">Brainstorm</strong>
                </h2>
            </div>
            <div class="overflow-hidden mb-4">
                <p class="lead mb-0 appear-animation" style="text-align: justify" data-appear-animation="maskUp"
                    data-appear-animation-delay="400">It is likely that you may find yourself at a stage of your
                    transition journey where you
                    know you want to be a part of the great return but are currently struggling to figure out
                    how you can get involved. You may be still trying to work out what you can do, how you
                    can utilise your skill sets and expertise and how you can contribute towards the
                    development of Africa. </p>
            </div>
            <p class="text-color-light-3 mb-4 appear-animation" style="text-align: justify"
                data-appear-animation="fadeInUpShorter" data-appear-animation-delay="600">Our goal with TGR
                Brainstorm is to help you develop your own unique core purpose as
                part of the greater collective purpose of the great return philosophy. We also want to
                help you start mapping out potential business ideas along the golden formula
                framework. It`s important to us that you are able to have a range of potential business
                ideas which incorporate your natural passions, interests, expertise and skill sets in a way
                that can provide value and can be of service to the development of Africa.</p>
        </div>
        <div class="col-lg-4">
            <div class="testimonial testimonial-secondary appear-animation" data-appear-animation="fadeIn"
                data-appear-animation-delay="800">
                <blockquote>
                    <p class="mb-0">For more information about TGR Brainstorm please book a consultation to speak to
                        an advisor.</p>

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
                    <h4 class="mt-2 mb-2">Opening <strong>Sections</strong></h4>

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
                                            Collaborating with you to learn more about who you are as an individual.
                                        </li>

                                        <li>
                                            Working with you to construct a core unique purpose that serves as your own
                                            personal mission statement.
                                        </li>

                                        <li>
                                            Gaining an in-depth understanding of what you’re passionate about, your interests,
                                            skill-sets and expertise.
                                        </li>

                                        <li>
                                            Finding out which industries and sectors you are most passionate about
                                            working in.

                                        </li>

                                        <li>
                                            Gathering information from key stakeholders, industry experts and key players
                                            about the nature of those industries/sectors and their challenges and opportunities.

                                        </li>

                                        <li>
                                            Working with you to generate potential ideas that meet the golden formula
                                            framework.

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
                                    <p>TGR Brainstorming sessions are split into three key parts which will span a 4-6 week
                                        period. The first part is focused on helping you develop a unique core purpose. The
                                        second part of the brainstorming sessions will focus on exploring some of the industries
                                        and sectors that you may be passion about or are interested in.</p>
                                    <p>This will serve as the
                                        basis of our investigate research to find out more about the opportunities and trends
                                        within those industries and sectors. The third part of the brainstorming sessions will
                                        focus on working with you to generate potential business ideas. At the end of the
                                        sessions, you should find yourself with a minimum three viable business ideas which you
                                        can later investigate further.</p>

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
                                src="{{ asset('img/generic/generic-corporate-3-2-full.jpg') }}">
                        </div>
                        <div class="pb-5">
                            <img alt="" class="img-fluid rounded"
                                src="{{ asset('img/generic/generic-corporate-3-3-full.jpg') }}">
                        </div>
                    </div>

                    <div class="toggle toggle-secondary toggle-simple" data-plugin-toggle>

                        <section class="toggle">
                            <a class="toggle-title">TGR Analytics</a>
                            <div class="toggle-content" style="text-align: justify">
                                <p>You might find yourself at the stage of your transition
                                    journey where you may have
                                    finally discovered potential business ideas which you would like to purse upon return.
                                    However, you lack the adequate research and market intelligence needed to assess the
                                    viability of your business idea.</p>
                                <a href="{{ route('advisory.analytic') }}" class="btn btn-modern btn-dark">Read more</a>
                            </div>
                        </section>
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
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
@endsection