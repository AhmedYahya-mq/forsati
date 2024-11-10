
// دالة لتفعيل CKEditor مع الإعدادات
function initializeCKEditor(selector, options = {}) {
    return CKEDITOR.replace(selector, {
        language: 'ar',
        removePlugins: 'elementspath',
        resize_enabled: true,
        removeButtons: 'Source,Save,About',
        ...options
    });
}

// تفعيل CKEditor للمحتوى العربي والإنجليزي
initializeCKEditor('content_ar');
initializeCKEditor('content_en', {
    on: {
        instanceReady: function () {
            this.document.getBody().setAttribute('dir', 'ltr');
        }
    }
});

// دالة لتسجيل إضافات FilePond
function registerFilePondPlugins() {
    FilePond.registerPlugin(
        FilePondPluginImagePreview,
        FilePondPluginImageExifOrientation,
        FilePondPluginFileValidateSize,
        FilePondPluginImageEdit,
        FilePondPluginImageResize
    );
}

// دالة لإعداد FilePond
function initializeFilePond() {
    const inputElement = document.querySelector('.container-form input[type="file"]');
    return FilePond.create(inputElement, {
        allowImageResize: true,
        imageResizeTargetWidth: 300,
        imageResizeTargetHeight: 100,
        imageResizeMode: 'contain',
        allowImagePreview: true,
        allowImageExifOrientation: true,
        allowFileSizeValidation: true,
        maxFileSize: '3MB',
        allowImageEdit: true,
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
        server: insatnsServerSelect2(),
    });
}

// دالة تعبئة البيانات في الجدول باستخدام jQuery
function renderData(scholarships) {
    let scholarshipsHtml = '';
    if (scholarships.length > 0) {
        scholarships.forEach((scholarship) => {
            const {
                id,
                image,
                title_ar,
                description_ar,
                created_at,
                deadline,
                visits,
                degreeLevels,
                country,
                funding_type,
                specializations
            } = scholarship;

            const degreeLevelsHtml = degreeLevels.map(level => `<span class="project-type">• ${level}</span>`).join('');
            const countryText = country;
            const fundingTypeText = funding_type;
            const specializationsHtml = specializations.map(specialization => `<span class="project-type">• ${specialization}</span>`).join('');

            scholarshipsHtml += `
                <div class="card text-right" id="user-${id}">
                    <div>
                        <div class="card-image row justify-content-center">
                            <div class="controller-awards row justify-content-between p-3 w-100" style="position: absolute; z-index: 100;">
                                <div class="col-md-0 item rounded-circle" data-toggle="tooltip" data-id="${id}" title="تعديل">
                                    <i class="fas fa-edit"></i>
                                </div>
                                <div class="col-md-0 item rounded-circle" data-toggle="tooltip" data-id="${id}" title="حذف">
                                    <i class="fas fa-trash-alt"></i>
                                </div>
                            </div>
                            <img src="${image}" title="${title_ar}" alt="${title_ar}" loading="lazy">
                            <div class="types">
                                ${specializationsHtml}
                                ${degreeLevelsHtml}
                                <span class="project-type">• ${countryText}</span>
                                <span class="project-type">• ${fundingTypeText}</span>
                            </div>
                        </div>
                        <a href="#" class="award-link">
                            <div class="head-info">
                                <span>مشاهدة: ${visits}</span>
                                <span>تاريخ النشر: ${created_at}</span>
                            </div>
                            <p class="card-title">${title_ar}</p>
                            <p class="card-body">${description_ar}</p>
                            <p class="footer">أخر <span class="by-name">موعد لتسجيل</span>: <span class="date">${deadline}</span></p>
                        </a>
                    </div>
                </div>
            `;
        });
    } else {
        scholarshipsHtml = `
            <tr id='notfound'>
                <td colspan="7">
                    <h2 class="text-center">لا يوجد منح </h2>
                </td>
            </tr>
        `;
    }

    // تحديث محتوى الصفحة
    const $scholarshipsContainer = $('#scholarships-container');
    $scholarshipsContainer.html(scholarshipsHtml);
}

// دالة لتنسيق الدول
function formatCountry(country) {
    var flagUrl = $(country.element).data('flag');
    var $country = $(
        (flagUrl == undefined) ? '<span style="display: flex;align-items: center;">' + country.text + '</span>' :
        '<span style="display: flex;align-items: center;"><img src="' + flagUrl + '" class="flag-icon"/><spn>' + country.text + '</spn></span>'
    );
    return $country;
}


// دالة إعداد Select2 للدول
function instanceCountries() {
    $('#country-select, #country-select-filter').select2({
        width: '100%',
        placeholder: "أختر الدولة",
        closeOnSelect: false,
        templateResult: formatCountry,
        templateSelection: formatCountry,
        dir: "rtl"
    });
}

function instanceSpecialization() {
    $('#specialization-select, #specialization-select-filter').select2({
        width: '100%',
        placeholder: "أختر التخصص",
        closeOnSelect: false,
        dir: "rtl"
    });
}

// دالة لعرض تحميل مؤقت
function renderLoading() {
    const $tableBody = $('#scholarships-container');
    $tableBody.html("");
    Array(10).fill().forEach(() => {
        $tableBody.append(`
        <div class="card">
            <a href="#" class="award-link">
                <div>
                    <div class="card-image card__skeleton">
                        <div class="types">
                            <span class="wrapper-type card__skeleton"></span>
                            <span class="wrapper-type card__skeleton"></span>
                            <span class="wrapper-type card__skeleton"></span>
                        </div>
                    </div>
                    <p></p>
                    <div class="head-info">
                        <span class="wrapper card__skeleton"></span>
                        <span class="wrapper card__skeleton"></span>
                    </div>
                    <p class="card-title wrapper-title card__skeleton"></p>
                    <p class="card-body wrapper-body card__skeleton"></p>
                    <p class="card-body wrapper-body card__skeleton"></p>
                    <p class="card-body wrapper-body card__skeleton"></p>
                    <p class="footer wrapper-footer card__skeleton"></p>
                </div>
            </a>
        </div>
        `);
    });
}

// دالة إضافة حدث التعديل
function eventEdit() {
    // إضافة حدث click على زر التعديل
    $('body').on('click', '.item[data-toggle="tooltip"][title="تعديل"]', async function () {
        const $userRow = $(this).closest('.card.text-right');
        const specializationId = getDataId($userRow);

        const userData = await fetchData(specializationId);
        if (!userData) return; // إنهاء العملية إذا فشل جلب البيانات

        populateForm(userData, $userRow);
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
    $('form input[type="date"][name="deadline"]').val(data.date);
    $('#country-select').val(data.countryId).trigger('change');
    $('#specialization-select').val(data.specializationsIds).trigger('change');
    $('input[type="radio"][name="funding_type"][value="' + data.funding_type_id + '"]').prop('checked', true).trigger('change');

    data.degreeLevelsIds.forEach(degreeLevelId => {
        $('input[type="checkbox"][name="degree_levels[]"][value="' + degreeLevelId + '"]').prop('checked', true).trigger('change');
    });

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


function updateElement(response) {
    const Scholarship = response.Scholarship;
    const $userRow = $(`#user-${Scholarship.id}`);
    const degreeLevelsHtml = Scholarship.degreeLevels.map(level => `<span class="project-type">• ${level}</span>`).join('');
    const countryText = Scholarship.country;
    const fundingTypeText = Scholarship.funding_type;
    const deadline = Scholarship.deadline;
    const specializationsHtml = Scholarship.specializations.map(specialization => `<span class="project-type">• ${specialization}</span>`).join('');
    const contryHtml = `<span class="project-type">• ${countryText}</span>`;
    const funding_typeHtml = `<span class="project-type">• ${fundingTypeText}</span>`;
    $userRow.find('div.types').html(degreeLevelsHtml + specializationsHtml + contryHtml + funding_typeHtml);
    $userRow.find('.card-title').text(Scholarship.title_ar);
    $userRow.find('.card-body').text(Scholarship.description_ar);
    $userRow.find('p.footer .date').text(deadline);
    $userRow.find('img').attr('src', Scholarship.image).attr('title', Scholarship.title_ar).attr('alt', Scholarship.title_ar);
}


// الإعدادات المبدئية
$(document).ready(function () {
    instanceCountries();
    instanceSpecialization();
    registerFilePondPlugins();
    initializeFilePond();
    eventEdit();
    eventDelete('المنحه',".card.text-right");
});
