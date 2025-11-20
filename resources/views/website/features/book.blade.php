@extends('website.layouts.main')

@section('title')
Books
@endsection

@section('content')
<section
    class="page-header page-header-modern page-header-background page-header-background-md overlay overlay-color-dark overlay-show overlay-op-1"
    style="background-image: url({{ asset('img/page-header/bc-adv.jpg') }});">
    <div class="container">
        <div class="row">
            <div class="col-md-8 order-2 order-md-1 align-self-center p-static">
                <h1>TGR <strong>Book</strong></h1>
                {{-- <span class="sub-title">Get in touch with us</span> --}}
            </div>
            <div class="col-md-4 order-1 order-md-2 align-self-center">
                <ul class="breadcrumb breadcrumb-light d-block text-md-end">
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li class="">Features</li>
                    <li class="active">Books</li>
                </ul>
            </div>
        </div>
    </div>
</section>
<div class="container pt-5">
    <div class="row py-4 mb-2">
        <div class="col-md-6 order-2">
            <div class="overflow-hidden">
                <h2 class="text-color-dark font-weight-bold text-12 mb-2 pt-0 mt-0 appear-animation"
                    data-appear-animation="maskUp" data-appear-animation-delay="300">The Great Return</h2>
            </div>
            <div class="overflow-hidden mb-3">
                <p class="font-weight-bold text-primary text-uppercase mb-0 appear-animation"
                    data-appear-animation="maskUp" data-appear-animation-delay="500">Book</p>
            </div>
            <p class="lead appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="700">
                Since 2019, there has been a growing movement taking place amongst the
                African Diaspora population living in the Western world. Why are thousands of them
                deciding to abandon the West and relocate back to Africa and start new lives?</p>
            <p class="pb-3 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="800">
                In the
                post-colonial period, we saw a great migration of people from Africa to the West in
                search of greater economic opportunity; so why are a significant percentage of them
                deciding to come back home?.</p>
            <hr class="solid my-4 appear-animation" data-appear-animation="fadeInUpShorter"
                data-appear-animation-delay="900">
            <div class="row align-items-center appear-animation" data-appear-animation="fadeInUpShorter"
                data-appear-animation-delay="1000">
                <div class="col-lg-6">
                    <a href="https://www.amazon.com/gp/aw/d/B0DJL5JL4M/ref=tmm_pap_swatch_0?ie=UTF8&dib_tag=se&dib=eyJ2IjoiMSJ9.saabk6HZlzd5TRRMGca8HQ.GtgXo7jDeK7vj5B2uijBKgZF1NDncQ6rSIWoinJKMRQ&qid=1728312008&sr=8-1" class="btn btn-modern btn-dark mt-3">Grab a copy</a>
                    {{-- <a href="{{route('contact')}}" class="btn btn-modern btn-primary mt-3">Contact Us</a> --}}
                </div>
                <div class="col-sm-6 text-lg-end my-4 my-lg-0">
                    <strong class="text-uppercase text-1 me-3 text-dark">Amazon</strong>
                    <ul class="social-icons float-lg-end">
                        <li class="social-icons-amazon"><a href="https://www.amazon.com/gp/aw/d/B0DJL5JL4M/ref=tmm_pap_swatch_0?ie=UTF8&dib_tag=se&dib=eyJ2IjoiMSJ9.saabk6HZlzd5TRRMGca8HQ.GtgXo7jDeK7vj5B2uijBKgZF1NDncQ6rSIWoinJKMRQ&qid=1728312008&sr=8-1" target="_blank"
                                title="amazon"><i class="fab fa-amazon"></i></a></li>

                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6 order-md-2 mb-4 mb-lg-0 appear-animation" data-appear-animation="fadeInRightShorter">
            <img src="{{ asset('img/gallery/gallery-2.png') }}" class="img-fluid mb-2" alt="" style="width: 500px; height: 650px;">
        </div>
    </div>
</div>
<hr>
<!-- <div class="container py-4">
    <div class="row pt-2 mt-2 mb-5">
        <div class="col-md-7 mb-4 mb-md-0">

            <h2 class="text-color-dark font-weight-normal text-5 mb-2">Book <strong
                    class="font-weight-extra-bold">Description</strong></h2>

            <p> Since the mid 2000s there has been a growing movement taken place amongst the African Diaspora
                population living in the western world.
                Why are thousands of them deciding to abandon the West and relocate back to Africa in order to start new
                lives?.</p>

            <p>In the post-colonial period, we saw a great migration of people from Africa to the west in
                search of greater economic opportunities so why are a significant percentage of them deciding to come
                back home?.</p>

            <hr class="solid my-5">

            <strong class="text-uppercase text-1 me-3 text-dark float-start position-relative top-2">Share</strong>
            <ul class="social-icons">
                <li class="social-icons-facebook"><a href="http://https://web.facebook.com/profile.php?id=61559081140764&__cft__[0]=AZUq_JhwXt78n3dLKy4eHyXVPdiFO521vSa3jEDlQOyTlC7k3kMh6BDHTUyHnJXq8AdWYhQaMVgDpeP617r7vIDpoY9mbmYKSZaRfMOI1TPHEqRRqev0j5O6egsxBNaT9W7xP-3fyZFHZt7RBhoXdZwQydiuVqts4btc-QeESndC2nJWuNq3UbuYNN8KtA7HEauGXqbRiFhkvXkucvvGfL8M0_9EW1OEkOuQko8wu8Tmp0HMnW1hWio_x75a8bRyswg" target="_blank" title="Facebook"><i
                            class="fab fa-facebook-f"></i></a></li>
                <li class="social-icons-youtube"><a href="https://www.youtube.com/@TGRAfrica" target="_blank" title="Youtube"><i
                            class="fab fa-youtube"></i></a></li>
                 <li class="social-icons-linkedin"><a href="http://www.linkedin.com/" target="_blank" title="Linkedin"><i
                                class="fab fa-linkedin-in"></i></a></li>
            </ul>

        </div>
        <div class="col-md-5">
            <h2 class="text-color-dark font-weight-normal text-5 mb-2">Book <strong
                    class="font-weight-extra-bold">Details</strong></h2>
            <ul class="list list-icons list-primary list-borders text-2">
                <li><i class="fas fa-caret-right left-10"></i> <strong class="text-color-primary">Author:</strong> Lordy
                    Emmen</li>
                <li><i class="fas fa-caret-right left-10"></i> <strong class="text-color-primary">Release Date:</strong>
                    12 June 2024</li>
                <li><i class="fas fa-caret-right left-10"></i> <strong class="text-color-primary">Category:</strong> <a
                        href="#" class="badge badge-dark badge-sm rounded-pill px-2 py-1 ms-1">Revolution</a><a
                        href="#" class="badge badge-dark badge-sm rounded-pill px-2 py-1 ms-1">Pan</a><a
                        href="#" class="badge badge-dark badge-sm rounded-pill px-2 py-1 ms-1">Africa</a></li>
                <li><i class="fas fa-caret-right left-10"></i> <strong class="text-color-primary">Book URL:</strong> <a
                        href="#" target="_blank" class="text-dark">http://www.amazon.com/thegreatreturn</a></li>
            </ul>
        </div>
    </div>

</div> -->
@endsection