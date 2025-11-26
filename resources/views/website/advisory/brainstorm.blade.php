@extends('website.layouts.main')

@section('title')
    Business
@endsection

@section('content')
    <section
        class="page-header page-header-modern page-header-background page-header-background-md overlay overlay-color-dark overlay-show overlay-op-1"
        style="background-image: url({{ asset('img/page-header/bc-adv.jpg') }});">
        <div class="container">
            <div class="row">
                <div class="col-md-8 order-2 order-md-1 align-self-center p-static">
                    <h1><strong>Business</strong></h1>
                </div>
                <div class="col-md-4 order-1 order-md-2 align-self-center">
                    <ul class="breadcrumb breadcrumb-light d-block text-md-end">
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li>Advisory</li>
                        <li class="active">Business</li>
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
                        data-appear-animation-delay="200"><strong class="font-weight-extra-bold">What we do</strong>
                    </h2>
                </div>
                <div class="overflow-hidden mb-4">
                    <p class="lead mb-0 appear-animation" style="text-align: justify" data-appear-animation="maskUp"
                        data-appear-animation-delay="400">At TGR Africa, our goal is to help diaspora entrepreneurs
                        establish successful businesses in Africa.</p>
                </div>
                <ul class="list mt-4 mb-3 text-2 appear-animation" style="text-align: justify"
                    data-appear-animation="fadeInUpShorter" data-appear-animation-delay="600">
                    <li>Discovering your core unique purpose</li>
                    <li>Generating business ideas that solve meaningful problems by leveraging on your skills/expertise and passions/interests</li>
                    <li>Conducting feasibility studies to evaluate the viability of your business ideas</li>
                    <li>Working with you to develop a business plan and strategy based on a low risk low cost and time efficient approach</li>
                    <li>Continuous Business support throughout entrepreneurial journey via monthly retainer</li>
                </ul>
            </div>
            <div class="col-lg-4">
                <div class="testimonial testimonial-secondary appear-animation" data-appear-animation="fadeIn"
                    data-appear-animation-delay="800">
                    <blockquote>
                        <p class="mb-0">Book a consultation and speak to one of our advisors for more information on the various ways we can support you
.</p>

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
                                                Gaining an in-depth understanding of what you’re passionate about, your
                                                interests,
                                                skill-sets and expertise.
                                            </li>

                                            <li>
                                                Finding out which industries and sectors you are most passionate about
                                                working in.

                                            </li>

                                            <li>
                                                Gathering information from key stakeholders, industry experts and key
                                                players
                                                about the nature of those industries/sectors and their challenges and
                                                opportunities.

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
                                        <p>TGR Businessing sessions are split into three key parts which will span a 4-6
                                            week
                                            period. The first part is focused on helping you develop a unique core purpose.
                                            The
                                            second part of the Businessing sessions will focus on exploring some of the
                                            industries
                                            and sectors that you may be passion about or are interested in.</p>
                                        <p>This will serve as the
                                            basis of our investigate research to find out more about the opportunities and
                                            trends
                                            within those industries and sectors. The third part of the Businessing sessions
                                            will
                                            focus on working with you to generate potential business ideas. At the end of
                                            the
                                            sessions, you should find yourself with a minimum three viable business ideas
                                            which you
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
                                <a class="toggle-title">Investment</a>
                                <div class="toggle-content" style="text-align: justify">
                                    <p>At TGR Africa , our goal is to help diaspora investors build wealth  and contribute to African development.</p>
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
