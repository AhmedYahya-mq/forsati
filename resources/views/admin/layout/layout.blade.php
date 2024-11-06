<html lang="en" dir="rtl">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="au theme template">
    <meta name="author" content="Hau Nguyen">
    <meta name="keywords" content="au theme template">
    <meta name="token" content="{{ session("token") }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Fontfaces CSS-->
    <link href="{{ asset('admin/css/font-face.css') }}" rel="stylesheet" media="all">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="{{ asset('vendor/mdi-font/css/material-design-iconic-font.min.css') }}"
        rel="stylesheet" media="all">

    <!-- Bootstrap CSS-->
    <link href="{{ asset('vendor/bootstrap-4.1/bootstrap.min.css') }}" rel="stylesheet"
        media="all">

    <!-- Vendor CSS-->
    <link href="{{ asset('vendor/animsition/animsition.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css') }}"
        rel="stylesheet" media="all">
    <link href="{{ asset("vendor/wow/animate.css") }}" rel="stylesheet" media="all">
    <link href="{{ asset("vendor/css-hamburgers/hamburgers.min.css") }}" rel="stylesheet"
        media="all">
    <link href="{{ asset('vendor/slick/slick.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('vendor/select2/select2.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('vendor/perfect-scrollbar/perfect-scrollbar.css') }}" rel="stylesheet"
        media="all">
    <link href="{{ asset('vendor/vector-map/jqvmap.min.css') }}" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="{{ asset('admin/css/setting.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('admin/css/loader.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('admin/css/style.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('admin/css/sections.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('vendor/message-box.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('customer/css/loader.css') }}" rel="stylesheet" media="all">
    <style>
        a.relative.inline-flex.items-center
       {
            color: #0098ff;
            text-decoration: none;
        }

        span.relative.inline-flex.items-center {
            color: rgb(167 167 167);
        }
        .side-top{
            left: 0;
        }
        .box-loader{
            position: fixed !important;
            background-color: #fff;
        }
    </style>
    @yield('header')

</head>

<body class="animsition text-right" style="animation-duration: 900ms; opacity: 1;">
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
    @yield("form")
    <div class="page-wrapper">
        <!-- MENU SIDEBAR-->
        <aside class="menu-sidebar2">
            <div class="logo">
                <a href="#">
                    <img src="{{ asset('admin/images/icon/logo.png') }}" loading="lazy" alt="فرصتي" title="فرصتي">
                </a>
            </div>
            <div class="menu-sidebar2__content js-scrollbar1 ps ps--active-y">
                <div class="account2">
                    <div class="image img-cir img-120">
                        <img src="{{ asset('storage/' . $user->image) }}" style="width: 100%; height: 100%;"
                                alt="{{ $user->name }}" title="{{ $user->name }}" loading="lazy">
                    </div>
                    <h4 class="name">{{ old('name', $user->name) }}</h4>
                    <x-dropdown-link :href="route('profile.edit')">
                        {{ __('الملف السخصي') }}
                    </x-dropdown-link>
                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-dropdown-link :href="route('logout')" onclick="event.preventDefault();
                                                this.closest('form').submit();">
                            {{ __('تسجيل الخروج') }}
                        </x-dropdown-link>
                    </form>
                </div>
                <nav class="navbar-sidebar2">
                    <ul class="list-unstyled navbar__list">
                        @if ($permission_types->contains("id","manage_all"))
                            <li class="@yield("dashboard")">
                                <a class="" href="{{ route('dashboard') }}">
                                    <i class="fas fa-tachometer-alt"></i>لوحة التحكم
                                </a>
                            </li>
                        @endif
                        @if ($permission_types->contains("id","manage_users") || $permission_types->contains("id","manage_all"))
                            <li class="@yield("user")">
                                <a href="{{ route('admin.usersManager.index') }}">
                                    <i class="fas fa-users"></i>أدارة المستخدمين
                                </a>
                            </li>
                        @endif
                        @if ($permission_types->contains("id","manage_content") || $permission_types->contains("id","manage_all"))
                            <li class="@yield("cuntent")">
                                <a href="{{ route('admin.contentmanager') }}">
                                    <i class="fas fa-tasks"></i>أدارة المحتوى
                                </a>
                            </li>
                        @endif
                        @if ($permission_types->contains("id","manage_blogs") || $permission_types->contains("id","manage_all"))
                            <li class="@yield("blogs")">
                                <a href="{{ route('admin.blogsManager') }}">
                                    <i class="fas fa-newspaper"></i>أدارة المدونات
                                </a>
                            </li>
                        @endif
                        @if ($permission_types->contains("id","manage_scholarships") || $permission_types->contains("id","manage_all"))
                            <li class="@yield("award")">
                                <a href="{{ route('admin.awardsManager') }}">
                                    <i class="zmdi zmdi-graduation-cap"></i>أدارة المنح
                                </a>
                            </li>
                        @endif
                        @if ($permission_types->contains("id","manage_specializations") || $permission_types->contains("id","manage_all"))
                            <li class="@yield("specialzation")">
                                <a href="{{ route('admin.specializationManager') }}">
                                    <i class="fas fa-clipboard-list"></i>أدارة التخصصات
                                </a>
                            </li>
                        @endif
                    </ul>
                </nav>
            </div>
        </aside>
        <!-- END MENU SIDEBAR-->

        <!-- PAGE CONTAINER-->
        <div class="page-container2">
            <!-- HEADER DESKTOP-->
            <header class="header-desktop2">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="header-wrap2">
                            <div class="logo d-block d-lg-none">
                                <a href="#">
                                    <img src="{{ asset('admin/images/icon/logo.png') }}"
                                        alt="فرصتي" title="فرصتي" loading="lazy">
                                </a>
                            </div>
                            <div class="header-button2">

                                <div class="header-button-item has-noti js-item-menu">


                                </div>
                                <div class="header-button-item mr-0 js-sidebar-btn">
                                    <i class="zmdi zmdi-menu"></i>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <aside class="menu-sidebar2 js-right-sidebar d-block d-lg-none">
                <div class="logo">
                    <a href="#">
                        <img src="{{ asset('admin/images/icon/logo.png') }}" loading="lazy" alt="فرصتي">
                    </a>
                </div>
                <div class="menu-sidebar2__content js-scrollbar2 ps">
                    <div class="account2">
                        <div class="image img-cir img-120">
                            <img src="{{ asset('storage/' . $user->image) }}" style="width: 100%; height: 100%;"
                                alt="{{ $user->name }}" title="{{ $user->name }}" loading="lazy">
                        </div>
                        <h4 class="name">{{ old('name', $user->name) }}</h4>
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('الملف السخصي') }}
                        </x-dropdown-link>
                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('تسجيل الخروج') }}
                            </x-dropdown-link>
                        </form>
                    </div>
                    <nav class="navbar-sidebar2">
                        <ul class="list-unstyled navbar__list">
                            @if ($permission_types->contains("id","manage_all"))
                                <li class="@yield("dashboard")">
                                    <a class="" href="{{ route('dashboard') }}">
                                        <i class="fas fa-tachometer-alt"></i>لوحة التحكم
                                    </a>
                                </li>
                            @endif
                            @if ($permission_types->contains("id","manage_users") || $permission_types->contains("id","manage_all"))
                                <li class="@yield("user")">
                                    <a href="{{ route('admin.usersManager.index') }}">
                                        <i class="fas fa-users"></i>أدارة المستخدمين
                                    </a>
                                </li>
                            @endif
                            @if ($permission_types->contains("id","manage_content") || $permission_types->contains("id","manage_all"))
                                <li class="@yield("cuntent")">
                                    <a href="{{ route('admin.contentmanager') }}">
                                        <i class="fas fa-tasks"></i>أدارة المحتوى
                                    </a>
                                </li>
                            @endif
                            @if ($permission_types->contains("id","manage_blogs") || $permission_types->contains("id","manage_all"))
                                <li class="@yield("blogs")">
                                    <a href="{{ route('admin.blogsManager') }}">
                                        <i class="fas fa-newspaper"></i>أدارة المدونات
                                    </a>
                                </li>
                            @endif
                            @if ($permission_types->contains("id","manage_scholarships") || $permission_types->contains("id","manage_all"))
                                <li class="@yield("award")">
                                    <a href="{{ route('admin.awardsManager') }}">
                                        <i class="zmdi zmdi-graduation-cap"></i>أدارة المنح
                                    </a>
                                </li>
                            @endif
                            @if ($permission_types->contains("id","manage_specializations") || $permission_types->contains("id","manage_all"))
                                <li class="@yield("specialzation")">
                                    <a href="{{ route('admin.specializationManager') }}">
                                        <i class="fas fa-clipboard-list"></i>أدارة التخصصات
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </nav>
                </div>
            </aside>
            <div class="popup-container">
            </div>
            @yield("content")
        </div>

    </div>

    <!-- Jquery JS-->
    <script src="{{ asset('vendor/jquery-3.2.1.min.js') }}"></script>
    <!-- Bootstrap JS-->
    <script src="{{ asset('vendor/bootstrap-4.1/popper.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap-4.1/bootstrap.min.js') }}"></script>
    <!-- Vendor JS       -->
    <script src="{{ asset('vendor/slick/slick.min.js') }}"></script>
    <script src="{{ asset('vendor/wow/wow.min.js') }}"></script>
    <script src="{{ asset('vendor/animsition/animsition.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap-progressbar/bootstrap-progressbar.min.js') }}">
    </script>
    <script src="{{ asset('vendor/counter-up/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('vendor/counter-up/jquery.counterup.min.js') }}"></script>
    <script src="{{ asset('vendor/circle-progress/circle-progress.min.js') }}"></script>
    <script src="{{ asset('vendor/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('vendor/chartjs/Chart.bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/select2/select2.min.js') }}"></script>
    <script src="{{ asset('vendor/vector-map/jquery.vmap.js') }}"></script>
    <script src="{{ asset('vendor/vector-map/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('vendor/vector-map/jquery.vmap.sampledata.js') }}"></script>
    <script src="{{ asset('vendor/vector-map/jquery.vmap.world.js') }}"></script>

    <!-- Main JS-->
    <script>
        function convertUrlToApiUrl(baseUrl=null) {
            let url = baseUrl || window.location.href;
            if (!url) return;
            if (url.indexOf('/api') === -1) {
                url = url.replace(/^(http|https):\/\/([^\s/]+)\//, '$1://$2/api/');
            }
            return url;
        }
        let urlForm = convertUrlToApiUrl().split('?')[0].replace(/\/$/, '');
    </script>
    <script src="{{ asset('vendor/message-box.js') }}"></script>
    <script src="{{ asset('admin/js/main.js') }}"></script>
    <script src="{{ asset('admin/js/functions.js') }}"></script>
    <script src="{{ asset('admin/js/form.js') }}"></script>
    @yield('scripts')
    <script>
        $(function () {
            $(".box-loader").remove();
        });
    </script>
</body>

</html>
