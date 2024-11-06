const list_value_filter = ["full", "partial", "private", "1", "2", "3", "4", "5"];
let list_data_filter = {};

// إضافة معالجات select2
function initializeSelect2() {
    $('#specialization-select-filter').select2();
    $('#country-select-filter').select2();
}

// معالجة اختيار عناصر الفلاتر
function handleSelectFilter(keyFilter, id, item = null, isSearch = true) {
    appendListItemFilter(id, keyFilter, item, isSearch);
}

// إضافة عنصر إلى الفلاتر
function addFilterListItem() {
    $(".container-filter .list-item").click(function () {
        let val_filter = $(this).attr("data-finance") || $(this).attr("data-Educational") || null;
        if (!val_filter) return;

        let keyFilter = $(this).attr("data-finance") ? "funding_types" :
                        $(this).attr("data-Educational") ? "degree_levels" : "search";

        let id = val_filter.replace(/'/g, '');
        if (id && list_value_filter.includes(id)) {
            list_data_filter[keyFilter]?.includes(id) ?
                removeListItemFilter(id, keyFilter, this) :
                handleSelectFilter(keyFilter, id, this);
        }
    });
}

// إزالة عنصر من الفلاتر
function deleteFilterListItem() {
    $(document).on('click', ".tag-item .remove-filter", function () {
        let id_filter = $(this).parent().attr("id") || null;
        let key_filter = $(this).parent().data("key") || null;

        if (!id_filter || !key_filter) return;

        if (key_filter === "funding_types" || key_filter === "degree_levels") {
            removeListItemFilter(id_filter, key_filter);
        } else if (key_filter === "specialization") {
            updateSelectFilter('#specialization-select-filter', id_filter, key_filter);
        } else if (key_filter === "country") {
            updateSelectFilter('#country-select-filter', id_filter, key_filter);
        }
    });
}

// تحديث الفلتر select2
function updateSelectFilter(selectId, id_filter, key_filter) {
    const selectedItems = $(selectId).val();
    const newSelection = selectedItems.filter(id => id !== id_filter);
    $(selectId).val(newSelection).trigger('change');
    removeListItemFilter(id_filter, key_filter);
}

// إضافة عنصر إلى قائمة الفلاتر
function appendListItemFilter(id, key, item = null, isSearch = true) {
    list_data_filter[key] = list_data_filter[key] || [];
    list_data_filter[key].push(id);

    const html = `
        <div class="tag-item" id="${id}" data-key="${key}">
            <span>${!(typeof item === 'string') ? $(item).text() : item}</span>
            <i class="fas fa-times remove-filter"></i>
        </div>`;
    $(".tags-items").prepend(html);

    if (!(typeof item === 'string')) {
        $(item).addClass("selected");
    }

    if (Object.keys(list_data_filter).length === 1 && $(".js-reset").length === 0) {
        $(".tags-items").append(`
            <div class="tag-item js-reset" onclick="resetListTagSearch();" style="cursor: pointer">
                <span>تهيئة</span>
                <i class="fas fa-times"></i>
            </div>`);
    }

    if (isSearch) {
        getDataFilter();
    }
}

// إزالة عنصر من قائمة الفلاتر
function removeListItemFilter(id, keyFilter, item = null) {
    list_data_filter[keyFilter] = list_data_filter[keyFilter]?.filter(item_id => item_id !== id);
    if (!list_data_filter[keyFilter]?.length) delete list_data_filter[keyFilter];

    $(`#${id}`).remove();
    if (!Object.keys(list_data_filter).length) $(".tags-items").html("");
    item ? $(item).removeClass("selected") : $(`.list-item[data-finance='${id}'], .list-item[data-Educational='${id}']`).removeClass("selected");
    removeParamsFromUrl([keyFilter], id);
}

// تحديث الرابط مع المعلمات الجديدة
function updateUrlWithParams(url, data = {}) {
    const urlObj = new URL(url);
    if (urlObj.searchParams.has("page")) {
        urlObj.searchParams.delete("page");
    }
    Object.keys(data).forEach(key => {
        urlObj.searchParams.delete(`${key}[]`);
        data[key].forEach(value => urlObj.searchParams.append(`${key}[]`, value));
    });
    return urlObj.href;
}

// إعادة تهيئة الفلاتر
function resetListTagSearch() {
    $('#country-select-filter, #specialization-select-filter').val(null).trigger('change');
    $(".tags-items").html("");
    $(".list-item").removeClass("selected");
    const keys = Object.keys(list_data_filter);
    list_data_filter = {};
    removeParamsFromUrl(keys);
}

// جلب البيانات بناءً على الفلاتر
async function getDataFilter() {
    let url = window.location.href.replace(/^(http|https):\/\/([^\s/]+)\//, '$1://$2/api/');
    url = updateUrlWithParams(url, list_data_filter);
    await api(url, "GET", list_data_filter || {}, handlerDataPagesResponse);
}

// دالة إزالة المعلمات من الرابط
async function removeParamsFromUrl(keys, value = '') {
    let url = window.location.href;
    const urlObj = new URL(url);

    keys.forEach(key => {
        if (value !== '') {
            const values = urlObj.searchParams.getAll(`${key}[]`);
            const newValues = values.filter(val => val !== value);
            urlObj.searchParams.delete(`${key}[]`);
            newValues.forEach(value => urlObj.searchParams.append(`${key}[]`, value));
        } else {
            urlObj.searchParams.delete(`${key}[]`);
        }
    });

    url = urlObj.href;
    window.history.pushState(null, null, url);

    if (url.indexOf('/api/') === -1) {
        url = url.replace(/^(http|https):\/\/([^\s/]+)\//, '$1://$2/api/');
    }

    await api(url, "GET", {}, handlerDataPagesResponse);
}

// تنفيذ عند تحميل الصفحة
$(document).ready(function () {
    initializeSelect2();
    addFilterListItem();
    deleteFilterListItem();

    // إضافة العناصر المختارة مسبقاً إلى الفلاتر
    instansMenuFilter();
});

function instansMenuFilter() {
    $.each($("#specialization-select-filter, #country-select-filter"), function (indexInArray, valueOfElement) {
        $(valueOfElement).select2('data').forEach(selectedItem => {
            appendListItemFilter(selectedItem.id, $(selectedItem.element).attr("name"), selectedItem.text, false);
        });
    });

    $(".container-filter .selected").each(function () {
        let val_filter = $(this).attr("data-finance") || $(this).attr("data-Educational") || null;
        if (val_filter) {
            let keyFilter = $(this).attr("data-finance") ? "funding_types" : "degree_levels";
            appendListItemFilter(val_filter, keyFilter, this, false);
        }
    });
}

