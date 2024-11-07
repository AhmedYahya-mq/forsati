let lang = "ar";
let indexItemMenuActive = 0;
let activeMenuItem = "";

// انميشن الاسكرول
// function revealFunc() {
//     window.sr = ScrollReveal({
//         distance: "150px",
//         duration: 1350,
//         easing: "ease-out",
//         delay: 200,
//     });

//     sr.reveal('.reveal-top', {
//         origin: "top",
//     });
//     sr.reveal('.reveal-left', {
//         origin: "left",
//     });
//     sr.reveal('.reveal-right', {
//         origin: "right",
//     });
//     sr.reveal('.reveal-bottom', {
//         origin: "bottom",
//     });
// }

// تهيئة التطبيق
function instnceApp() {
    // instnceLang();
    instanceMode();
}

// تهيئة التطبيق للغة الافتراضيه من تخزين
function instnceLang() {
    lang = localStorage.getItem('lang') || getUserLanguage();
    if (lang === 'en') {
        $("header,main").each(function () {
            $(this).toggleClass("en");
        });
    }
    $('[data-lang]').each(function () {
        const key = $(this).data('lang');
        $(this).html(language[lang][key]);
    });
}




// حدث تغيير حجم شاشه
function resizeScreen() {
    $(window).resize(function () {
        menuActiveEditeResize();
    });
}

// تعديل القائمة نشطة بحسب عرض شاشة
function menuActiveEditeResize() {
    let li = $(".menu-desktop ul li").eq(indexItemMenuActive);
    let liWidth = $(li).outerWidth(true);
    let liLeft = $(li).position().left;
    let liRight = $(".menu-desktop ul").outerWidth(true) - (liLeft + liWidth);
    let liLast = $(".menu-desktop ul li").last();
    $(liLast).css({
        "transition": "unset"
    });
    if (window.innerWidth >= 800) {
        $("header").removeClass("show-menu");
        $(".menu-desktop").removeClass("show");
        $(".btn-show-menu").children("span").removeClass("animation-slide");
        $(liLast).css({
            "top": "40px",
            "right": (lang === "ar") ? (liRight + "px") : "unset",
            "left": (lang === "en") ? (liLeft + "px") : "unset",
            "width": liWidth
        });
    } else {
        $(".menu-desktop").removeClass("show");
        $("header").removeClass("show-menu");
        $(liLast).css({
            "top": (indexItemMenuActive) * 40 + 40 + "px",
            "right": "unset",
            "left": "unset",
            "width": liWidth
        });
    }
    $(liLast).css({
        "transition": "all 0.5s ease-in-out"
    })
}

// القائمة المفعله يظهر تحته الخط عند ضغط عليه
function activeMenu() {
    $(".menu-desktop ul li").on("click", function () {
        let verticl = (window.innerWidth <= 870) ? "top" : (lang === "en") ? "left" : "right";
        let moveBefore = null;
        indexItemMenuActive = $(this).index();
        let li = this;
        let liWidth = $(li).outerWidth(true);
        let liLeft = $(li).position().left;
        let liRight = $(".menu-desktop ul").outerWidth(true) - (liLeft + liWidth);
        if (verticl == "right")
            moveBefore = {
                "top": "40px",
                "right": liRight + "px",
                "left": "unset",
                "width": liWidth
            };
        else if (verticl == "left") {
            moveBefore = {
                "top": "40px",
                "left": liLeft + "px",
                "right": "unset",
                "width": liWidth
            };
        } else
            moveBefore = {
                "top": (indexItemMenuActive) * 40 + 40 + "px",
                "right": "unset",
                "width": liWidth
            };
        $(".menu-desktop ul li").last().css(moveBefore);

    });
}


// اضهار او خفاء القائمة في حالة شاشة صغيره
function showAndHideMenu() {
    $(".btn-show-menu").click(function () {
        $("header").toggleClass("show-menu");
        $(this).children("span").toggleClass("animation-slide");
        $(".menu-desktop").toggleClass("show");
        $(".user-info nav").hide();
    });
}
// تهيئة وضع التطبيق (ليلي أو نهاري) بناءً على localStorage أو إعدادات النظام
function instanceMode() {
    const savedMode = localStorage.getItem("mode");

    if (savedMode) {
        // إذا كان هناك وضع مخزن في localStorage، يتم تطبيقه مباشرة
        savedMode === "dark" ? activateDarkMode() : activateLightMode();
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
    $("header .mode").click(function () {

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
    $("#js-pagition").find("a, span[aria-current='page'] span, span[aria-disabled='true'] span, span.relative.inline-flex.items-center.px-4.py-2.text-sm.font-medium.text-gray-500.bg-white.border.border-gray-300.cursor-default.leading-5.rounded-md").addClass("dark:bg-gray-800 dark:border-gray-600");
}

// تطبيق الوضع الفاتح
function activateLightMode() {
    $("html").removeClass("dark");
    $("html").addClass("light");
    $("header .mode .fas").removeClass("fa-sun").addClass("fa-moon");
    $(".bg-v-dark").removeClass("active");
    $(".container-base,header,.box-loader,main,body").removeClass("dark");
    $("#js-pagition").find("a, span[aria-current='page'] span, span[aria-disabled='true'] span, span.relative.inline-flex.items-center.px-4.py-2.text-sm.font-medium.text-gray-500.bg-white.border.border-gray-300.cursor-default.leading-5.rounded-md").removeClass("dark:bg-gray-800 dark:border-gray-600");
}


// اضهار قائمة البروفايل
function MenueProfileShowandHide() {
    $(".profile").click(function () {
        $(".user-info nav").toggle();
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

// الحصول على لغة المتصفح
function getUserLanguage() {
    var userLang = navigator.language || navigator.userLanguage;
    var langCode = userLang.split('-')[0];

    if (langCode !== "ar" && langCode !== "en") {
        langCode = "en";
    }

    return langCode;
}


// عداد الانجازات =================================
function counters() {
    const nums = document.querySelectorAll('#achievements h2 span');
    const section = document.querySelector('#achievements');
    if (section != undefined) {
        let sectionHeight = parseFloat(section.offsetHeight);
        let sectionPadding = parseFloat($(section).css('padding'));
        let started = false;
        $(".container-base").scroll(function (e) {
            if (this.scrollTop >= section.offsetTop - 550) {
                if (!started) {
                    nums.forEach((num) => {
                        num.textContent = 0;
                        startCount(num)
                    });
                }
                started = true;
            }
            // if (this.scrollTop <= section.offsetTop - ((sectionHeight / 2) + 550 + (sectionPadding / 2))) {
            //     started = false;
            // }
            // if (this.scrollTop >= section.offsetTop + sectionHeight) {
            //     started = false;
            // }
        });
    }
};


// تشغيل العداد
function startCount(el) {
    let goal = el.dataset.goal;
    let increment = Math.ceil(goal / 300);
    let count = setInterval(() => {
        el.textContent = parseInt(el.textContent) + increment;
        if (parseInt(el.textContent) >= goal) {
            el.textContent = goal;
            clearInterval(count);
        }
    }, 1500 / goal);
}

/**
 * دالة `gotoTop` تضبط وظيفة زر العودة إلى الأعلى وتعالج سلوك التمرير.
 *
 * - عند النقر على الزر المخصص للعودة إلى الأعلى، تقوم الدالة بتمرير الحاوية إلى أعلى بشكل سلس.
 * - عند التمرير داخل الحاوية، تضيف أو تزيل فئة "active" من عنصر آخر بناءً على موضع التمرير.
 */
function gotoTop() {
    $(".js-gotop").on("click", function (event) {
        event.preventDefault();
        const $container = $(".container-base");
        $container.animate({
            scrollTop: 0
        }, 500, "swing");
        return false;
    });

    $(".container-base").scroll(function () {
        $(this).scrollTop() > 200 ? $(".js-top").addClass("active") : $(".js-top").removeClass("active");
    });
}

function buttonFilterShow() {
    $(".filter_button").click(function () {
        $(".box_show_filter").toggle();
    });
    $(document).click(function (event) {
        if (!$(event.target).closest('.box_show_filter').length && !$(event.target).closest('.filter_button').length) {
            $('.box_show_filter').hide();
        }
    });

    $(".box_show_filter").click(function (event) {
        event.stopPropagation(); // منع النقر داخل القائمة من إغلاقها
    });

    // للتأكد من أن القائمة لا تختفي عند النقر داخل select2
    $(document).on('click', '.select2-container', function (event) {
        event.stopPropagation();
    });
}


// ----------------------------------------------------------------

// بداية تشغيل الصفحة
$(function () {
    resizeScreen();
    activeMenu();
    showAndHideMenu();
    MenueProfileShowandHide();
    changeMode();
    instnceApp();
    loaderBase(false, 500);
    counters();
    $(".menu-desktop ul #activ").trigger("click");
    gotoTop();
    // revealFunc();
});


// ----------------------------------------------------------------
