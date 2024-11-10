
function resetForm() {
    // إعادة تعيين النموذج
    $("#form")[0].reset();
    $("#form").find("input[name='id']").remove();
    // إعادة تعيين select2 إذا كانت العناصر موجودة
    if ($('#country-select').length && $('#specialization-select').length) {
        $('#country-select, #specialization-select, #permissions-select').val(null).trigger('change');
    }

    if ($('#permissions-select').length) {
        $('#permissions-select').val(null).trigger('change');
    }

    // إعادة تعيين CKEditor إذا كان موجودًا
    if (typeof CKEDITOR !== 'undefined' && CKEDITOR.instances['content_ar']) {
        CKEDITOR.instances['content_ar'].setData('');
    }

    // إعادة تعيين CKEditor إذا كان موجودًا
    if (typeof CKEDITOR !== 'undefined' && CKEDITOR.instances['content_en']) {
        CKEDITOR.instances['content_en'].setData('');
    }

    // إعادة تعيين FilePond إذا كان موجودًا
    if (typeof FilePond !== 'undefined') {
        // الحصول على جميع عناصر الإدخال المرتبطة بـ FilePond
        const filePondElements = document.querySelectorAll('.filepond');

        // إعادة تعيين الملفات لكل عنصر
        filePondElements.forEach(element => {
            const pond = FilePond.find(element); // الحصول على كائن FilePond
            if (pond && pond.getFiles().length > 0) {
                pond.removeFiles(); // إعادة تعيين الملفات
            }
        });
    }
}


// دالة لإرسال النموذج
function eventSubmit() {
    $("#form").on('submit', function (e) {
        e.preventDefault(); // منع الإرسال الافتراضي للنموذج
        let formData = collectFormData(this); // جمع بيانات النموذج

        // التحقق مما إذا كان الحقل "id" موجودًا وله قيمة
        const id = $(this).find("input[name='id']").val();
        if (id) {
            updateData(formData, id);
        } else {
            createData(formData);
        }
    });
}

// دالة لجمع بيانات النموذج
function collectFormData(form) {
    const formData = new FormData(form); // إنشاء كائن FormData من النموذج

    // التحقق من وجود CKEditor للمحتوى العربي
    if (typeof CKEDITOR !== 'undefined' && CKEDITOR.instances['content_ar']) {
        formData.set("content_ar", CKEDITOR.instances['content_ar'].getData());
    }

    // التحقق من وجود CKEditor للمحتوى الإنجليزي
    if (typeof CKEDITOR !== 'undefined' && CKEDITOR.instances['content_en']) {
        formData.set("content_en", CKEDITOR.instances['content_en'].getData());
    }

    return formData; // إرجاع FormData
}


function formDataToJson(formData) {
    let object = {};
    // تحويل FormData إلى كائن عادي مع التعامل مع الحقول المتعددة الاختيارات
    formData.forEach((value, key) => {

        // التعامل مع الحقول التي تنتهي بـ []
        if (key.endsWith('[]')) {
            key = key.slice(0, -2); // إزالة القوسين من نهاية اسم الحقل

            // التحقق مما إذا كان المفتاح موجودًا مسبقًا
            if (object[key]) {
                // إذا كان المفتاح موجودًا ومصفوفة، إضافة القيمة الجديدة
                if (Array.isArray(object[key])) {
                    object[key].push(value);
                } else {
                    // إذا كان المفتاح موجودًا وليس مصفوفة، تحويله إلى مصفوفة
                    object[key] = [object[key], value];
                }
            } else {
                // إذا لم يكن المفتاح موجودًا، تعيين القيمة كمصفوفة جديدة
                object[key] = [value];
            }
        } else {
            // إذا لم تكن الحقل تنتهي بـ []، تعيين القيمة
            if (object[key]) {
                // إذا كان المفتاح موجودًا ومصفوفة، إضافة القيمة الجديدة
                if (Array.isArray(object[key])) {
                    object[key].push(value);
                } else {
                    // إذا كان المفتاح موجودًا وليس مصفوفة، تحويله إلى مصفوفة
                    object[key] = [object[key], value];
                }
            } else {
                object[key] = value; // تعيين القيمة
            }
        }
    });
    const jsonData = JSON.stringify(object); // تحويل الكائن إلى JSON
    return jsonData; // إرجاع JSON
}


async function deleteFalde(id, elemenRemove) {
    await api(`${urlForm}/destroy/${id}`, "DELETE", {}, (response) => {
        console.log(response.message);
        $(elemenRemove).remove();
        Popup.showPopup(Popup.MessageType.SUCCESS, response.message);
    }, false);
}


function eventAddData() {
    $(".add-btn-js").click(function () {
        $("#title-form").text("إضافة");
        $("#form").find("button[type='submit']").text("إضافة");
        $(".container-form").css({
            "display": "flex"
        }).hide().fadeIn(500);
        $(document.body).css({
            "overflow": "hidden"
        });
    });
}

function eventCloseForm() {
    $("#close-form").click(function () {
        $(".container-form").fadeOut(500);
        $(document.body).css({
            "overflow": "auto"
        });
        resetForm();
    });
}


async function createData(fromData) {
    await api(`${urlForm}/store`, "POST", fromData, function (response) {
        renderData(response, true);
        Popup.showPopup(Popup.MessageType.SUCCESS, response.message);
        resetForm();
    }, false, false, false);
}

async function updateData(fromData, id) {
    let jsonData = formDataToJson(fromData);
    await api(`${urlForm}/update/${id}`, "put", jsonData, function (response) {
        updateElement(response);
        Popup.showPopup(Popup.MessageType.SUCCESS, response.message);
        resetForm();
        $("#close-form").click();
    }, false);
}


function eventDelete(nameObject, parentElement = 'tr') {
    $('body').on('click', '.item[data-toggle="tooltip"][title="حذف"]', function () {
        // الحصول على الصف الذي يحتوي على المستخدم
        const $element = $(this).closest(parentElement);
        const id = $element.attr('id').replace('user-', '');
        ConfirmBox.show({
            message: 'هل أنت متأكد أنك تريد حذف هذا ' + nameObject + '؟',
            confirmText: 'حذف',
            cancelText: 'إلغاء',
            defaultAction: 'cancel',
        }).then((result) => {
            if (result) {
                deleteFalde(id, $element);
            } else {
                console.log('تم إلغاء العملية');
            }
        });
    });
}

$(function () {
    eventAddData();
    eventCloseForm();
    eventSubmit();
});
