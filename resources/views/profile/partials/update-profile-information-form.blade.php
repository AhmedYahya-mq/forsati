<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('معلومات الملف الشخصي') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("قم بتحديث معلومات ملف حسابك وعنوان بريدك الإلكتروني.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div style="display: flex; justify-content: center; width: 100%;">
            <div style="width: 200px; height: 200px; margin-bottom: 30px;">
                <!-- عنصر الإدخال للصورة -->
                <x-text-input id="img-profile" class="filepond"
                                accept="image/png, image/jpeg, image/gif"
                                name="image" type="file"
                                data-default-file="{{ public_path().'/resources'.trim('/admin/images/icon/avatar-big-01.jpg') }}"
                                autofocus />
                <x-input-error class="mt-2" :messages="$errors->get('img')" />
            </div>
        </div>
        <div>
            <x-input-label for="name" :value="__('الأسم')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('البريد الكتروني')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('عنوان بريدك الإلكتروني غير موثق.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('انقر هنا لإعادة إرسال بريد التحقق.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('تم إرسال رابط تحقق جديد إلى عنوان بريدك الإلكتروني.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>



        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('حفظ') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    style="color: green"
                >{{ __('تم الحفظ.') }}</p>
            @endif
        </div>
    </form>
</section>
