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
                <div class="mb-4 text-sm text-gray-600">
                    {{ __("auth.forgot_password_message") }}
                </div>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />
                <form method="POST" action="{{ route('user.password.email') }}">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <x-input-label for="email" :value="__('auth.login.email')" />
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                            :value="old('email')" required autofocus />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <x-primary-button>
                            {{ __('auth.send_password_reset_link') }}
                        </x-primary-button>
                    </div>
                </form>

            </div>
        </div>
    </section>
    @endsection


    @section("script")
    <script src="{{ asset('customer/js/login_or_sigup.js') }}"></script>
    @endsection
