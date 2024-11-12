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
                    {{ __('auth.register.verification_message') }}
                </div>

                @if (session('status') == 'verification-link-sent')
                    <div class="mb-4 font-medium text-sm text-green-600">
                        {{ __('auth.passwords.verification_link_sent') }}
                    </div>
                @endif

                <div class="mt-4 flex items-center justify-between">
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf

                        <div>
                            <x-primary-button>
                                {{ __('auth.verification.resend') }}
                            </x-primary-button>
                        </div>
                    </form>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <button type="submit"
                            class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('auth.logout') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
    @endsection


    @section("script")
    <script src="{{ asset('customer/js/login_or_sigup.js') }}"></script>
    @endsection
