
// ---------------------- دوال مساعدة ----------------------

// دالة بناء صف الجدول بناءً على البيانات
function buildTableRow(specialization, index) {
    return `
        <tr class="tr-shadow" id="user-${specialization.id}" style="border-bottom: 5px solid #f2f2f2;">
            <td><span>${index + 1}</span></td>
            <td>
                <div class="table-data__info" id="data-info">
                    <h6>${specialization.name_ar}</h6>
                    <span><span>${specialization.name_en}</span></span>
                </div>
            </td>
            <td>
                <div class="table-data-feature">
                    <button class="item" data-toggle="tooltip" data-id="${specialization.id}" title="تعديل">
                        <i class="zmdi zmdi-edit"></i>
                    </button>
                    <button class="item" data-toggle="tooltip" data-id="${specialization.id}" title="حذف">
                        <i class="zmdi zmdi-delete"></i>
                    </button>
                </div>
            </td>
        </tr>
    `;
}

// ---------------------- دوال تحديث الجدول ----------------------

// دالة تعبئة البيانات في الجدول
function renderData(specializations, isAdd = false) {
    let tableBody = '';
    // إذا كان المدخل المستخدم صف واحد فقط، حوله إلى مصفوفة
    if (!Array.isArray(specializations)) {

        specializations = [specializations.specialization];
    }

    // إذا كانت البيانات موجودة
    if (specializations.length > 0) {
        specializations.forEach((specialization, index) => {
            tableBody += buildTableRow(specialization, index);
        });
    } else {
        // إذا لم توجد بيانات
        tableBody = `
            <tr id='notfound'>
                <td colspan="7"><h2 class="text-center">لا يوجد مستخدمين</h2></td>
            </tr>
        `;
    }

    // تحديث محتوى tbody
    const $tableBody = $("table tbody");
    if (!isAdd) {
        $tableBody.html(tableBody);
    } else {
        $tableBody.prepend(tableBody);
    }
}

// دالة تحديث صف محدد في الجدول
function updateElement(responce) {
    specialization = responce.specialization;
    const $userRow = $(`#user-${specialization.id}`);
    $userRow.find('#data-info h6').text(specialization.name_ar);
    $userRow.find('#data-info span span').text(specialization.name_en);
}

// ---------------------- دوال التعامل مع الأحداث ----------------------

function eventEdit() {
    // إضافة حدث click على زر التعديل
    $('body').on('click', '.item[data-toggle="tooltip"][title="تعديل"]', async function () {
        const $userRow = $(this).closest('tr');
        const specializationId = getDataId($userRow);

        const data = await fetchData(specializationId);
        if (!data) return; // إنهاء العملية إذا فشل جلب البيانات

        populateForm(data);
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
    $('input[name="name_ar"]').val(data.name_ar);
    $('input[name="name_en"]').val(data.name_en);

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


// ---------------------- دوال عرض التحميل ----------------------

// دالة لعرض مؤشر التحميل عند جلب البيانات
function renderLoading() {
    const $tableBody = $('table.table tbody');
    $tableBody.html(""); // تفريغ محتوى الجدول قبل عرض التحميل

    $tableBody.html(`
        <tr class="tr-shadow" style="border-bottom: 5px solid #f2f2f2;">
            <td colspan="3">
                <div class="loader-search">
                    <div class="loaderMiniContainer">
                        <div class="barContainer">
                            <span class="bar"></span>
                            <span class="bar bar2"></span>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 101 114" class="svgIcon">
                            <circle stroke-width="7" stroke="black" transform="rotate(36.0692 46.1726 46.1727)" r="29.5497" cy="46.1727" cx="46.1726"></circle>
                            <line stroke-width="7" stroke="black" y2="111.784" x2="97.7088" y1="67.7837" x1="61.7089"></line>
                        </svg>
                    </div>
                </div>
            </td>
        </tr>
    `);
}

// ---------------------- تشغيل الأحداث عند تحميل الصفحة ----------------------

$(function () {
    eventEdit();  // تشغيل حدث التعديل
    eventDelete('التخصص');  // تشغيل حدث الحذف
});
