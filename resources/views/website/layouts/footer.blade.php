<footer id="footer">
    @php
    use Carbon\Carbon;
    @endphp

    <div class="container">
        <div class="footer-ribbon"><span>Get in Touch</span></div>
        <div class="row py-5 my-4">
            <div class="col-md-6 col-lg-4 mb-4 mb-lg-0">
                <h5 class="text-3 mb-3">The Great Return</h5>
                <p class="pe-1">
                    Our primary focus is to help facilitate
                    engagement between the African Diaspora and Africa on a business
                    and investment level. We believe these two key areas offer the best solution
                    for sustainable long term development in Africa.
                </p>
                <div class="alert alert-success d-none" id="newsletterSuccess">
                    <strong>Success!</strong> <br>News letter Subscription successful. <br> Thank you.
                </div>
                <div class="alert alert-danger d-none" id="newsletterError"></div>
                <!-- <form id="newsletterForm" action="#" method="POST" class="me-4 mb-3 mb-md-0">
                    <div class="input-group input-group-rounded">
                        <input class="form-control form-control-sm bg-light" placeholder="Email Address" name="newsletterEmail" id="newsletterEmail" type="email" />
                        <button class="btn btn-light text-color-dark" type="submit">
                            <strong>GO!</strong>
                        </button>
                    </div>
                </form> -->
            </div>
            <?php

            use App\Models\Blog;

            $latest_blogs = Blog::latest()->paginate(4);
            ?>
            <div class="col-md-6 col-lg-3 mb-4 mb-lg-0">
                <h5 class="text-3 mb-3">LATEST POSTS</h5>
                <ul class="list-unstyled mb-0">
                    @foreach ($latest_blogs as $blog)
                    <li class="mb-2 pb-1">
                        <a href="{{ route('newssingle', $blog->uuid) }}">
                            <p class="text-3 text-color-light opacity-8 mb-0">
                                <i class="fas fa-angle-right text-color-secondary"></i>
                                <strong class="ms-2 font-weight-semibold">{{ Str::limit($blog->title, 15, '...') }}</strong>
                            </p>
                            <p class="text-2 mb-0"></p>
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
            <div class="col-md-6 col-lg-3 mb-4 mb-md-0">
                <div class="contact-details">
                    <h5 class="text-3 mb-3">CONTACT US</h5>
                    <ul class="list list-icons list-icons-lg">
                        <!-- <li class="mb-1">
                            <i class="fa fa-phone text-color-secondary"></i>
                            <p class="m-0">
                                <a href="tel:+233209398306">+233209398306</a>
                            </p>
                            <p class="m-0">GB33 Nii Tsoku Komletse, Abbey St</p>
                            <p class="m-0">Gbawe Zero, Greater Accra</p>
                        </li>-->
                        <li class="mb-1">
                            <i class="fab fa-whatsapp text-color-secondary"></i>
                            <p class="m-0">
                                <a href="tel:+233500200335">+233500200335</a>
                            </p>
                        </li>
                        <li class="mb-1">
                            <i class="far fa-envelope text-color-secondary"></i>
                            <p class="m-0">
                                <a href="mailto:info@tgrafrica.com">info@tgrafrica.com</a>
                            </p>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-6 col-lg-2">
                <h5 class="text-3 mb-3">FOLLOW US</h5>
                <ul class="social-icons">
                    <li class="social-icons-facebook">
                        <iframe src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fweb.facebook.com%2Fprofile.php%3Fid%3D61559081140764%26__cft__[0]%3DAZUq_JhwXt78n3dLKy4eHyXVPdiFO521vSa3jEDlQOyTlC7k3kMh6BDHTUyHnJXq8AdWYhQaMVgDpeP617r7vIDpoY9mbmYKSZaRfMOI1TPHEqRRqev0j5O6egsxBNaT9W7xP-3fyZFHZt7RBhoXdZwQydiuVqts4btc-QeESndC2nJWuNq3UbuYNN8KtA7HEauGXqbRiFhkvXkucvvGfL8M0_9EW1OEkOuQko8wu8Tmp0HMnW1hWio_x75a8bRyswg&tabs=timeline&width=200&height=70&small_header=true&adapt_container_width=true&hide_cover=true&show_facepile=false&appId=5035938946497779" width="200" height="70" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowfullscreen="true" data-theme="dark" allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"></iframe>
                    </li>
                    <li class="social-icons-linkedin">
                        <script src="https://apis.google.com/js/platform.js"></script>

                        <div class="g-ytsubscribe" data-channelid="UCnl1Z1PExMQGPiwUEhbQCWQ" data-layout="full" data-count="default" rel="noopener noreferrer"></div>
                    </li>
                    <li class="social-icons-twitter"><a href="http://www.twitter.com/" target="_blank"
                            title="X"><i class="fab fa-x-twitter"></i></a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="footer-copyright">
        <div class="container py-2">
            <div class="row py-4">
                <div class="col-lg-1 d-flex align-items-center justify-content-center justify-content-lg-start mb-2 mb-lg-0">
                    <a href="{{ route('home') }}" class="logo pe-0 pe-lg-3">
                        <img alt="TGR Logo" src="{{ asset('img/logo-footer.png') }}" class="opacity-5" width="49" height="22" data-plugin-options="{'appearEffect': 'fadeIn'}" />
                    </a>
                </div>
                <div class="col-lg-7 d-flex align-items-center justify-content-center justify-content-lg-start mb-4 mb-lg-0">
                    <p>© Copyright {{ Carbon::now()->year }} {{ Carbon::now()->format('j M Y, g:i A') }}. All Rights Reserved. | By <a href="http://www.wantechsolutions.com">Wan Tech Solutions</a></p>
                </div>
                {{-- <div class="col-lg-5 d-flex align-items-center justify-content-center justify-content-lg-end">
                    <p></p>
                </div> --}}

                {{-- <div
                    class="col-lg-7 d-flex align-items-center justify-content-center justify-content-lg-start mb-4 mb-lg-0">
                    <p>© Copyright 2024. All Rights Reserved. | By <a href="http://www.wantechsolutions.com">Wan Tech
                            Solutions</a></p>
                </div> --}}
                <div class="col-lg-4 d-flex align-items-center justify-content-center justify-content-lg-end">
                    <nav id="sub-menu">
                        <ul>
                            <li>
                                <i class="fas fa-angle-right"></i><a href="javascript:void(0)" class="ms-1 text-decoration-none">FAQ's</a>
                            </li>
                            <li>
                                <i class="fas fa-angle-right"></i><a href="javascript:void(0)" class="ms-1 text-decoration-none">Available Books</a>
                            </li>
                            <li>
                                <i class="fas fa-angle-right"></i><a href="{{ route('contact') }}" class="ms-1 text-decoration-none">Contact Us</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</footer>