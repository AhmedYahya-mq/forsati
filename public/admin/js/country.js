// إعداد الفلاتر للدول والتخصصات
function setupSelect2Filter(selector, type) {
    $(selector).on('select2:select', function (e) {
        const selectedOption = e.params.data;
        appendListItemFilter(selectedOption.id, type, selectedOption.text);
    });

    $(selector).on('select2:unselect', function (e) {
        const selectedOption = e.params.data;
        removeListItemFilter(selectedOption.id, type);
    });
}

// دالة لإدارة عرض وإخفاء الفلتر
function toggleFilterBox(event) {
    event.stopPropagation();
    $(".box_show_filter").toggle();
}

// إخفاء الفلتر عند النقر في أي مكان آخر
function hideFilterBox(event) {
    if (!$(event.target).closest('.box_show_filter').length && !$(event.target).closest('.filter_button').length) {
        $('.box_show_filter').hide();
    }
}

// أحداث الجافا سكريبت
$(function () {
    setupSelect2Filter('#country-select-filter', 'country');
    setupSelect2Filter('#specialization-select-filter', 'specialization');

    $(".filter_button").click(toggleFilterBox);
    $(document).click(hideFilterBox);
    $(".box_show_filter").click(function (event) {
        event.stopPropagation(); // منع النقر داخل القائمة من إغلاقها
    });

    // للتأكد من أن القائمة لا تختفي عند النقر داخل select2
    $(document).on('click', '.select2-container', function (event) {
        event.stopPropagation();
    });
});
