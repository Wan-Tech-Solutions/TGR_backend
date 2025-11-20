@extends('website.layouts.main')
@section('title')
    TGR AFRICA
@endsection
@section('content')
    <style>
       /* Popup container to center the popup */
#overlay {
    display: none; /* Hidden by default */
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent black background */
    justify-content: center;
    align-items: center;
    z-index: 9999;
}

.popup-container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100%;
}

/* Popup styles */
#popup {
    background-color: white;
    padding: 20px;
    border-radius: 10px;
    max-width: 90%; /* Allow for responsiveness */
    width: 500px; /* Default width for larger screens */
    text-align: center;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    position: relative;
    margin: 0 auto;
    margin-left: -30px;
    margin-top: -70px;
}

/* Close button style */
.close-btn {
    position: absolute;
    top: 10px;
    right: 10px;
    font-size: 24px;
    background: transparent;
    border: none;
    color: #000;
    cursor: pointer;
}

/* Responsive image */
.img-fluid {
    max-width: 100%;
    height: auto;
}

/* Responsive typography and layout adjustments */
@media (max-width: 768px) {
    #popup {
        width: 80%; /* Use 80% of the screen width on smaller devices */
        margin-left: -10px; /* Adjust margin-left to center on smaller screens */
        margin-top: -100px;
    }

    .modal-title {
        font-size: 18px; /* Adjust font size on small screens */
    }

    #popup img {
        width: 100%; /* Make the image take up the full width of the popup */
        height: auto;
    }
}

@media (max-width: 576px) {
    #popup {
        width: 90%; /* Make the popup even smaller on extra small screens */
        margin-left: -10px; /* Adjust margin-left for very small screens */
        margin-top: -100px;
    }

    .modal-title {
        font-size: 16px; /* Reduce title size for very small screens */
    }
}


        /*New adjustment*/
        @media (max-width: 768px) {
            #header {
                position: relative;
                height: auto;
                top: 0;
                position: relative;
                z-index: 1;
            }

            .header-nav-top ul.nav {
                display: flex;
                flex-direction: column;
                /* Stack nav items */
                padding: 0;
            }

            .header-body {
                padding: 10px;
                /* Reduce padding for smaller screens */
            }
        }

        @media (min-width: 769px) and (max-width: 1024px) {
            #header {
                position: relative;
                top: 0;
                height: auto;
            }

            .header-nav-top ul.nav {
                display: flex;
                justify-content: space-between;
                /* Spread items evenly */
            }
        }

        @media (max-width: 768px) {

            .header-top .container,
            .header-container .container {
                display: flex;
                flex-direction: column;
                align-items: center;
            }

            .header-logo img {
                width: 100px;
                /* Adjust logo size for mobile */
            }
        }
    </style>


    <!-- Book popup -->
<div id="overlay" style="display: none;">
    <div class="popup-container">
        <div id="popup" class="ipopup">
            <button id="iclose" class="close-btn">&times;</button>
            <h4 class="modal-title" id="defaultModalLabel"><strong>The Great Return</strong></h4>
            <img class="img-fluid box-shadow-3 my-2 border-radius" src="{{ asset('img/gallery/gallery-2.png') }}"
                href="https://a.co/d/f5xmi3p" alt="" style="height: 275px; width: 230px;">
            <br>
            <a class="align-items-center" href="https://a.co/d/bg4dL5s" style="font-size: large;">Grab a copy on Amazon now
                <span class="social-icons-amazon">
                    <a href="https://a.co/d/bg4dL5s" target="_blank" title="amazon"><i class="fab fa-amazon"></i></a>
                </span>
            </a>
        </div>
    </div>
</div>

<script>
    // Book popup script
    window.onload = function() {
        var show_delay = 0; // Show immediately on page load (0ms delay)
        var hide_delay = 30000; // Hide after 30 seconds

        // Immediately show the popup after page is fully loaded
        document.getElementById('overlay').style.display = 'block';

        // Hide the popup after the specified duration (show_delay + hide_delay)
        setTimeout(function() {
            document.getElementById('overlay').style.display = 'none';
        }, show_delay + hide_delay);

        // Close button functionality
        document.getElementById('iclose').onclick = function() {
            document.getElementById('overlay').style.display = 'none';
        };
    };
</script>

<!-- End of Book popup -->
    <div role="main" class="main">
        <div class="owl-carousel owl-carousel-light owl-carousel-light-init-fadeIn owl-theme manual dots-inside dots-horizontal-center show-dots-hover show-dots-xs nav-style-1 nav-inside nav-inside-plus nav-dark nav-lg nav-font-size-lg show-nav-hover mb-0"
            data-plugin-options="{'autoplayTimeout': 7000}" data-dynamic-height="['650px','650px','650px','550px','500px']"
            style="height: 650px;">
            <div class="owl-stage-outer">
                <div class="owl-stage">
                    <!-- Carousel Slide 1 -->
                    <div class="owl-item position-relative"
                        style="background-image: url(img/slides/slide-corporate-3-2.jpg); background-size: cover; background-position: center;">
                        <div class="container position-relative z-index-1 h-100">
                            <div class="row align-items-center h-100">
                                <div class="col-lg-6 text-center">
                                    <div class="d-flex flex-column align-items-center justify-content-center h-100">
                                        <h3 class="position-relative text-color-white color-white text-5 line-height-5 font-weight-medium ls-0 px-4 mb-2 appear-animation"
                                            style="color: white" data-appear-animation="fadeInDownShorterPlus"
                                            data-plugin-options="{'minWindowWidth': 0}">
                                            <span class="position-absolute right-100pct top-50pct transform3dy-n50">
                                                <img src="{{ asset('img/slides/slide-title-border-light.png') }}"
                                                    class="w-auto appear-animation"
                                                    data-appear-animation="fadeInRightShorter"
                                                    data-appear-animation-delay="250"
                                                    data-plugin-options="{'minWindowWidth': 0}" alt="" />
                                            </span>
                                            A JOURNEY BACK <span class="position-relative">TO <span
                                                    class="position-absolute left-50pct transform3dx-n50 top-0 mt-4"><img
                                                        src="{{ asset('img/slides/slide-blue-line.png') }}"
                                                        class="w-auto appear-animation"
                                                        data-appear-animation="fadeInLeftShorterPlus"
                                                        data-appear-animation-delay="1000"
                                                        data-plugin-options="{'minWindowWidth': 0}"
                                                        alt="" /></span></span>
                                            <span class="position-absolute left-100pct top-50pct transform3dy-n50">
                                                <img src="{{ asset('img/slides/slide-title-border-light.png') }}"
                                                    class="w-auto appear-animation"
                                                    data-appear-animation="fadeInLeftShorter"
                                                    data-appear-animation-delay="250"
                                                    data-plugin-options="{'minWindowWidth': 0}" alt="" />
                                            </span>
                                        </h3>
                                        <h1 class="text-color-white font-weight-extra-bold text-12-5 line-height-1 mb-2 appear-animation"
                                            style="color: white" data-appear-animation="blurIn"
                                            data-appear-animation-delay="500" data-plugin-options="{'minWindowWidth': 0}">
                                            HOME & HEART</h1>
                                        <p class="text-4-5 text-color-white font-weight-light mb-0" style="color: white"
                                            data-plugin-animated-letters
                                            data-plugin-options="{'startDelay': 1000, 'minWindowWidth': 0}">welcome to The
                                            Great Return</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Carousel Slide 2 -->
                    <div class="owl-item position-relative overflow-hidden">
                        <div class="background-image-wrapper position-absolute top-0 left-0 right-0 bottom-0"
                            data-appear-animation="kenBurnsToRight" data-appear-animation-duration="13s"
                            data-plugin-options="{'minWindowWidth': 0}" data-carousel-onchange-show
                            style="background-image: url(img/slides/slide-corporate-3-a.jpg); background-size: cover; background-position: center;">
                        </div>
                        <div class="container position-relative z-index-3 h-100">
                            <div class="row justify-content-center align-items-center h-100">
                                <div class="col-lg-7">
                                    <div class="d-flex flex-column align-items-center">
                                        <h2 class="text-color-dark font-weight-extra-bold text-12-5 line-height-1 text-center mb-3 appear-animation"
                                            data-appear-animation="blurIn" data-appear-animation-delay="500"
                                            data-plugin-options="{'minWindowWidth': 0}">HOMECOMING</h2>
                                        <p class="text-4-5 text-color-dark font-weight-light text-center mb-4"
                                            data-plugin-animated-letters
                                            data-plugin-options="{'startDelay': 1000, 'minWindowWidth': 0, 'animationSpeed': 30}">
                                            Where Every Story Begins Anew</p>
                                        <a href="#"
                                            class="btn btn-secondary btn-modern font-weight-bold text-2 py-3 btn-px-5 mt-2 appear-animation"
                                            data-appear-animation="fadeInUpShorter" data-appear-animation-delay="2500"
                                            data-plugin-options="{'minWindowWidth': 0}">DISCOVER MORE <i
                                                class="fas fa-arrow-right ms-2"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="owl-nav">
                <button type="button" role="presentation" class="owl-prev" aria-label="Previous"></button>
                <button type="button" role="presentation" class="owl-next" aria-label="Next"></button>
            </div>
            <div class="owl-dots mb-5">
                <button role="button" class="owl-dot active"><span></span></button>
                <button role="button" class="owl-dot"><span></span></button>
            </div>
        </div>

        <section class="section section-height-3 bg-color-grey m-0 border-0 mb-50">
            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-lg-6 pb-sm-4 pb-lg-0 pe-lg-5 mb-sm-5 mb-lg-0">
                        <h2 class="text-color-dark font-weight-normal text-6 mb-2"> We are <strong
                                class="font-weight-extra-bold">TGR Africa</strong></h2>
                        <p class="lead pe-lg-5 me-lg-5">We are dedicated to rebuilding, reconnecting and revitalising the
                            African diasporas relationship with Africa</p>
                        <a href="{{ route('about.mission') }}"
                            class="btn btn-dark font-weight-semibold btn-px-4 btn-py-2 text-2">LEARN MORE</a>
                    </div>
                    <div class="col-sm-8 col-md-6 col-lg-4 offset-sm-4 offset-md-4 offset-lg-2 position-relative mt-sm-5"
                        style="top: 1.7rem;">
                        <img src="{{ asset('img/generic/generic-corporate-3-1.png') }}"
                            class="img-fluid position-absolute d-none d-sm-block appear-animation"
                            data-appear-animation="expandIn" data-appear-animation-delay="300"
                            style="top: 10%; left: -50%;" alt="" />
                        <img src="{{ asset('img/generic/generic-corporate-3-2.png') }}"
                            class="img-fluid position-absolute d-none d-sm-block appear-animation"
                            data-appear-animation="expandIn" style="top: -33%; left: -29%;" alt="" />
                        <img src="{{ asset('img/generic/generic-corporate-3-3.png') }}"
                            class="img-fluid position-relative appear-animation mb-2" data-appear-animation="expandIn"
                            data-appear-animation-delay="600" alt="" />
                    </div>
                </div>
            </div>
        </section>



        <div class="home-intro bg-secondary">
            <div class="container">

                <div class="row align-items-center">
                    <div class="col-lg-8">
                        <p>
                            If you are ready to join
                            <span class="highlighted-word">‘The Great Return’</span>
                            {{-- <span>, please book a consultation or email us.</span> --}}
                        </p>
                    </div>
                    <div class="col-lg-4">
                        <div class="get-started text-start text-lg-end">
                            <a href="{{ route('features.consult') }}"
                                class="btn btn-dark btn-lg text-3 font-weight-semibold px-4 py-3">Book a
                                Consultation</a>

                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>

    <section class="section section-height-3 border-0 mt-0 mb-0">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h2 class="font-weight-normal text-6 mb-3"><strong class="font-weight-extra-bold">Meet</strong> The
                        Founders</h2>
                </div>
            </div>
            <div class="row">
                <!-- Founder 1 -->
                <div class="col-md-6">
                    <div class="row align-items-center pt-4 appear-animation" data-appear-animation="fadeInLeftShorter">
                        <div class="col-md-4 mb-4 mb-md-0">
                            <img class="img-fluid scale-2 pe-5 pe-md-0 my-4" src="{{ asset('img/lordy.png') }}"
                                alt="Lordy Emmen" />
                        </div>
                        <div class="col-md-8 ps-md-5">
                            <p class="text-4" style="text-align: justify;">
                                <strong>Lordy Emmen | Founder & CEO of TGR Africa </strong>
                            </p>
                            <p><strong>Lordy Emmen</strong> is a diaspora entrepreneur, a diaspora engagement and investment
                                activist,
                                a self-proclaimed African Development Ambassador and author of the book <strong>‘The Great
                                    Return’</strong>.
                                She is of Ghanian decent, born and bred in Ghana where she lived up until she completed her
                                undergraduate degree at the University of Ghana, Legon,..
                                <!--with a BA in Economics and Resource -->
                        </div>
                    </div>
                    <hr class="solid my-5">
                </div>
                <!-- Founder 2 -->
                <div class="col-md-6">
                    <div class="row align-items-center pt-4 appear-animation" data-appear-animation="fadeInRightShorter">
                        <div class="col-md-4 mb-4 mb-md-0">
                            <img class="img-fluid scale-2 pe-5 pe-md-0 my-4" src="{{ asset('img/clement.png') }}"
                                alt="Agyegewe Chanayireh" />
                        </div>
                        <div class="col-md-8 ps-md-5">
                            <p class="text-4" style="text-align: justify;">
                                <strong>Agyegewe Chanayireh | Co-Founder & COO</strong>
                            </p>
                            <p><strong>Agyegewe Chanayireh</strong> is the Co-Founder and Chief Operations Officer
                                of <strong>TGR Africa</strong>. He also
                                helped co-write <strong>‘The Great Return’</strong> alongside his business
                                partner<strong>Lordy Emmen</strong>.
                                Agyegewe’s interest in joining the great return begun in his students’
                                days at the University of Manchester where he studied Modern Middle Eastern History...
                                <!-- Middle Eastern History.
                                    The course was intended to prepare him to work as a foreign diplomat in the Middle East on
                                    behalf of the British Government, and through his studies, he was awakened to
                                    colonialism and imperialism and the long-term consequences they have had on the developing
                                    world. -->
                            </p>
                        </div>
                    </div>
                    <hr class="solid my-5">

                </div>
            </div>
            <div class="row">
                <div class="col-12 text-center">
                    <a href="{{ route('about.founder') }}"
                        class="btn btn-dark font-weight-semibold rounded-0 px-5 btn-py-2 text-2 p-relative bottom-3">Read
                        More About Founders</a>
                </div>
            </div>
        </div>
    </section>


    <section class="section section-secondary border-0 py-0 m-0 appear-animation" data-appear-animation="fadeIn">
        <div class="container">
            <div class="row align-items-center justify-content-center justify-content-lg-between pb-5 pb-lg-0">
                <div class="col-lg-5 order-2 order-lg-1 pt-4 pt-lg-0 pb-5 pb-lg-0 mt-5 mt-lg-0 appear-animation"
                    data-appear-animation="fadeInRightShorter" data-appear-animation-delay="200">
                    <h2 class="font-weight-bold text-color-light text-7 mb-2">The Great Return</h2>
                    <p class="lead font-weight-light text-color-light text-4">Book</p>
                    <p class="font-weight-light text-color-light text-2 mb-4 opacity-7">Since 2019, there has been a
                        growing movement taking place amongst the
                        African Diaspora population living in the Western world. Why are thousands of them
                        deciding to abandon the West and relocate back to Africa and start new lives?</p>
                    <a href="https://a.co/d/bg4dL5s" class="btn btn-primary btn-px-5 btn-py-2 text-2">Get it on Amazon</a>
                </div>
                <div class="col-9 offset-lg-1 col-lg-5 order-1 order-lg-2 scale-2">
                    <img class="img-fluid box-shadow-3 my-2 border-radius" src="{{ asset('img/gallery/gallery-1.png') }}"
                        alt="">
                </div>
            </div>
        </div>
    </section>
    <section class="section section-no-background section-height-4 border-0 pb-5 m-0 appear-animation"
        data-appear-animation="fadeIn">
        <div class="container">
            <div class="row justify-content-center recent-posts appear-animation" data-appear-animation="fadeInUpShorter"
                data-appear-animation-delay="200">

                <div class="text-center">
                    <div class="col">
                        <h2 class="font-weight-normal text-6 mt-4">Latest <strong
                                class="font-weight-extra-bold">Blog</strong></h2>
                    </div>
                </div>
                <?php

                use App\Models\Blog;

                $latest_blogs = Blog::latest()->paginate(4);
                ?>
                <div class="blog-posts">
                    <div class="row">
                        @foreach ($latest_blogs as $blog)
                            <div class="col-md-4 col-lg-3">
                                <article class="post post-medium border-0 pb-0 mb-5">
                                    {{-- <div class="post-image">
                                        <a href="{{ route('newssingle', $blog->uuid) }}">
                            <img src="{{ asset('img/blog/medium/' . $blog->image) }}" class="img-fluid img-thumbnail img-thumbnail-no-borders rounded-0" alt="{{ $blog->title }}" />
                            </a>
                    </div> --}}

                                    <div class="post-content">
                                        <h2 class="font-weight-semibold text-5 line-height-6 mt-3 mb-2">
                                            <a href="{{ route('newssingle', $blog->uuid) }}">{{ $blog->title }}</a>
                                        </h2>
                                        <p>{{ Str::limit($blog->content, 100, '...') }}</p>
                                        <div class="post-meta">
                                            <span class="d-block mt-2">
                                                <a href="{{ route('newssingle', $blog->uuid) }}"
                                                    class="btn btn-xs btn-light text-1 text-uppercase">Read More</a>
                                            </span>
                                        </div>
                                    </div>
                                </article>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    <hr>

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

    <!-- <script>
        document.addEventListener("DOMContentLoaded", function() {
            var show_delay = 0; // Show immediately on page load
            var hide_delay = 10000; // Hide after 30 seconds
            setTimeout(function() {
                document.getElementById('overlay').style.display = 'block';
            }, show_delay);
            // Hide the popup after the specified duration
            setTimeout(function() {
                document.getElementById('overlay').style.display = 'none';
            }, show_delay + hide_delay);
            // Close button functionality
            document.getElementById('iclose').onclick = function() {
                document.getElementById('overlay').style.display = 'none';
            };
        });
    </script> -->
@endsection
