
// دالة إعداد CKEditor
const initCKEditor = (selector, lang) => {
    CKEDITOR.replace(selector, {
        language: lang,
        removePlugins: 'elementspath',
        resize_enabled: true,
        removeButtons: 'Source,Save,About'
    });
};

// دالة إعداد FilePond
const initFilePond = (inputSelector) => {
    FilePond.registerPlugin(
        FilePondPluginImagePreview,
        FilePondPluginImageExifOrientation,
        FilePondPluginFileValidateSize,
        FilePondPluginImageEdit,
        FilePondPluginImageResize
    );

    const inputElement = document.querySelector(inputSelector);
    const pondOptions = {
        allowImageResize: true,
    imageResizeTargetWidth: 300, // العرض الأقصى للصورة (بالبكسل)
    imageResizeTargetHeight: 100, // الارتفاع الأقصى للصورة (بالبكسل)
    imageResizeMode: 'contain', // الوضع 'contain' لضمان تناسب الأبعاد دون تشويه الصورة
    allowImagePreview: true, // تفعيل معاينة الصور
    allowImageExifOrientation: true, // تصحيح اتجاه الصورة تلقائيًا
    allowFileSizeValidation: true, // التحقق من حجم الملفات
    maxFileSize: '3MB', // الحد الأقصى لحجم الملف
    allowImageEdit: true, // تفعيل تعديل الصور
    imageEditEditor: FilePondPluginImageEdit, // ربط المكون الإضافي لتعديل الصور
    labelIdle: 'اسحب و ادرج صوره أو <span class="filepond--label-action"> تصفح الصور </span>',
    labelInvalidField: 'الحقل يحتوي على ملفات غير صالحة',
    labelFileWaitingForSize: 'بانتظار الحجم',
    labelFileSizeNotAvailable: 'الحجم غير متاح',
    labelFileLoading: 'بالإنتظار',
    labelFileLoadError: 'حدث خطأ أثناء التحميل',
    labelFileProcessing: 'يتم الرفع',
    labelFileProcessingComplete: 'تم الرفع',
    labelFileProcessingAborted: 'تم إلغاء الرفع',
    labelFileProcessingError: 'حدث خطأ أثناء الرفع',
    labelFileProcessingRevertError: 'حدث خطأ أثناء التراجع',
    labelFileRemoveError: 'حدث خطأ أثناء الحذف',
    labelTapToCancel: 'انقر للإلغاء',
    labelTapToRetry: 'انقر لإعادة المحاولة',
    labelTapToUndo: 'انقر للتراجع',
    labelButtonRemoveItem: 'مسح',
    labelButtonAbortItemLoad: 'إلغاء',
    labelButtonRetryItemLoad: 'إعادة',
    labelButtonAbortItemProcessing: 'إلغاء',
    labelButtonUndoItemProcessing: 'تراجع',
    labelButtonRetryItemProcessing: 'إعادة',
    labelButtonProcessItem: 'رفع',
    labelMaxFileSizeExceeded: 'الملف كبير جدا',
    labelMaxFileSize: 'حجم الملف الأقصى: {filesize}',
    labelMaxTotalFileSizeExceeded: 'تم تجاوز الحد الأقصى للحجم الإجمالي',
    labelMaxTotalFileSize: 'الحد الأقصى لحجم الملف: {filesize}',
    labelFileTypeNotAllowed: 'ملف من نوع غير صالح',
    fileValidateTypeLabelExpectedTypes: 'تتوقع {allButLastType} من {lastType}',
    imageValidateSizeLabelFormatError: 'نوع الصورة غير مدعوم',
    imageValidateSizeLabelImageSizeTooSmall: 'الصورة صغير جدا',
    imageValidateSizeLabelImageSizeTooBig: 'الصورة كبيرة جدا',
    imageValidateSizeLabelExpectedMinSize: 'الحد الأدنى للأبعاد هو: {minWidth} × {minHeight}',
    imageValidateSizeLabelExpectedMaxSize: 'الحد الأقصى للأبعاد هو: {maxWidth} × {maxHeight}',
    imageValidateSizeLabelImageResolutionTooLow: 'الدقة ضعيفة جدا',
    imageValidateSizeLabelImageResolutionTooHigh: 'الدقة مرتفعة جدا',
    imageValidateSizeLabelExpectedMinResolution: 'أقل دقة: {minResolution}',
    imageValidateSizeLabelExpectedMaxResolution: 'أقصى دقة: {maxResolution}',

    server: insatnsServerSelect2(),
    };

    return FilePond.create(inputElement, pondOptions);
};

// دالة عرض البيانات في الجدول
function renderData(response, isAdd = false) {
    let blogs = Array.isArray(response) ? response : [response.blog];
    let tableBody = '';
console.log(response)
    if (blogs.length > 0) {
        blogs.forEach(blog => {
            const { id, title_ar, title_en, description_ar, description_en, content_ar, content_en, image } = blog;
            tableBody += `
                <div class="portfolio-box mix uiux text-right" id="user-${id}">
                    <div class="portfolio-content">
                        <h3 data-en="${title_en}">${title_ar}</h3>
                        <p data-en="${description_en}">${description_ar}</p>
                        <input type="hidden" id="cont_ar" value='${content_ar}'>
                        <input type="hidden" id="cont_en" value='${content_en}'>
                        <a href="#" class="readMore">إقراء المزيد</a>
                    </div>
                    <div class="portfolio-img row m-1 justify-content-center" style="position: relative;">
                        <div class="controller-awards row p-2 justify-content-between w-100" style="position: absolute;z-index: 100;">
                            <button class="col-md-0 rounded-circle item" data-toggle="tooltip" data-id="${id}" title="تعديل">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="col-md-0 rounded-circle item" data-toggle="tooltip" data-id="${id}" title="حذف">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                        <img id="image-blog" src="${image}" title="${title_ar}" alt="${title_ar}" loading="lazy">
                    </div>
                </div>
            `;
        });
    } else {
        tableBody = `<tr id='notfound'><td colspan="7"><h2 class="text-center">لا يوجد مدونات</h2></td></tr>`;
    }

    const $tableBody = $(".boxing .portfolio-gallery");
    !isAdd ? $tableBody.html(tableBody) : $tableBody.prepend(tableBody);
}


// دالة إضافة حدث التعديل
function eventEdit() {
    // إضافة حدث click على زر التعديل
    $('body').on('click', '.item[data-toggle="tooltip"][title="تعديل"]', async function () {
        const $userRow = $(this).closest('.portfolio-box.mix.uiux.text-right');
        const blogId = getDataId($userRow);

        const userData = await fetchData(blogId);
        if (!userData) return; // إنهاء العملية إذا فشل جلب البيانات

        populateForm(userData);
        showForm();
    });
}

// دالة للحصول على معرف المستخدم
function getDataId($userRow) {
    return $userRow.attr('id').replace('user-', '');
}

// دالة لجلب بيانات المستخدم
async function fetchData(specializationId) {
    try {
        let response = {};
        await api(`${urlForm}/edit/${specializationId}`, "GET", {}, (r) => {
            response = r;
        }, false);
        return response.data; // ارجع بيانات المستخدم
    } catch (error) {
        console.error("Error fetching user data:", error);
        return null; // إعادة القيمة null في حالة الخطأ
    }
}

// دالة لملء النموذج بالبيانات
function populateForm(data) {
    $('input[name="title_ar"]').val(data.title_ar);
    $('input[name="title_en"]').val(data.title_en);
    CKEDITOR.instances['content_ar'].setData(data.content_ar);
    CKEDITOR.instances['content_en'].setData(data.content_en);
    $('textarea[name="description_ar"]').val(data.description_ar.trim() || "");
    $('textarea[name="description_en"]').val(data.description_en.trim() || "");

    // تعيين الحقول المخفية وقيم الـ form
    $('#form').prepend(`<input type='hidden' name='id' value='${data.id}'>`);
    $("#title-form").text("تعديل");
    $("#form").find("button[type='submit']").text("تعديل");
}

// دالة لإظهار النموذج
function showForm() {
    $(".container-form").css({
        "display": "flex"
    }).hide().fadeIn(500);
    $(document.body).css({
        "overflow": "hidden"
    });
}


// دالة تحديث الصف في الجدول
function updateElement(response) {
    const blog = response.blog;
    const $userRow = $(`#user-${blog.id}`);

    $userRow.find('.portfolio-content h3').text(blog.title_ar).data('en', blog.title_en);
    $userRow.find('.portfolio-content p').text(blog.description_ar).data('en', blog.description_en);
    $userRow.find('.portfolio-content input#cont_ar').val(blog.content_ar);
    $userRow.find('.portfolio-content input#cont_en').val(blog.content_en);
    $userRow.find('#image-blog').attr('src', blog.image).attr('title', blog.title_ar).attr('alt', blog.title_ar);
}

// دالة عرض التحميل
function renderLoading() {
    const $tableBody = $(".boxing .portfolio-gallery");
    $tableBody.html("");
    Array(10).fill().forEach(() => {
        $tableBody.append(`
            <div class="portfolio-box">
                <div class="portfolio-content">
                    <h3 class="wrapper-title card__skeleton"></h3>
                    <p class="wrapper-body card__skeleton"></p>
                    <p class="wrapper-body card__skeleton"></p>
                    <p class="wrapper-body card__skeleton"></p>
                    <a href="#" class="readMore wrapper-footer card__skeleton"></a>
                </div>
                <div class="portfolio-img wrapper-img card__skeleton" style="height: 100%;"></div>
            </div>
        `);
    });
}

// تنفيذ الإعدادات عند التحميل
$(function () {
    initCKEditor('content_ar', 'ar');
    initCKEditor('content_en', 'en');
    initFilePond('.container-form input[type="file"]');
    eventEdit();
    eventDelete("لمدونة",".portfolio-box.mix.uiux.text-right");
});
