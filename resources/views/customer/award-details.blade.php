@extends("customer.layout.layout")



@section("styles")

<link rel="stylesheet" href="{{ asset("customer/css/blogs.css") }}">
<link rel="stylesheet" href="{{ asset("customer/css/blog-details.css") }}">
<link rel="stylesheet" href="{{ asset("customer/css/awards.css") }}">
<link rel="stylesheet" href="{{ asset("customer/css/loader-card.css") }}">
<link rel="stylesheet" href="{{ asset("customer/css/comments.css") }}">

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
        <a href="{{ route('award') }}"><i class="fa-solid fa-house"></i> <span
                data-lang="home"></span></a>/ <span data-lang="awards"></span>
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
            <div class="filtters-box">
            </div>
        </div>
        <button class="search__button">
            <div class="search__icon">
                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
                    <title>magnifying-glass</title>
                    <path
                        d="M17.545 15.467l-3.779-3.779c0.57-0.935 0.898-2.035 0.898-3.21 0-3.417-2.961-6.377-6.378-6.377s-6.186 2.769-6.186 6.186c0 3.416 2.961 6.377 6.377 6.377 1.137 0 2.2-0.309 3.115-0.844l3.799 3.801c0.372 0.371 0.975 0.371 1.346 0l0.943-0.943c0.371-0.371 0.236-0.84-0.135-1.211zM4.004 8.287c0-2.366 1.917-4.283 4.282-4.283s4.474 2.107 4.474 4.474c0 2.365-1.918 4.283-4.283 4.283s-4.473-2.109-4.473-4.474z">
                    </path>
                </svg>
            </div>
        </button>
        <input type="text" class="search__input" placeholder="Search...">
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
                            <title>magnifying-glass</title>
                            <path
                                d="M17.545 15.467l-3.779-3.779c0.57-0.935 0.898-2.035 0.898-3.21 0-3.417-2.961-6.377-6.378-6.377s-6.186 2.769-6.186 6.186c0 3.416 2.961 6.377 6.377 6.377 1.137 0 2.2-0.309 3.115-0.844l3.799 3.801c0.372 0.371 0.975 0.371 1.346 0l0.943-0.943c0.371-0.371 0.236-0.84-0.135-1.211zM4.004 8.287c0-2.366 1.917-4.283 4.282-4.283s4.474 2.107 4.474 4.474c0 2.365-1.918 4.283-4.283 4.283s-4.473-2.109-4.473-4.474z">
                            </path>
                        </svg>
                    </div>
                </button>
                <input type="text" class="search__input" placeholder="Search...">
            </form>
        </div>
        <h1 class="top-title filter-title" style="font-size: 1.5em;">Filters</h1>
        <div class="filtters-box nav-filter">
            <div class="container-filter" id="selected-filter">
                <h4 style="padding: 20px 0;" id="get-selected-nav">الدولة</h4>
                <select id="country-select" multiple="multiple" style="width: 100%;">
                </select>
            </div>
            <div class="container-filter">
                <h4 style="padding: 20px 0 6px;" id="get-selected">التمويل</h4>
                <ul class="list">
                    <li>
                        <div class="list-item" data-finance="FF">ممولة بالكامل</div>
                    </li>
                    <li>
                        <div class="list-item" data-finance="PF">ممولة جزئي</div>
                    </li>
                    <li>
                        <div class="list-item" data-finance="PE">نفقه خاصه</div>
                    </li>
                </ul>
            </div>
            <div class="container-filter">
                <h4 style="padding: 20px 0 6px;" id="get-selected">درجة التعليميه</h4>
                <ul class="list">
                    <li>
                        <div class="list-item" data-Educational="Dr">الدكتورة</div>
                    </li>
                    <li>
                        <div class="list-item" data-Educational="Master's">ماجيستير</div>
                    </li>
                    <li>
                        <div class="list-item" data-Educational="Bachelor's">بكاليوريوس</div>
                    </li>
                </ul>
            </div>
        </div>
        <h1 class="top-title" style="font-size: 1.5em;">أفضل المنح</h1>
        <div class="box-top-blog">
            <div class="card-top">
                <div class="card-img">
                    <img src="static/assets/card1.webp" alt="">
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
                    <img src="static/assets/card2.webp" alt="">
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
                    <img src="static/assets/card1.webp" alt="">
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
                    <img src="static/assets/card2.webp" alt="">
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
                    <img src="static/assets/card1.webp" alt="">
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

        <h1 class="top-title">اقرأ أيضاً</h1>
        <div class="box-top-blog">
            <div class="card-top">
                <div class="card-img">
                    <img src="static/assets/blog/1.jpg" alt="">
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
                    <img src="static/assets/blog/2.jpg" alt="">
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
                    <img src="static/assets/blog/3.jpg" alt="">
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
                    <img src="static/assets/blog/4.jpg" alt="">
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
                    <img src="static/assets/blog/5.jpg" alt="">
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
                    ">Tags : </h4>
            <div class="tags-items">
            </div>
        </div>
        <div class="awards-box blog-details">
            <div class="img-post" style=" max-width: 400px;">
                <img src="static/assets/card1.webp" alt="UI/UX Design">
                <div class="social-media post-social-media">
                    <a href=""><i class="fa-brands fa-facebook"></i></a>
                    <a href=""><i class="fa-brands fa-whatsapp"></i></a>
                    <a href=""><i class="fa-brands fa-telegram"></i></a>
                    <a href=""><i class="fa-brands fa-x-twitter"></i></a>
                </div>
            </div>
            <div class="content">
                <p dir="rtl">تقنية المعلومات (Information Technology) هي مجال يشمل كل ما يتعلق باستخدام
                    التكنولوجيا في معالجة وإدارة المعلومات. يتناول هذا المجال مجموعة واسعة من الأنشطة والتقنيات
                    التي تشمل الحوسبة، تخزين البيانات، تحليلها، وتأمينها. يُعدّ هذا المجال أحد أهم ركائز التطور
                    الحديث في شتى جوانب الحياة.</p>

                <h3 dir="rtl">مكونات تقنية المعلومات</h3>

                <p dir="rtl">تقنية المعلومات تتكون من عدة عناصر رئيسية تشمل:</p>

                <ol dir="rtl" style="margin-right:40px">
                    <li>
                        <p><strong>الأجهزة (Hardware):</strong>&nbsp;وتشمل جميع المكونات المادية التي تُمكّن
                            الحواسيب والأنظمة التقنية من العمل. من الأمثلة على ذلك: الحواسيب، الخوادم، وأجهزة
                            التخزين.</p>
                    </li>
                    <li>
                        <p><strong>البرمجيات (Software):</strong>&nbsp;وهي البرامج والتطبيقات التي تُشغل الأجهزة
                            وتُمكن المستخدمين من تنفيذ المهام المختلفة. من أشهر الأمثلة: نظم التشغيل مثل Windows
                            وLinux، وبرامج الإنتاجية مثل Microsoft Office.</p>
                    </li>
                    <li>
                        <p><strong>الشبكات (Networks):</strong>&nbsp;تشمل الربط بين أجهزة الكمبيوتر والأنظمة
                            المختلفة لنقل البيانات والمعلومات بينها، مما يسمح بالتواصل والتعاون الفوري عبر
                            الإنترنت أو الشبكات المحلية.</p>
                    </li>
                    <li>
                        <p><strong>إدارة البيانات (Data Management):</strong>&nbsp;يتضمن جمع، تخزين، وتحليل
                            البيانات، بالإضافة إلى الحفاظ على أمنها. قواعد البيانات، مثل MySQL وOracle، تُعتبر
                            جزءاً أساسياً من هذا المكون.</p>
                    </li>
                    <li>
                        <p><strong>أمن المعلومات (Information Security):</strong>&nbsp;يركز على حماية المعلومات
                            والبيانات من الوصول غير المصرح به أو التلاعب بها. يشمل ذلك تطوير وتنفيذ استراتيجيات
                            أمنية مثل التشفير والجدران النارية.</p>
                    </li>
                </ol>

                <h3 dir="rtl">أهمية تقنية المعلومات</h3>

                <p dir="rtl">تقنية المعلومات تلعب دورًا حيويًا في حياة الأفراد والشركات على حد سواء. من خلال
                    الحوسبة السحابية (Cloud Computing)، يمكن تخزين البيانات وإدارتها بكفاءة عالية وبتكلفة أقل.
                    تسهم تقنيات المعلومات في زيادة إنتاجية الأعمال من خلال تحسين الاتصال وتدفق المعلومات، مما
                    يساعد في اتخاذ القرارات بشكل أسرع وأكثر دقة.</p>

                <h3 dir="rtl">التحديات والمستقبل</h3>

                <p dir="rtl">مع التطور السريع في تقنية المعلومات، تظهر تحديات جديدة مثل قضايا الخصوصية وأمن
                    البيانات، بالإضافة إلى ضرورة التعامل مع الكم الهائل من البيانات المنتجة يوميًا. المستقبل
                    يتجه نحو اعتماد تقنيات الذكاء الاصطناعي (AI) وإنترنت الأشياء (IoT)، مما سيزيد من تعقيد
                    المشهد التكنولوجي ويعزز من دور تقنية المعلومات في حياتنا اليومية.</p>

                <p dir="rtl">في النهاية، تقنية المعلومات ليست مجرد مجال تقني، بل هي عنصر أساسي في تطور المجتمعات
                    الحديثة، حيث تساهم في تحسين جودة الحياة وتوفير حلول مبتكرة <a
                        href="https://coolors.co/0470dc-0353a4-c3dffe-002855-001845-00143d-33415c-5c677d-7d8597-d2d4da"
                        target="_blank">للمشاكل التقليدية.</a></p>

            </div>
        </div>

        <div class="pages">
            <button data-lang="next">Next</button>
            <span>1/10</span>
            <button data-lang="back">back</button>
        </div>
    </div>
</div>
<section class="portfolio" id="portfolio">
    <h1 class="top-title" style="margin-bottom: 40px;">مدونات مشابهه</h1>
    <div class="awards-box">
        <div class="card">
            <a href="#" class="award-link">
                <div>
                    <div class="card-image">
                        <img src="static/assets/card1.webp" alt="">
                        <div class="types">
                            <span class="project-type">• تمويل جزئي</span>
                            <span class="project-type">• الصين</span>
                            <span class="project-type">• ماجستير</span>
                        </div>
                    </div>
                    </p>
                    <div class="head-info">
                        <span>176 مشاهدة</span>
                        <span>27 Jul, 2024</span>
                    </div>
                    <p class="card-title">منح حكومة الصين</p>
                    <p class="card-body">
                        منح حكومة الصين هي فرص دراسية تُقدمها الحكومة الصينية للطلاب الدوليين من مختلف
                        أنحاء
                        العالم،
                        بهدف تعزيز التبادل الثقافي والمعرفي بين الصين والدول الأخرى.
                    </p>
                    <p class="footer">أخر <span class="by-name">موعد لتسجيل</span> : <span class="date">25/05/23</span>
                    </p>
                </div>
            </a>
        </div>
        <div class="card">
            <a href="#" class="award-link">
                <div>
                    <div class="card-image">
                        <img src="static/assets/card1.webp" alt="">
                        <div class="types">
                            <span class="project-type">• تمويل جزئي</span>
                            <span class="project-type">• الصين</span>
                            <span class="project-type">• ماجستير</span>
                        </div>
                    </div>
                    </p>
                    <div class="head-info">
                        <span>176 مشاهدة</span>
                        <span>27 Jul, 2024</span>
                    </div>
                    <p class="card-title">منح حكومة الصين</p>
                    <p class="card-body">
                        منح حكومة الصين هي فرص دراسية تُقدمها الحكومة الصينية للطلاب الدوليين من مختلف
                        أنحاء
                        العالم،
                        بهدف تعزيز التبادل الثقافي والمعرفي بين الصين والدول الأخرى.
                    </p>
                    <p class="footer">أخر <span class="by-name">موعد لتسجيل</span> : <span class="date">25/05/23</span>
                    </p>
                </div>
            </a>
        </div>
        <div class="card">
            <a href="#" class="award-link">
                <div>
                    <div class="card-image">
                        <img src="static/assets/card1.webp" alt="">
                        <div class="types">
                            <span class="project-type">• تمويل جزئي</span>
                            <span class="project-type">• الصين</span>
                            <span class="project-type">• ماجستير</span>
                        </div>
                    </div>
                    </p>
                    <div class="head-info">
                        <span>176 مشاهدة</span>
                        <span>27 Jul, 2024</span>
                    </div>
                    <p class="card-title">منح حكومة الصين</p>
                    <p class="card-body">
                        منح حكومة الصين هي فرص دراسية تُقدمها الحكومة الصينية للطلاب الدوليين من مختلف
                        أنحاء
                        العالم،
                        بهدف تعزيز التبادل الثقافي والمعرفي بين الصين والدول الأخرى.
                    </p>
                    <p class="footer">أخر <span class="by-name">موعد لتسجيل</span> : <span class="date">25/05/23</span>
                    </p>
                </div>
            </a>
        </div>
        <div class="card">
            <a href="#" class="award-link">
                <div>
                    <div class="card-image">
                        <img src="static/assets/card1.webp" alt="">
                        <div class="types">
                            <span class="project-type">• تمويل جزئي</span>
                            <span class="project-type">• الصين</span>
                            <span class="project-type">• ماجستير</span>
                        </div>
                    </div>
                    </p>
                    <div class="head-info">
                        <span>176 مشاهدة</span>
                        <span>27 Jul, 2024</span>
                    </div>
                    <p class="card-title">منح حكومة الصين</p>
                    <p class="card-body">
                        منح حكومة الصين هي فرص دراسية تُقدمها الحكومة الصينية للطلاب الدوليين من مختلف
                        أنحاء
                        العالم،
                        بهدف تعزيز التبادل الثقافي والمعرفي بين الصين والدول الأخرى.
                    </p>
                    <p class="footer">أخر <span class="by-name">موعد لتسجيل</span> : <span class="date">25/05/23</span>
                    </p>
                </div>
            </a>
        </div>
    </div>
</section>

<section class="comment-module">
    <h1 class="top-title" style="margin-bottom: 40px;">التعليفات</h1>
    <div class="comment-section">
        <div class="comments-wrp"></div> <!-- comments wrapper -->
        <div class="reply-input container-comment">
            <img src="static/assets/images/avatars/image-juliusomo.webp" alt="" class="usr-img" />
            <textarea class="cmnt-input" placeholder="Add a comment..."></textarea>
            <button class="bu-primary">SEND</button>
        </div> <!-- reply input -->
    </div>
</section>
@endsection


@section("script")
<script src="{{ asset('customer/js/countries.js') }}"></script>
<script src="{{ asset('customer/js/filter.js') }}"></script>
<script src="{{ asset('customer/js/country.js') }}"></script>
<script src="{{ asset('customer/js/app.js') }}"></script>
@endsection
