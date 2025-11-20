@extends('website.layouts.main')

@section('title')
News
@endsection

@section('content')
<section
    class="page-header page-header-modern page-header-background page-header-background-md overlay overlay-color-dark overlay-show overlay-op-5"
    style="background-image: url(img/page-header/page-header-background.jpg);">
    <div class="container">
        <div class="row">
            <div class="col-md-8 order-2 order-md-1 align-self-center p-static">
                <h1>Our <strong>News</strong></h1>
                <span class="sub-title">Read more about us</span>
            </div>
            <div class="col-md-4 order-1 order-md-2 align-self-center">
                <ul class="breadcrumb breadcrumb-light d-block text-md-end">
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li class="active">News</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<div role="main" class="main">
    <div class="container">
        <div class="container py-4">
            <div class="row">
                <div class="col">
                    <div class="blog-posts">
                        <div class="row">
                            @foreach ($latest_blogs as $blog)
                            <div class="col-md-4 col-lg-3">
                                <article class="post post-medium border-0 pb-0 mb-5">
                                    <!-- <div class="post-image">
                                        <a href="{{ route('newssingle', $blog->uuid) }}">
                                            <img src="{{ asset('img/blog/medium/return.png' . $blog->image) }}"
                                                class="img-fluid img-thumbnail img-thumbnail-no-borders rounded-0"
                                                alt="{{ $blog->title }}" />
                                        </a>
                                    </div> -->

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

                    <div class="row">
                        <div class="col">
                            <ul class="pagination float-end">
                                {{ $latest_blogs->links() }}
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection