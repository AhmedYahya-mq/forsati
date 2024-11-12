<!--Website: wwww.codingdung.com-->
<!DOCTYPE html>
<html lang="{{ $locale }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ahmed Yahya</title>
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('customer/css/loader.css') }}">
    <link rel="stylesheet" href="{{ asset('customer/css/mode.css') }}">
    <link rel="stylesheet" href="{{ asset('customer/css/settings.css') }}">
    <link rel="stylesheet" href="{{ asset('customer/css/profile/toggle-mode.css') }}">
    <link rel="stylesheet" href="{{ asset('customer/css/profile/loader.css') }}">
    <link rel="stylesheet" href="{{ asset('customer/css/profile/style.css') }}">
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
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('vendor/message-box.css') }}" rel="stylesheet" media="all">

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
    <div class="container-fluid container-base flex-grow-1 container-p-y align-items-md-start" dir="{{ $dir }}">
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
                            <div class="card-body media align-items-center">
                                <div class="image-profile">
                                    <div class="three-body">
                                        <div class="three-body__dot"></div>
                                        <div class="three-body__dot"></div>
                                        <div class="three-body__dot"></div>
                                    </div>
                                    <img src="{{ asset("storage/$user->image") }}"
                                        style="height: 100%;" alt="{{ $user->name }}"
                                        accept="image/png, image/jpeg, image/gif" name="image"
                                        class="d-block ui-w-80 account-settings-image">
                                    <button class="button">
                                        <span class="X"></span>
                                        <span class="Y"></span>
                                    </button>
                                </div>
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
                            @if(session('succeses.user') && !empty(session('succeses.user')))
                                <div class="massege-pup">
                                    <div class="popup-p success-popup-p">
                                        <div class="success-icon-p">
                                            <i class="fa-solid fa-circle-check"></i>
                                        </div>
                                        <div class="success-message-p">{{ session('succeses.user') }}
                                        </div>
                                        <div class="close-icon-p">
                                            <i class="fa-solid fa-xmark"></i>
                                        </div>
                                    </div>
                                </div>
                            @elseif($errors->has('warning.user'))
                                <div class="massege-pup">
                                    <div class="popup-p alert-popup-p">
                                        <div class="alert-icon-p">
                                            <i class="fa-solid fa-triangle-exclamation"></i>
                                        </div>
                                        <div class="alert-message-p">
                                            {{ $errors->first('warning.user') }}</div>
                                        <div class="close-icon-p">
                                            <i class="fa-solid fa-xmark"></i>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <form action="{{ route('profile.general') }}" id="user" method="post">
                                @csrf
                                @method("PUT")
                                <input type="hidden" name="image" id="image">
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
                                                    href="{{ route('verification.notice') }}">{{ __("auth.verification.resend") }}</a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div
                                    class="text-{{ $align === "right"?"left":"right" }} m-3">
                                    <button type="submit"
                                        class="btn">{{ __("profile.save-changes") }}</button>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="account-change-password">
                            <p class="mt-1 text-sm text-gray-600 m-4">
                                {{ __('تأكد من أن حسابك يستخدم كلمة مرور طويلة وعشوائية للبقاء آمناً.') }}
                            </p>
                            <form method="post" action="{{ route('password.update') }}"
                                class="mt-6 space-y-6">
                                @csrf
                                @method('put')

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
                                        @if (session('status') === 'profile-updated')
                                    <p
                                            x-data="{ show: true }"
                                            x-show="show"
                                            x-transition
                                            x-init="setTimeout(() => show = false, 2000)"
                                            class="text-sm text-gray-600"
                                            style="color: green"
                                        >{{ __('تم الحفظ.') }}</p>
                                    @endif
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="account-info">
                        @if(session('info'))
                                <div class="massege-pup">
                                    <div class="popup-p success-popup-p">
                                        <div class="success-icon-p">
                                            <i class="fa-solid fa-circle-check"></i>
                                        </div>
                                        <div class="success-message-p">{{ session('info') }}
                                        </div>
                                        <div class="close-icon-p">
                                            <i class="fa-solid fa-xmark"></i>
                                        </div>
                                    </div>
                                </div>
                            @elseif($errors->has('info'))
                                <div class="massege-pup">
                                    <div class="popup-p alert-popup-p">
                                        <div class="alert-icon-p">
                                            <i class="fa-solid fa-triangle-exclamation"></i>
                                        </div>
                                        <div class="alert-message-p">
                                            {{ $errors->first('info') }}</div>
                                        <div class="close-icon-p">
                                            <i class="fa-solid fa-xmark"></i>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <form action="{{ route('profile.detail') }}" method="post">
                                @csrf
                                @method('PUT')
                                <div class="card-body pb-2">
                                    <div class="form-group">
                                        <label class="form-label">{{ __("profile.bio") }}</label>
                                        <textarea name="bio" class="form-control"
                                            rows="5">{{ $user->detailsUser->bio ?? "" }}</textarea>
                                    </div>
                                    <div class="card-body pb-2">
                                        <h6 class="mb-4">{{ __("app.gender") }}</h6>
                                        <div class="form-group mr-3 form-check-inline">
                                            <label class="switcher">
                                                <input type="radio" class="switcher-input" name="gender"
                                                    {{ strtolower($user->detailsUser->gender ?? "") ==="m"?"checked":"" }}
                                                    value="M">
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
                                                <input type="radio" class="switcher-input" name="gender" value="F"
                                                    {{ strtolower($user->detailsUser->gender ?? "") === "f" ?"checked":"" }}>
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
                                        <input type="date" class="form-control text-{{ $align }}" name="birthday"
                                            value="{{ $user->detailsUser->birthday ?? "" }}">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">{{ __("profile.country") }}</label>
                                        <select class="custom-select search" dir="{{ $dir }}" name="country"
                                            id="country-select">
                                            <!-- الخيار الافتراضي الفارغ -->
                                            <option value="" disabled
                                                {{ !$user->country_id ? 'selected' : '' }}>
                                                {{ __("app.choose_country") }}</option>
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
                                        <input type="text" class="form-control" name="phone"
                                            value="{{ $user->detailsUser->phone ?? "" }}">
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
                        @if(session('link'))
                                <div class="massege-pup">
                                    <div class="popup-p success-popup-p">
                                        <div class="success-icon-p">
                                            <i class="fa-solid fa-circle-check"></i>
                                        </div>
                                        <div class="success-message-p">{{ session('link') }}
                                        </div>
                                        <div class="close-icon-p">
                                            <i class="fa-solid fa-xmark"></i>
                                        </div>
                                    </div>
                                </div>
                            @elseif($errors->has('link'))
                                <div class="massege-pup">
                                    <div class="popup-p alert-popup-p">
                                        <div class="alert-icon-p">
                                            <i class="fa-solid fa-triangle-exclamation"></i>
                                        </div>
                                        <div class="alert-message-p">
                                            {{ $errors->first('link') }}</div>
                                        <div class="close-icon-p">
                                            <i class="fa-solid fa-xmark"></i>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <form action="{{ route('profile.link') }}" method="post">
                                @csrf
                                @method('PUT')
                                <div class="card-body pb-2">
                                    <div class="form-group">
                                        <label class="form-label">{{ __("profile.twitter") }}</label>
                                        <input type="text" class="form-control" name="twitter"
                                            value="{{ $user->detailsUser->twitter }}">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">{{ __("profile.facebook") }}</label>
                                        <input type="text" class="form-control" name="facebook"
                                            value="{{ $user->detailsUser->facebook }}">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">{{ __("profile.google") }}</label>
                                        <input type="text" class="form-control" name="google"
                                            value="{{ $user->detailsUser->google }}">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">{{ __("profile.linkedIn") }}</label>
                                        <input type="text" class="form-control" name="linkedIn"
                                            value="{{ $user->detailsUser->linkedIn ?? "" }}">
                                    </div>
                                    <div class="form-group">
                                        <label
                                            class="form-label">{{ __("profile.instagram") }}</label>
                                        <input type="text" class="form-control" name="instagram"
                                            value="{{ $user->detailsUser->instagram ?? "" }}">
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
                    @if(session('notifications'))
                                <div class="massege-pup">
                                    <div class="popup-p success-popup-p">
                                        <div class="success-icon-p">
                                            <i class="fa-solid fa-circle-check"></i>
                                        </div>
                                        <div class="success-message-p">{{ session('notifications') }}
                                        </div>
                                        <div class="close-icon-p">
                                            <i class="fa-solid fa-xmark"></i>
                                        </div>
                                    </div>
                                </div>
                            @elseif($errors->has('notifications'))
                                <div class="massege-pup">
                                    <div class="popup-p alert-popup-p">
                                        <div class="alert-icon-p">
                                            <i class="fa-solid fa-triangle-exclamation"></i>
                                        </div>
                                        <div class="alert-message-p">
                                            {{ $errors->first('notifications') }}</div>
                                        <div class="close-icon-p">
                                            <i class="fa-solid fa-xmark"></i>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        <form action="{{ route('profile.notifications') }}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="card-body pb-2">
                                <h6 class="mb-4 text-center-md">{{ __("profile.application") }}</h6>
                                <div class="form-group">
                                    <label class="switcher">
                                        <input type="checkbox" class="switcher-input" name="news"
                                           {{ $user->detailsUser->notification['blog'] ?"checked":"" }}>
                                        <span class="switcher-indicator">
                                            <span class="switcher-yes"></span>
                                            <span class="switcher-no"></span>
                                        </span>
                                        <span class="switcher-label">{{ __("profile.news") }}</span>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label class="switcher">
                                        <input type="checkbox" class="switcher-input" name="scholarships"
                                            {{ $user->detailsUser->notification['scholarship']?"checked":""  }}>
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
                                        <input type="checkbox" class="switcher-input" name="ad"
                                            {{ $user->detailsUser->notification['ad']?"checked":"" }}>
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
                                                            <p class="light">{{ __("profile.light") }}
                                                            </p>
                                                            <p class="dark">{{ __("profile.dark") }}
                                                            </p>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <h6 class="mb-2 text-center">{{ __("profile.lang") }}</h6>
                                <select class="form-select form-select-sm" id="language-select"
                                    aria-label=".form-select-sm example">
                                    <option value="en"
                                        {{ \Illuminate\Support\Facades\App::getLocale() ==="en"?"selected":"" }}>
                                        {{ __("profile.en") }}</option>
                                    <option value="ar"
                                        {{ \Illuminate\Support\Facades\App::getLocale() !=="en"?"selected":"" }}>
                                        {{ __("profile.ar") }}</option>
                                </select>
                                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg mt-4">
                                    <div class="max-w-xl">
                                    <section class="space-y-6">
                                        <header>
                                            <h2 class="text-lg font-medium text-gray-900">
                                                {{ __('profile.delete-account') }}
                                            </h2>

                                            <p class="mt-1 text-sm text-gray-600">
                                                {{ __('profile.warning-del-acount') }}
                                            </p>
                                        </header>

                                        <x-danger-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">
                                            {{ __('profile.delete-account') }}</x-danger-button>

                                        <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
                                            <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
                                                @csrf
                                                @method('delete')

                                                <h2 class="text-lg font-medium text-gray-900">
                                                    {{ __('profile.title-pup-del-account') }}
                                                </h2>

                                                <p class="mt-1 text-sm text-gray-600">
                                                    {{ __('profile.pup-del-account') }}
                                                </p>

                                                <div class="mt-6">
                                                    <x-input-label for="password" value="{{ __('profile.current-password') }}"
                                                        class="sr-only" />

                                                    <x-text-input id="password" name="password" type="password" class="mt-1 block w-3/4"
                                                        placeholder="{{ __('profile.current-password') }}" />

                                                    <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
                                                </div>

                                                <div class="mt-6 flex justify-end">
                                                    <x-secondary-button x-on:click="$dispatch('close')">
                                                        {{ __('profile.cancel') }}
                                                    </x-secondary-button>

                                                    <x-danger-button class="ms-3">
                                                        {{ __('profile.delete-account') }}
                                                    </x-danger-button>
                                                </div>
                                            </form>
                                        </x-modal>
                                    </section>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <div class="text-{{ $align === "right"?"left":"right" }} m-3">
                            <form method="POST" action="{{ route('logout') }}" class="text-{{ $align === "right"?"left":"right" }} m-3" >
                                @csrf
                                <button type="submit"
                                    class="btn text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 text-decoration-none">
                                    {{ __(key: 'app.logout') }}
                                </button>
                            </form>
                        </div>
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
    <script src="{{ asset('vendor/message-box.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap-4.1/popper.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap-4.1/bootstrap.min.js') }}"></script>
    <script src="{{ asset('customer/js/profile/main.js') }}"></script>

</body>

</html>
