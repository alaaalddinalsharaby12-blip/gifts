<section>
    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-5">
        @csrf
        @method('patch')

        {{-- current_password --}}
        <div>
            <label for="current_password" class="block text-sm font-bold text-gray-700 mb-2 mr-1">
                كلمة المرور الحالية
            </label>
            <input id="current_password" name="current_password" type="password"
                   class="input-style block w-full border-gray-200 focus:border-pink-500 focus:ring-pink-500 rounded-2xl shadow-sm transition"
                   autocomplete="current-password">
            <x-input-error class="mt-2 text-right" :messages="$errors->get('current_password')" />
        </div>

        {{-- password --}}
        <div>
            <label for="password" class="block text-sm font-bold text-gray-700 mb-2 mr-1">
                كلمة المرور الجديدة
            </label>
            <input id="password" name="password" type="password"
                   class="input-style block w-full border-gray-200 focus:border-pink-500 focus:ring-pink-500 rounded-2xl shadow-sm transition"
                   autocomplete="new-password">
            <x-input-error class="mt-2 text-right" :messages="$errors->get('password')" />
        </div>

        {{-- password_confirmation --}}
        <div>
            <label for="password_confirmation" class="block text-sm font-bold text-gray-700 mb-2 mr-1">
                تأكيد كلمة المرور
            </label>
            <input id="password_confirmation" name="password_confirmation" type="password"
                   class="input-style block w-full border-gray-200 focus:border-pink-500 focus:ring-pink-500 rounded-2xl shadow-sm transition"
                   autocomplete="new-password">
            <x-input-error class="mt-2 text-right" :messages="$errors->get('password_confirmation')" />
        </div>

        <div class="flex items-center justify-center gap-4 pt-2">
            <button type="submit" class="btn-submit px-10">
                تغيير كلمة المرور
            </button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                   class="text-sm text-green-600 font-bold">تم تحديث كلمة المرور</p>
            @endif
        </div>
    </form>
</section>