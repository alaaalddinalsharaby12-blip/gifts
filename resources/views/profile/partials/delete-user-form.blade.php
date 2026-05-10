<section class="space-y-6">
    <div class="flex justify-center">
        <button 
            x-data="" 
            x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
            class="px-8 py-3 bg-red-50 text-red-600 font-black rounded-2xl hover:bg-red-600 hover:text-white transition-all duration-300 border border-red-100"
        >
            إغلاق الحساب نهائياً
        </button>
    </div>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-8 text-right">
            @csrf
            @method('delete')

            <h2 class="text-2xl font-black text-gray-900 mb-3">
                هل أنت متأكد من الحذف؟
            </h2>

            <p class="text-gray-500 leading-relaxed mb-6">
                بمجرد حذف الحساب، سيتم مسح كافة البيانات والطلبات بشكل نهائي. يرجى إدخال كلمة المرور لتأكيد رغبتك في الحذف.
            </p>

            <div class="mt-6">
                <label for="password" class="sr-only">كلمة المرور</label>
                
                <input 
                    id="password" 
                    name="password" 
                    type="password" 
                    class="input-style block w-full border-gray-200 focus:border-red-500 focus:ring-red-500 rounded-2xl transition-all" 
                    placeholder="أدخل كلمة المرور للتأكيد"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2 text-right" />
            </div>

            <div class="mt-8 flex flex-row-reverse gap-3 justify-start">
                <button type="submit" class="px-6 py-3 bg-red-600 text-white rounded-xl font-bold hover:bg-red-700 transition shadow-lg shadow-red-200">
                    تأكيد الحذف النهائي
                </button>

                <button type="button" x-on:click="$dispatch('close')" class="px-6 py-3 bg-gray-100 text-gray-600 rounded-xl font-bold hover:bg-gray-200 transition">
                    تراجع
                </button>
            </div>
        </form>
    </x-modal>
</section>