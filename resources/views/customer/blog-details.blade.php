@extends("customer.layout.layout")

@section("styles")
<link rel="stylesheet" href="{{ asset("customer/css/blogs.css") }}">
<link rel="stylesheet" href="{{ asset("customer/css/blogpost.css") }}">
<link rel="stylesheet" href="{{ asset("customer/css/blog-details.css") }}">
<link rel="stylesheet" href="{{ asset("customer/css/comments.css") }}">
<meta name="blog" content="{{ $blog->id }}">
@endsection

@section("blog","activ")


@section("main.layout")
<div class="side-src">
    <strong>
        <a href="{{ route('home') }}"><i class="fa-solid fa-house"></i><span
                data-lang="home"></span></a>&nbsp;>&nbsp;<a href="{{ route("blog") }}"><span
                data-lang="blog">{{ __("app.blog") }}</span></a><span>&nbsp;>&nbsp;{{ $blog->{"title_".$locale} }}</span>
    </strong>
</div>
<div class="box-search mobile-search">
    <form action="http://127.0.0.1:8000/blogs" method="get" class="search">
        <button class="search__button">
            <div class="search__icon">
                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
                    <title>بحث</title>
                    <path
                        d="M17.545 15.467l-3.779-3.779c0.57-0.935 0.898-2.035 0.898-3.21 0-3.417-2.961-6.377-6.378-6.377s-6.186 2.769-6.186 6.186c0 3.416 2.961 6.377 6.377 6.377 1.137 0 2.2-0.309 3.115-0.844l3.799 3.801c0.372 0.371 0.975 0.371 1.346 0l0.943-0.943c0.371-0.371 0.236-0.84-0.135-1.211zM4.004 8.287c0-2.366 1.917-4.283 4.282-4.283s4.474 2.107 4.474 4.474c0 2.365-1.918 4.283-4.283 4.283s-4.473-2.109-4.473-4.474z">
                    </path>
                </svg>
            </div>
        </button>
        <input type="text" class="search__input" name="search" placeholder="Search...">
    </form>
</div>
<div class="boxing">
    <div class="side-left-blog">
        <div class="box-search">
        <form action="http://127.0.0.1:8000/blogs" method="get" class="search">
                <button class="search__button">
                    <div class="search__icon">
                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                            viewBox="0 0 20 20">
                            <title>بحث</title>
                            <path
                                d="M17.545 15.467l-3.779-3.779c0.57-0.935 0.898-2.035 0.898-3.21 0-3.417-2.961-6.377-6.378-6.377s-6.186 2.769-6.186 6.186c0 3.416 2.961 6.377 6.377 6.377 1.137 0 2.2-0.309 3.115-0.844l3.799 3.801c0.372 0.371 0.975 0.371 1.346 0l0.943-0.943c0.371-0.371 0.236-0.84-0.135-1.211zM4.004 8.287c0-2.366 1.917-4.283 4.282-4.283s4.474 2.107 4.474 4.474c0 2.365-1.918 4.283-4.283 4.283s-4.473-2.109-4.473-4.474z">
                            </path>
                        </svg>
                    </div>
                </button>
                <input type="text" class="search__input" name="search" placeholder="Search...">
            </form>
        </div>
        <h1 class="top-title">{{ __("app.bestBlogs") }}</h1>
        <div class="box-top-blog">
            @forelse($topFiveBlogs as $topBlog)
                <a href="{{ route("blog.details",$topBlog->{"slug_".$locale}) }}"
                    title="{{ $topBlog->{"title_".$locale} }}">
                    <div class="card-top">
                        <div class="card-img">
                            <img src="{{ asset(path: "storage/" . $topBlog->image) }}"
                                alt="{{ $topBlog->{"title_".$locale} }}">
                            <span>
                                {{ $loop->iteration }}
                            </span>
                        </div>
                        <p>
                            {{ $topBlog->{"description_".$locale} }}
                        </p>
                    </div>
                </a>
            @empty
            @endforelse
        </div>
    </div>
    <div class="side-right-blog blog-details">
        <div class="img-post">
            <img id="image-blog" src="{{ asset(path: "storage/" . $blog->image) }}"
                title="{{ $blog->{"title_".$locale} }}"
                alt="{{ $blog->{"title_".$locale} }}" loading="lazy">
            <div class="social-media post-social-media">
                <a href=""><i class="fa-brands fa-facebook"></i></a>
                <a href=""><i class="fa-brands fa-whatsapp"></i></a>
                <a href=""><i class="fa-brands fa-telegram"></i></a>
                <a href=""><i class="fa-brands fa-x-twitter"></i></a>
            </div>
        </div>
        <div class="content {{ $locale }}">
            {!! $blog->{"content_".$locale} !!}
        </div>
    </div>
</div>
<section class="portfolio" id="portfolio">
    <h1 class="top-title" style="margin-bottom: 40px;">{{ __("app.relatedBlog") }}</h1>
    <div class="portfolio-gallery">
        @forelse($relatedBlogs as $relatedBlog)
            <div class="portfolio-box mix uiux text-right" id="user-{{ $relatedBlog->id }}">
                <div class="portfolio-content">
                    <h3>{{ $relatedBlog->{"title_".$locale} }}</h3>
                    <p>
                        {{ $relatedBlog->{"description_".$locale} }}
                    </p>
                    <a href="{{ route("blog.details",$relatedBlog->{"slug_".$locale}) }}"
                        class="readMore">
                        <span class="text-center">{{ __('app.btn_read_more') }}</span>
                    </a>
                </div>
                <div class="portfolio-img row m-1 justify-content-center" style="position: relative;">
                    <img id="image-blog"
                        src="{{ asset(path: "storage/" . $relatedBlog->image) }}"
                        title="{{ $relatedBlog->{"title_".$locale} }}"
                        alt="{{ $relatedBlog->{"title_".$locale} }}" loading="lazy">
                </div>
            </div>
        @empty
            <div class="notfound">
                <h2 class="text-center">{{ __('app.notfound_blogs') }}</h2>
            </div>
        @endforelse
    </div>
</section>

<section class="comment-module">
    <h1 class="top-title" style="margin-bottom: 40px;">{{ __("app.comments") }}</h1>
    <div class="comment-section">
        <div class="comments-wrp base">
            <div class="comments-wrp">

            </div>
            <div id="view-comment">
                <button class="botao load-more">
                    <span class="texto">View more</span>
                </button>
            </div>
        </div>
        @if(isset($user) && $user->id!= null)
            <div class="reply-input base-input-reply container-comment">
                <img src="{{ asset("storage/".$user->image) }}" alt="" class="usr-img" />
                <textarea class="cmnt-input"
                    placeholder="{{ __("app.write_your_comment") }}..."></textarea>
                <button class="bu-primary">{{ __("app.comment") }}</button>
            </div>
        @endif
    </div>
</section>

@endsection


@section("script")
<script src="{{ asset("customer/js/functions.js") }}"></script>
<script src="{{ asset("customer/js/app.js") }}"></script>

@endsection
