
// ---------------تهيئة select2------------
function initializeSelect2() {
    $('#permissions-select').select2({
        width: '100%',
        placeholder: "أختر الصلاحيات",
        closeOnSelect: false,
        allowClear: true,
        dir: "rtl"
    });
    handleSelect2Events();
}

// معالجة أحداث select2
function handleSelect2Events() {
    $('#permissions-select').on('select2:select select2:unselect', function () {
        const selectedValues = $('#permissions-select').val();
        if (selectedValues.length > 1 && selectedValues.includes('manage_all')) {
            $('#permissions-select').val(selectedValues.filter(value => value !== 'manage_all')).trigger('change');
        }
    });
}

// دوال عامة
function togglePasswordVisibility() {
    $('.icon-show-pass').click(function () {
        const target = $(this).data('target');
        const passwordField = $(target);
        const type = passwordField.attr('type') === 'password' ? 'text' : 'password';
        passwordField.attr('type', type);
        $(this).toggleClass('fa-eye fa-eye-slash');
    });
}

function filterUsers() {
    $(".js-select2").change(async function (e) {
        e.preventDefault();
        let url = processUrl(window.location.href, "user-type", $(this).val());
        url=convertUrlToApiUrl(url);
        await api(url, "GET", {}, handlerDataPagesResponse, true);
    });
}

function toggleUserState() {
    $(document).on("change", "input[name='state']", function () {
        $(this).attr("disabled", true);
        const userId = $(this).data('id');
        api(`${urlForm}/state-users/${userId}`, "PUT", {
            _token: $('meta[name="csrf-token"]').attr('content'),
        }, response => {
            $(this).prop('checked', response.status);
            Popup.showPopup(Popup.MessageType.SUCCESS, response.message);
        }, false);
        $(this).removeAttr("disabled");
    });
}

function toggleEmailVerification() {
    $(document).on("change", "input[name='email_verified_at']", function () {
        $(this).attr("disabled", true);
        const userId = $(this).data('id');
        api(`${urlForm}/email-verified-users/${userId}`, "PUT", {
            _token: $('meta[name="csrf-token"]').attr('content')
        }, response => {
            $(this).prop('checked', response.email_verified_at != null);
            Popup.showPopup(Popup.MessageType.SUCCESS, response.message);
        }, false);
        $(this).removeAttr("disabled");
    });
}

// دوال تعبئة البيانات في الجدول
function renderData(users, isAdd = false) {
    users = Array.isArray(users) ? users : [users.user];
    const tableBody = users.length ? users.map((user, index) => `
        <tr id='user-${user.id}'>
            <td><span>${index + 1}</span></td>
            <td id='info-user'>
                <div class="table-data__info">
                    <h6>${user.name}</h6>
                    <span><a href="mailto:${user.email}">${user.email}</a></span>
                </div>
            </td>
            <td id='role'>
                ${getUserRoleHTML(user.permissions)}
            </td>
            <td id='policies'>
                <div class="rs-select2--trans rs-select2--sm">
                    ${user.permissions.map(permission => `
                        <span class="role user mt-1" style="background-color: goldenrod;" data-policy="${permission.id}">${permission.text}</span>`).join('')}
                </div>
            </td>
            <td>
                <label class="switch">
                    <input type="checkbox" name="state" data-id="${user.id}" ${user.status ? 'checked' : ''} />
                    <span class="slider"></span>
                </label>
            </td>
            <td>
                <label class="switch">
                    <input type="checkbox" name="email_verified_at" data-id="${user.id}" ${user.email_verified_at != null ? 'checked' : ''} />
                    <span class="slider"></span>
                </label>
            </td>
            <td>
                <div class="table-data-feature">
                    <button class="item" data-toggle="tooltip" title="تعديل">
                        <i class="zmdi zmdi-edit"></i>
                    </button>
                    <button class="item" data-toggle="tooltip" title="حذف">
                        <i class="zmdi zmdi-delete"></i>
                    </button>
                </div>
            </td>
        </tr>
    `).join('') : `
        <tr id='notfound'>
            <td colspan="7">
                <h2 class="text-center">لا يوجد مستخدمين</h2>
            </td>
        </tr>`;
    if (isAdd) {
        $("table tbody").prepend(tableBody)
    } else {
        $("table tbody").html(tableBody);
    }
}

function updateElement(response) {
    const user = response.user;
    const $userRow = $(`#user-${user.id}`);
    $userRow.find('#info-user h6').text(user.name);
    $userRow.find('#info-user a').text(user.email).attr('href', `mailto:${user.email}`);
    $userRow.find('#role').html(getUserRoleHTML(user.permissions));

    let permissionsHTML = user.permissions.map(permission => `
        <span class="role user mt-1" style="background-color: goldenrod;" data-policy="${permission.id}">${permission.text}</span>`).join('');
    $userRow.find('#policies .rs-select2--trans').html(permissionsHTML);

    $userRow.find('input[name="state"]').prop('checked', user.status);
    $userRow.find('input[name="email_verified_at"]').prop('checked', user.email_verified_at != null);
}

function getUserRoleHTML(permissions) {
    console.log(permissions);
    if (permissions.length === 1 && permissions[0].id === 'manage_all') {
        return '<span class="role admin">مشرف</span>';
    }
    if (permissions.length > 1 && permissions[0].id !== 'normal_user' && permissions[0].id !== 'manage_all') {
        return '<span class="role user">مستخدم</span>';
    }
    return '<span class="role member">عضو</span>';
}


function eventEdit() {
    // إضافة حدث click على زر التعديل
    $('body').on('click', '.item[data-toggle="tooltip"][title="تعديل"]', async function () {
        const $userRow = $(this).closest('tr');
        const userId = getDataId($userRow);

        const userData = await fetchData(userId);
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
    $('#user-name').val(data.name);
    $('#user-email').val(data.email);
    let permissions = data.permissions.map(permission => permission.id);
    $('#permissions-select').val(permissions).trigger('change');

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


function renderLoading() {
    $('table.table tbody').html(`
        <tr>
            <td colspan="7">
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

// تهيئة الأحداث عند تحميل الصفحة
$(function () {
    initializeSelect2();
    togglePasswordVisibility();
    filterUsers();
    toggleUserState();
    toggleEmailVerification();
    eventEdit();
    eventDelete('المستخدم');
});
