@extends("customer.layout.layout")

@section("styles")
<link rel="stylesheet" href="{{ asset('customer/css/ligin_or_sigup.css') }}">

<!-- Fonts -->
<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

<!-- Scripts -->
@vite(['resources/css/app.css', 'resources/js/app.js'])
    @endsection


    @section("home","activ")

    @section("main.layout")
    <section class="container-form forms">
        <div class="form login">
            <div class="form-content">
                <x-input-error :messages="$errors->get('socialError')" class="mt-2" />
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <x-input-label for="email" :value="__('auth.login.email')" />
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                            :value="old('email')" required autofocus autocomplete="ame" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="mt-4">
                        <x-input-label for="password" :value="__('auth.login.password')" />
                        <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                            autocomplete="current-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Remember Me -->
                    <div class="flex mt-4 justify-between items-center">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox"
                                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                name="remember">
                            <span
                                class="ms-2 text-sm text-gray-600">{{ __('auth.login.remember_me') }}</span>
                        </label>
                        <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            href="{{ route('register') }}">
                            {{ __('auth.login.yes_account') }}
                        </a>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        @if(Route::has('password.request'))
                            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                href="{{ route('password.request') }}">
                                {{ __('auth.login.forgot_password') }}
                            </a>
                        @endif

                        <x-primary-button class="ms-3 btn" style="width: unset;">
                            {{ __('auth.login.submit') }}
                        </x-primary-button>
                    </div>

                    <div class="block mt-4">
                        <div class="divider">Or</div>
                    </div>

                    <div class="flex mt-4 items-center justify-center gap-6">
                        <a href="" title="{{ __('auth.login.facebook_login') }}"><i
                                class="fa-brands fa-facebook" style="transform: scale(1.5);"></i></a>
                        <a href="{{ route('google') }}"
                            title="{{ __('auth.login.google_login') }}"><i class="fa-brands fa-google"
                                style="transform: scale(1.5);"></i></a>
                    </div>
                </form>
            </div>
        </div>
    </section>
    @endsection


    @section("script")
    <script src="{{ asset('customer/js/login_or_sigup.js') }}"></script>
    @endsection
