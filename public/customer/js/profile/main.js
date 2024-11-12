
const old_image = $(".image-profile img").attr('src');

// تهيئة وضع التطبيق (ليلي أو نهاري) بناءً على localStorage أو إعدادات النظام
function instanceMode() {
    const savedMode = localStorage.getItem("mode");

    if (savedMode) {
        // إذا كان هناك وضع مخزن في localStorage، يتم تطبيقه مباشرة
        savedMode === "dark" ? activateDarkMode() : activateLightMode();
        $("#switch").attr("checked", savedMode === "dark");
    } else {
        // إذا لم يكن هناك وضع مخزن، نعتمد على إعدادات النظام
        if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
            activateDarkMode();
        } else {
            activateLightMode();
        }
    }

    // الاستماع لتغييرات إعدادات النظام وتحديث الوضع تلقائيًا
    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
        if (e.matches) {
            activateDarkMode();
            localStorage.setItem("mode", "dark");
        } else {
            activateLightMode();
            localStorage.setItem("mode", "light");
        }
    });
}

// وظيفة للتبديل بين الوضعين عند النقر على زر التبديل
function changeMode() {
    $("#switch").change(function () {
        if ($(".bg-v-dark").hasClass("active")) {
            activateLightMode();
            localStorage.setItem("mode", "light");
        } else {
            activateDarkMode();
            localStorage.setItem("mode", "dark");
        }
    });
}

// تطبيق الوضع الداكن
function activateDarkMode() {
    $("html").addClass("dark");
    $("html").removeClass("light");
    $("header .mode .fas").removeClass("fa-moon").addClass("fa-sun");
    $(".bg-v-dark").addClass("active");
    $(".container-base,header,.box-loader,main,body").addClass("dark");
    $("#js-pagition").find(
        "a, span[aria-current='page'] span, span[aria-disabled='true'] span, span.relative.inline-flex.items-center.px-4.py-2.text-sm.font-medium.text-gray-500.bg-white.border.border-gray-300.cursor-default.leading-5.rounded-md"
    ).addClass("dark:bg-gray-800 dark:border-gray-600");
}

// تطبيق الوضع الفاتح
function activateLightMode() {
    $("html").removeClass("dark");
    $("html").addClass("light");
    $("header .mode .fas").removeClass("fa-sun").addClass("fa-moon");
    $(".bg-v-dark").removeClass("active");
    $(".container-base,header,.box-loader,main,body").removeClass("dark");
    $("#js-pagition").find(
        "a, span[aria-current='page'] span, span[aria-disabled='true'] span, span.relative.inline-flex.items-center.px-4.py-2.text-sm.font-medium.text-gray-500.bg-white.border.border-gray-300.cursor-default.leading-5.rounded-md"
    ).removeClass("dark:bg-gray-800 dark:border-gray-600");
}

// دالة لتنسيق الدول
function formatCountry(country) {
    var flagUrl = $(country.element).data('flag');
    var $country = $(
        (flagUrl == undefined) ? '<span style="display: flex;align-items: center;">' + country.text +
        '</span>' :
        '<span style="display: flex;align-items: center;"><img src="' + flagUrl +
        '" class="flag-icon"/><spn>' + country.text + '</spn></span>'
    );
    return $country;
}


// دالة إعداد Select2 للدول
function instanceCountries() {
    $('#country-select').select2({
        width: '100%',
        placeholder: $('#country-select').attr('placeholder'),
        closeOnSelect: false,
        templateResult: formatCountry,
        templateSelection: formatCountry,
        dir: $('#country-select').attr('dir'),
    });
}

// أضهار شاشة التحميل او اخفائة
function loaderBase(isShow, timeout = 0) {
    if (isShow) {
        $(".box-loader").show();
        return;
    }
    setTimeout(function () {
        $(".box-loader").hide()
    }, timeout);
}


// دالة لتحديث الوقت في العنصر
let lastMinute = -1; // لتخزين الدقيقة السابقة
let lastSecond = -1; // لتخزين الثانية السابقة

function updateTime() {
    // الحصول على المنطقة الزمنية للمستخدم
    let userTimezone = Intl.DateTimeFormat().resolvedOptions().timeZone;

    // الحصول على الوقت بتنسيق 12 ساعة مع AM/PM بناءً على المنطقة الزمنية
    let currentDate = new Date();
    let currentMinute = currentDate.getMinutes(); // الحصول على الدقيقة الحالية
    let currentSecond = currentDate.getSeconds(); // الحصول على الثانية الحالية

    // تحديث الوقت فقط إذا تغيرت الدقيقة أو الثانية
    if (currentMinute !== lastMinute || currentSecond !== lastSecond) {
        let timeWithTimezone = new Intl.DateTimeFormat('en-US', {
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit', // إضافة الثواني
            hour12: true,
            timeZone: userTimezone
        }).format(currentDate);

        // تحديث العنصر الذي يحتوي على الكلاس "time"
        document.querySelector('.time').textContent = timeWithTimezone;

        // تحديث الدقيقة والثانية السابقة
        lastMinute = currentMinute;
        lastSecond = currentSecond;
    }
}


// دالة للحصول على حالة البطارية
function updateBatteryStatus() {
    if (navigator.getBattery) {
        navigator.getBattery().then(function (battery) {
            // الحصول على مستوى الشحن كنسبة مئوية
            let batteryLevel = Math.round(battery.level * 100); // تحويله إلى نسبة مئوية
            let chargingStatus = battery.charging ? "Charging" : "Not charging";

            // عرض مستوى الشحن وحالة الشحن في وحدة التحكم
            console.log("Battery level: " + batteryLevel + "%");
            console.log("Charging status: " + chargingStatus);

            if (!battery.charging) {
                $("i.fa-bolt").hide();
            } else {
                $("i.fa-bolt").show();
            }
            let backgroundColor = '';

            // تحديد اللون بناءً على نسبة البطارية
            if (batteryLevel <= 25) {
                backgroundColor = 'var(--red)';
            } else if (batteryLevel <= 50) {
                backgroundColor = 'var(--orange)';
            } else if (batteryLevel <= 75) {
                backgroundColor = 'var(--yellow)';
            } else {
                backgroundColor = 'var(--green)';
            }
            $(".charge").height(batteryLevel + "%");
            $(".charge").css('background-color', backgroundColor);
            // تحديث العنصر الذي يحتوي على الكلاس "battery-status" لعرض حالة البطارية
            $(".precent-battery").text(batteryLevel + "%");
        });
    } else {
        console.log("Battery Status API is not supported by this browser.");
    }
}


function initUploadFile() {
    $('.account-settings-fileinput').change(function (e) {
        let file = e.target.files[0];
        const maxSize = 800 * 1024;
        if (file && file.size <= maxSize) {
            // عرض الصورة محلياً باستخدام FileReader
            let reader = new FileReader();
            reader.onload = function (event) {
                $(".image-profile img").attr("src", event.target.result);
            };
            reader.readAsDataURL(file);
            $(".image-profile .three-body").show();
            let formData = new FormData();
            formData.append('image', file);
            const url = new URL(window.location.href);
            url.pathname = `/api${url.pathname}/upload-image-temp`;
            $.ajax({
                url: url.href,
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    $(".image-profile .three-body").hide();
                    $(".image-profile .button").show();
                    $('#user #image').val(response.path);

                },
                error: function (xhr, status, error) {
                    $(".image-profile img").attr("src", old_image);
                    Popup.showPopup(Popup.MessageType.ERROR, 'حدث خطأ أثناء رفع الصورة:' + error, 'body');
                }
            });
        } else if (file) {
            Popup.showPopup(Popup.MessageType.ALERT, 'حجم الصورة يتجاوز الحد المسموح به (800 كيلوبايت)', "body");

        }
    });

    $(".image-profile .button").click(function () {
        const url = new URL(window.location.href);
        url.pathname = `/api${url.pathname}/delete-temp-image`;
        $.ajax({
            url: url.href,
            type: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            data: {
                "path": $('#user #image').val()
            },
            success: function (response) {
                $(".image-profile img").attr("src", old_image);
                $(".image-profile .button").hide();
                $('#user #image').val('');
            },
            error: function (xhr, status, error) {
                Popup.showPopup(Popup.MessageType.ERROR, 'حدث خطأ أثناء حذف الصورة:' + error, 'body');
            }
        });
    });
}

$(function () {
    initUploadFile();
    instanceCountries();
    instanceMode();
    changeMode();
    loaderBase(false, 500);
    updateTime();
    setInterval(updateTime, 1000);

    updateBatteryStatus();

    setInterval(updateBatteryStatus, 1000);

    document.getElementById('language-select').addEventListener('change', function () {
        const selectedLanguage = this.value; // الحصول على اللغة المختارة

        // تحديد الـ URL الجديد مع اللغة المختارة
        const newUrl = '/lang/' + selectedLanguage;

        // إعادة توجيه المستخدم إلى الـ URL الجديد
        window.location.href = newUrl;
    });

    $(".close-icon-p").click(function(){

        $(this).parent().parent().hide(500);
        $(this).parent().parent().remove(500);
    })

});
