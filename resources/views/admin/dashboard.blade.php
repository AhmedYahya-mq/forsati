@extends("admin.layout.layout")

@section('header')
<link href="{{ asset('admin/css/dashboard/dashboard.css') }}" rel="stylesheet" media="all">

<!-- Title Page-->
<title>لوحة التحكم</title>
@endsection

@section("content")

<section class="statistic">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 col-lg-3">
                    <div class="statistic__item">
                        <h2 class="number">{{ $countMembers }}</h2>
                        <span class="desc">عدد العضاء</span>
                        <div class="icon">
                            <i class="zmdi zmdi-account-o"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="statistic__item">
                        <h2 class="number">{{ $countScholarships }}</h2>
                        <span class="desc">عدد المنح</span>
                        <div class="icon">
                            <i class="zmdi zmdi-graduation-cap"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="statistic__item">
                        <h2 class="number">{{ $counteAcsptants }}</h2>
                        <span class="desc">عدد المقبولين</span>
                        <div class="icon">
                            <i class="fas fa-handshake"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="statistic__item">
                        <h2 class="number">{{ $countBlogs }}</h2>
                        <span class="desc">عدد المدونات</span>
                        <div class="icon">
                            <i class="fas fa-newspaper"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 col-xl-8">
                    <div class="au-card m-b-30">
                        <div class="au-card-inner">
                            <div class="chartjs-size-monitor"
                                style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;">
                                <div class="chartjs-size-monitor-expand"
                                    style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                                    <div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0">
                                    </div>
                                </div>
                                <div class="chartjs-size-monitor-shrink"
                                    style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                                    <div style="position:absolute;width:200%;height:200%;left:0; top:0">
                                    </div>
                                </div>
                            </div>
                            <h3 class="title-2 m-b-40">أحصائيات</h3>
                            <canvas id="barChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-xl-4">
                    <!-- TOP CAMPAIGN-->
                    <div class="top-campaign ">
                        <h3 class="title-3 m-b-30">أفضل المنح زيارة</h3>
                        <div class="table-responsive">
                            <table class="table table-top-campaign">
                                <tbody>
                                    @foreach($topScholarships as $topScholarship)
                                        <tr>
                                            <td>{{ $loop->iteration }}. {{ $topScholarship->title_ar }}</td>
                                            <td>{{ $topScholarship->visit ?? 0 }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- END TOP CAMPAIGN-->
                </div>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">

                <div class="col-md-12">
                    <!-- MAP DATA-->
                    <div class="map-data m-b-40">
                        <h3 class="title-3 m-b-30">
                            <i class="zmdi zmdi-map"></i>عدد الزيارات لكل دولة
                        </h3>
                        <div class="map-wrap m-t-45 m-b-20 js-map">
                            <div id="vmap" style="height: 284px;"></div>
                        </div>
                        <div class="table-wrap js-map" style="display: none;">
                            <div class="table-responsive table-style1">
                                <table class="table">
                                    <thead>
                                        <th>الدوله</th>
                                        <th>عدد الزيارات</th>
                                    </thead>
                                    <tbody id="tbody-table">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div id="js-loader-visit">
                            <div class="container-loader" id="container-loader" style="position: relative;background-color: #fff">
                                <div id="wifi-loader">
                                    <svg class="circle-outer" viewBox="0 0 86 86">
                                        <circle class="back" cx="43" cy="43" r="40"></circle>
                                        <circle class="front" cx="43" cy="43" r="40"></circle>
                                        <circle class="new" cx="43" cy="43" r="40"></circle>
                                    </svg>
                                    <svg class="circle-middle" viewBox="0 0 60 60">
                                        <circle class="back" cx="30" cy="30" r="27"></circle>
                                        <circle class="front" cx="30" cy="30" r="27"></circle>
                                    </svg>
                                    <svg class="circle-inner" viewBox="0 0 34 34">
                                        <circle class="back" cx="17" cy="17" r="14"></circle>
                                        <circle class="front" cx="17" cy="17" r="14"></circle>
                                    </svg>
                                    <div class="text" dir="rtl" data-text="جاري التحميل..."></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END MAP DATA-->
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script src="{{ asset('admin/js/dashboard/dashboard.js') }}"></script>
@endsection
@section("dashboard","active")
