<!--Website: wwww.codingdung.com-->
<!DOCTYPE html>
<html lang="{{ $locale }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ahmed Yahya</title>
    <link rel="stylesheet" href="{{ asset('customer/css/loader.css') }}">
    <link rel="stylesheet" href="{{ asset('customer/css/profile/style.css') }}">
    <link rel="stylesheet" href="{{ asset('customer/css/mode.css') }}">
    <link rel="stylesheet" href="{{ asset('customer/css/settings.css') }}">
    <link rel="stylesheet" href="{{ asset('customer/css/profile/toggle-mode.css') }}">
    <!-- Bootstrap CSS-->
    <link href="{{ asset('vendor/bootstrap-4.1/bootstrap.min.css') }}" rel="stylesheet"
        media="all">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- select2 Styles -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <!-- Or for RTL support select2 -->
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.rtl.min.css" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body dir="{{ $dir }}" class="{{ $locale }}">
    <div class="bg-v-dark"></div>
    <div class="box-loader">
        <div class="loader">
            <div class="box box-1">
                <div class="side-left"></div>
                <div class="side-right"></div>
                <div class="side-top"></div>
            </div>
            <div class="box box-2">
                <div class="side-left"></div>
                <div class="side-right"></div>
                <div class="side-top"></div>
            </div>
            <div class="box box-3">
                <div class="side-left"></div>
                <div class="side-right"></div>
                <div class="side-top"></div>
            </div>
            <div class="box box-4">
                <div class="side-left"></div>
                <div class="side-right"></div>
                <div class="side-top"></div>
            </div>
        </div>
    </div>
    <div class="container-fluid container-base flex-grow-1 container-p-y align-items-md-start" dir="{{  $dir  }}" >
        <h4 class="font-weight-bold py-3 mb-4">
            <a
                href="{{ url()->previous() == url()->current() ? url('/') : url()->previous() }}"><i
                    class="fa fa-arrow-{{ $align }}"></i></a> {{ __("profile.profile") }}
        </h4>
        <div class="card overflow-hidden">
            <div class="row no-gutters row-bordered row-border-light">
                <div class="col-md-3 pt-0 border-bottom-sm border-bottom-lg">
                    <div class="list-group  list-group-flush account-settings-links md:flex md:items-center md:g-1">
                        <a class="list-group-item list-group-item-action active" data-toggle="list"
                            href="#account-general">{{ __("profile.general") }}</a>
                        <a class="list-group-item list-group-item-action" data-toggle="list"
                            href="#account-change-password">{{ __("profile.change-pass") }}</a>
                        <a class="list-group-item list-group-item-action" data-toggle="list"
                            href="#account-info">{{ __("profile.info") }}</a>
                        <a class="list-group-item list-group-item-action" data-toggle="list"
                            href="#account-social-links">{{ __("profile.social-links") }}</a>
                        <a class="list-group-item list-group-item-action" data-toggle="list"
                            href="#account-notifications">{{ __("profile.notification") }}</a>
                        <a class="list-group-item list-group-item-action" data-toggle="list"
                            href="#account-settings">{{ __("profile.settings") }}</a>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="tab-content">
                        <div class="tab-pane fade active show" id="account-general">
                            <form action="" method="post">
                                <div class="card-body media align-items-center">
                                    <img src="{{ asset("storage/$user->image") }}"
                                        alt="{{ $user->name }}" accept="image/png, image/jpeg, image/gif" name="image"
                                        class="d-block ui-w-80">
                                    <div class="media-body ml-4 text-{{ $align }}">
                                        <label class="btn btn-outline-primary">
                                            {{ __("profile.up-image") }}
                                            <input type="file" class="account-settings-fileinput">
                                        </label> &nbsp;
                                        <div class="text-light small mt-1">
                                            {{ __("profile.warning-image") }}</div>
                                    </div>
                                </div>
                                <hr class="border-light m-0">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label class="form-label">{{ __("profile.name") }}</label>
                                        <input type="text" name="name" class="form-control mb-1"
                                            value="{{ $user->name }}">
                                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">{{ __("profile.mail") }}</label>
                                        <input type="text" name="email" class="form-control mb-1"
                                            value="{{ $user->email }}">
                                        <x-input-error class="mt-2" :messages="$errors->get('email')" />
                                        @if($user->email_verified_at === null)
                                            <div class="alert alert-warning mt-3">
                                                {{ __("profile.confirmation-mail") }}<br>
                                                <a
                                                    href="javascript:void(0)">{{ __("auth.verification.resend") }}</a>
                                            </div>
                                        @endif
                                    </div>
                                    <!-- <div class="form-group">
                                    <label class="form-label">Company</label>
                                    <input type="text" class="form-control" value="Company Ltd.">
                                </div> -->
                                </div>
                                <div
                                    class="text-{{ $align === "right"?"left":"right" }} m-3">
                                    <button type="button"
                                        class="btn">{{ __("profile.save-changes") }}</button>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="account-change-password">
                            <form action="" method="post">
                                <div class="card-body pb-2">
                                    <div class="form-group">
                                        <label
                                            class="form-label">{{ __("profile.current-password") }}</label>
                                        <input type="password" name="current_password" class="form-control">
                                        <x-input-error :messages="$errors->updatePassword->get('current_password')"
                                            class="mt-2" />
                                    </div>
                                    <div class="form-group">
                                        <label
                                            class="form-label">{{ __("profile.new-password") }}</label>
                                        <input type="password" name="password" class="form-control">
                                        <x-input-error :messages="$errors->updatePassword->get('password')"
                                            class="mt-2" />

                                    </div>
                                    <div class="form-group">
                                        <label
                                            class="form-label">{{ __("profile.repeat-password") }}</label>
                                        <input type="password" class="form-control" name="password_confirmation">
                                        <x-input-error :messages="$errors->updatePassword->get('password_confirmation')"
                                            class="mt-2" />
                                    </div>
                                </div>
                                <div
                                    class="text-{{ $align === "right"?"left":"right" }} m-3">
                                    <button type="submit"
                                        class="btn">{{ __("profile.save-changes") }}</button>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="account-info">
                            <form action="" method="post">
                                <div class="card-body pb-2">
                                    <div class="form-group">
                                        <label class="form-label">{{ __("profile.bio") }}</label>
                                        <textarea name="bio" class="form-control" rows="5"></textarea>
                                    </div>
                                    <div class="card-body pb-2">
                                        <h6 class="mb-4">{{ __("app.gender") }}</h6>
                                        <div class="form-group mr-3 form-check-inline">
                                            <label class="switcher">
                                                <input type="radio" class="switcher-input" name="gender">
                                                <span class="switcher-indicator">
                                                    <span class="switcher-yes"></span>
                                                    <span class="switcher-no"></span>
                                                </span>
                                                <span
                                                    class="switcher-label">{{ __("app.male") }}</span>
                                            </label>
                                        </div>
                                        <div class="form-group  mr-3 form-check-inline">
                                            <label class="switcher">
                                                <input type="radio" class="switcher-input" name="gender">
                                                <span class="switcher-indicator">
                                                    <span class="switcher-yes"></span>
                                                    <span class="switcher-no"></span>
                                                </span>
                                                <span
                                                    class="switcher-label">{{ __("app.female") }}</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">{{ __("profile.birthday") }}</label>
                                        <input type="date" class="form-control text-{{ $align }}" name="barthday"
                                            value="1999-06-11">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">{{ __("profile.country") }}</label>
                                        <select class="custom-select search" dir="{{ $dir }}" name="country" id="country-select">
                                                <!-- الخيار الافتراضي الفارغ -->
                                            <option value="" disabled {{ !$user->country_id ? 'selected' : '' }}>{{ __("app.choose_country") }}</option>
                                            @foreach($countries as $country)
                                                <option name="country"
                                                    {{ $country->_id === $user->country_id?"selected":"" }}
                                                    value="{{ $country->_id }}" data-flag="{{ $country->flag }}">
                                                    {{ $country->{'name_'.$locale} }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <hr class="border-light m-0">
                                <div class="card-body pb-2">
                                    <h6 class="mb-4">{{ __("profile.contacts") }}</h6>
                                    <div class="form-group">
                                        <label class="form-label">{{ __("profile.phone") }}</label>
                                        <input type="text" class="form-control" name="phone" value="+0 (123) 456 7891">
                                    </div>
                                </div>
                                <div
                                    class="text-{{ $align === "right"?"left":"right" }} m-3">
                                    <button type="submit"
                                        class="btn">{{ __("profile.save-changes") }}</button>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="account-social-links">
                            <form action="" method="post">
                                <div class="card-body pb-2">
                                    <div class="form-group">
                                        <label class="form-label">{{ __("profile.twitter") }}</label>
                                        <input type="text" class="form-control" name="twitter"
                                            value="https://twitter.com/user">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">{{ __("profile.facebook") }}</label>
                                        <input type="text" class="form-control" name="facebook"
                                            value="https://www.facebook.com/user">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">{{ __("profile.google") }}</label>
                                        <input type="text" class="form-control" name="google" value>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">{{ __("profile.linkedIn") }}</label>
                                        <input type="text" class="form-control" name="linkedIn" value>
                                    </div>
                                    <div class="form-group">
                                        <label
                                            class="form-label">{{ __("profile.instagram") }}</label>
                                        <input type="text" class="form-control" name="instagram"
                                            value="https://www.instagram.com/user">
                                    </div>
                                    <div
                                        class="text-{{ $align === "right"?"left":"right" }} m-3">
                                        <button type="submit"
                                            class="btn">{{ __("profile.save-changes") }}</button>
                                    </div>
                            </form>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="account-notifications">
                        <form action="" method="post">
                            <div class="card-body pb-2">
                                <h6 class="mb-4 text-center-md">{{ __("profile.application") }}</h6>
                                <div class="form-group">
                                    <label class="switcher">
                                        <input type="checkbox" class="switcher-input" name="news" checked>
                                        <span class="switcher-indicator">
                                            <span class="switcher-yes"></span>
                                            <span class="switcher-no"></span>
                                        </span>
                                        <span class="switcher-label">{{ __("profile.news") }}</span>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label class="switcher">
                                        <input type="checkbox" class="switcher-input" name="scholarships-new">
                                        <span class="switcher-indicator">
                                            <span class="switcher-yes"></span>
                                            <span class="switcher-no"></span>
                                        </span>
                                        <span
                                            class="switcher-label">{{ __("profile.scholarships-new") }}</span>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label class="switcher">
                                        <input type="checkbox" class="switcher-input" name="ad-new" checked>
                                        <span class="switcher-indicator">
                                            <span class="switcher-yes"></span>
                                            <span class="switcher-no"></span>
                                        </span>
                                        <span class="switcher-label">{{ __("profile.ad-new") }}</span>
                                    </label>
                                </div>
                            </div>
                            <div
                                class="text-{{ $align === "right"?"left":"right" }} m-3">
                                <button type="submit"
                                    class="btn">{{ __("profile.save-changes") }}</button>
                            </div>
                        </form>
                    </div>

                    <div class="tab-pane fade" id="account-settings">
                        <form action="" method="post">
                            <div class="card-body pb-2 text-center">
                                <h6 class="mb-4 text-center-md">{{ __("profile.settings") }}</h6>
                                <div class="toggle mb-4" dir="ltr">
                                    <input id="switch" type="checkbox">
                                    <div class="app">
                                        <div class="body">

                                            <div class="phone">
                                                <div class="header-phone">
                                                    <div class="menu">
                                                        <div class="time"></div>
                                                        <div class="icons">
                                                            <div class="network"></div>
                                                            <div class="precent-battery"></div>
                                                        </div>
                                                    </div>
                                                    <!-- Battery container -->
                                                    <div class="battery">
                                                        <!-- Battery head (top part) -->
                                                        <div class="battery-head"></div>
                                                        <!-- Battery body -->
                                                        <div class="battery-body">
                                                            <!-- Lightning bolt icon -->
                                                            <i class="fas fa-bolt"></i>
                                                            <!-- Charging animation element -->
                                                            <div class="charge"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="content">
                                                    <div class="circle">
                                                        <div class="crescent"></div>
                                                    </div>

                                                    <label for="switch">
                                                        <div class="toggle"></div>
                                                        <div class="names">
                                                            <p class="light">{{ __("profile.light") }}</p>
                                                            <p class="dark">{{ __("profile.dark") }}</p>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <h6 class="mb-2 text-center">{{ __("profile.lang") }}</h6>
                                <select class="form-select form-select-sm" id="language-select" aria-label=".form-select-sm example">
                                    <option value="en"  {{ \Illuminate\Support\Facades\App::getLocale() ==="en"?"selected":"" }}>{{ __("profile.en") }}</option>
                                    <option value="ar" {{ \Illuminate\Support\Facades\App::getLocale() !=="en"?"selected":"" }} >{{ __("profile.ar") }}</option>
                                </select>

                                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg mt-4">
                                    <div class="max-w-xl">
                                        @include('profile.partials.delete-user-form')
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <!-- Scripts -->
    <!-- <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script> -->
    <script src="{{ asset("customer/js/jquery-3.7.1.min.js") }}"></script>
    <!-- Scripts jquery + select2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js"></script>
    <!-- Bootstrap JS-->
    <script src="{{ asset('vendor/bootstrap-4.1/popper.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap-4.1/bootstrap.min.js') }}"></script>
    <script>
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
                    let batteryLevel =Math.round(battery.level * 100); // تحويله إلى نسبة مئوية
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


        $(function () {
            instanceCountries();
            instanceMode();
            changeMode();
            loaderBase(false, 500);
            updateTime();
            setInterval(updateTime, 1000);
            // استدعاء الدالة فورًا لتحديث حالة البطارية عند تحميل الصفحة
            updateBatteryStatus();

            // تحديث حالة البطارية كل ثانية (1000 ميلي ثانية)
            setInterval(updateBatteryStatus, 1000);

            document.getElementById('language-select').addEventListener('change', function() {
                const selectedLanguage = this.value;  // الحصول على اللغة المختارة

// تحديد الـ URL الجديد مع اللغة المختارة
const newUrl = '/lang/' + selectedLanguage;

// إعادة توجيه المستخدم إلى الـ URL الجديد
window.location.href = newUrl;
            });

        });

    </script>
</body>

</html>
