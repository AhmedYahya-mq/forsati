let list_data_filter = [];
const list_value_filter = [
    "FF",
    "PF",
    "PE",
    "Dr",
    "Masters",
    "Bachelors"
]


function addFilterListItem() {
    $(".container-filter .list-item").click(function () {
        let val_filter = $(this).attr("data-finance") || $(this).attr("data-Educational") || null;
        let id = val_filter.split('\'').join('');
        if (id) {
            if (list_value_filter.includes(id)) {
                if (!list_data_filter.includes(id)) {
                    appendListItemFilter(id, this);
                    return;
                } else {
                    removeListItemFilter(id, this);
                    return;
                }
            }
        }
    });
}

function deleteFilterListItem() {
    $(document).on('click', ".tag-item .remove-filter", function () {
        let id_filter = $(this).parent().attr("id") || null;
        if (id_filter) {
            if (list_value_filter.includes(id_filter)) {
                removeListItemFilter(id_filter);
                return;
            } else if (specializations.some(specialization => specialization.id == id_filter)) {
                const selectedSpecialization = $('#specialization-select').val();
                const newSelection = selectedSpecialization.filter(id => id !== id_filter);
                $('#specialization-select').val(newSelection).trigger('change');
                removeListItemFilter(id_filter);
                return;
            } else if (countries.some(country => country.id === id_filter)) {
                const selectedCountries = $('#country-select').val();
                const newSelection = selectedCountries.filter(id => id !== id_filter);
                $('#country-select').val(newSelection).trigger('change');
                removeListItemFilter(id_filter);
                return;
            }

        }
    });
}


function appendListItemFilter(id, item = null) {
    list_data_filter.push(id);
    let html = `<div class="tag-item" id="${id}">
                    <span>${!(Object.prototype.toString.call(item) === '[object String]') ? $(item).text() : item}</span>
                    <i class="fa-solid fa-xmark remove-filter"></i>
                </div>`;
    $(".tags-items").prepend(html);
    if (!(Object.prototype.toString.call(item) === '[object String]'))
        $(item).addClass("selected");
    if (list_data_filter.length == 1) {
        let html = `<div class="tag-item"  onclick="resetListTagSearch();" style="cursor: pointer">
        <span>تهيئة</span>
        <i class="fa-solid fa-xmark"></i>
    </div>`;
        $(".tags-items").append(html);
    }
}

function removeListItemFilter(id, item = null) {
    if (item)
        $(item).removeClass("selected");
    else
        $(`.list-item[data-finance='${id}']`).removeClass("selected");

    list_data_filter = list_data_filter.filter(function (item_id) {
        return item_id !== id;
    });

    $(`#${id}`).remove();

    if (list_data_filter.length == 0) {
        $(".tags-items").html("");
    }
}


function resetListTagSearch() {
    $('#country-select').val(null).trigger('change');
    $('#specialization-select').val(null).trigger('change');
    $(".tags-items").html("");
    $(".list-item").removeClass("selected");
    list_data_filter = [];
}

$(document).ready(function () {
    buttonFilterShow();
    addFilterListItem();
    deleteFilterListItem();
});