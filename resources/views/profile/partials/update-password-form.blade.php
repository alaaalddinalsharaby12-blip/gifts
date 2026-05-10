<section>
    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-5">
        @csrf
        @method('put')

        <div>
            <label for="update_password_current_password" class="block text-sm font-bold text-gray-700 mb-2 mr-1">
                كلمة المرور الحالية
            </label>
            <input id="update_password_current_password" name="current_password" type="password" 
                   class="input-style block w-full border-gray-200 focus:border-pink-500 focus:ring-pink-500 rounded-2xl shadow-sm transition" 
                   autocomplete="current-password" placeholder="••••••••">
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2 text-right" />
        </div>

        <div>
            <label for="update_password_password" class="block text-sm font-bold text-gray-700 mb-2 mr-1">
                كلمة المرور الجديدة
            </label>
            <input id="update_password_password" name="password" type="password" 
                   class="input-style block w-full border-gray-200 focus:border-pink-500 focus:ring-pink-500 rounded-2xl shadow-sm transition" 
                   autocomplete="new-password" placeholder="••••••••">
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2 text-right" />
        </div>

        <div>
            <label for="update_password_password_confirmation" class="block text-sm font-bold text-gray-700 mb-2 mr-1">
                تأكيد كلمة المرور الجديدة
            </label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" 
                   class="input-style block w-full border-gray-200 focus:border-pink-500 focus:ring-pink-500 rounded-2xl shadow-sm transition" 
                   autocomplete="new-password" placeholder="••••••••">
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2 text-right" />
        </div>

        <div class="flex items-center justify-center gap-4 pt-2">
            <button type="submit" class="btn-submit px-10">
                {{ __('تحديث كلمة المرور') }}
            </button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-green-600 font-bold"
                >تم التحديث بنجاح</p>
            @endif
        </div>
    </form>
</section>