<section>
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-5">
        @csrf
        @method('patch')

        <div>
            <label for="name" class="block text-sm font-bold text-gray-700 mb-2 mr-1">
                الاسم الكامل
            </label>
            <input id="name" name="name" type="text" 
                   class="input-style block w-full border-gray-200 focus:border-pink-500 focus:ring-pink-500 rounded-2xl shadow-sm transition" 
                   value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
            <x-input-error class="mt-2 text-right" :messages="$errors->get('name')" />
        </div>

        <div>
            <label for="email" class="block text-sm font-bold text-gray-700 mb-2 mr-1">
                البريد الإلكتروني
            </label>
            <input id="email" name="email" type="email" 
                   class="input-style block w-full border-gray-200 focus:border-pink-500 focus:ring-pink-500 rounded-2xl shadow-sm transition" 
                   value="{{ old('email', $user->email) }}" required autocomplete="username">
            <x-input-error class="mt-2 text-right" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-3 p-3 bg-yellow-50 rounded-xl border border-yellow-100">
                    <p class="text-sm text-yellow-700 font-medium">
                        بريدك الإلكتروني غير مؤكد بعد.
                        <button form="send-verification" class="text-pink-600 font-bold hover:underline focus:outline-none transition">
                            اضغط هنا لإعادة إرسال رابط التفعيل.
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-bold text-sm text-green-600">
                            تم إرسال رابط تفعيل جديد إلى بريدك بنجاح.
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center justify-center gap-4 pt-2">
            <button type="submit" class="btn-submit px-10">
                حفظ التعديلات
            </button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-green-600 font-bold"
                >تم الحفظ</p>
            @endif
        </div>
    </form>
</section>