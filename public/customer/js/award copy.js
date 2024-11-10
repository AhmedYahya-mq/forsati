// دالة تعبئة البيانات في الجدول باستخدام jQuery
function renderData(scholarships) {
    let scholarshipsHtml = '';
    if (scholarships.length > 0) {
        scholarships.forEach((scholarship) => {
            const {
                id,
                image,
                title,
                slug,
                description,
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
                            <img src="${image}" title="${title}" alt="${title}" loading="lazy">
                            <div class="types">
                                ${specializationsHtml}
                                ${degreeLevelsHtml}
                                <span class="project-type">• ${countryText}</span>
                                <span class="project-type">• ${fundingTypeText}</span>
                            </div>
                        </div>
                        <a href="${slug}" class="award-link">
                            <div class="head-info">
                                <span>${document.documentElement.lang !== "en"? "مشاهدة" : "Watch"}: ${visits}</span>
                                <span>${document.documentElement.lang !== "en"? "تاريخ النشر" : "Published Date"} ${created_at}</span>
                            </div>
                            <p class="card-title">${title}</p>
                            <p class="card-body">${description}</p>
                            <p class="footer">${document.documentElement.lang !== "en"? "الموعد النهائي للتسجيل" : "Registration Deadline :"} <span class="date">${deadline}</span></p>
                        </a>
                    </div>
                </div>
            `;
        });
    } else {
        scholarshipsHtml = `
            <tr id='notfound'>
                <td colspan="7">
                    <h2 class="text-center">${document.documentElement.lang !== "en"? "لا توجد منح" : "Not found Scholarships"}</h2>
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
    $('#country-select-filter').select2({
        width: '100%',
        placeholder: $('#country-select-filter').attr('placeholder'),
        closeOnSelect: false,
        templateResult: formatCountry,
        templateSelection: formatCountry,
        dir: "rtl"
    });
}

function instanceSpecialization() {
    $('#specialization-select-filter').select2({
        width: '100%',
        placeholder: $('#specialization-select-filter').attr('placeholder'),
        closeOnSelect: false,
        dir: "rtl"
    });
}

let isTransfer = false; // تعريف المتغير خارج الدالة ليتم الاحتفاظ بحالته

function transferContentBasedOnScreenWidth() {
    const $navFilter = $('.filtters-box');
    const $boxShowFilter = $('.box_show_filter .box_filter_m');

    // شرط إذا كان عرض الشاشة أقل من أو يساوي 800px ولم يتم نقل العنصر بالفعل
    if ($(window).width() <= 800 && $boxShowFilter.children('.filtters-box').length === 0) {
        $boxShowFilter.append($navFilter);
        isTransfer = true; // تحديث الحالة
    }
    // شرط إذا كان عرض الشاشة أكبر من 800px ولم يتم إعادة العنصر إلى مكانه الأصلي
    else if ($(window).width() > 800 && $('.top-title.filter-title').next('.filtters-box').length === 0) {
        $('.box_show_filter').hide();
        $navFilter.insertAfter($('.top-title.filter-title'));
        isTransfer = false; // تحديث الحالة
    }
}

// الإعدادات المبدئية
$(document).ready(function () {
    $(window).resize(transferContentBasedOnScreenWidth);
    transferContentBasedOnScreenWidth();
    instanceCountries();
    instanceSpecialization();
});
