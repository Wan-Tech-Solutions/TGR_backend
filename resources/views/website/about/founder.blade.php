@extends('website.layouts.main')

@section('title')
Founders
@endsection

@section('content')
<section
    class="page-header page-header-modern page-header-background page-header-background-md overlay overlay-color-dark overlay-show overlay-op-5"
    style="background-image: url({{ asset('img/page-header/page-header-backgrounda.jpg') }});">
    <div class="container">
        <div class="row">
            <div class="col-md-8 order-2 order-md-1 align-self-center p-static">
                <h1>Meet Our <strong>Founders</strong></h1>
                <span class="sub-title">The visionaries behind TGR Africa</span>
            </div>
            <div class="col-md-4 order-1 order-md-2 align-self-center">
                <ul class="breadcrumb breadcrumb-light d-block text-md-end">
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li>About</li>
                    <li class="active">Founders</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<div class="container py-5 mt-4">
    <!-- Lordy Emmen Section -->
    <div class="row mb-5 align-items-center founder-section">
        <div class="col-lg-5 mb-4 mb-lg-0">
            <div class="founder-image-container">
                <img class="img-fluid rounded shadow-lg" src="{{ asset('img/lordy.png') }}" alt="Lordy Emmen">
                <div class="founder-overlay">
                    <div class="founder-social">
                        <a href="#" class="social-icon"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-7 ps-lg-4">
            <div class="founder-content">
                <div class="founder-badge mb-3">Founder & CEO</div>
                <h2 class="text-color-primary mb-2 font-weight-bold">Lordy Emmen</h2>
                <p class="text-4 font-weight-bold mb-4 text-color-secondary">Diaspora Entrepreneur & African Development Ambassador</p>
                
                <div class="founder-highlights mb-4">
                    <div class="highlight-item">
                        <i class="fas fa-book highlight-icon"></i>
                        <span>Author of "The Great Return"</span>
                    </div>
                    <div class="highlight-item">
                        <i class="fas fa-graduation-cap highlight-icon"></i>
                        <span>Fellow Chartered Certified Accountant (FCCA)</span>
                    </div>
                    <div class="highlight-item">
                        <i class="fas fa-briefcase highlight-icon"></i>
                        <span>20+ Years in Finance & Accountancy</span>
                    </div>
                </div>

                <div class="founder-bio">
                    <p class="text-3-5 mb-3" style="text-align: justify;">
                        <strong>Lordy Emmen</strong> is a diaspora entrepreneur, diaspora engagement and investment activist, self-proclaimed African Development Ambassador, and author of the book <strong>"The Great Return"</strong>.
                    </p>

                    <p class="text-3-5 mb-3" style="text-align: justify;">
                        Of Ghanaian descent and born and bred in Ghana, she completed her undergraduate degree at the University of Ghana, Legon, with a BA in Economics and Resource Study. She moved to the UK to join her family and has lived there for over 24 years, building a successful career in finance and accountancy spanning more than 20 years.
                    </p>

                    <p class="text-3-5 mb-3" style="text-align: justify;">
                        She is a Chartered Certified Accountant (ACCA) and Fellow of ACCA (FCCA), with extensive work experience in both public and private sectors, including the NHS and leading organizations such as ABP (UK's leading ports group), where she served as Financial Controller and Finance Business Partner, leading FP&A delivery including budgets, 5-year plans, and financial controls.
                    </p>

                    <p class="text-3-5 mb-3" style="text-align: justify;">
                        Since 2019, along with her husband, she has made strategic investments in Ghana's poultry sector, recognizing the opportunity to reduce the country's dependency on foreign food imports. Her passion for African development and hands-on experience in African business inspired the creation of <strong>TGR Africa</strong>.
                    </p>

                    <p class="text-3-5" style="text-align: justify;">
                        Lordy is a strong advocate for diaspora involvement in African development, believing that the diaspora can play a significant role in Africa's economic transformation. Her guiding philosophy is to find innovative ways to make profit through the fulfillment of purpose, and she firmly believes that the diaspora has tremendous economic opportunities in investing in African development.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="divider-section">
        <div class="divider-line"></div>
        <div class="divider-icon">
            <i class="fas fa-seedling"></i>
        </div>
        <div class="divider-line"></div>
    </div>

    <!-- Agyegewe Chanayireh Section -->
    <div class="row align-items-center founder-section">
        <div class="col-lg-5 mb-4 mb-lg-0 order-lg-2">
            <div class="founder-image-container">
                <img class="img-fluid rounded shadow-lg" src="{{ asset('img/clement.png') }}" alt="Agyegewe Chanayireh">
                <div class="founder-overlay">
                    <div class="founder-social">
                        <a href="#" class="social-icon"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-7 pe-lg-4 order-lg-1">
            <div class="founder-content">
                <div class="founder-badge mb-3">Co-Founder & COO</div>
                <h2 class="text-color-primary mb-2 font-weight-bold">Agyegewe Chanayireh</h2>
                <p class="text-4 font-weight-bold mb-4 text-color-secondary">Business Strategist & Development Expert</p>
                
                <div class="founder-highlights mb-4">
                    <div class="highlight-item">
                        <i class="fas fa-book highlight-icon"></i>
                        <span>Co-author of "The Great Return"</span>
                    </div>
                    <div class="highlight-item">
                        <i class="fas fa-university highlight-icon"></i>
                        <span>University of Manchester Graduate</span>
                    </div>
                    <div class="highlight-item">
                        <i class="fas fa-chart-line highlight-icon"></i>
                        <span>Business Development Executive</span>
                    </div>
                </div>

                <div class="founder-bio">
                    <p class="text-3-5 mb-3" style="text-align: justify;">
                        Agyegewe Chanayireh is the Co-Founder and Chief Operations Officer of TGR Africa, and also co-authored <strong>"The Great Return"</strong> alongside business partner Lordy Emmen. His journey toward making the great return began during his studies at the University of Manchester, where he studied Modern Middle Eastern History.
                    </p>

                    <p class="text-3-5 mb-3" style="text-align: justify;">
                        Through his academic pursuits, Agyegewe developed a deep understanding of colonialism and imperialism and their long-term consequences on developing nations. As someone of Ghanaian descent, he recognized these same challenges facing Africa and came to the realization that he could either be part of the solution or part of the problem.
                    </p>

                    <p class="text-3-5 mb-3" style="text-align: justify;">
                        In his professional career, Agyegewe has worked as a Business Development Executive for financial institutions, training providers, and marketing agencies, gaining valuable expertise in business strategy and development.
                    </p>

                    <p class="text-3-5" style="text-align: justify;">
                        At TGR Africa, his primary role is to manage all business advisory services and develop innovative investment products that effectively channel diaspora capital into highly productive areas, facilitating further development of African economies. His strategic vision and operational expertise are instrumental in driving TGR Africa's mission forward.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .founder-section {
        transition: transform 0.3s ease-in-out;
        margin-bottom: 5rem !important;
    }

    .founder-section:hover {
        transform: translateY(-5px);
    }

    .founder-image-container {
        position: relative;
        overflow: hidden;
        border-radius: 12px;
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
    }

    .founder-image-container img {
        width: 100%;
        transition: transform 0.5s ease;
        max-height: 550px;
        object-fit: cover;
    }

    .founder-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.3);
        display: flex;
        align-items: flex-end;
        justify-content: flex-end;
        opacity: 0;
        transition: opacity 0.3s ease;
        padding: 20px;
    }

    .founder-image-container:hover .founder-overlay {
        opacity: 1;
    }

    .founder-image-container:hover img {
        transform: scale(1.03);
    }

    .founder-social {
        display: flex;
        gap: 10px;
    }

    .social-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: var(--primary);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .social-icon:hover {
        background: white;
        color: var(--primary);
        transform: translateY(-3px);
    }

    .founder-content {
        padding: 20px 0;
    }

    .founder-badge {
        display: inline-block;
        background: var(--primary);
        color: white;
        padding: 8px 16px;
        border-radius: 30px;
        font-size: 0.9rem;
        font-weight: 600;
        letter-spacing: 0.5px;
    }

    .founder-section h2 {
        font-size: 2.2rem;
        letter-spacing: -0.5px;
        margin-bottom: 0.5rem;
    }

    .founder-section .text-color-secondary {
        color: var(--primary);
        font-size: 1.1rem;
        border-left: 3px solid var(--primary);
        padding-left: 15px;
    }

    .founder-highlights {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .highlight-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 15px;
        background: #f8f9fa;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .highlight-item:hover {
        background: #e9ecef;
        transform: translateX(5px);
    }

    .highlight-icon {
        color: var(--primary);
        font-size: 1.2rem;
        width: 24px;
        text-align: center;
    }

    .divider-section {
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 4rem 0;
    }

    .divider-line {
        height: 2px;
        background: linear-gradient(to right, transparent, var(--primary), transparent);
        flex: 1;
        max-width: 200px;
    }

    .divider-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: var(--primary);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 20px;
        font-size: 1.5rem;
    }

    .shadow-lg {
        box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.175) !important;
    }

    @media (max-width: 991px) {
        .founder-section {
            margin-bottom: 3rem !important;
        }
        
        .founder-highlights {
            gap: 8px;
        }
        
        .highlight-item {
            padding: 8px 12px;
        }
        
        .divider-section {
            margin: 3rem 0;
        }
        
        .divider-icon {
            width: 50px;
            height: 50px;
            font-size: 1.2rem;
        }
    }
</style>

@endsection