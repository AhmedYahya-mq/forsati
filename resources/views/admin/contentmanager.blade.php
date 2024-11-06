@extends("admin.layout.layout")

@section('header')
<link href="{{ asset('admin/css/form.css') }}" rel="stylesheet" media="all">
<link href="{{ asset('admin/css/contentManager/contentManager.css') }}" rel="stylesheet"
    media="all">

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
<!-- Flatpickr CSS من CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<!-- Title Page-->
<title>أدارة المحتوى</title>
@endsection


@section("form")
<div class="container-form">
    <div class="container">
        <div class="row justify-content-between">
            <!-- عنوان النموذج وزر الإغلاق -->
            <div class="mb-3">
                <h2>إضافة أعلان</h2>
            </div>
            <div class="mb-3" id="close-form" title="إغلاق">
                <span class="btn"><i class="fas fa-times"></i></span>
            </div>
        </div>

        <!-- نموذج الإدخال -->
        <form id="form">
            <div class="row">
                <div class="col-12 mb-3 text-right">
                    <label for="title" class="form-label"> عنوان أعلان:</label>
                    <input type="text" name="title" class="form-control" id="title"
                        placeholder="أدخل أعنوان الأعلان...">
                </div>

                <div class="col-12 mb-3 text-right">
                    <label for="title" class="form-label"> رأبط الأعلان:</label>
                    <input type="url" name="url" class="form-control" id="title"
                        placeholder="أدخل رابط الذي يوجه الى الأعلان...">
                </div>
            </div>
            <div class="form-group col-12 mb-3 text-right">
                <label for="">حدد الفترة الومنية</label>
                <div class="form-row align-items-end">
                    <div class="form-group col-md-5">
                        <label for="startDate">من:</label>
                        <input type="date" class="form-control" id="startDate" name="start_date"
                            placeholder="تاريخ البدء">
                    </div>
                    <div class="form-group col-md-5">
                        <label for="endDate">إلى:</label>
                        <input type="date" class="form-control" id="endDate" name="end_date"
                            placeholder="تاريخ الانتهاء">
                    </div>
                </div>
            </div>
            <!-- حقل رفع الصور -->
            <div class="col-12 mb-3 text-right">
                <label class="form-label">صورة الأعلان في الهاتف:</label>
                <input type="file" class="filepond" name="mobile_image" data-allow-reorder="true"
                    data-max-file-size="3MB" data-max-files="3">
            </div>

            <div class="col-12 mb-3 text-right">
                <label class="form-label">صورة الأعلان في الحاسوب:</label>
                <input type="file" class="filepond" name="desktop_image" data-allow-reorder="true"
                    data-max-file-size="3MB" data-max-files="3">
            </div>
            <!-- زر الإرسال -->
            <button type="submit" class="btn btn-primary">حفظ</button>
        </form>
    </div>
</div>
@endsection


@section("content")
<section>
    <div class="main-content">
        <div class="section__content section__content--p30 mt-5 pt-5">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <!-- DATA TABLE -->
                        <h3 class="title-5 m-b-35">بيانات الأعلانات</h3>
                        <div class="row justify-content-between px-3 align-items-center mb-2">
                            <div class="col-md-0 mt-3">
                                <div class="search-container">
                                    <div class="input-container">
                                        <input type="text" name="search" class="input search" value="{{ $search }}"
                                            id="search" placeholder="البحث عن أعلان...">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="" viewBox="0 0 24 24"
                                            class="icon">
                                            <g stroke-width="0" id="SVGRepo_bgCarrier"></g>
                                            <g stroke-linejoin="round" stroke-linecap="round"
                                                id="SVGRepo_tracerCarrier"></g>
                                            <g id="SVGRepo_iconCarrier">
                                                <rect fill="white" height="24" width="24"></rect>
                                                <path fill=""
                                                    d="M2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12ZM9 11.5C9 10.1193 10.1193 9 11.5 9C12.8807 9 14 10.1193 14 11.5C14 12.8807 12.8807 14 11.5 14C10.1193 14 9 12.8807 9 11.5ZM11.5 7C9.01472 7 7 9.01472 7 11.5C7 13.9853 9.01472 16 11.5 16C12.3805 16 13.202 15.7471 13.8957 15.31L15.2929 16.7071C15.6834 17.0976 16.3166 17.0976 16.7071 16.7071C17.0976 16.3166 17.0976 15.6834 16.7071 15.2929L15.31 13.8957C15.7471 13.202 16 12.3805 16 11.5C16 9.01472 13.9853 7 11.5 7Z"
                                                    clip-rule="evenodd" fill-rule="evenodd"></path>
                                            </g>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-0 mt-3">
                                <button class="icon-btn add-btn add-btn-js">
                                    <div class="add-icon"></div>
                                    <div class="btn-txt" title="اضافة أعلان">أضافة أعلان</div>
                                </button>
                            </div>
                        </div>
                        <!-- USER DATA-->
                        <div class="user-data m-b-30">
                            <h3 class="title-3 m-b-30">
                                <i class="zmdi zmdi-account-calendar"></i>بيانات الأعلانات
                            </h3>
                            <div class="filters m-b-45">
                                <div class="rs-select2--dark rs-select2--md m-r-10 rs-select2--border">
                                    <select class="js-select2" name="stateAd">
                                        <option
                                            {{ $stateAd == "__ALL__"?'selected="selected"':"" }}
                                            value="__ALL__">كل الأعلانات</option>
                                        <option
                                            {{ $stateAd == "__ACTIVE__"?'selected="selected"':"" }}
                                            value="__ACTIVE__">النشطه</option>
                                        <option
                                            {{ $stateAd == "__UNACTIVE__"?'selected="selected"':"" }}
                                            value="__UNACTIVE__">غير النشطه</option>
                                    </select>
                                    <div class="dropDownSelect2"></div>
                                </div>
                            </div>
                            <div class="table-responsive table-data">
                                <table class="table" style="margin-top: 20px;">
                                    <thead>
                                        <tr>
                                            <th>عنوان الاعلان</th>
                                            <th>صوره الهواتف</th>
                                            <th>صورة الكمبيوتر</th>
                                            <th>نشط</th>
                                            <th>بداية الفترة</th>
                                            <th>نهاية الفترة</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($advertisements as $advertisement)
                                            <tr id="user-{{ $advertisement->id }}">
                                                <td>
                                                    <div class="table-data__info" id="data-info">
                                                        <h6>{{ $advertisement->title }}</h6>
                                                        <span>
                                                            <a
                                                                href="{{ $advertisement->url }}">{{ $advertisement->url }}</a>
                                                        </span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="rs-select2--trans rs-select2--sm">
                                                        <div>
                                                            <img id="mobile_image"
                                                                src="{{ asset('storage/'. $advertisement->mobile_image) }}"
                                                                alt="{{ $advertisement->title }}" title="{{ $advertisement->title }}"
                                                                style="width: 75px; height: 75px;" loading="lazy" />
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="rs-select2--trans rs-select2--sm">
                                                        <div>
                                                            <img src="{{ asset(path: 'storage/'. $advertisement->desktop_image) }}"
                                                                alt="{{ $advertisement->title }}"  title="{{ $advertisement->title }}"
                                                                style="width: 125px; height: 65px;" loading="lazy" />
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="rs-select2--trans rs-select2--sm">
                                                        <div class="switch">
                                                            <label for="isActivate">
                                                                <input type="checkbox" id="isActivate"
                                                                    data-id="{{ $advertisement->id }}"
                                                                    name="isActivate"
                                                                    {{ $advertisement->isActivate?"checked":"" }} />
                                                                <span class=" slider"></span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="rs-select2--trans rs-select2--sm">
                                                        <div class="data-start">
                                                            <span>{{ \Carbon\Carbon::parse($advertisement->start_date)->format('Y-m-d') }}</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="rs-select2--trans rs-select2--sm">
                                                        <div class="data-end">
                                                            <span>{{ \Carbon\Carbon::parse($advertisement->end_date)->format('Y-m-d') }}</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="table-data-feature">
                                                        <button class="item" data-id="{{ $advertisement->id }}"
                                                            data-toggle="tooltip" title="تعديل" name="isActivate"
                                                            data-placement="top" title="" data-original-title="Edit">
                                                            <i class="zmdi zmdi-edit"></i>
                                                        </button>
                                                        <button class="item" data-id="{{ $advertisement->id }}"
                                                            data-toggle="tooltip" title="حذف" data-placement="top"
                                                            title="" data-original-title="Delete">
                                                            <i class="zmdi zmdi-delete"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr id='notfound'>
                                                <td colspan="7">
                                                    <h2 class="text-center">لا يوجد اي علانات</h2>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="user-data__footer">
                                <div>
                                    <span id="show-pages">
                                        {{ __('pagination.showing') }}
                                        {{ $advertisements->firstItem() ?? 0 }}
                                        {{ __('pagination.to') }}
                                        {{ $advertisements->lastItem() ?? 0 }}
                                        {{ __('pagination.of') }} {{ $advertisements->total() }}
                                        {{ __('pagination.results') }}
                                    </span>
                                </div>
                                <div id="js-pagition">
                                    {{ $advertisements->onEachSide(-1)->links() }}
                                </div>
                            </div>
                        </div>
                        <!-- END USER DATA-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection


@section("scripts")
<script src="{{ asset('admin/js/contentManager/contentManager.js') }}"></script>
@endsection
@section("cuntent","active")
