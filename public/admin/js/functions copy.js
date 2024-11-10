// -------------تهيئة مربع البحث------------------------
function instansSearch() {
    eventInputSearch();
    eventKeyprss();
    clickSearch();
}

// حدث عند ضغط على كيبورد في مربع البحث
function eventKeyprss(params) {
    $("#search").on('keypress', async (event) => {
        if (event.key === 'Enter') {
            await search();
        }
    });
}

// البحث
async function search() {
    const query = $("#search").val().trim();
    if (query) {
        let url = window.location.href;
        if (url.indexOf('/api/') === -1) {
            // استخدم تعبير منتظم لإضافة '/api/' بعد اسم النطاق
            url = url.replace(/^(http|https):\/\/([^\s/]+)\//, '$1://$2/api/');
        }

        url = processUrl(url, "search", query);
        await api(url, "GET", {}, handlerDataPagesResponse);
    }
}

// حدث الادخال في مربع البحث
function eventInputSearch() {
    $("#search").on('input', async () => {
        const query = $("#search").val().trim();
        if (!query) {
            let url = window.location.href;
            // Check if 'api' is not already in the URL
            if (url.indexOf('/api/') === -1) {
                // استخدم تعبير منتظم لإضافة '/api/' بعد اسم النطاق
                url = url.replace(/^(http|https):\/\/([^\s/]+)\//, '$1://$2/api/');
            }
            url = processUrl(url, "search", query);
            await api(url, "GET", {}, handlerDataPagesResponse);
        }
    });
}

//  حدث عند صغط على زرار البحث
function clickSearch() {
    // حدث البحث
    $("#btn-search").on('click', async function (e) {
        e.preventDefault();
        await search();
    });
}
// ------------end instans search-----------------


//  تهيئة تنقل بين صفحات

function instansTranslatePagitions() {
    $("p.text-sm.text-gray-700.leading-5").parent("div").remove();
    clickBtnPage();
}

// حدث ضغط على زرار صفحة
// حدث ضغط على زرار صفحة
function clickBtnPage() {
    $(document).on("click", "a.relative.inline-flex.items-center", async function (e) {
        e.preventDefault();
        let url = getPageUrl(this);
        if (!url) return;
        if (url.indexOf('/api/') === -1) {
            // استخدم تعبير منتظم لإضافة '/api/' بعد اسم النطاق
            url = url.replace(/^(http|https):\/\/([^\s/]+)\//, '$1://$2/api/');
        }
        $("a.relative.inline-flex.items-center").attr('disabled', 'disabled');

        url = hundlerUrl(url);
        await api(url, "GET", {}, handlerDataPagesResponse);
    });
}


// وظيفة لجلب رابط الصفحة الحالي وتحديثه بمعلمة الصفحة المطلوبة
function getPageUrl(element) {
    let url = new URL($(element).attr("href"));
    let currentUrl = new URL(window.location.href);

    // تحديث رابط الصفحة الحالي مع الحفاظ على المعلمات
    currentUrl.searchParams.delete("page");
    currentUrl.searchParams.append("page", url.searchParams.get("page"));

    return currentUrl.href;
}


function hundlerUrl(url) {
    // التحقق من أن العنصر موجود وقيمته ليست فارغة
    if ($(".js-select2").length && $(".js-select2").val().trim() !== "" && $(".js-select2").val().trim() !== "__ALL__") {
        let user_type = $(".js-select2").val();
        url = processUrl(url, "user_type", user_type, false);
    }

    // التحقق من أن العنصر موجود وقيمته ليست فارغة
    if ($("#search").length && $("#search").val().trim() !== "") {
        const query = $("#search").val().trim();
        url = processUrl(url, "search", query, false);
    }
    return url;
}


// معالجة رابط
function processUrl(url, nameParam, valueParam, canDelPage = true, deleteParam = "page") {
    let currentUrl = new URL(url);
    if (currentUrl.searchParams.has(deleteParam) && canDelPage) {
        currentUrl.searchParams.delete(deleteParam);
    }

    if (currentUrl.searchParams.has(nameParam)) {
        currentUrl.searchParams.set(nameParam, valueParam || "");
    } else {
        currentUrl.searchParams.append(nameParam, valueParam || "");
    }
    return currentUrl.href;
}

// -----------------تجهيز قائمة تنقل بين صفحات------------
function instansPagitions() {
    $("#js-pagition").html(`
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between">
        <div class="flex justify-between flex-1 sm:hidden"></div>
        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <div>
                <span class="relative z-0 inline-flex rtl:flex-row-reverse shadow-sm rounded-md">
                </span>
            </div>
        </div>
    </nav>
    `);
}


function renderPagetionButton(meta) {
    renderButtonPervious(meta.previous_page);
    renderButtonNext(meta.next_page);
}

function renderButtonNext(next_page) {
    if (next_page !== null) {
        $("div.flex.justify-between.flex-1").append(`
            <a href="${next_page}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 dark:focus:border-blue-700 dark:active:bg-gray-700 dark:active:text-gray-300">
                التالي »
            </a>
            `)
    } else {
        $("div.flex.justify-between.flex-1").append(`
            <span class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-md dark:text-gray-600 dark:bg-gray-800 dark:border-gray-600">
                التالي »
            </span>
            `);
    }

}

function renderButtonPervious(previous_page) {
    if (previous_page !== null) {
        $("div.flex.justify-between.flex-1").prepend(`
            <a href="${previous_page}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 dark:focus:border-blue-700 dark:active:bg-gray-700 dark:active:text-gray-300">
                « السابق
            </a>
            `);
    } else {
        $("div.flex.justify-between.flex-1").prepend(`
            <span class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-md dark:text-gray-600 dark:bg-gray-800 dark:border-gray-600">
                « السابق
            </span>
            `);
    }

}


function renderListPagetion(links) {
    let itritor = 0;
    links.forEach(link => {
        if (itritor !== 0 && itritor !== links.length - 1 && itritor !== links.length - 2) {
            listButtonPagetion(link);
        }
        if (itritor === 0) {
            if (link.url) {
                $('span.relative.z-0.inline-flex.shadow-sm.rounded-md').append(`
                    <a href="${link.url}" rel="prev" class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-l-md leading-5 hover:text-gray-400 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150 dark:bg-gray-800 dark:border-gray-600 dark:active:bg-gray-700 dark:focus:border-blue-800" aria-label="${link.label}">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                    </a>
                `);
            } else {
                $('span.relative.z-0.inline-flex.shadow-sm.rounded-md').append(`
                    <span aria-disabled="true" aria-label="${link.label}">
                        <span class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-l-md leading-5 dark:bg-gray-800 dark:border-gray-600" aria-hidden="true">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        </span>
                    </span>
                `);
            }
        }
        if (itritor === links.length - 2) {
            if (link.url) {
                $('span.relative.z-0.inline-flex.shadow-sm.rounded-md').append(`
                    <a href="${link.url}" rel="prev" class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-r-md leading-5 hover:text-gray-400 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150 dark:bg-gray-800 dark:border-gray-600 dark:active:bg-gray-700 dark:focus:border-blue-800" aria-label="${link.label}">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                    </a>
                `);
            } else {
                $('span.relative.z-0.inline-flex.shadow-sm.rounded-md').append(`
                    <span aria-disabled="true" aria-label="${link.label}">
                        <span class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-r-md leading-5 dark:bg-gray-800 dark:border-gray-600" aria-hidden="true">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        </span>
                    </span>
                `);
            }
        }
        itritor++;

    });
}

function listButtonPagetion(link) {

    if (!link.active) {
        $('span.relative.z-0.inline-flex.shadow-sm.rounded-md').append(`
                <a href="${link.url}" class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 hover:text-gray-500 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400 dark:hover:text-gray-300 dark:active:bg-gray-700 dark:focus:border-blue-800" aria-label="Go to page 2">
                    ${link.label}
                </a>
            `);
    } else {
        $('span.relative.z-0.inline-flex.shadow-sm.rounded-md').append(`
                <span aria-current="page">
                    <span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 dark:bg-gray-800 dark:border-gray-600">
                        ${link.label}
                    </span>
                </span>
            `);
    }
}
// دالة لإنشاء Loader بناءً على نوع الطلب
function loader(text) {
    let $element = $("body").prepend(`
        <div class="container-loader" id="container-loader">
            <div id="wifi-loader">
                <svg class="circle-outer" viewBox="0 0 86 86">
                    <circle class="back" cx="43" cy="43" r="40"></circle>
                    <circle class="front" cx="43" cy="43" r="40"></circle>
                    <circle class="new" cx="43" cy="43" r="40"></circle>
                </svg>
                <svg class="circle-middle" viewBox="0 0 60 60">
                    <circle class="back" cx="30" cy="30" r="27"></circle>
                    <circle class="front" cx="30" cy="30" r="27"></circle>
                </svg>
                <svg class="circle-inner" viewBox="0 0 34 34">
                    <circle class="back" cx="17" cy="17" r="14"></circle>
                    <circle class="front" cx="17" cy="17" r="14"></circle>
                </svg>
                <div class="text" dir="rtl" data-text="${text}..."></div>
            </div>
        </div>
    `);
    return $element.find("#container-loader");
}

// دالة لإظهار الرسائل بناءً على نوع الطلب

function getLoaderMessage(method) {
    const messages = {
        'get': 'جارٍ تحميل البيانات',
        'post': 'جارٍ إضافة البيانات',
        'put': 'جارٍ تحديث البيانات',
        'patch': 'جارٍ تعديل البيانات',
        'delete': 'جارٍ حذف البيانات',
    };
    return messages[method.toLowerCase()] || 'جاري التحميل';
}

// دالة عامة للتعامل مع الأخطاء
function handleError(jqXHR, textStatus, errorThrown) {
    let message = 'حدث خطأ غير معروف.';
    if (jqXHR.responseJSON && jqXHR.responseJSON.message) {
        message = jqXHR.responseJSON.message;
    } else if (textStatus === 'timeout') {
        message = "طلبك استغرق وقتًا طويلاً ولم يتم استلام الاستجابة.";
    } else if (textStatus === 'abort') {
        message = "تم إلغاء الطلب.";
    } else {
        message = "حدث خطأ غير معروف: " + errorThrown;
    }
    Popup.showPopup(Popup.MessageType.ERROR, message);
    return message;
}

// دالة للتعامل مع API
function api(url, method = "GET", data = {}, handleResponse = (response) => {}, isChangeUrl = true, processData = true, contentType = "application/json") {
    let $loader = null;
    if (typeof renderLoading === "function" && method === "GET" && isChangeUrl) {
        renderLoading();
    }
    if (method === "GET" && !isChangeUrl) {
        $loader = loader(getLoaderMessage(method));
    }

    if (["POST", "PUT", "PATCH", "DELETE"].includes(method.toUpperCase())) {
        $loader = loader(getLoaderMessage(method));
    }

    return new Promise((resolve, reject) => {
        $.ajax({
            url: url,
            type: method,
            data: data,
            processData: processData,
            contentType: contentType,
            success: function (response) {
                handleResponse(response);
                changeUrl(url, isChangeUrl);
                if ($loader) $loader.remove();
                resolve();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                if (jqXHR.responseJSON && jqXHR.responseJSON.errors) {
                    let delay = 0;
                    Object.keys(jqXHR.responseJSON.errors).forEach((field) => {
                        jqXHR.responseJSON.errors[field].forEach((error) => {
                            setTimeout(() => {
                                Popup.showPopup(Popup.MessageType.ERROR, error);
                            }, delay);
                            delay += 1000;
                        });
                    });
                } else {
                    handleError(jqXHR, textStatus, errorThrown);
                }
                if ($loader) $loader.remove();
            }
        });
    });
}

function changeUrl(url, isChange = true) {
    if (isChange && url.indexOf('/api/') !== -1) {
        url = url.replace(/\/api\//, '/');
        window.history.pushState(null, null, url);
        return;
    }
    if (isChange && url.indexOf('/api/') === -1) {
        window.history.pushState(null, null, url);
        return;
    }
}

// ------------نهاية دوال تعامل مع api-----------

function handlerDataPagesResponse(response) {
    const data = response.data;
    const meta = response.meta;
    renderData(data);
    $("#show-pages").html(`عرض ${meta.from || 0} إلى ${meta.to || 0} من ${meta.total[0]} نتائج`);
    instansPagitions();
    renderPagetionButton(meta);
    renderListPagetion(meta.links);
}

function insatnsServerSelect2() {
    return {
        process: {
            url: `${urlForm}/upload-image-temp`,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            onload: (response) => {
                const data = JSON.parse(response);
                temp_image = data.path;
                console.log('Image uploaded:', temp_image);
                return temp_image;
            },
            onerror: (jqXHR, textStatus, errorThrown) => {
                let message = 'حدث خطأ غير معروف.';

                if (jqXHR.responseJSON && jqXHR.responseJSON.message) {
                    message = jqXHR.responseJSON.message; // استخدم رسالة الخطأ من الاستجابة
                } else if (textStatus === 'timeout') {
                    message = "طلبك استغرق وقتًا طويلاً ولم يتم استلام الاستجابة."; // رسالة خاصة للوقت المستغرق
                } else if (textStatus === 'abort') {
                    message = "تم إلغاء الطلب."; // رسالة خاصة للإلغاء
                } else {
                    message = "حدث خطأ غير معروف: " + errorThrown; // رسالة عامة للخطأ
                }

                Popup.showPopup(Popup.MessageType.ERROR, message); // عرض رسالة الخطأ
                return message;
            }
        },
        revert: {
            url: `${urlForm}/delete-temp-image`,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            onload: (response) => {
                const data = JSON.parse(response);
                console.log('Image deleted:', data.status);
                return data.status ? null : data.error; // إرجاع الخطأ إذا حدث
            },
            onerror: (jqXHR, textStatus, errorThrown) => {
                let message = 'حدث خطأ غير معروف.';

                if (jqXHR.responseJSON && jqXHR.responseJSON.message) {
                    message = jqXHR.responseJSON.message; // استخدم رسالة الخطأ من الاستجابة
                } else if (textStatus === 'timeout') {
                    message = "طلبك استغرق وقتًا طويلاً ولم يتم استلام الاستجابة."; // رسالة خاصة للوقت المستغرق
                } else if (textStatus === 'abort') {
                    message = "تم إلغاء الطلب."; // رسالة خاصة للإلغاء
                } else {
                    message = "حدث خطأ غير معروف: " + errorThrown; // رسالة عامة للخطأ
                }

                Popup.showPopup(Popup.MessageType.ERROR, message); // عرض رسالة الخطأ
                return message;
            }
        }
    }
}
// ملف app.js أو main.js
$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    instansSearch();
    instansTranslatePagitions();
});
