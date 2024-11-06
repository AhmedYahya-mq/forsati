@extends("customer.layout.layout")

@section("styles")
<link rel="stylesheet" href="{{ asset("customer/css/say.css") }}">
<link rel="stylesheet" href="{{ asset("customer/css/blogpost.css") }}">
<link rel="stylesheet" href="{{ asset("customer/css/awards.css") }}">
@endsection

@section("home","activ")

@section("main.layout")
<section id="introdaction">
    <div class="side-left-bar reveal-bottom">
        <h2 class="title-introdaction" data-lang="hello"></h2>
        <h3><span></span></h3>
        <p data-lang="web-description">{{ __('app.web-description') }}</p>
        <div class="social-media">
            <a href=""><i class="fa-brands fa-facebook"></i></a>
            <a href=""><i class="fa-brands fa-whatsapp"></i></a>
            <a href=""><i class="fa-brands fa-telegram"></i></a>
            <a href=""><i class="fa-brands fa-x-twitter"></i></a>
        </div>
        <button class="btn" data-lang="contact">{{ __('app.contact') }}</button>
    </div>
    <div class="side-right-bar reveal-top">
        <img src="{{ asset("customer/assets/image1.png") }}" alt="" loading="lazy" srcset="">
        <div class="box-border">
        </div>

        <div class="box-circler">
            <div class="circle" style="--r:5">فـ</div>
            <div class="circle" style="--r:4">ـر</div>
            <div class="circle" style="--r:3">صـ</div>
            <div class="circle" style="--r:2">ـتـ</div>
            <div class="circle" style="--r:1">ـي</div>

            <div class="circle" style="--r:33">سـ</div>
            <div class="circle" style="--r:32">ـبـ</div>
            <div class="circle" style="--r:31">ـيـ</div>
            <div class="circle" style="--r:30">ـلـ</div>
            <div class="circle" style="--r:29">ـك</div>
            <div class="circle" style="--r:28">نـ</div>
            <div class="circle" style="--r:27">ـحـ</div>
            <div class="circle" style="--r:26">ـو</div>
            <div class="circle" style="--r:25">تـ</div>
            <div class="circle" style="--r:24">ـعـ</div>
            <div class="circle" style="--r:23">ـلـ</div>
            <div class="circle" style="--r:22">ـيـ</div>
            <div class="circle" style="--r:21">ـم</div>
            <div class="circle" style="--r:20">أ</div>
            <div class="circle" style="--r:19">فـ</div>
            <div class="circle" style="--r:18">ـضـ</div>
            <div class="circle" style="--r:17">ـل</div>
        </div>
    </div>
</section>

<section id="about">
    <div class="side-logo">
        <img loading="lazy" src="{{ asset("customer/assets/logo.png") }}" alt="" srcset="">
    </div>
    <div class="side-content">
        <h2 data-lang="about">{{ __('app.about') }}</h2>
        <strong data-lang="about-title">{{ __('app.about-title') }}</strong>
        <p data-lang="about-description">
            {!! __('app.about-description') !!}
        </p>
        <div class="social-media">
            <a href=""><i class="fa-brands fa-facebook"></i></a>
            <a href=""><i class="fa-brands fa-whatsapp"></i></a>
            <a href=""><i class="fa-brands fa-telegram"></i></a>
            <a href=""><i class="fa-brands fa-x-twitter"></i></a>
        </div>
        <button class="btn" data-lang="btn_read_more">{{ __('app.btn_read_more') }}</button>
    </div>
</section>

<section id="achievements">
    <div class="card-number">
        <i class="fa-solid fa-users-viewfinder"></i>
        <h2>+<span data-goal="25420000">0</span></h2>
        <p data-lang="website-visits">{{ __('app.website-visits') }}</p>
    </div>
    <div class="card-number">
        <i class="fa-solid fa-plane"></i>
        <h2>+<span data-goal="2000">0</span></h2>
        <p data-lang="accepted-scholarships-us">{{ __('app.accepted-scholarships-us') }}</p>
    </div>
    <div class="card-number">
        <i class="fa-solid fa-file-signature"></i>
        <h2>+<span data-goal="6140">0</span></h2>
        <p data-lang="applicants-us">{{ __('app.applicants-us') }}</p>
    </div>
</section>

<section id="services">
    <div class="card-wrap">
        <div class="card-header one">
            <i class="fa fa-graduation-cap icon"></i>
        </div>
        <div class="card-content">
            <h1 class="card-title" data-lang="services-1">{{ __('app.services-1') }}</h1>
            <p class="card-text" data-lang="services-descriptions-1">
                {{ __('app.services-descriptions-1') }}
            </p>

        </div>
    </div>
    <div class="card-wrap">
        <div class="card-header two">
            <i class="fa fa-chalkboard-teacher icon"></i>
        </div>
        <div class="card-content">
            <h1 class="card-title" data-lang="services-2">{{ __('app.services-2') }}</h1>
            <p class="card-text" data-lang="services-descriptions-2">
                {{ __('app.services-descriptions-2') }}
            </p>

        </div>
    </div>
    <div class="card-wrap">
        <div class="card-header three">
            <i class="fa fa-clipboard-list icon"></i>
        </div>
        <div class="card-content">
            <h1 class="card-title" data-lang="services-3">{{ __('app.services-3') }}</h1>
            <p class="card-text" data-lang="services-descriptions-3">
                {{ __('app.services-descriptions-3') }}
            </p>

        </div>
    </div>
    <div class="card-wrap">
        <div class="card-header four">
            <i class="fa fa-file-signature icon"></i>
        </div>
        <div class="card-content">
            <h1 class="card-title" data-lang="services-4">{{ __('app.services-4') }}</h1>
            <p class="card-text" data-lang="services-descriptions-4">
                {{ __('app.services-descriptions-4') }}
            </p>

        </div>
    </div>
    <div class="card-wrap">
        <div class="card-header one">
            <i class="fa fa-envelope-open-text icon"></i>
        </div>
        <div class="card-content">
            <h1 class="card-title" data-lang="services-5">{{ __('app.services-5') }}</h1>
            <p class="card-text" data-lang="services-descriptions-5">
                {{ __('app.services-descriptions-5') }}
            </p>

        </div>
    </div>
    <div class="card-wrap">
        <div class="card-header two">
            <i class="fa fa-book-reader icon"></i>
        </div>
        <div class="card-content">
            <h1 class="card-title" data-lang="services-6">{{ __('app.services-6') }}</h1>
            <p class="card-text" data-lang="services-descriptions-6">
                {{ __('app.services-descriptions-6') }}
            </p>

        </div>
    </div>
</section>
<section class="ads" dir="rtl">
    <div class="swiper mySwiper">
        <div class="swiper-wrapper">
            @forelse($advertisements as $advertisement)
                <div class="banner-container swiper-slide">
                    <div class="banner" dir="ltr">
                        <a href="{{ $advertisement->url }}" target="_blank" rel="noopener noreferrer">
                            <div class="image-ad-box">
                                <img class="mobile" loading="lazy"
                                    src="{{ asset("storage/".$advertisement->mobile_image) }}"
                                    alt="{{ $advertisement->title }}" title="{{ $advertisement->title }}">
                                <img class="desktop" loading="lazy"
                                    src="{{ asset("storage/".$advertisement->desktop_image) }}"
                                    alt="{{ $advertisement->title }}" title="{{ $advertisement->title }}">
                            </div>
                        </a>
                    </div>
                </div>
            @empty

            @endforelse
        </div>
    </div>
</section>

<section id="awards">
    @forelse($scholarships as $scholarship)
    <div class="card text-right" id="user-{{ $scholarship->id }}">
    <div>
        <div class="card-image row justify-content-center">
            <img src="{{ asset('storage/'.$scholarship->image) }}"
                alt="{{ $scholarship->{'title_'.$locale} }}" title="{{ $scholarship->{'title_'.$locale} }}" loading="lazy">
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
                    {{ $funding_types[$scholarship->funding_type] }}</span>
            </div>
        </div>

        <a href="#" class="award-link">
            <div class="head-info">
                <span class="fsz-10">{{ __('app.watch') }}
                    {{ $scholarship->formatVisits() ?: "0" }}</span>
                <span class="fsz-10">{{ __('app.brief') }}
                    {{ $scholarship->created_at->format('Y-d-M') }}</span>
            </div>
            <p class="card-title">{{ $scholarship->{'title_'.$locale} }}</p>
            <p class="card-body">
                {{ $scholarship->{'description_'.$locale} }}
            </p>
            <p class="footer"><span class="by-name">{{ __('app.deadline') }}</span> :
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
</section>

<section class="portfolio" id="portfolio">
    <div class="portfolio-gallery">
        @forelse($blogs as $blog)
            <div class="portfolio-box mix uiux text-right" id="user-{{ $blog->id }}">
                <div class="portfolio-content">
                    <h3>{{ $blog->{"title_".$locale} }}</h3>
                    <p>
                        {{ $blog->{"description_".$locale} }}
                    </p>
                    <a href="#" class="readMore">
                        <span class="text-center">{{ __('app.btn_read_more') }}</span>
                    </a>
                </div>
                <div class="portfolio-img row m-1 justify-content-center" style="position: relative;">
                    <img id="image-blog"
                        src="{{ asset(path: "storage/" . $blog->image) }}"
                        title="{{ $blog->{"title_".$locale} }}" alt="{{ $blog->{"title_".$locale} }}" loading="lazy">
                </div>
            </div>
        @empty
            <div class="notfound">
                <h2 class="text-center">{{ __('app.notfound_blogs') }}</h2>
            </div>
        @endforelse
    </div>
</section>

<section id="container" dir="ltr">
    <div class="board">
        <div class="box-title">
            <h2 class="text-light" data-lang="say-title">A word from our customers</h2>
            <p class="text-light" data-lang="say-subtitle">Opinions of some customers</p>
        </div>

        <!-- Slider main container -->
        <div class="swiper-say">
            <!-- Additional required wrapper -->
            <div class="swiper-wrapper">
                <!-- Slides -->
                <div class="swiper-slide">
                    <div class="flex">
                        <div class="comments">
                            "شكرًا لمنصة فرصتي، لقد حصلت على منحة دراسية رائعة من خلالها. كانت تجربتي مع
                            المنصة سهلة وميسرة، والآن أستطيع متابعة دراستي في جامعة أحلامي."
                        </div>
                        <div class="profile">
                            <img loading="lazy" src="{{ asset("customer/assets/image1.png") }}"
                                alt="">
                            <a href="#">محمد الخالدي</a>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="flex">
                        <div class="comments">
                            "أشكر فريق عمل فرصتي على الدعم المستمر وتوفير الفرص المميزة. بفضل المنصة، حصلت
                            على منحة دراسية كاملة لم أكن لأحصل عليها لولاهم."
                        </div>
                        <div class="profile">
                            <img loading="lazy"
                                src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=4&w=256&h=256&q=60"
                                alt="">
                            <a href="#">حمد المصري</a>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="flex">
                        <div class="comments">
                            "امتنان كبير لمنصة فرصتي! بفضل المنحة التي وفروها لي، تمكنت من متابعة دراستي في
                            الخارج وتحقيق أحلامي الأكاديمية. أنصح الجميع بالاستفادة من هذه الفرص القيمة."
                        </div>
                        <div class="profile">
                            <img loading="lazy"
                                src="https://images.unsplash.com/photo-1503185912284-5271ff81b9a8?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=facearea&facepad=4&w=256&h=256&q=60"
                                alt="">
                            <a href="#">سارة العلي</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- If we need pagination -->
            <div class="swiper-pagination"></div>

            <!-- If we need navigation buttons -->
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>

        </div>

    </div>
</section>

<section class="contact-us" id="contact-us">
    <div class="contact-us">
        <h2 data-lang="stay-in-touch">{{ __('app.stay_in_touch') }}</h2>
        <p data-lang="discription_say">
            {{ __('app.discription_say') }}
        </p>
    </div>
    <div class="containerContact">
        <div class="contactInfo">
            <div class="box-contact">
                <div class="icon"><b><i class="fa-solid fa-location-dot"></i></b></div>
                <div class="text">
                    <h3 data-lang="addres">
                        {{ __('app.address') }}
                    </h3>
                    <p>405544 Sugar Camp Road,<br>Owatonna Minnesota,<br>22545521</p>
                </div>
            </div>
            <div class="box-contact">
                <div class="icon"><b><i class="fa-solid fa-phone"></i></b></div>
                <div class="text">
                    <h3 data-lang="phone">
                        {{ __('app.phone') }}
                    </h3>
                    <p dir="ltr">+967 771 508 902</p>
                </div>
            </div>
            <div class="box-contact">
                <div class="icon"><b><i class="fa-solid fa-envelope"></i></b></div>
                <div class="text">
                    <h3 data-lang="email">
                        {{ __('app.email') }}
                    </h3>
                    <p>forsaty@gmail.com</p>
                </div>
            </div>
            <h2 class="txt" data-lang="Connect-with-us">{{ __('app.connect_with_us') }}</h2>
            <div class="social-media">
                <a href=""><i class="fa-brands fa-facebook"></i></a>
                <a href=""><i class="fa-brands fa-whatsapp"></i></a>
                <a href=""><i class="fa-brands fa-telegram"></i></a>
                <a href=""><i class="fa-brands fa-x-twitter"></i></a>
            </div>
        </div>
        <div class="contactForm">
            <form action="" method="post">
                <h2 data-lang="send-masseg">{{ __('app.send_masseg') }}</h2>
                <div class="inputBox">
                    <input type="text" required name="" id="">
                    <span data-lang="full-name">{{ __('app.full_name') }}</span>
                </div>
                <div class="inputBox">
                    <input type="text" required name="" id="">
                    <span data-lang="email">{{ __('app.email') }}</span>
                </div>
                <div class="inputBox">
                    <textarea rows="1" name="" id="" required></textarea>
                    <span data-lang="write-message">{{ __('app.write_message') }}</span>
                </div>
                <div class="inputBox">
                    <button type="submit" value="Send" class="btn"
                        data-lang="send">{{ __('app.send') }}</button>
                </div>
            </form>
        </div>
    </div>
</section>

@endsection

@section("script")
<script src="{{ asset("customer/js/swiper.js") }}"></script>
<script>
    $(document).ready(function () {
        $('a[href^="#"]').on('click', function (event) {
            try {
                event.preventDefault();

                var target = this.hash;
                var $target = $(target);

                $('.container').animate({
                    scrollTop: $target.offset().top
                }, 1000);
            } catch {
                console.error("link error");
            }
        });
    });

</script>
@endsection
