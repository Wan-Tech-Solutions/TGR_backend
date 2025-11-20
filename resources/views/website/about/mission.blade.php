@extends('website.layouts.main')

@section('title')
Mission
@endsection

@section('content')
<section
    class="page-header page-header-modern page-header-background page-header-background-md overlay overlay-color-dark overlay-show overlay-op-5"
    style="background-image: url({{ asset('img/page-header/page-header-background.jpg') }});">
    <div class="container">
        <div class="row">
            <div class="col-md-8 order-2 order-md-1 align-self-center p-static">
                <h1>Our <strong>Mission</strong></h1>
                {{-- <span class="sub-title">Get in touch with us</span> --}}
            </div>
            <div class="col-md-4 order-1 order-md-2 align-self-center">
                <ul class="breadcrumb breadcrumb-light d-block text-md-end">
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li>About</li>
                    <li class="active">Mission</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<div class="container py-2">
    <div class="row">
        <div class="col">
            <div class="overflow-hidden mb-3">
                <h2 class="word-rotator slide font-weight-bold text-8 mb-0 appear-animation"
                    data-appear-animation="maskUp">
                    <span>Mission </span>
                </h2>
            </div>
            <p style="text-align: justify">We believe the resources of the diaspora need to be mobilised efficiently towards
                areas of high productivity that can support African Development. We believe it’s also
                important for diaspora resources to be focused on a particular country because if we
                are successful in transforming that country, it could serve as a beacon of hope to
                other African Nations.
            </p>

            <p style="text-align: justify"> Our mission is to make Ghana the focus of diaspora
                engagement in Africa because we believe Ghana presents favourable economic,
                social and political conditions necessary for significant transformational
                development. The hope is for Ghana to serve as the blueprint for the rest of African
                NaBons to follow.
            </p>



        </div>
    </div>

</div>
@endsection