@extends('admin.layout.layout')
@section("header")

<meta name="csrf-token" content="{{ csrf_token() }}">

<title>الملف السخصي</title>

<!-- Fonts -->
<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />


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

<!-- FilePond File Validate Type Plugin -->
<script src="{{ asset('vendor/filepond/filepond-plugin-file-validate-type.min.js') }}"></script>

<!-- FilePond Image Crop Plugin -->
<script src="{{ asset('vendor/filepond/filepond-plugin-image-crop.min.js') }}"></script>

<!-- FilePond Image Transform Plugin -->
<script src="{{ asset('vendor/filepond/filepond-plugin-image-transform.min.js') }}"></script>

<!-- Scripts -->
@vite(['resources/css/app.css', 'resources/js/app.js'])
    @endsection

    @section("content")
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('الملف الشخصي') }}
        </h2>
    </x-slot>

    <div class="py-12" style="padding-top: 7rem">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>

    @endsection


    @section("scripts")
    <script>
        // تسجيل الإضافات الخاصة بـ FilePond
        FilePond.registerPlugin(
            FilePondPluginFileValidateType,
            FilePondPluginImageExifOrientation,
            FilePondPluginImagePreview,
            FilePondPluginImageCrop,
            FilePondPluginImageResize,
            FilePondPluginImageTransform,
            FilePondPluginImageEdit
        );


        let temp_image = null;
        // الحصول على عنصر الإدخال
        const inputElement = document.querySelector('#img-profile');

        // تفعيل FilePond على عنصر الإدخال
        FilePond.create(inputElement, {
            allowImagePreview: true, // تفعيل معاينة الصور
            allowImageExifOrientation: true, // تصحيح اتجاه الصورة تلقائيًا
            allowFileSizeValidation: true, // التحقق من حجم الملفات
            maxFileSize: '3MB', // الحد الأقصى لحجم الملف
            allowImageEdit: true, // تفعيل تعديل الصور
            imageEditEditor: FilePondPluginImageEdit, // ربط المكون الإضافي لتعديل الصور

            // تخصيص واجهة FilePond
            stylePanelLayout: 'compact circle',
            styleLoadIndicatorPosition: 'center bottom',
            styleProgressIndicatorPosition: 'right bottom',
            styleButtonRemoveItemPosition: 'left bottom',
            styleButtonProcessItemPosition: 'right bottom',
            // إعدادات اللغة
            labelIdle: 'اسحب و ادرج صورة الملف شخصي أو <span class="filepond--label-action"> تصفح </span>',
            labelInvalidField: 'الحقل يحتوي على ملفات غير صالحة',
            labelFileWaitingForSize: 'بانتظار الحجم',
            labelFileSizeNotAvailable: 'الحجم غير متاح',
            labelFileLoading: 'جارٍ التحميل...',
            labelFileLoadError: 'حدث خطأ أثناء التحميل',
            labelFileProcessing: 'جارٍ الرفع...',
            labelFileProcessingComplete: 'تم الرفع',
            labelFileProcessingAborted: 'تم إلغاء الرفع',
            labelFileProcessingError: 'حدث خطأ أثناء الرفع',
            labelFileProcessingRevertError: 'حدث خطأ أثناء التراجع',
            labelFileRemoveError: 'حدث خطأ أثناء الحذف',
            labelTapToCancel: 'اضغط للإلغاء',
            labelTapToRetry: 'اضغط لإعادة المحاولة',
            labelTapToUndo: 'اضغط للتراجع',
            labelButtonRemoveItem: 'مسح',
            labelButtonAbortItemLoad: 'إلغاء',
            labelButtonRetryItemLoad: 'إعادة',
            labelButtonAbortItemProcessing: 'إلغاء',
            labelButtonUndoItemProcessing: 'تراجع',
            labelButtonRetryItemProcessing: 'إعادة',
            labelButtonProcessItem: 'رفع',
            labelMaxFileSizeExceeded: 'حجم الملف أكبر من الحد المسموح',
            labelMaxFileSize: 'الحد الأقصى للحجم: {filesize}',
            labelMaxTotalFileSizeExceeded: 'تم تجاوز الحد الأقصى للحجم الإجمالي',
            labelMaxTotalFileSize: 'الحد الأقصى للحجم الإجمالي: {filesize}',
            labelFileTypeNotAllowed: 'نوع الملف غير مسموح',
            fileValidateTypeLabelExpectedTypes: 'نوع الملف غير مدعوم. الأنواع المتوقعة هي {allButLastType} أو {lastType}',
            imageValidateSizeLabelFormatError: 'نوع الصورة غير مدعوم',
            imageValidateSizeLabelImageSizeTooSmall: 'الصورة صغيرة جدًا',
            imageValidateSizeLabelImageSizeTooBig: 'الصورة كبيرة جدًا',
            imageValidateSizeLabelExpectedMinSize: 'الحد الأدنى للأبعاد هو {minWidth} × {minHeight}',
            imageValidateSizeLabelExpectedMaxSize: 'الحد الأقصى للأبعاد هو {maxWidth} × {maxHeight}',
            imageValidateSizeLabelImageResolutionTooLow: 'دقة الصورة منخفضة جدًا',
            imageValidateSizeLabelImageResolutionTooHigh: 'دقة الصورة مرتفعة جدًا',
            imageValidateSizeLabelExpectedMinResolution: 'الحد الأدنى للدقة هو {minResolution}',
            imageValidateSizeLabelExpectedMaxResolution: 'الحد الأقصى للدقة هو {maxResolution}',
            // إعدادات الخادم
            server: {
                process: {
                    url: '{{ route("profile.upload-image-temp") }}',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    onload: (response) => {
                        const data = JSON.parse(response);
                        temp_image=data.path;
                        console.log('Image uploaded:', temp_image);
                        return temp_image; 
                    },
                    onerror: (response) => {
                        console.error('Upload error:', response);
                        return response.path;
                    }
                },
                revert: {
                    url: '{{ route("profile.delete-temp-image") }}',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    onload: (response) => {
                        const data = JSON.parse(response);
                        console.log('Image deleted:', data.status);
                        return data.status ? null : data.error; // إرجاع الخطأ إذا حدث
                    },
                    onerror: (response) => {
                        console.error('Error during revert:', response);
                    },
                }
            }

        });

    </script>

    @endsection
