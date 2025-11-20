@extends('website.layouts.main')

@section('title')
    Consultation
@endsection

@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <style>
        .flatpickr-calendar {
            padding: 0 !important;
            margin: 0 !important;
            border: 1px solid #ddd;
        }

        .date-time-container {
            overflow: visible;
            position: relative;
            width: 100%;
        }
    </style>

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
                        data-appear-animation-delay="200">BOOK A <strong class="font-weight-extra-bold">
                            CONSULTATION</strong></h2>
                </div>
                <div class="overflow-hidden mb-4">
                    <p class="lead mb-0 appear-animation" style="text-align: justify" data-appear-animation="maskUp"
                        data-appear-animation-delay="400">We understand everyone is at different stages of
                        their great return journey. We want to
                        provide you with all the necessary support along your journey to the best of our ability.
                        We believe success in joining the great return will depend on the quality of our
                        transition preparation. We take transition preparation very seriously and our goal is to
                        ensure that we can provide you with all the necessary assistance you may need.</p>


                </div>
            </div>
            <div class="col-lg-4">
                <div class="testimonial testimonial-secondary appear-animation" data-appear-animation="fadeIn"
                    data-appear-animation-delay="800">
                    <blockquote>
                        <p class="mb-0">Book a free
                            consultation to
                            discuss your TGR needs with one of our advisors.
                        </p>
                        <hr>
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <a href="#" class="btn btn-dark font-weight-semibold btn-px-4 btn-py-2 text-2"
                            data-bs-toggle="modal" data-bs-target="#questionnaireModal">Book a Consultation</a>
                    </blockquote>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="infoModalLabel">Information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{ session('info') }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
                                            circumstances and needs, you will first need to complete a short questionnaire.
                                            This is
                                            designed to evaluate how ready you are to join the great return.</p>
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


    <div class="modal fade" id="questionnaireModal" tabindex="-1" aria-labelledby="questionnaireModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header justify-content-center custom-modal-header">
                    <h5 class="modal-title text-center">Book a free consultation to discuss your TGR needs with an advisor.
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body custom-modal-body">
                    <form id="questionnaireForm" action="{{ route('submit-questionnaire') }}" method="POST">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" required
                                    placeholder="Enter your name">
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required
                                    placeholder="Enter your email">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Phone</label>
                            <input type="text" class="form-control" id="contact" name="contact" required>
                        </div>
                        <div class="form-group mb-0">
                            <div class="row">
                                <div class="form-group col-sm-6 mb-3">
                                    <label class="form-label mb-1 text-2">Country Of Residence</label>

                                    <select class="form-control text-3 h-auto py-2" name="country_of_residence">
                                        <option value="" disabled
                                            {{ old('country_of_residence') ? '' : 'selected' }}>
                                            Select your country
                                        </option>
                                        <option value="Afghanistan"
                                            {{ old('country_of_residence') == 'Afghanistan' ? 'selected' : '' }}>
                                            Afghanistan (+93)
                                        </option>
                                        <option value="Albania"
                                            {{ old('country_of_residence') == 'Albania' ? 'selected' : '' }}>
                                            Albania (+355)
                                        </option>
                                        <option value="Algeria"
                                            {{ old('country_of_residence') == 'Algeria' ? 'selected' : '' }}>
                                            Algeria (+213)
                                        </option>
                                        <option value="Andorra"
                                            {{ old('country_of_residence') == 'Andorra' ? 'selected' : '' }}>
                                            Andorra (+376)
                                        </option>
                                        <option value="Angola"
                                            {{ old('country_of_residence') == 'Angola' ? 'selected' : '' }}>
                                            Angola (+244)
                                        </option>
                                        <option value="Antigua and Barbuda"
                                            {{ old('country_of_residence') == 'Antigua and Barbuda' ? 'selected' : '' }}>
                                            Antigua and Barbuda (+1-268)
                                        </option>
                                        <option value="Argentina"
                                            {{ old('country_of_residence') == 'Argentina' ? 'selected' : '' }}>
                                            Argentina (+54)
                                        </option>
                                        <option value="Armenia"
                                            {{ old('country_of_residence') == 'Armenia' ? 'selected' : '' }}>
                                            Armenia (+374)
                                        </option>
                                        <option value="Australia"
                                            {{ old('country_of_residence') == 'Australia' ? 'selected' : '' }}>
                                            Australia (+61)
                                        </option>
                                        <option value="Austria"
                                            {{ old('country_of_residence') == 'Austria' ? 'selected' : '' }}>
                                            Austria (+43)
                                        </option>
                                        <option value="Azerbaijan"
                                            {{ old('country_of_residence') == 'Azerbaijan' ? 'selected' : '' }}>
                                            Azerbaijan (+994)
                                        </option>
                                        <option value="Bahamas"
                                            {{ old('country_of_residence') == 'Bahamas' ? 'selected' : '' }}>
                                            Bahamas (+1-242)
                                        </option>
                                        <option value="Bahrain"
                                            {{ old('country_of_residence') == 'Bahrain' ? 'selected' : '' }}>
                                            Bahrain (+973)
                                        </option>
                                        <option value="Bangladesh"
                                            {{ old('country_of_residence') == 'Bangladesh' ? 'selected' : '' }}>
                                            Bangladesh (+880)
                                        </option>
                                        <option value="Barbados"
                                            {{ old('country_of_residence') == 'Barbados' ? 'selected' : '' }}>
                                            Barbados (+1-246)
                                        </option>
                                        <option value="Belarus"
                                            {{ old('country_of_residence') == 'Belarus' ? 'selected' : '' }}>
                                            Belarus (+375)
                                        </option>
                                        <option value="Belgium"
                                            {{ old('country_of_residence') == 'Belgium' ? 'selected' : '' }}>
                                            Belgium (+32)
                                        </option>
                                        <option value="Belize"
                                            {{ old('country_of_residence') == 'Belize' ? 'selected' : '' }}>
                                            Belize (+501)
                                        </option>
                                        <option value="Benin"
                                            {{ old('country_of_residence') == 'Benin' ? 'selected' : '' }}>
                                            Benin (+229)
                                        </option>
                                        <option value="Bhutan"
                                            {{ old('country_of_residence') == 'Bhutan' ? 'selected' : '' }}>
                                            Bhutan (+975)
                                        </option>
                                        <option value="Bolivia"
                                            {{ old('country_of_residence') == 'Bolivia' ? 'selected' : '' }}>
                                            Bolivia (+591)
                                        </option>
                                        <option value="Bosnia and Herzegovina"
                                            {{ old('country_of_residence') == 'Bosnia and Herzegovina' ? 'selected' : '' }}>
                                            Bosnia and Herzegovina (+387)
                                        </option>
                                        <option value="Botswana"
                                            {{ old('country_of_residence') == 'Botswana' ? 'selected' : '' }}>
                                            Botswana (+267)
                                        </option>
                                        <option value="Brazil"
                                            {{ old('country_of_residence') == 'Brazil' ? 'selected' : '' }}>
                                            Brazil (+55)
                                        </option>
                                        <option value="Brunei"
                                            {{ old('country_of_residence') == 'Brunei' ? 'selected' : '' }}>
                                            Brunei (+673)
                                        </option>
                                        <option value="Bulgaria"
                                            {{ old('country_of_residence') == 'Bulgaria' ? 'selected' : '' }}>
                                            Bulgaria (+359)
                                        </option>
                                        <option value="Burkina Faso"
                                            {{ old('country_of_residence') == 'Burkina Faso' ? 'selected' : '' }}>
                                            Burkina Faso (+226)
                                        </option>
                                        <option value="Burundi"
                                            {{ old('country_of_residence') == 'Burundi' ? 'selected' : '' }}>
                                            Burundi (+257)
                                        </option>
                                        <option value="Cambodia"
                                            {{ old('country_of_residence') == 'Cambodia' ? 'selected' : '' }}>
                                            Cambodia (+855)
                                        </option>
                                        <option value="Cameroon"
                                            {{ old('country_of_residence') == 'Cameroon' ? 'selected' : '' }}>
                                            Cameroon (+237)
                                        </option>
                                        <option value="Canada"
                                            {{ old('country_of_residence') == 'Canada' ? 'selected' : '' }}>
                                            Canada (+1)
                                        </option>
                                        <option value="Cape Verde"
                                            {{ old('country_of_residence') == 'Cape Verde' ? 'selected' : '' }}>
                                            Cape Verde (+238)
                                        </option>
                                        <option value="Central African Republic"
                                            {{ old('country_of_residence') == 'Central African Republic' ? 'selected' : '' }}>
                                            Central African Republic (+236)
                                        </option>
                                        <option value="Chad"
                                            {{ old('country_of_residence') == 'Chad' ? 'selected' : '' }}>
                                            Chad (+235)
                                        </option>
                                        <option value="Chile"
                                            {{ old('country_of_residence') == 'Chile' ? 'selected' : '' }}>
                                            Chile (+56)
                                        </option>
                                        <option value="China"
                                            {{ old('country_of_residence') == 'China' ? 'selected' : '' }}>
                                            China (+86)
                                        </option>
                                        <option value="Colombia"
                                            {{ old('country_of_residence') == 'Colombia' ? 'selected' : '' }}>
                                            Colombia (+57)
                                        </option>
                                        <option value="Comoros"
                                            {{ old('country_of_residence') == 'Comoros' ? 'selected' : '' }}>
                                            Comoros (+269)
                                        </option>
                                        <option value="Congo"
                                            {{ old('country_of_residence') == 'Congo' ? 'selected' : '' }}>
                                            Congo (+242)
                                        </option>
                                        <option value="Costa Rica"
                                            {{ old('country_of_residence') == 'Costa Rica' ? 'selected' : '' }}>
                                            Costa Rica (+506)
                                        </option>
                                        <option value="Croatia"
                                            {{ old('country_of_residence') == 'Croatia' ? 'selected' : '' }}>
                                            Croatia (+385)
                                        </option>
                                        <option value="Cuba"
                                            {{ old('country_of_residence') == 'Cuba' ? 'selected' : '' }}>
                                            Cuba (+53)
                                        </option>
                                        <option value="Cyprus"
                                            {{ old('country_of_residence') == 'Cyprus' ? 'selected' : '' }}>
                                            Cyprus (+357)
                                        </option>
                                        <option value="Czech Republic"
                                            {{ old('country_of_residence') == 'Czech Republic' ? 'selected' : '' }}>
                                            Czech Republic (+420)
                                        </option>
                                        <option value="Denmark"
                                            {{ old('country_of_residence') == 'Denmark' ? 'selected' : '' }}>
                                            Denmark (+45)
                                        </option>
                                        <option value="Djibouti"
                                            {{ old('country_of_residence') == 'Djibouti' ? 'selected' : '' }}>
                                            Djibouti (+253)
                                        </option>
                                        <option value="Dominica"
                                            {{ old('country_of_residence') == 'Dominica' ? 'selected' : '' }}>
                                            Dominica (+1-767)
                                        </option>
                                        <option value="Dominican Republic"
                                            {{ old('country_of_residence') == 'Dominican Republic' ? 'selected' : '' }}>
                                            Dominican Republic (+1-809)
                                        </option>
                                        <option value="Ecuador"
                                            {{ old('country_of_residence') == 'Ecuador' ? 'selected' : '' }}>
                                            Ecuador (+593)
                                        </option>
                                        <option value="Egypt"
                                            {{ old('country_of_residence') == 'Egypt' ? 'selected' : '' }}>
                                            Egypt (+20)
                                        </option>
                                        <option value="El Salvador"
                                            {{ old('country_of_residence') == 'El Salvador' ? 'selected' : '' }}>
                                            El Salvador (+503)
                                        </option>
                                        <option value="Equatorial Guinea"
                                            {{ old('country_of_residence') == 'Equatorial Guinea' ? 'selected' : '' }}>
                                            Equatorial Guinea (+240)
                                        </option>
                                        <option value="Eritrea"
                                            {{ old('country_of_residence') == 'Eritrea' ? 'selected' : '' }}>
                                            Eritrea (+291)
                                        </option>
                                        <option value="Estonia"
                                            {{ old('country_of_residence') == 'Estonia' ? 'selected' : '' }}>
                                            Estonia (+372)
                                        </option>
                                        <option value="Eswatini"
                                            {{ old('country_of_residence') == 'Eswatini' ? 'selected' : '' }}>
                                            Eswatini (+268)
                                        </option>
                                        <option value="Ethiopia"
                                            {{ old('country_of_residence') == 'Ethiopia' ? 'selected' : '' }}>
                                            Ethiopia (+251)
                                        </option>
                                        <option value="Fiji"
                                            {{ old('country_of_residence') == 'Fiji' ? 'selected' : '' }}>
                                            Fiji (+679)
                                        </option>
                                        <option value="Finland"
                                            {{ old('country_of_residence') == 'Finland' ? 'selected' : '' }}>
                                            Finland (+358)
                                        </option>
                                        <option value="France"
                                            {{ old('country_of_residence') == 'France' ? 'selected' : '' }}>
                                            France (+33)
                                        </option>
                                        <option value="Gabon"
                                            {{ old('country_of_residence') == 'Gabon' ? 'selected' : '' }}>
                                            Gabon (+241)
                                        </option>
                                        <option value="Gambia"
                                            {{ old('country_of_residence') == 'Gambia' ? 'selected' : '' }}>
                                            Gambia (+220)
                                        </option>
                                        <option value="Georgia"
                                            {{ old('country_of_residence') == 'Georgia' ? 'selected' : '' }}>
                                            Georgia (+995)
                                        </option>
                                        <option value="Germany"
                                            {{ old('country_of_residence') == 'Germany' ? 'selected' : '' }}>
                                            Germany (+49)
                                        </option>
                                        <option value="Ghana"
                                            {{ old('country_of_residence') == 'Ghana' ? 'selected' : '' }}>
                                            Ghana (+233)
                                        </option>
                                        <option value="Greece"
                                            {{ old('country_of_residence') == 'Greece' ? 'selected' : '' }}>
                                            Greece (+30)
                                        </option>
                                        <option value="Grenada"
                                            {{ old('country_of_residence') == 'Grenada' ? 'selected' : '' }}>
                                            Grenada (+1-473)
                                        </option>
                                        <option value="Guatemala"
                                            {{ old('country_of_residence') == 'Guatemala' ? 'selected' : '' }}>
                                            Guatemala (+502)
                                        </option>
                                        <option value="Guinea"
                                            {{ old('country_of_residence') == 'Guinea' ? 'selected' : '' }}>
                                            Guinea (+224)
                                        </option>
                                        <option value="Guinea-Bissau"
                                            {{ old('country_of_residence') == 'Guinea-Bissau' ? 'selected' : '' }}>
                                            Guinea-Bissau (+245)
                                        </option>
                                        <option value="Guyana"
                                            {{ old('country_of_residence') == 'Guyana' ? 'selected' : '' }}>
                                            Guyana (+592)
                                        </option>
                                        <option value="Haiti"
                                            {{ old('country_of_residence') == 'Haiti' ? 'selected' : '' }}>
                                            Haiti (+509)
                                        </option>
                                        <option value="Honduras"
                                            {{ old('country_of_residence') == 'Honduras' ? 'selected' : '' }}>
                                            Honduras (+504)
                                        </option>
                                        <option value="Hungary"
                                            {{ old('country_of_residence') == 'Hungary' ? 'selected' : '' }}>
                                            Hungary (+36)
                                        </option>
                                        <option value="Iceland"
                                            {{ old('country_of_residence') == 'Iceland' ? 'selected' : '' }}>
                                            Iceland (+354)
                                        </option>
                                        <option value="India"
                                            {{ old('country_of_residence') == 'India' ? 'selected' : '' }}>
                                            India (+91)
                                        </option>
                                        <option value="Indonesia"
                                            {{ old('country_of_residence') == 'Indonesia' ? 'selected' : '' }}>
                                            Indonesia (+62)
                                        </option>
                                        <option value="Iran"
                                            {{ old('country_of_residence') == 'Iran' ? 'selected' : '' }}>
                                            Iran (+98)
                                        </option>
                                        <option value="Iraq"
                                            {{ old('country_of_residence') == 'Iraq' ? 'selected' : '' }}>
                                            Iraq (+964)
                                        </option>
                                        <option value="Ireland"
                                            {{ old('country_of_residence') == 'Ireland' ? 'selected' : '' }}>
                                            Ireland (+353)
                                        </option>
                                        <option value="Israel"
                                            {{ old('country_of_residence') == 'Israel' ? 'selected' : '' }}>
                                            Israel (+972)
                                        </option>
                                        <option value="Italy"
                                            {{ old('country_of_residence') == 'Italy' ? 'selected' : '' }}>
                                            Italy (+39)
                                        </option>
                                        <option value="Jamaica"
                                            {{ old('country_of_residence') == 'Jamaica' ? 'selected' : '' }}>
                                            Jamaica (+1-876)
                                        </option>
                                        <option value="Japan"
                                            {{ old('country_of_residence') == 'Japan' ? 'selected' : '' }}>
                                            Japan (+81)
                                        </option>
                                        <option value="Jordan"
                                            {{ old('country_of_residence') == 'Jordan' ? 'selected' : '' }}>
                                            Jordan (+962)
                                        </option>
                                        <option value="Kazakhstan"
                                            {{ old('country_of_residence') == 'Kazakhstan' ? 'selected' : '' }}>
                                            Kazakhstan (+7)
                                        </option>
                                        <option value="Kenya"
                                            {{ old('country_of_residence') == 'Kenya' ? 'selected' : '' }}>
                                            Kenya (+254)
                                        </option>
                                        <option value="Kiribati"
                                            {{ old('country_of_residence') == 'Kiribati' ? 'selected' : '' }}>
                                            Kiribati (+686)
                                        </option>
                                        <option value="Korea, North"
                                            {{ old('country_of_residence') == 'Korea, North' ? 'selected' : '' }}>
                                            Korea, North (+850)
                                        </option>
                                        <option value="Korea, South"
                                            {{ old('country_of_residence') == 'Korea, South' ? 'selected' : '' }}>
                                            Korea, South (+82)
                                        </option>
                                        <option value="Kosovo"
                                            {{ old('country_of_residence') == 'Kosovo' ? 'selected' : '' }}>
                                            Kosovo (+383)
                                        </option>
                                        <option value="Kuwait"
                                            {{ old('country_of_residence') == 'Kuwait' ? 'selected' : '' }}>
                                            Kuwait (+965)
                                        </option>
                                        <option value="Kyrgyzstan"
                                            {{ old('country_of_residence') == 'Kyrgyzstan' ? 'selected' : '' }}>
                                            Kyrgyzstan (+996)
                                        </option>
                                        <option value="Laos"
                                            {{ old('country_of_residence') == 'Laos' ? 'selected' : '' }}>
                                            Laos (+856)
                                        </option>
                                        <option value="Latvia"
                                            {{ old('country_of_residence') == 'Latvia' ? 'selected' : '' }}>
                                            Latvia (+371)
                                        </option>
                                        <option value="Lebanon"
                                            {{ old('country_of_residence') == 'Lebanon' ? 'selected' : '' }}>
                                            Lebanon (+961)
                                        </option>
                                        <option value="Lesotho"
                                            {{ old('country_of_residence') == 'Lesotho' ? 'selected' : '' }}>
                                            Lesotho (+266)
                                        </option>
                                        <option value="Liberia"
                                            {{ old('country_of_residence') == 'Liberia' ? 'selected' : '' }}>
                                            Liberia (+231)
                                        </option>
                                        <option value="Libya"
                                            {{ old('country_of_residence') == 'Libya' ? 'selected' : '' }}>
                                            Libya (+218)
                                        </option>
                                        <option value="Liechtenstein"
                                            {{ old('country_of_residence') == 'Liechtenstein' ? 'selected' : '' }}>
                                            Liechtenstein (+423)
                                        </option>
                                        <option value="Lithuania"
                                            {{ old('country_of_residence') == 'Lithuania' ? 'selected' : '' }}>
                                            Lithuania (+370)
                                        </option>
                                        <option value="Luxembourg"
                                            {{ old('country_of_residence') == 'Luxembourg' ? 'selected' : '' }}>
                                            Luxembourg (+352)
                                        </option>
                                        <option value="Madagascar"
                                            {{ old('country_of_residence') == 'Madagascar' ? 'selected' : '' }}>
                                            Madagascar (+261)
                                        </option>
                                        <option value="Malawi"
                                            {{ old('country_of_residence') == 'Malawi' ? 'selected' : '' }}>
                                            Malawi (+265)
                                        </option>
                                        <option value="Malaysia"
                                            {{ old('country_of_residence') == 'Malaysia' ? 'selected' : '' }}>
                                            Malaysia (+60)
                                        </option>
                                        <option value="Maldives"
                                            {{ old('country_of_residence') == 'Maldives' ? 'selected' : '' }}>
                                            Maldives (+960)
                                        </option>
                                        <option value="Mali"
                                            {{ old('country_of_residence') == 'Mali' ? 'selected' : '' }}>
                                            Mali (+223)
                                        </option>
                                        <option value="Malta"
                                            {{ old('country_of_residence') == 'Malta' ? 'selected' : '' }}>
                                            Malta (+356)
                                        </option>
                                        <option value="Marshall Islands"
                                            {{ old('country_of_residence') == 'Marshall Islands' ? 'selected' : '' }}>
                                            Marshall Islands (+692)
                                        </option>
                                        <option value="Mauritania"
                                            {{ old('country_of_residence') == 'Mauritania' ? 'selected' : '' }}>
                                            Mauritania (+222)
                                        </option>
                                        <option value="Mauritius"
                                            {{ old('country_of_residence') == 'Mauritius' ? 'selected' : '' }}>
                                            Mauritius (+230)
                                        </option>
                                        <option value="Mexico"
                                            {{ old('country_of_residence') == 'Mexico' ? 'selected' : '' }}>
                                            Mexico (+52)
                                        </option>
                                        <option value="Micronesia"
                                            {{ old('country_of_residence') == 'Micronesia' ? 'selected' : '' }}>
                                            Micronesia (+691)
                                        </option>
                                        <option value="Moldova"
                                            {{ old('country_of_residence') == 'Moldova' ? 'selected' : '' }}>
                                            Moldova (+373)
                                        </option>
                                        <option value="Monaco"
                                            {{ old('country_of_residence') == 'Monaco' ? 'selected' : '' }}>
                                            Monaco (+377)
                                        </option>
                                        <option value="Mongolia"
                                            {{ old('country_of_residence') == 'Mongolia' ? 'selected' : '' }}>
                                            Mongolia (+976)
                                        </option>
                                        <option value="Montenegro"
                                            {{ old('country_of_residence') == 'Montenegro' ? 'selected' : '' }}>
                                            Montenegro (+382)
                                        </option>
                                        <option value="Morocco"
                                            {{ old('country_of_residence') == 'Morocco' ? 'selected' : '' }}>
                                            Morocco (+212)
                                        </option>
                                        <option value="Mozambique"
                                            {{ old('country_of_residence') == 'Mozambique' ? 'selected' : '' }}>
                                            Mozambique (+258)
                                        </option>
                                        <option value="Myanmar"
                                            {{ old('country_of_residence') == 'Myanmar' ? 'selected' : '' }}>
                                            Myanmar (+95)
                                        </option>
                                        <option value="Namibia"
                                            {{ old('country_of_residence') == 'Namibia' ? 'selected' : '' }}>
                                            Namibia (+264)
                                        </option>
                                        <option value="Nauru"
                                            {{ old('country_of_residence') == 'Nauru' ? 'selected' : '' }}>
                                            Nauru (+674)
                                        </option>
                                        <option value="Nepal"
                                            {{ old('country_of_residence') == 'Nepal' ? 'selected' : '' }}>
                                            Nepal (+977)
                                        </option>
                                        <option value="Netherlands"
                                            {{ old('country_of_residence') == 'Netherlands' ? 'selected' : '' }}>
                                            Netherlands (+31)
                                        </option>
                                        <option value="New Zealand"
                                            {{ old('country_of_residence') == 'New Zealand' ? 'selected' : '' }}>
                                            New Zealand (+64)
                                        </option>
                                        <option value="Nicaragua"
                                            {{ old('country_of_residence') == 'Nicaragua' ? 'selected' : '' }}>
                                            Nicaragua (+505)
                                        </option>
                                        <option value="Niger"
                                            {{ old('country_of_residence') == 'Niger' ? 'selected' : '' }}>
                                            Niger (+227)
                                        </option>
                                        <option value="Nigeria"
                                            {{ old('country_of_residence') == 'Nigeria' ? 'selected' : '' }}>
                                            Nigeria (+234)
                                        </option>
                                        <option value="North Macedonia"
                                            {{ old('country_of_residence') == 'North Macedonia' ? 'selected' : '' }}>
                                            North Macedonia (+389)
                                        </option>
                                        <option value="Norway"
                                            {{ old('country_of_residence') == 'Norway' ? 'selected' : '' }}>
                                            Norway (+47)
                                        </option>
                                        <option value="Oman"
                                            {{ old('country_of_residence') == 'Oman' ? 'selected' : '' }}>
                                            Oman (+968)
                                        </option>
                                        <option value="Pakistan"
                                            {{ old('country_of_residence') == 'Pakistan' ? 'selected' : '' }}>
                                            Pakistan (+92)
                                        </option>
                                        <option value="Palau"
                                            {{ old('country_of_residence') == 'Palau' ? 'selected' : '' }}>
                                            Palau (+680)
                                        </option>
                                        <option value="Panama"
                                            {{ old('country_of_residence') == 'Panama' ? 'selected' : '' }}>
                                            Panama (+507)
                                        </option>
                                        <option value="Papua New Guinea"
                                            {{ old('country_of_residence') == 'Papua New Guinea' ? 'selected' : '' }}>
                                            Papua New Guinea (+675)
                                        </option>
                                        <option value="Paraguay"
                                            {{ old('country_of_residence') == 'Paraguay' ? 'selected' : '' }}>
                                            Paraguay (+595)
                                        </option>
                                        <option value="Peru"
                                            {{ old('country_of_residence') == 'Peru' ? 'selected' : '' }}>
                                            Peru (+51)
                                        </option>
                                        <option value="Philippines"
                                            {{ old('country_of_residence') == 'Philippines' ? 'selected' : '' }}>
                                            Philippines (+63)
                                        </option>
                                        <option value="Poland"
                                            {{ old('country_of_residence') == 'Poland' ? 'selected' : '' }}>
                                            Poland (+48)
                                        </option>
                                        <option value="Portugal"
                                            {{ old('country_of_residence') == 'Portugal' ? 'selected' : '' }}>
                                            Portugal (+351)
                                        </option>
                                        <option value="Qatar"
                                            {{ old('country_of_residence') == 'Qatar' ? 'selected' : '' }}>
                                            Qatar (+974)
                                        </option>
                                        <option value="Romania"
                                            {{ old('country_of_residence') == 'Romania' ? 'selected' : '' }}>
                                            Romania (+40)
                                        </option>
                                        <option value="Russia"
                                            {{ old('country_of_residence') == 'Russia' ? 'selected' : '' }}>
                                            Russia (+7)
                                        </option>
                                        <option value="Rwanda"
                                            {{ old('country_of_residence') == 'Rwanda' ? 'selected' : '' }}>
                                            Rwanda (+250)
                                        </option>
                                        <option value="Saint Kitts and Nevis"
                                            {{ old('country_of_residence') == 'Saint Kitts and Nevis' ? 'selected' : '' }}>
                                            Saint Kitts and Nevis (+1-869)
                                        </option>
                                        <option value="Saint Lucia"
                                            {{ old('country_of_residence') == 'Saint Lucia' ? 'selected' : '' }}>
                                            Saint Lucia (+1-758)
                                        </option>
                                        <option value="Saint Vincent and the Grenadines"
                                            {{ old('country_of_residence') == 'Saint Vincent and the Grenadines' ? 'selected' : '' }}>
                                            Saint Vincent and the Grenadines (+1-784)
                                        </option>
                                        <option value="Samoa"
                                            {{ old('country_of_residence') == 'Samoa' ? 'selected' : '' }}>
                                            Samoa (+685)
                                        </option>
                                        <option value="San Marino"
                                            {{ old('country_of_residence') == 'San Marino' ? 'selected' : '' }}>
                                            San Marino (+378)
                                        </option>
                                        <option value="Sao Tome and Principe"
                                            {{ old('country_of_residence') == 'Sao Tome and Principe' ? 'selected' : '' }}>
                                            Sao Tome and Principe (+239)
                                        </option>
                                        <option value="Saudi Arabia"
                                            {{ old('country_of_residence') == 'Saudi Arabia' ? 'selected' : '' }}>
                                            Saudi Arabia (+966)
                                        </option>
                                        <option value="Senegal"
                                            {{ old('country_of_residence') == 'Senegal' ? 'selected' : '' }}>
                                            Senegal (+221)
                                        </option>
                                        <option value="Serbia"
                                            {{ old('country_of_residence') == 'Serbia' ? 'selected' : '' }}>
                                            Serbia (+381)
                                        </option>
                                        <option value="Seychelles"
                                            {{ old('country_of_residence') == 'Seychelles' ? 'selected' : '' }}>
                                            Seychelles (+248)
                                        </option>
                                        <option value="Sierra Leone"
                                            {{ old('country_of_residence') == 'Sierra Leone' ? 'selected' : '' }}>
                                            Sierra Leone (+232)
                                        </option>
                                        <option value="Singapore"
                                            {{ old('country_of_residence') == 'Singapore' ? 'selected' : '' }}>
                                            Singapore (+65)
                                        </option>
                                        <option value="Slovakia"
                                            {{ old('country_of_residence') == 'Slovakia' ? 'selected' : '' }}>
                                            Slovakia (+421)
                                        </option>
                                        <option value="Slovenia"
                                            {{ old('country_of_residence') == 'Slovenia' ? 'selected' : '' }}>
                                            Slovenia (+386)
                                        </option>
                                        <option value="Solomon Islands"
                                            {{ old('country_of_residence') == 'Solomon Islands' ? 'selected' : '' }}>
                                            Solomon Islands (+677)
                                        </option>
                                        <option value="Somalia"
                                            {{ old('country_of_residence') == 'Somalia' ? 'selected' : '' }}>
                                            Somalia (+252)
                                        </option>
                                        <option value="South Africa"
                                            {{ old('country_of_residence') == 'South Africa' ? 'selected' : '' }}>
                                            South Africa (+27)
                                        </option>
                                        <option value="South Sudan"
                                            {{ old('country_of_residence') == 'South Sudan' ? 'selected' : '' }}>
                                            South Sudan (+211)
                                        </option>
                                        <option value="Spain"
                                            {{ old('country_of_residence') == 'Spain' ? 'selected' : '' }}>
                                            Spain (+34)
                                        </option>
                                        <option value="Sri Lanka"
                                            {{ old('country_of_residence') == 'Sri Lanka' ? 'selected' : '' }}>
                                            Sri Lanka (+94)
                                        </option>
                                        <option value="Sudan"
                                            {{ old('country_of_residence') == 'Sudan' ? 'selected' : '' }}>
                                            Sudan (+249)
                                        </option>
                                        <option value="Suriname"
                                            {{ old('country_of_residence') == 'Suriname' ? 'selected' : '' }}>
                                            Suriname (+597)
                                        </option>
                                        <option value="Sweden"
                                            {{ old('country_of_residence') == 'Sweden' ? 'selected' : '' }}>
                                            Sweden (+46)
                                        </option>
                                        <option value="Switzerland"
                                            {{ old('country_of_residence') == 'Switzerland' ? 'selected' : '' }}>
                                            Switzerland (+41)
                                        </option>
                                        <option value="Syria"
                                            {{ old('country_of_residence') == 'Syria' ? 'selected' : '' }}>
                                            Syria (+963)
                                        </option>
                                        <option value="Taiwan"
                                            {{ old('country_of_residence') == 'Taiwan' ? 'selected' : '' }}>
                                            Taiwan (+886)
                                        </option>
                                        <option value="Tajikistan"
                                            {{ old('country_of_residence') == 'Tajikistan' ? 'selected' : '' }}>
                                            Tajikistan (+992)
                                        </option>
                                        <option value="Tanzania"
                                            {{ old('country_of_residence') == 'Tanzania' ? 'selected' : '' }}>
                                            Tanzania (+255)
                                        </option>
                                        <option value="Thailand"
                                            {{ old('country_of_residence') == 'Thailand' ? 'selected' : '' }}>
                                            Thailand (+66)
                                        </option>
                                        <option value="Timor-Leste"
                                            {{ old('country_of_residence') == 'Timor-Leste' ? 'selected' : '' }}>
                                            Timor-Leste (+670)
                                        </option>
                                        <option value="Togo"
                                            {{ old('country_of_residence') == 'Togo' ? 'selected' : '' }}>
                                            Togo (+228)
                                        </option>
                                        <option value="Tonga"
                                            {{ old('country_of_residence') == 'Tonga' ? 'selected' : '' }}>
                                            Tonga (+676)
                                        </option>
                                        <option value="Trinidad and Tobago"
                                            {{ old('country_of_residence') == 'Trinidad and Tobago' ? 'selected' : '' }}>
                                            Trinidad and Tobago (+1-868)
                                        </option>
                                        <option value="Tunisia"
                                            {{ old('country_of_residence') == 'Tunisia' ? 'selected' : '' }}>
                                            Tunisia (+216)
                                        </option>
                                        <option value="Turkey"
                                            {{ old('country_of_residence') == 'Turkey' ? 'selected' : '' }}>
                                            Turkey (+90)
                                        </option>
                                        <option value="Turkmenistan"
                                            {{ old('country_of_residence') == 'Turkmenistan' ? 'selected' : '' }}>
                                            Turkmenistan (+993)
                                        </option>
                                        <option value="Tuvalu"
                                            {{ old('country_of_residence') == 'Tuvalu' ? 'selected' : '' }}>
                                            Tuvalu (+688)
                                        </option>
                                        <option value="Uganda"
                                            {{ old('country_of_residence') == 'Uganda' ? 'selected' : '' }}>
                                            Uganda (+256)
                                        </option>
                                        <option value="Ukraine"
                                            {{ old('country_of_residence') == 'Ukraine' ? 'selected' : '' }}>
                                            Ukraine (+380)
                                        </option>
                                        <option value="United Arab Emirates"
                                            {{ old('country_of_residence') == 'United Arab Emirates' ? 'selected' : '' }}>
                                            United Arab Emirates (+971)
                                        </option>
                                        <option value="United Kingdom"
                                            {{ old('country_of_residence') == 'United Kingdom' ? 'selected' : '' }}>
                                            United Kingdom (+44)
                                        </option>
                                        <option value="United States"
                                            {{ old('country_of_residence') == 'United States' ? 'selected' : '' }}>
                                            United States (+1)
                                        </option>
                                        <option value="Uruguay"
                                            {{ old('country_of_residence') == 'Uruguay' ? 'selected' : '' }}>
                                            Uruguay (+598)
                                        </option>
                                        <option value="Uzbekistan"
                                            {{ old('country_of_residence') == 'Uzbekistan' ? 'selected' : '' }}>
                                            Uzbekistan (+998)
                                        </option>
                                        <option value="Vanuatu"
                                            {{ old('country_of_residence') == 'Vanuatu' ? 'selected' : '' }}>
                                            Vanuatu (+678)
                                        </option>
                                        <option value="Vatican City"
                                            {{ old('country_of_residence') == 'Vatican City' ? 'selected' : '' }}>
                                            Vatican City (+379)
                                        </option>
                                        <option value="Venezuela"
                                            {{ old('country_of_residence') == 'Venezuela' ? 'selected' : '' }}>
                                            Venezuela (+58)
                                        </option>
                                        <option value="Vietnam"
                                            {{ old('country_of_residence') == 'Vietnam' ? 'selected' : '' }}>
                                            Vietnam (+84)
                                        </option>
                                        <option value="Yemen"
                                            {{ old('country_of_residence') == 'Yemen' ? 'selected' : '' }}>
                                            Yemen (+967)
                                        </option>
                                        <option value="Zambia"
                                            {{ old('country_of_residence') == 'Zambia' ? 'selected' : '' }}>
                                            Zambia (+260)
                                        </option>
                                        <option value="Zimbabwe"
                                            {{ old('country_of_residence') == 'Zimbabwe' ? 'selected' : '' }}>
                                            Zimbabwe (+263)
                                        </option>
                                    </select>
                                </div>
                                <div class="form-group col-sm-6 mb-3">
                                    <label class="form-label mb-1 text-2">Nationality</label>
                                    <input type="text" value=""
                                        data-msg-required="Please enter your Nationality." maxlength="100"
                                        class="form-control text-3 h-auto py-2" name="nationality"
                                        value="{{ old('nationality') }}">
                                    @error('nationality')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror

                                </div>
                            </div>
                        </div>
                        @php
                            $questions = [
                                'On a scale of 1-10 how much to do you agree with the great return philosophy',
                                'On a scale of 1-10 how much do you believe that more people in the diaspora should be informed about the great return',
                                'On a scale of 1-10 how important do you believe it is for all of us to spread the great return philosophy to as many people as possible',
                                'On a scale of 1-10 how much do you believe you possess valuable skills, knowledge and expertise that can be used to support African development',
                                'On a scale of 1-10 how prepared are you to adopt an entrepreneurial mindset',
                                'On a scale of 1-10 how will you rate your current business acumen',
                                'On a scale of 1-10 how experienced are you in taking leadership positions',
                                'On a scale of 1-10 how strong are your communication skills',
                                'On a scale of 1-10 how good are you at problem solving',
                                'On a scale of 1-10 how good are you at thinking strategically',
                                'On a scale of 1-10 how good are you with dealing with pressure',
                                'On a scale of 1-10 how good are you with practising delayed gratification',
                                'On a scale of 1-10 how much do you see failure as a necessary part of long-term success',
                                'On a scale of 1-10 how resilient are you',
                                'On a scale of 1-10 how easy is it for you to visualise a desired outcome before it has yet to be manifested',
                                'On a scale of 1-10 how willing are you to confront some of the challenges that come with joining the great return',
                                'On a scale of 1-10 how easy would it be for you to raise a minimum of $10,000 as start-up capital',
                                'On a scale of 1-10 how willing are you to adopt the mentality of a servant in the service of African development',
                                'On a scale of 1-10 how unfulfilled are you with your current life in the diaspora',
                                'On a scale of 1-10 how much do you believe that joining TGR will lead to you having more fulfilment and meaning in your life',
                                'On a scale of 1-10 how much do you believe that Africa could offer you a greater opportunity for wealth and financial freedom compared to the West',
                                'On a scale of 1-10 how much do you believe moving to Africa will give you a sense of belonging and connection that you desire',
                                'On a scale of 1-10 how connected do you feel to Africa',
                                'On a scale of 1-10 how important is your African heritage as part of your identity',
                                'On a scale of 1-10 how unappreciated do you feel living in the diaspora',
                                'On a scale of 1-10 how important do you believe it is to invest in your transition preparation when relocating back to Africa',
                                'On a scale of 1-10 how much do you believe that the more prepared you are, the higher the likelihood of your TGR success',
                                'On a scale of 1-10 how knowledgeable are you about the economic opportunities available to you in Africa',
                                'On a scale of 1-10 how beneficial will it be for you to be better educated about Africa',
                                'On a scale of 1-10 how confident are you in generating potential business ideas that you can become passionate about, complement your skills and expertise, and support African development',
                                'On a scale of 1-10 how much clarity do you have about what your unique purpose in Africa will be as part of the collective purpose of The Great Return',
                                'On a scale of 1-10 how well have you researched potential business ideas in order to assess their viability and whether they can work successfully in Africa',
                                'On a scale of 1-10 how developed is your business strategy for implementing your idea',
                                'On a scale of 1-10 how beneficial will it be for you to receive assistance in evaluating some of your business ideas',
                            ];
                        @endphp

                        @foreach ($questions as $index => $question)
                            <div class="mb-3">
                                <label for="question{{ $index }}"
                                    class="form-label">{{ $question }}</label>
                                <select class="form-control" id="question{{ $index }}"
                                    name="question{{ $index }}" required>
                                    @for ($i = 1; $i <= 10; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        @endforeach

                        <hr>
                        <h5>Kindly choose a Convenient Time and Date for Your Consultation</h5>
                        {{-- <div class="mb-3">
                            <label for="date" class="form-label">Preferred Date</label>
                            <input type="date" class="form-control" id="date" name="response_date" required>
                        </div> --}}
                        {{-- <div class="mb-3 date-time-container">
                            <label for="time" class="form-label">Preferred Date and Time (Please key in your preferred
                                time at your location).</label>
                            <input type="datetime-local" class="form-control modern-date-time" id="time"
                                name="response_time_and_date" placeholder="Select date and time" required>
                        </div> --}}
                        <div class="mb-3 date-time-container">
                            <label for="time" class="form-label">Preferred Date and Time</label>
                            <input type="text" class="form-control modern-date-time" id="time"
                                name="response_time_and_date" placeholder="Select date and time" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal design styling -->

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if (session('info'))
                var infoModal = new bootstrap.Modal(document.getElementById('infoModal'));
                infoModal.show();
            @endif
        });
    </script>

    {{-- <script>
        flatpickr("#time", {
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            minDate: "today",
            animate: false,
            onOpen: function(selectedDates, dateStr, instance) {
                instance.calendarContainer.style.position = "absolute";
            }
        });
    </script> --}}

    <script>
        flatpickr("#time", {
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            minDate: "today",
            animate: false,
            onOpen: function(selectedDates, dateStr, instance) {
                const calendar = instance.calendarContainer;
                calendar.style.position = "absolute";

                const rect = instance._input.getBoundingClientRect();
                calendar.style.left = `${rect.left}px`;
                calendar.style.top = `${rect.bottom + window.scrollY}px`;
            }
        });
    </script>


    <style>
        /* Modal Header */
        .custom-modal-header {
            background-color: #ed5348;
            padding: 10px;
            position: relative;
        }

        .modal-content {
            width: 90%;
            /* Use a percentage for responsiveness */
            max-width: 600px;
            /* Set a maximum width */
            max-height: 80vh;
            /* Prevent overflow */
            overflow-y: auto;
            /* Enable scrolling if content overflows */
            border-radius: 8px;
            /* Rounded corners */
        }

        /* Flexbox to align children */
        .modal-body {
            display: flex;
            flex-direction: column;
            padding: 20px;
            /* Increased padding for better spacing */
        }

        .date-time-container {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            margin-bottom: 1rem;
            /* Add margin to separate from other content */
        }

        .date-time-container input[type="datetime-local"] {
            width: 100%;
            /* Make it responsive */
            padding: 10px;
        }

        /* Responsive adjustments for smaller screens */
        @media (max-width: 576px) {
            .modal-content {
                width: 95%;
                /* Slightly wider on small screens */
            }

            .custom-modal-header .modal-title {
                font-size: 12px;
            }

            .form-title,
            .sub-title {
                font-size: 1.1rem;
            }

            .form-control,
            .submit-btn {
                font-size: 14px;
            }
        }

        /* General Form Styling */
        #questionnaireForm {
            width: 100%;
            /* Full width within modal */
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        /* Button Styling */
        .submit-btn {
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            border: none;
            color: #fff;
            font-size: 16px;
            font-weight: bold;
            border-radius: 6px;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }

        .submit-btn:hover {
            background-color: #0056b3;
            box-shadow: 0 6px 12px rgba(0, 123, 255, 0.3);
        }

        /* Placeholder and Input Styles */
        .modern-date-time::placeholder {
            font-size: 0.85em;
            color: #6c757d;
        }

        .modern-date-time {
            font-size: 16px;
            padding: 12px;
            cursor: pointer;
        }

        .date-time-container {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            /* Aligns label and input to the start */
            max-width: fit-content;
            /* Ensures the container fits its content */
        }

        .date-time-container input[type="datetime-local"] {
            width: 200px;
            /* Set a specific width that suits your design */
            padding: 10px;
            /* Maintain padding for aesthetics */
            border: 1px solid #ced4da;
            /* Consistent border styling */
            border-radius: 6px;
            /* Rounded corners */
            font-size: 16px;
            /* Font size for the input */
        }

        @media (max-width: 576px) {
            .date-time-container input[type="datetime-local"] {
                width: 100%;
                /* Full width on smaller screens */
            }
        }
    </style>
@endsection
