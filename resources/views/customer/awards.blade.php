@extends("customer.layout.layout")

@section("styles")

<link rel="stylesheet" href="{{ asset("customer/css/blogs.css") }}">
<link rel="stylesheet" href="{{ asset("customer/css/awards.css") }}">
<link rel="stylesheet" href="{{ asset("customer/css/loader-card.css") }}">

<!-- select2 Styles -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
<link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
<!-- Or for RTL support select2 -->
<link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.rtl.min.css" />

<!-- Scripts jquery + select2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js"></script>

<!-- Scripts -->
@vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .boxing .side-right-blog .pages {
            position: static;
            transform: unset;
        }

        .card-top .card-img img {
            width: 90px;
            height: 90px;
        }

        .flag-icon {
            margin-right: 8px;
            width: 20px;
            height: 15px;
        }

        .select2-container--default .select2-selection--multiple {
            box-shadow: 5px 5px 6px #dadada, -5px -5px 6px #f6f6f6;
        }

        main.dark .select2-container--default .select2-selection--multiple {
            background-color: var(--dark-color) !important;
            box-shadow: 5px 5px 8px #1b1b1b, -5px -5px 8px #272727;
        }

        .select2-container--default .select2-search--inline .select2-search__field {
            padding: 0px 15px;
            padding-top: 5px;
            height: 30px;
        }

        body.dark .select2-container--default .select2-results>.select2-results__options li span {
            color: var(--primary-color) !important;
        }

    </style>
    @endsection

    @section("award","activ")

    @section("main.layout")
    <div class="side-src">
        <strong>
            <a href="{{ route('home') }}"><i class="fa-solid fa-house"></i> <span
                    data-lang="home"></span></a>/ <span data-lang="awards">{{ __("app.scholarships") }}</span>
        </strong>
    </div>
    <div class="box-search mobile-search">
        <form action="#" class="search">
            <div class="filter_button">
                <div class="filter_icon">
                    <i class="fa-solid fa-sliders"></i>
                </div>
            </div>
            <div class="box_show_filter">
                <div class="box_filter_m"></div>
            </div>
            <button class="search__button">
                <div class="search__icon">
                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
                        <title>{{ __("search") }}</title>
                        <path
                            d="M17.545 15.467l-3.779-3.779c0.57-0.935 0.898-2.035 0.898-3.21 0-3.417-2.961-6.377-6.378-6.377s-6.186 2.769-6.186 6.186c0 3.416 2.961 6.377 6.377 6.377 1.137 0 2.2-0.309 3.115-0.844l3.799 3.801c0.372 0.371 0.975 0.371 1.346 0l0.943-0.943c0.371-0.371 0.236-0.84-0.135-1.211zM4.004 8.287c0-2.366 1.917-4.283 4.282-4.283s4.474 2.107 4.474 4.474c0 2.365-1.918 4.283-4.283 4.283s-4.473-2.109-4.473-4.474z">
                        </path>
                    </svg>
                </div>
            </button>
            <input type="text" title="{{ __("search") }}" id="search" value="{{ $search }}" class="search__input" placeholder="{{ __("search") }}...">
        </form>
    </div>
    <div class="boxing">
        <div class="side-left-blog">
            <div class="box-search">
                <form action="#" class="search">
                    <button class="search__button">
                        <div class="search__icon">
                            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                viewBox="0 0 20 20">
                                <title>{{ __("search") }}</title>
                                <path
                                    d="M17.545 15.467l-3.779-3.779c0.57-0.935 0.898-2.035 0.898-3.21 0-3.417-2.961-6.377-6.378-6.377s-6.186 2.769-6.186 6.186c0 3.416 2.961 6.377 6.377 6.377 1.137 0 2.2-0.309 3.115-0.844l3.799 3.801c0.372 0.371 0.975 0.371 1.346 0l0.943-0.943c0.371-0.371 0.236-0.84-0.135-1.211zM4.004 8.287c0-2.366 1.917-4.283 4.282-4.283s4.474 2.107 4.474 4.474c0 2.365-1.918 4.283-4.283 4.283s-4.473-2.109-4.473-4.474z">
                                </path>
                            </svg>
                        </div>
                    </button>
                    <input type="text" title="{{ __("search") }}" id="search" value="{{ $search }}" class="search__input"
                        placeholder="{{ __("search") }}...">
                </form>
            </div>
            <h1 class="top-title filter-title" style="font-size: 1.5em;">Filters</h1>
            <div class="filtters-box">
                <div class="container-filter" id="selected-filter">
                    <h4 style="padding: 20px 0;" id="get-selected-nav">{{ __("app.country") }}</h4>
                    <select id="country-select-filter" placeholder="{{ __("app.choose_country") }}"
                        multiple="" style="width: 100%;">
                        @foreach($countries as $country)
                            <option name="country"
                                {{ in_array($country->_id, $filters['countryIds'])?"selected":"" }}
                                value="{{ $country->_id }}" data-flag="{{ $country->flag }}">
                                {{ $country->{'name_'.$locale} }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="container-filter" id="selected-filter">
                    <h4 style="padding: 20px 0;" id="get-selected-nav">{{ __("app.major") }}</h4>
                    <select id="specialization-select-filter"
                        placeholder="{{ __("app.choose_major") }}" multiple=""
                        style="width: 100%;">
                        @foreach($specializations as $specialization)
                            <option name="specialization"
                                {{ in_array( $specialization->id, $filters['specializationIds'])?"selected":"" }}
                                value="{{ $specialization->id }}">
                                {{ $specialization->{'name_'.$locale} }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="container-filter">
                    <h4 style="padding: 20px 0 6px;" id="get-selected">{{ __("app.funding_type") }}
                    </h4>
                    <ul class="list">
                        <li>
                            <div class="list-item {{ in_array("full", $filters['fundingTypes'])?"selected":"" }}"
                                data-finance="full">{{ __("app.full") }}</div>
                        </li>
                        <li>
                            <div class="list-item {{ in_array("partial", $filters['fundingTypes'])?"selected":"" }}"
                                data-finance="partial">{{ __("app.partial") }}</div>
                        </li>
                        <li>
                            <div class="list-item {{ in_array("private", $filters['fundingTypes'])?"selected":"" }}"
                                data-finance="private">{{ __("app.private") }}</div>
                        </li>
                    </ul>
                </div>
                <div class="container-filter">
                    <h4 style="padding: 20px 0 6px;" id="get-selected">{{ __("app.educational_level") }}</h4>
                    <ul class="list">
                        @foreach($degree_levels as $degree_level)
                            <li>
                                <div class="list-item {{ in_array($degree_level->id, $filters['degreeLevelIds'])?"selected":"" }}"
                                    data-educational="{{ $degree_level->id }}">
                                    {{ $degree_level->{'name_'.$locale} }}</div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <h1 class="top-title" style="font-size: 1.5em;">{{ __("app.best_scholarships") }}</h1>
            <div class="box-top-blog">
                <div class="card-top">
                    <div class="card-img">
                        <img src="{{ asset('customer/assets/card1.webp') }}" alt="">
                        <span>
                            1
                        </span>
                    </div>
                    <div>
                        <h3>منح حكومة الصين</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consequuntur incidunt
                            repellat
                            quis ex quod ut doloremque dolorem aperiam obcaecati veritatis. Nesciunt vero
                            ducimus
                            aperiam non saepe ipsa vel placeat amet.</p>
                    </div>
                </div>
                <div class="card-top">
                    <div class="card-img">
                        <img src="{{ asset('customer/assets/card2.webp') }}" alt="">
                        <span>
                            2
                        </span>
                    </div>
                    <div>
                        <h3>منح حكومة الصين</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consequuntur incidunt
                            repellat
                            quis ex quod ut doloremque dolorem aperiam obcaecati veritatis. Nesciunt vero
                            ducimus
                            aperiam non saepe ipsa vel placeat amet.</p>
                    </div>
                </div>
                <div class="card-top">
                    <div class="card-img">
                        <img src="{{ asset('customer/assets/card1.webp') }}" alt="">
                        <span>
                            3
                        </span>
                    </div>
                    <div>
                        <h3>منح حكومة الصين</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consequuntur incidunt
                            repellat
                            quis ex quod ut doloremque dolorem aperiam obcaecati veritatis. Nesciunt vero
                            ducimus
                            aperiam non saepe ipsa vel placeat amet.</p>
                    </div>
                </div>
                <div class="card-top">
                    <div class="card-img">
                        <img src="{{ asset('customer/assets/card1.webp') }}" alt="">
                        <span>
                            4
                        </span>
                    </div>
                    <div>
                        <h3>منح حكومة الصين</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consequuntur incidunt
                            repellat
                            quis ex quod ut doloremque dolorem aperiam obcaecati veritatis. Nesciunt vero
                            ducimus
                            aperiam non saepe ipsa vel placeat amet.</p>
                    </div>
                </div>
                <div class="card-top">
                    <div class="card-img">
                        <img src="{{ asset('customer/assets/card1.webp') }}" alt="">
                        <span>
                            5
                        </span>
                    </div>
                    <div>
                        <h3>منح حكومة الصين</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consequuntur incidunt
                            repellat
                            quis ex quod ut doloremque dolorem aperiam obcaecati veritatis. Nesciunt vero
                            ducimus
                            aperiam non saepe ipsa vel placeat amet.</p>
                    </div>
                </div>

            </div>
            <h1 class="top-title">{{ __("app.read_also") }}</h1>
            <div class="box-top-blog">
                <div class="card-top">
                    <div class="card-img">
                        <img src="{{ asset('customer/assets/blog/1.jpg') }}" alt="">
                        <span>
                            1
                        </span>
                    </div>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consequuntur incidunt repellat
                        quis ex quod ut doloremque dolorem aperiam obcaecati veritatis. Nesciunt vero ducimus
                        aperiam non saepe ipsa vel placeat amet.</p>
                </div>
                <div class="card-top">
                    <div class="card-img">
                        <img src="{{ asset('customer/assets/blog/1.jpg') }}" alt="">
                        <span>
                            2
                        </span>
                    </div>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consequuntur incidunt repellat
                        quis ex quod ut doloremque dolorem aperiam obcaecati veritatis. Nesciunt vero ducimus
                        aperiam non saepe ipsa vel placeat amet.</p>
                </div>
                <div class="card-top">
                    <div class="card-img">
                        <img src="{{ asset('customer/assets/blog/1.jpg') }}" alt="">
                        <span>
                            3
                        </span>
                    </div>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consequuntur incidunt repellat
                        quis ex quod ut doloremque dolorem aperiam obcaecati veritatis. Nesciunt vero ducimus
                        aperiam non saepe ipsa vel placeat amet.</p>
                </div>
                <div class="card-top">
                    <div class="card-img">
                        <img src="{{ asset('customer/assets/blog/1.jpg') }}" alt="">
                        <span>
                            4
                        </span>
                    </div>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consequuntur incidunt repellat
                        quis ex quod ut doloremque dolorem aperiam obcaecati veritatis. Nesciunt vero ducimus
                        aperiam non saepe ipsa vel placeat amet.</p>
                </div>
                <div class="card-top">
                    <div class="card-img">
                        <img src="{{ asset('customer/assets/blog/1.jpg') }}" alt="">
                        <span>
                            5
                        </span>
                    </div>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consequuntur incidunt repellat
                        quis ex quod ut doloremque dolorem aperiam obcaecati veritatis. Nesciunt vero ducimus
                        aperiam non saepe ipsa vel placeat amet.</p>
                </div>
            </div>
        </div>
        <div class="side-right-blog portfolio" id="portfolio">
            <div class="tags-box">
                <h4 style="
                    min-width: 46px;
                    ">{{ __("app.tag") }} : </h4>
                <div class="tags-items">
                </div>
            </div>
            <div class="awards-box" id="scholarships-container">
                @forelse($scholarships as $scholarship)
                    <div class="card text-right" id="user-{{ $scholarship->id }}">
                        <div>
                            <div class="card-image row justify-content-center">
                                <img src="{{ asset('storage/'.$scholarship->image) }}"
                                    alt="{{ $scholarship->{'title_'.$locale} }}"
                                    title="{{ $scholarship->{'title_'.$locale} }}"
                                    loading="lazy">
                                <div class="types">
                                    @foreach($scholarship->specializations as $specialization)
                                        <span class="project-type">•
                                            {{ $specialization->{'name_'.$locale} }}</span>
                                    @endforeach
                                    @foreach($scholarship->degree_levels as $degree_level)
                                        <span class="project-type">•
                                            {{ $degree_level->{'name_'.$locale} }}</span>
                                    @endforeach
                                    <span class="project-type">•
                                        {{ $scholarship->country->{'name_'.$locale} }}</span>
                                    <span class="project-type">•
                                        {{ __("app.$scholarship->funding_type") }}</span>
                                </div>
                            </div>

                            <a href="#" class="award-link">
                                <div class="head-info">
                                    <span class="fsz-10">{{ __('app.watch') }}
                                        {{ $scholarship->formatVisits() ?: "0" }}</span>
                                    <span class="fsz-10">{{ __('app.brief') }}
                                        {{ $scholarship->created_at->format('Y-d-M') }}</span>
                                </div>
                                <p class="card-title">{{ $scholarship->{'title_'.$locale} }}
                                </p>
                                <p class="card-body">
                                    {{ $scholarship->{'description_'.$locale} }}
                                </p>
                                <p class="footer"><span
                                        class="by-name">{{ __('app.deadline') }}</span> :
                                    <span class="date"> {{ $scholarship->deadline }}</span>
                                </p>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="notfound">
                        <h2 class="text-center">{{ __('app.notfound_scholarships') }}</h2>
                    </div>
                @endforelse
            </div>

            <div class="pages">
                <div id="js-pagition" dir="ltr">
                    {{ $scholarships->onEachSide(-1)->links() }}
                </div>
            </div>
        </div>
    </div>
    @endsection


    @section("script")
    <script src="{{ asset('customer/js/functions.js') }}"></script>
    <script src="{{ asset('customer/js/country.js') }}"></script>
    <script src="{{ asset('customer/js/filter.js') }}"></script>
    <script src="{{ asset('customer/js/award.js') }}"></script>
    @endsection
