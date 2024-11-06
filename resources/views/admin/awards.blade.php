@extends("admin.layout.layout")

@section('header')
<link href="{{ asset('admin/css/form.css') }}" rel="stylesheet" media="all">
<link href="{{ asset('admin/css/awards/awards.css') }}" rel="stylesheet" media="all">
<link href="{{ asset('admin/css/filter.css') }}" rel="stylesheet" media="all">
<link href="{{ asset('admin/css/loader-card.css') }}" rel="stylesheet" media="all">

<!-- select2 Styles -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
<link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
<!-- Or for RTL support select2 -->
<link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.rtl.min.css" />

<!-- Scripts jquery + select2 -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.0/dist/jquery.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js"></script>


<!-- تضمين CKEditor -->
<script src="{{ asset('vendor/ckeditor/ckeditor.js') }}"></script>

<!-- FilePond CSS -->
<link href="{{ asset('vendor/filepond/filepond.css') }}" rel="stylesheet">
<!-- FilePond Image Preview Plugin CSS -->
<link href="{{ asset('vendor/filepond/filepond-plugin-image-preview.min.css') }}"
    rel="stylesheet">

<!-- FilePond JavaScript -->
<script src="{{ asset('vendor/filepond/filepond.js') }}"></script>
<!-- FilePond Image Preview Plugin -->
<script src="{{ asset('vendor/filepond/filepond-plugin-image-preview.min.js') }}"></script>
<!-- FilePond Image Exif Orientation Plugin -->
<script src="{{ asset('vendor/filepond/filepond-plugin-image-exif-orientation.min.js') }}">
</script>
<!-- FilePond File Validate Size Plugin -->
<script src="{{ asset('vendor/filepond/filepond-plugin-file-validate-size.min.js') }}"></script>
<!-- FilePond Image Edit Plugin -->
<script src="{{ asset('vendor/filepond/filepond-plugin-image-edit.min.js') }}"></script>
<!-- FilePond Image Resize Plugin -->
<script src="{{ asset('vendor/filepond/filepond-plugin-image-resize.min.js') }}"></script>
<!-- Title Page-->
<title>أدارة المنح</title>
<style>
    .select2-container {
        width: 100% !important;
    }

</style>
@endsection

@php
    $funding_types=[
    "full"=>"تمويل كامل",
    "partial"=>"تمويل جزئي",
    "private"=>"نفقة خاصه"
    ];
@endphp
@section("form")
<div class="container-form">
    <div class="container">
        <div class="row justify-content-between">
            <!-- عنوان النموذج وزر الإغلاق -->
            <div class="mb-3">
                <h2>إضافة منحة</h2>
            </div>
            <div class="mb-3" id="close-form" title="إغلاق">
                <span class="btn"><i class="fas fa-times"></i></span>
            </div>
        </div>

        <!-- نموذج الإدخال -->
        <form id="form">
            <div class="row">
                <!-- حقل إدخال عنوان المنحة -->
                <div class="col-12 mb-3 text-right">
                    <label for="title" class="form-label">عنوان المنحة:</label>
                    <input type="text" class="form-control" id="title" name="title_ar" placeholder="أدخل عنوان المنحة">
                </div>
                <!-- حقل إدخال عنوان المنحة -->
                <div class="col-12 mb-3 text-right">
                    <label for="title" class="form-label">عنوان المنحة بألانجليزي:</label>
                    <input type="text" class="form-control" id="title" name="title_en" placeholder="أدخل عنوان المنحة">
                </div>

                <!-- منطقة النص لوصف المنحة -->
                <div class="col-12 mb-3 text-right">
                    <label for="description" class="form-label">وصف المنحة:</label>
                    <textarea class="form-control" id="description" rows="3" name="description_ar"
                        placeholder="أدخل وصف المنحة"></textarea>
                </div>

                <div class="col-12 mb-3 text-right">
                    <label for="description" class="form-label">وصف المنحة بألانجليزي:</label>
                    <textarea class="form-control" id="description" rows="3" name="description_en"
                        placeholder="أدخل وصف المنحة"></textarea>
                </div>

                <!-- قائمة منسدلة لاختيار الدولة -->
                <div class="col-12 mb-3 text-right">
                    <label for="country-select" class="form-label">اختر الدولة:</label>
                    <select id="country-select" name="countery" class="form-control" style="width: 100%;">
                    <option value="" selected disabled></option>
                        @foreach($countries as $country)
                            <option value="{{ $country->_id }}" data-flag="{{ $country->flag }}">
                                {{ $country->name_ar }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- قائمة منسدلة متعددة لاختيار التخصصات -->
                <div class="col-12 mb-3 text-right">
                    <label for="specialization-select" class="form-label">اختر التخصص:</label>
                    <select id="specialization-select" name="specializations[]" class="form-control" multiple="multiple"
                        style="width: 100%;">

                        @foreach($specializations as $specialization)
                            <option value="{{ $specialization->id }}">
                                {{ $specialization->name_ar }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- خيارات التمويل -->
                <div class="col-12 mb-3 text-right">
                    <label class="form-label">نوع التمويل:</label>
                    <div class="row">
                        <div class="form-check col-md-2 mb-3">
                            <input class="btn-check" id="full-funding" autocomplete="off" type="radio" name="funding_type"
                                value="full">
                            <label class="btn btn-outline-primary" for="full-funding">ممولة كاملة</label>
                        </div>
                        <div class="form-check col-md-2 mb-3">
                            <input class="btn-check" id="partial-funding" autocomplete="off" type="radio" name="funding_type"
                                value="partial">
                            <label class="btn btn-outline-primary" for="partial-funding">ممولة جزئيًا</label>
                        </div>
                        <div class="form-check col-md-2 mb-3">
                            <input class="btn-check" id="self-funding" autocomplete="off" type="radio" name="funding_type"
                                value="private">
                            <label class="btn btn-outline-primary" for="self-funding">نفقة خاصة</label>
                        </div>
                    </div>
                </div>

                <!-- خيارات درجة الدراسة -->
                <div class="col-12 mb-3 text-right">
                    <label class="form-label">درجة الدراسة:</label>
                    <div class="row">
                        @foreach($degree_levels as $degree_level )
                            <div class="form-check col-md-2 mb-3">
                                <input class="btn-check" autocomplete="off" type="checkbox" name="degree_levels[]"
                                    id="{{ $degree_level->name_en }}" value="{{ $degree_level->id }}">
                                <label class="btn btn-outline-primary"
                                    for="{{ $degree_level->name_en }}">{{ $degree_level->name_ar }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>


                <div class="col-12 mb-3 text-right">
                    <label for="content_ar" class="form-label">محتوى المنحة:</label>
                    <textarea class="form-control" name="content_ar" id="content_ar" rows="5"></textarea>
                </div>
                <div class="col-12 mb-3 text-right">
                    <label for="content_en" class="form-label">محتوى المنحة بألانجليزي:</label>
                    <textarea class="form-control" name="content_en" id="content_en" rows="5"></textarea>
                </div>

                <div class="col-12 mb-3 text-right">
                    <label for="deadline" class="form-label">اخر موعد تسجيل:</label>
                    <input type="date" class="form-control" id="deadline" name="deadline">
                </div>
            </div>
            <!-- حقل رفع الصور -->
            <div class="text-right">
                <label class="form-label">صورة المنحة:</label>
                <input type="file" class="filepond" name="image" data-allow-reorder="true" data-max-file-size="3MB"
                    data-max-files="3">
            </div>
            <!-- زر الإرسال -->
            <button type="submit" class="btn btn-primary">حفظ</button>
        </form>
    </div>
</div>
@endsection


@section("content")
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="row">
            <div class="container-fluid">
                <main class="m-3">
                    <div class="box-search text-right row wrap justify-content-center align-item-center p-3">
                        <button class="icon-btn add-btn add-btn-js">
                            <div class="add-icon"></div>
                            <div class="btn-txt" title="اضافة منحه">أضافة منحه</div>
                        </button>
                        <div class="search col-md-10">
                            <div class="filter_button">
                                <div class="filter_icon" title="تصفية البحث">
                                    <i class="fa fa-sliders-h"></i>
                                </div>
                            </div>
                            <div class="box_show_filter">
                                <div class="filtters-box">
                                    <div class="container-filter" id="selected-filter">
                                        <h4 style="padding: 20px 0;" id="get-selected-nav">الدولة</h4>
                                        <select id="country-select-filter"  placeholder="أختر التخصصات" multiple=""
                                            style="width: 100%;">
                                            @foreach($countries as $country)
                                                <option name="country"
                                                    {{ in_array($country->_id, $filters['countryIds'])?"selected":"" }}
                                                    value="{{ $country->_id }}" data-flag="{{ $country->flag }}">
                                                    {{ $country->name_ar }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="container-filter" id="selected-filter">
                                        <h4 style="padding: 20px 0;" id="get-selected-nav">التخصص</h4>
                                        <select id="specialization-select-filter"  placeholder="أختر التخصصات"
                                            multiple="" style="width: 100%;">
                                            @foreach($specializations as $specialization)
                                                <option name="specialization"
                                                    {{ in_array( $specialization->id, $filters['specializationIds'])?"selected":"" }}
                                                    value="{{ $specialization->id }}">
                                                    {{ $specialization->name_ar }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="container-filter">
                                        <h4 style="padding: 20px 0 6px;" id="get-selected">التمويل</h4>
                                        <ul class="list">
                                            <li>
                                                <div class="list-item {{ in_array("full", $filters['fundingTypes'])?"selected":"" }}"
                                                    data-finance="full">ممولة بالكامل</div>
                                            </li>
                                            <li>
                                                <div class="list-item {{ in_array("partial", $filters['fundingTypes'])?"selected":"" }}"
                                                    data-finance="partial">ممولة جزئي</div>
                                            </li>
                                            <li>
                                                <div class="list-item {{ in_array("private", $filters['fundingTypes'])?"selected":"" }}"
                                                    data-finance="private">نفقه خاصه</div>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="container-filter">
                                        <h4 style="padding: 20px 0 6px;" id="get-selected">درجة التعليميه
                                        </h4>
                                        <ul class="list">
                                            @foreach($degree_levels as $degree_level)
                                                <li>
                                                    <div class="list-item {{ in_array($degree_level->id, $filters['degreeLevelIds'])?"selected":"" }}"
                                                        data-educational="{{ $degree_level->id }}">
                                                        {{ $degree_level->name_ar }}</div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
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
                            <input type="text" title="بحث" id="search" value="{{ $search }}" class="search__input"
                                placeholder="بحث...">
                        </div>
                    </div>
                    <div class="boxing">
                        <div class="side-right-blog portfolio" id="portfolio">
                            <div class="tags-box">
                                <h4 style="
                                        min-width: 46px;
                                        ">وسوم : </h4>
                                <div class="tags-items">
                                </div>
                            </div>
                            <div class="awards-box" id="scholarships-container">

                                @forelse($scholarships as $scholarship)
                                    <div class="card text-right" id="user-{{ $scholarship->id }}">
                                        <div>
                                            <div class="card-image row justify-content-center">
                                                <div class="controller-awards row justify-content-between p-3 w-100"
                                                    style="position: absolute;z-index: 100;">
                                                    <div class="col-md-0 item rounded-circle"
                                                        data-id="{{ $scholarship->id }}" data-toggle="tooltip" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </div>
                                                    <div class="col-md-0 item rounded-circle" data-toggle="tooltip"
                                                        data-id="{{ $scholarship->id }}" title="حذف">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </div>
                                                </div>
                                                <img src="{{ asset('storage/'.$scholarship->image) }}"
                                                    alt="{{ $scholarship->title_ar }}" title="{{ $scholarship->title_ar }}" loading="lazy">
                                                <div class="types">
                                                    @foreach($scholarship->specializations as $specialization)
                                                        <span class="project-type">•
                                                            {{ $specialization->name_ar }}</span>
                                                    @endforeach
                                                    @foreach($scholarship->degree_levels as $degree_level)
                                                        <span class="project-type">•
                                                            {{ $degree_level->name_ar }}</span>
                                                    @endforeach
                                                    <span class="project-type">•
                                                        {{ $scholarship->country->name_ar }}</span>
                                                    <span class="project-type">•
                                                        {{ $funding_types[$scholarship->funding_type] }}</span>
                                                </div>
                                            </div>

                                            <a href="#" class="award-link">
                                                <div class="head-info">
                                                <span>مشاهدة: {{ $scholarship->formatVisits() ?: "0" }}</span>
                                                    <span>تاريخ النشر:
                                                        {{ $scholarship->created_at->format('Y-d-M') }}</span>
                                                </div>
                                                <p class="card-title">{{ $scholarship->title_ar }}</p>
                                                <p class="card-body">
                                                    {{ $scholarship->description_ar }}
                                                </p>
                                                <p class="footer">أخر <span class="by-name">موعد لتسجيل</span> :
                                                    <span class="date">{{ $scholarship->deadline }}</span>
                                                </p>
                                            </a>
                                        </div>
                                    </div>
                                @empty
                                    <tr id='notfound'>
                                        <td colspan="7">
                                            <h2 class="text-center">لا يوجد منح </h2>
                                        </td>
                                    </tr>
                                @endforelse
                            </div>

                            <div class="pages">
                                <div id="js-pagition">
                                    {{ $scholarships->onEachSide(-1)->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>
</div>
@endsection


@section("scripts")

<!-- <script src="{{ asset('admin/js/countries.js') }}"></script> -->
<script src="{{ asset('admin/js/country.js') }}"></script>
<script src="{{ asset('admin/js/filter.js') }}"></script>
<script src="{{ asset('admin/js/awards/awards.js') }}"></script>
@endsection
@section("award","active")
