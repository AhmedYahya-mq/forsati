
FilePond.registerPlugin(
    FilePondPluginImagePreview,
    FilePondPluginImageExifOrientation,
    FilePondPluginFileValidateSize,
    FilePondPluginImageEdit,
    FilePondPluginImageResize
);

function initPondPhone() {
    const inputPhone = document.querySelector('.container-form input[name="mobile_image"]');
    const pond_phone = FilePond.create(inputPhone, {
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
    });
}

function initPondPC() {

    const inputPc = document.querySelector('.container-form input[name="desktop_image"]');
    const pond_pc = FilePond.create(inputPc, {
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
    });
}


function updateStateAdvertisement() {
    $(document).on("change", "input[name='isActivate']", function () {
        $(this).attr("disabled", true);
        var userId = $(this).data('id');
        api(`${urlForm}/updateAdvertisementStatus/${userId}`, "PUT", {
            _token: $('meta[name="csrf-token"]').attr('content'),
        }, (response) => {
            $(this).prop('checked', response.isActivate);
            Popup.showPopup(Popup.MessageType.SUCCESS, response.message);
        }, false);
        $(this).removeAttr("disabled");
    });
}

// دالة تعبئة البيانات في الجدول باستخدام jQuery
// دالة لتعيين الإعلانات من الاستجابة
function getAdvertisements(response) {
    let advertisements = response.advertisement || response;

    // التأكد من أن الإعلانات في شكل مصفوفة
    return Array.isArray(advertisements) ? advertisements : [advertisements];
}

// دالة لإنشاء صورة
function createImage(src, alt, width, height) {
    return `
        <div style="width:114px;">
            <img src="${src}" alt="${alt}" title="${alt}" style="width: ${width}px; height: ${height}px;" loading="lazy"/>
        </div>
    `;
}

// دالة لإنشاء صف إعلان
function createAdvertisementRow(advertisement) {
    const { id, title, url, mobile_image, desktop_image, isActivate, startDate, endDate } = advertisement;

    const mobileImageSrc = mobile_image || 'default-mobile.png';
    const desktopImageSrc = desktop_image || 'default-desktop.png';
    const isChecked = isActivate ? "checked" : "";

    return `
        <tr id="user-${id}">
            <!-- عنوان الإعلان والرابط -->
            <td>
                <div class="table-data__info" id="data-info">
                    <h6>${title}</h6>
                    <span><a href="${url}" target="_blank">${url}</a></span>
                </div>
            </td>
            <!-- صورة الهاتف المحمول -->
            <td>${createImage(mobileImageSrc, 'Mobile Image', 75, 75)}</td>
            <!-- صورة سطح المكتب -->
            <td>${createImage(desktopImageSrc, 'Desktop Image', 125, 65)}</td>
            <!-- حالة التفعيل -->
            <td><div style="width:114px;"><div class="switch"><label for="isActivate"><input type="checkbox" id="isActivate" name="isActivate" data-id="${id}" ${isChecked} /><span class="slider"></span></label></div></div></td>
            <!-- تاريخ البداية والنهاية -->
            <td><div class="data-start" style="width:114px;">${startDate}</div></td>
            <td><div class="data-end" style="width:114px;">${endDate}</div></td>
            <!-- أدوات التعديل والحذف -->
            <td>
                <div class="table-data-feature">
                    <button class="item" data-id="${id}" data-toggle="tooltip" title="تعديل" name="isActivate" data-placement="top" data-original-title="Edit">
                        <i class="zmdi zmdi-edit"></i>
                    </button>
                    <button class="item" data-id="${id}" data-toggle="tooltip" title="حذف" data-placement="top" data-original-title="Delete">
                        <i class="zmdi zmdi-delete"></i>
                    </button>
                </div>
            </td>
        </tr>
    `;
}

// دالة لإنشاء محتوى الجدول بناءً على الإعلانات
function generateBodyElement(advertisements) {
    if (advertisements.length > 0) {
        return advertisements.map(createAdvertisementRow).join(''); // دمج الصفوف
    } else {
        return `
        <tr id='notfound'>
            <td colspan="7"><h2 class="text-center">لا يوجد أعلانات</h2></td>
        </tr>`;
    }
}

// دالة لتحديث محتوى الجدول
function updateBodyElement(tableBody, isAdd = false) {
    const $tableBody = $("table tbody");
    if (!isAdd) {
        $tableBody.html(tableBody); // استبدال المحتوى بالكامل
    } else {
        $tableBody.prepend(tableBody); // إضافة الصف في الأعلى
    }
}

// دالة رئيسية لتوليد الجدول
function renderData(response, isAdd = false) {
    const advertisements = getAdvertisements(response); // استلام الإعلانات
    const tableBody = generateBodyElement(advertisements); // توليد الصفوف
    updateBodyElement(tableBody, isAdd); // تحديث الجدول
}


function updateElement(responce) {
    advertisement = responce.advertisement;
    const $userRow = $(`#user-${advertisement.id}`);

    $userRow.find('#data-info h6').text(advertisement.title);
    $userRow.find('#data-info span a').text(advertisement.url);
    $userRow.find('#data-info span a').attr("href", advertisement.url);
    $userRow.find('img#mobile_image').attr("src", advertisement.mobile_image);
    $userRow.find('img#desktop_image').attr("src", advertisement.desktop_image);;
    $userRow.find('td .switch input[type="checkbox"]').attr("src", advertisement.isActivate ? "checked='checked'" : "");
    $userRow.find('#data-info h6').text(advertisement.title);
    $userRow.find('td .data-start').text(advertisement.startDate);
    $userRow.find('td .data-end').text(advertisement.endDate);


}

function eventEdit() {
    // إضافة حدث click على زر التعديل
    $('body').on('click', '.item[data-toggle="tooltip"][title="تعديل"]', async function () {
        const $userRow = $(this).closest('tr');
        const contentId = getDataId($userRow);

        const userData = await fetchData(contentId);
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
async function fetchData(id) {
    try {
        let response = {};
        await api(`${urlForm}/edit/${id}`, "GET", {}, (r) => {
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
    $('input[name="title"]').val(data.title);
    $('input[name="url"]').val(data.url);
    $('form input[type="date"][name="start_date"]').val(data.startDate);
    $('form input[type="date"][name="end_date"]').val(data.endDate);

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


function eventFilterStateAd() {
    $(".js-select2").change(async function (e) {
        e.preventDefault($(this).val());
        url = processUrl(window.location.href, "stateAd", $(this).val());
        url=convertUrlToApiUrl(url);
        await api(url, "GET", {}, handlerDataPagesResponse, true);
    });
}


function renderLoading() {
    const $tableBody = $('table.table tbody');
    $tableBody.html("");
    console.log($tableBody);
    $tableBody.html(`
        <tr>
            <td colspan="7">
                    <div class="loader-search">
                        <div class="loaderMiniContainer">
                            <div class="barContainer">
                                <span class="bar"></span>
                                <span class="bar bar2"></span>
                            </div>
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 101 114"
                                class="svgIcon"
                            >
                            <circle
                                stroke-width="7"
                                stroke="black"
                                transform="rotate(36.0692 46.1726 46.1727)"
                                r="29.5497"
                                cy="46.1727"
                                cx="46.1726"
                            ></circle>
                            <line
                                stroke-width="7"
                                stroke="black"
                                y2="111.784"
                                x2="97.7088"
                                y1="67.7837"
                                x1="61.7089"
                            ></line>
                            </svg>
                        </div>
                    </div>
                </td>
            </tr>
        `);
}

$(function () {
    initPondPC();
    initPondPhone();
    eventEdit();
    eventDelete('الأعلان');
    updateStateAdvertisement();
    eventFilterStateAd();
});
