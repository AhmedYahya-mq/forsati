$(document).ready(function () {


    function formatSpecialization(specialization) {
        if (!specialization.id) return specialization.text;

        return $(
            `<span dir="ltr"><span>${specialization.text}</span></span>`
        );
    }


    let flag_append = true;
    if (window.innerWidth <= 600) {
        $(".container-filter").detach().prependTo(".box_show_filter .filtters-box");
        flag_append = false;
    }


    $(window).resize(function () {
        if (!flag_append) {
            if (window.innerWidth > 600) {
                $(".box_show_filter").hide();
                $(".container-filter").detach().prependTo(".nav-filter");
                flag_append = true;
            }
        }
        if (flag_append) {
            if (window.innerWidth <= 600) {
                $(".container-filter").detach().prependTo(".box_show_filter .filtters-box");
                flag_append = false;
            }
        }
    });

    function formatCountry(country) {
        if (!country.id) return country.text;

        return $(
            `<span ><img src="${country.flag}" class="flag-icon" /> <span>${country.text}</span></span>`
        );
    }

    $('#country-select').select2({
        data: countries,
        placeholder: "اختر دولة",
        allowClear: true,
        closeOnSelect: false,
        templateResult: formatCountry,
        templateSelection: formatCountry

    });

    
    $('#specialization-select').select2({
        data: specializations, // إضافة خيار فارغ
        placeholder: "اختر التخصصات",
        allowClear: true,
        closeOnSelect: false,
        templateResult: formatSpecialization,
        templateSelection: formatSpecialization
    });

    $('.select2-search__field').attr("dir", (lang === "en") ? "ltr" : "rtl");
    $('.select2-search__field').attr("placeholder", (lang === "en") ? "Choose Country" : "أختر الدولة");
    $('.select2-search__field').eq(1).attr("placeholder", (lang === "en") ? "Choose Specializations" : "أختر التخصصات");


    $('#country-select').on('select2:select', function (e) {
        const selectedOption = e.params.data;
        appendListItemFilter(selectedOption.id, selectedOption.text);
    });

    $('#country-select,#country-select-nav').on('select2:unselect', function (e) {
        const selectedOption = e.params.data;
        removeListItemFilter(selectedOption.id);
    });

    $('#specialization-select').on('select2:select', function (e) {
        const selectedOption = e.params.data;
        appendListItemFilter(selectedOption.id, selectedOption.text);
    });

    $('#specialization-select,#specialization-select-nav').on('select2:unselect', function (e) {
        const selectedOption = e.params.data;
        removeListItemFilter(selectedOption.id);
    });
});