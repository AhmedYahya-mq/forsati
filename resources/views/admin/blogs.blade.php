@extends("admin.layout.layout")

@section('header')
<link href="{{ asset('admin/css/form.css') }}" rel="stylesheet" media="all">
<link href="{{ asset('admin/css/blogs/blogs.css') }}" rel="stylesheet" media="all">
<link href="{{ asset('admin/css/blogs/blogpost.css') }}" rel="stylesheet" media="all">
<link href="{{ asset('admin/css/loader-card.css') }}" rel="stylesheet" media="all">


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
<title>أدارة المدونات</title>
@endsection


@section("form")
<div class="container-form">
    <div class="container">
        <div class="row justify-content-between">
            <!-- عنوان النموذج وزر الإغلاق -->
            <div class="mb-3">
                <h2>إضافة مدونه</h2>
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
                    <label for="title" class="form-label">عنوان الدونه:</label>
                    <input type="text" class="form-control" id="title" name="title_ar"
                        placeholder="أدخل عنوان المنحة...">
                </div>

                <div class="col-12 mb-3 text-right">
                    <label for="title" class="form-label">عنوان الدونه الأنجليزي:</label>
                    <input type="text" class="form-control" id="title" name="title_en"
                        placeholder="أدخل عنوان المنحة...">
                </div>

                <!-- منطقة النص لوصف المنحة -->
                <div class="col-12 mb-3 text-right">
                    <label for="description" class="form-label">وصف المدونه:</label>
                    <textarea class="form-control" id="description" name="description_ar" rows="3"
                        placeholder="أدخل وصف المدونه..."></textarea>
                </div>

                <div class="col-12 mb-3 text-right">
                    <label for="description" class="form-label">وصف المدونه الأنجليزي:</label>
                    <textarea class="form-control" id="description" name="description_en" rows="3"
                        placeholder="أدخل وصف المدونه..."></textarea>
                </div>

                <!-- منطقة النص لوصف المنحة (تكرار الوصف) -->
                <div class="col-12 mb-3 text-right">
                    <label for="content_ar" class="form-label">محتوى المدونه:</label>
                    <textarea class="form-control" placeholder="أدخل مجتوى المدونه..." name="content_ar" id="content_ar"
                        rows="5"></textarea>
                </div>

                <div class="col-12 mb-3 text-right">
                    <label for="content_en" class="form-label">محتوى المدونه الأنجليزي:</label>
                    <textarea class="form-control" placeholder="أدخل مجتوى المدونه..." name="content_en" id="content_en"
                        rows="5"></textarea>
                </div>


            </div>
            <!-- حقل رفع الصور -->
            <div class="text-right">
                <label class="form-label">صورة المدونه:</label>
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
<section>
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="row">
                <div class="container-fluid">
                    <main class="m-3">
                        <div class="box-search text-right row wrap  justify-content-center align-item-center p-3">
                            <button class="icon-btn add-btn add-btn-js">
                                <div class="add-icon"></div>
                                <div class="btn-txt" title="اضافة منحه">أضافة مدونة</div>
                            </button>
                            <div action="#" class="search col-md-10">
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
                                <input type="text" title="بحث" class="search__input search" id="search" name="search" placeholder="بحث...">
                            </div>
                        </div>
                        <div class="boxing">
                            <div class="side-right-blog portfolio" id="portfolio">
                                <div class="portfolio-gallery">

                                    @forelse ($blogs as $blog)
                                        <div class="portfolio-box mix uiux text-right" id="user-{{ $blog->id }}">
                                            <div class="portfolio-content">
                                                <h3 data-en="{{ $blog->title_en }}">{{ $blog->title_ar }}</h3>
                                                <p data-en="{{ $blog->description_en }}">
                                                    {{ $blog->description_ar }}
                                                </p>
                                                <input type="hidden"  id="cont_ar" value="{{ $blog->content_ar }}">
                                                <input type="hidden"  id="cont_en" value="{{ $blog->content_en }}">
                                                <a href="#" class="readMore">إقراء المزيد</a>
                                            </div>
                                            <div class="portfolio-img row m-1 justify-content-center"
                                                style="position: relative;">
                                                <div class="controller-awards row p-2 justify-content-between  w-100"
                                                    style="position: absolute;z-index: 100;">
                                                    <button class="col-md-0 rounded-circle item"  data-toggle="tooltip" data-id="{{ $blog->id }}" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="col-md-0  rounded-circle item"  data-toggle="tooltip" data-id="{{ $blog->id }}" title="حذف">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </div>
                                                <img id="image-blog" src="{{ asset(path: "storage/" . $blog->image) }}" title="{{ $blog->title_ar }}" alt="{{ $blog->title_ar }}" loading="lazy">
                                            </div>
                                        </div>
                                    @empty

                                    @endforelse
                                </div>

                                <div class="pages">
                                    <div id="js-pagition">
                                        {{ $blogs->onEachSide(-1)->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </main>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection


@section("scripts")
<script src="{{ asset('admin/js/blogs/blog.js') }}"></script>
@endsection

@section("blogs","active")
