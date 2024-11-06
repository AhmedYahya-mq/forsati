<!DOCTYPE html>
<html lang="{{ \Illuminate\Support\Facades\App::getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="token" content="{{ session("token") }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <link rel="stylesheet" href="{{ asset("customer/css/settings.css") }}">
    <link rel="stylesheet" href="{{ asset("customer/css/header.css") }}">
    <link rel="stylesheet" href="{{ asset("customer/css/main.css") }}">
    <link rel="stylesheet" href="{{ asset("customer/css/translation.css") }}">
    <link rel="stylesheet" href="{{ asset("customer/css/loader.css") }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Link Swiper's CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <link rel="stylesheet" href="{{ asset("customer/css/mode.css") }}">
    <link rel="stylesheet" href="{{ asset("customer/css/footer.css") }}">
    <link rel="stylesheet" href="{{ asset("customer/css/ads.css") }}">
    <link rel="stylesheet" href="{{ asset("customer/css/goto-top.css") }}">
    <link rel="stylesheet" href="{{ asset("customer/css/widegt-floting-button-whatsapp.css") }}">
    <script src="{{ asset("customer/js/jquery-3.7.1.min.js") }}"></script>
    <script src="{{ asset("customer/js/translation.js") }}"></script>
    <script src="https://unpkg.com/scrollreveal"></script>
    @yield("styles")

    <title data-lang="title">{{ __("app.forsaty") }}</title>
</head>

<body class="{{ \Illuminate\Support\Facades\App::getLocale() }}"></body>
    <div class="bg-v-dark"></div>
    <div class="box-loader">
        <div class="loader">
            <div class="box box-1">
                <div class="side-left"></div>
                <div class="side-right"></div>
                <div class="side-top"></div>
            </div>
            <div class="box box-2">
                <div class="side-left"></div>
                <div class="side-right"></div>
                <div class="side-top"></div>
            </div>
            <div class="box box-3">
                <div class="side-left"></div>
                <div class="side-right"></div>
                <div class="side-top"></div>
            </div>
            <div class="box box-4">
                <div class="side-left"></div>
                <div class="side-right"></div>
                <div class="side-top"></div>
            </div>
        </div>
    </div>
    <div class="container-base {{ \Illuminate\Support\Facades\App::getLocale() }}">
        <header class="{{ \Illuminate\Support\Facades\App::getLocale() }}">
            <a href="{{ route('home') }}">
                <div class="logo">
                    <img src="{{ asset("customer/assets/logo.png") }}" alt="فرصتي" loading="lazy"
                        srcset="">
                </div>
            </a>
            <div class="nav-sidebar">
                <div class="menu-desktop">
                    <ul>
                        <li id="@yield("home")"><a data-lang="home"
                                href="{{ route('home') }}#introdaction">{{ __('app.home') }}</a>
                        </li>
                        <li><a data-lang="serveies"
                                href="{{ route('home') }}#services">{{ __('app.serveies') }}</a>
                        </li>
                        <li id="@yield("blog")"><a data-lang="blog"
                                href="{{ route('blog') }}">{{ __('app.blog') }}</a>
                        </li>
                        <li id="@yield("award")"><a data-lang="awards"
                                href="{{ route('award') }}">{{ __('app.scholarships') }}</a>
                        </li>
                        {{-- <li><a data-lang="online_courses" href="#">{{ __('app.online_courses') }}</a>
                        </li> --}}
                        <li><a data-lang="contact"
                                href="{{ route('home') }}#contact-us">{{ __('app.contact') }}</a>
                        </li>
                        <li><a data-lang="about"
                                href="{{ route('home') }}#about">{{ __('app.about') }}</a>
                        </li>
                        <li></li>
                    </ul>

                </div>

                <div class="left-nav">
                    @if(isset($user) && $user)
                        <div class="user-info">
                            <div class="profile">
                                <img src="{{ asset(path: 'storage/'."$user->image") }}"
                                    alt="{{ $user->name }}" loading="lazy" srcset="">
                            </div>
                            <nav>
                                <ul class="menu-user">
                                    <li><a data-lang="profile"
                                            href="{{ route('profile') }}">{{ __('app.profile') }}</a>
                                    </li>
                                    <li><a data-lang="favorite" href="#">{{ __('app.favorite') }}</a>
                                    </li>
                                    <form method="POST" action="{{ route('user.logout') }}">
                                        @csrf
                                        <button type="submit"
                                            class="underline btn text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            {{ __(key: 'app.logout') }}
                                        </button>
                                    </form>
                                </ul>
                            </nav>
                        </div>
                    @else
                        <a href="{{ route('user.login') }}" id="login"><b
                                data-lang="login">{{ __('app.login') }}</b></a>
                    @endif
                    <div class="mode">
                        <i class="fas fa-sun"></i>
                    </div>

                    <div class="translation">
                        <a href="{{ route("change_language") }}"><i id="btn-lang"
                                class="fa-solid fa-language"></i></a>
                    </div>
                </div>
                <div class="btn-show-menu ml-1">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
        </header>
        <main class="{{ \Illuminate\Support\Facades\App::getLocale() }}">
            @yield("main.layout")
        </main>

        <footer class="{{ \Illuminate\Support\Facades\App::getLocale() }}">
            <div class="footer-f">
                <div class="row">
                    <a href=""><i class="fa-brands fa-facebook"></i></a>
                    <a href=""><i class="fa-brands fa-whatsapp"></i></a>
                    <a href=""><i class="fa-brands fa-telegram"></i></a>
                    <a href=""><i class="fa-brands fa-x-twitter"></i></a>
                </div>

                <div class="row">
                    <ul>
                        <li ><a data-lang="home"
                                href="{{ route('home') }}#introdaction">{{ __('app.home') }}</a>
                        </li>
                        <li><a data-lang="serveies"
                                href="{{ route('home') }}#services">{{ __('app.serveies') }}</a>
                        </li>
                        <li><a data-lang="blog"
                                href="{{ route('blog') }}">{{ __('app.blog') }}</a>
                        </li>
                        <li><a data-lang="awards"
                                href="{{ route('award') }}">{{ __('app.scholarships') }}</a>
                        </li>
                        {{-- <li><a data-lang="online_courses" href="#">{{ __('app.online_courses') }}</a>
                        </li> --}}
                        <li><a data-lang="contact"
                                href="{{ route('home') }}#contact-us">{{ __('app.contact') }}</a>
                        </li>
                        <li><a data-lang="about"
                                href="{{ route('home') }}#about">{{ __('app.about') }}</a>
                        </li>
                    </ul>
                </div>

                <div class="row">
                    <span><a data-lang="copyright">
                            {{ __('app.copyright') }}
                        </a></span>
                </div>
            </div>
        </footer>
        <div class="chat-whatsapp">

        </div>
        <div class="gototop js-top">
            <a href="#" class="js-gotop"><i class="fa-solid fa-chevron-up" style="color:var(--text-color);"></i></a>
        </div>
    </div>

    <script src="{{ asset("customer/js/script-floting-action-button-whatsapp.js") }}"></script>
    <script src="{{ asset("customer/js/script.js") }}"></script>

    @yield('script')
</body>

</html>
