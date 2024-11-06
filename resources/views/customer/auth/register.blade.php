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
                <form method="POST" action="{{ route('user.register') }}">
                    @csrf

                    <!-- Name -->
                    <div>
                        <x-input-label for="name" :value="__('auth.register.name')" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')"
                            required autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Email Address -->
                    <div class="mt-4">
                        <x-input-label for="email" :value="__('auth.register.email')" />
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                            :value="old('email')" required autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="mt-4">
                        <x-input-label for="password" :value="__('auth.register.password')" />
                        <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                            autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Confirm Password -->
                    <div class="mt-4">
                        <x-input-label for="password_confirmation" :value="__('auth.register.confirm_password')" />
                        <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                            name="password_confirmation" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            href="{{ route('user.login') }}">
                            {{ __('auth.register.no_account') }}
                        </a>

                        <x-primary-button class="ms-4 btn" style="width: unset;">
                            {{ __('auth.register.submit') }}
                        </x-primary-button>
                    </div>

                    <div class="block mt-4">
                        <div class="divider">Or</div>
                    </div>

                    <div class="flex mt-4 items-center justify-center gap-6">
                        <a href="" title="{{ __('auth.register.facebook_login') }}"><i
                                class="fa-brands fa-facebook" style="transform: scale(1.5);"></i></a>
                        <a href="" title="{{ __('auth.register.google_login') }}"><i
                                class="fa-brands fa-google" style="transform: scale(1.5);"></i></a>
                    </div>
                </form>

            </div>
        </div>
    </section>
    @endsection


    @section("script")
    <script src="{{ asset('customer/js/login_or_sigup.js') }}"></script>
    @endsection
