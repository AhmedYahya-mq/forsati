@extends("admin.layout.layout")

@section('header')
<link href="{{ asset('admin/css/form.css') }}" rel="stylesheet" media="all">
<link href="{{ asset('admin/css/table.css') }}" rel="stylesheet" media="all">

<style>
    body {
        background-color: #f2f2f2;
    }

</style>

<!-- Title Page-->
<title>أدارة التخصصات</title>

@endsection


@section("form")
<div class="container-form">
    <div class="container">
        <div class="row justify-content-between">
            <!-- عنوان النموذج وزر الإغلاق -->
            <div class="mb-3">
                <h2><span id="title-form">إضافة</span> تخصص</h2>
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
                    <label for="title" class="form-label"> أسم العربي التخصص:</label>
                    <input type="text" name="name_ar" class="form-control" id="title"
                        placeholder="أدخل أسم العربي التخصص...">
                </div>
                <div class="col-12 mb-3 text-right">
                    <label for="title" class="form-label"> أسم الانجليزي التخصص:</label>
                    <input type="text" name="name_en" class="form-control" id="title"
                        placeholder="أدخل أسم الانجليزي التخصص...">
                </div>
            </div>
            <!-- زر الإرسال -->
            <button type="submit" class="btn btn-primary">حفظ</button>
        </form>
    </div>
</div>
@endsection


@section("content")
<section>
    <div class="main-content pt-5">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12 pb-5">
                        <!-- DATA TABLE -->
                        <h3 class="title-5 m-b-35">بيانات التخصصات</h3>
                        <div class="row justify-content-between px-3 align-items-center">
                            <div class="col-md-0 mt-3">
                                <div class="search-container">
                                    <div class="input-container">
                                        <input type="text" name="text" id="search" class="input" placeholder="البحث عن تخصص...">
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
                                <button class="au-btn au-btn-icon au-btn--green au-btn--small add-btn-js">
                                    <i class="zmdi zmdi-plus"></i>أضافة تخصص</button>
                            </div>
                        </div>
                        <div class="table-responsive table-responsive-data2" style="height: 50%;">
                            <table class="table table-data2">
                                <thead>
                                    <tr>
                                        <th style="
                                                    padding-left: 0;
                                                    width: 50px;
                                                "
                                        >الرقم</th>
                                        <th>أسم التخصص</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $index = 0;
                                    @endphp
                                    @forelse ($specializations  as $specialization)
                                    <tr class="tr-shadow" id="user-{{$specialization->id}}"
                                    style="border-bottom: 5px solid #f2f2f2;">
                                        <td>
                                            <span>
                                                {{ ++$index }}
                                            </span>
                                        </td>
                                            <td>
                                                <div class="table-data__info" id="data-info">
                                                    <h6>{{ $specialization->name_ar }}</h6>
                                                    <span>
                                                        <span>{{ $specialization->name_en }}</span>
                                                    </span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="table-data-feature">
                                                    <button class="item" data-toggle="tooltip" data-id="{{ $specialization->id }}" title="تعديل" data-placement="top"
                                                        title="" data-original-title="Edit">
                                                        <i class="zmdi zmdi-edit"></i>
                                                    </button>
                                                    <button class="item" data-toggle="tooltip" data-id="{{ $specialization->id }}" title="حذف" data-placement="top"
                                                        title="" data-original-title="Delete">
                                                        <i class="zmdi zmdi-delete"></i>
                                                    </button>
                                                </div>
                                            </td>
                                    </tr>
                                    @empty
                                <tr id='notfound'>
                                        <td colspan="4">
                                            <h2 class="text-center">لا يوجد تخصصات</h2>
                                        </td>
                                    </tr>
                                    @endforelse

                                </tbody>
                            </table>
                        </div>
                        <div class="user-data__footer m-3">
                                    <div>
                                        <span id="show-pages">
                                            {{ __('pagination.showing') }} {{ $specializations->firstItem() ?? 0 }}
                                            {{ __('pagination.to') }} {{ $specializations->lastItem() ?? 0 }}
                                            {{ __('pagination.of') }} {{ $specializations->total() }}
                                            {{ __('pagination.results') }}
                                        </span>
                                    </div>
                                    <div id="js-pagition">
                                        {{ $specializations->onEachSide(-1)->links() }}
                                    </div>
                            </div>
                        <!-- END DATA TABLE -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection


@section("scripts")
<script src="{{ asset("admin/js/specializationsManager/specializations.js") }}"></script>
@endsection
@section("specialzation","active")
