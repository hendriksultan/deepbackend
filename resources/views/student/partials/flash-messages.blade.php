{{-- ========================================================================= --}}
    {{-- ⭐ NOTIFIKASI FLASH MESSAGE (AUTO CLOSE 5 DETIK) ⭐ --}}
{{-- ========================================================================= --}}

    @if(session('success'))
    {{-- Tambahan: x-init="setTimeout(() => show = false, 5000)" --}}
    <div x-data="{ show: true }"
      x-show="show"
      x-init="setTimeout(() => show = false, 5000)"
      x-transition.duration.500ms
      class="mb-6 bg-green-50 dark:bg-green-900/40 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-200 px-5 py-4 rounded-[20px] shadow-lg flex items-start gap-3 relative z-50">

      <div class="bg-green-100 dark:bg-green-800 p-2 rounded-full shrink-0">
        <svg class="w-6 h-6 text-green-600 dark:text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
        </svg>
      </div>
      <div class="pt-1 flex-1">
        <h4 class="font-bold text-lg">Alhamdulillah!</h4>
        <p>{{ session('success') }}</p>
        {{-- Progress bar animasi durasi (Opsional, pemanis visual) --}}
        <div class="mt-2 h-1 w-full bg-green-200 dark:bg-green-800 rounded-full overflow-hidden">
          <div class="h-full bg-green-500 transition-all duration-[5000ms] ease-linear w-0" x-init="$nextTick(() => $el.style.width = '100%')"></div>
        </div>
      </div>
      <button @click="show = false" class="absolute top-4 right-4 text-green-500 hover:text-green-700 dark:hover:text-green-200">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
      </button>
    </div>
    @endif

    @if(session('error'))
    <div x-data="{ show: true }"
      x-show="show"
      x-init="setTimeout(() => show = false, 5000)"
      x-transition.duration.500ms
      class="mb-6 bg-red-50 dark:bg-red-900/40 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-200 px-5 py-4 rounded-[20px] shadow-lg flex items-start gap-3 relative z-50">

      <div class="bg-red-100 dark:bg-red-800 p-2 rounded-full shrink-0">
        <svg class="w-6 h-6 text-red-600 dark:text-red-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
      </div>
      <div class="pt-1 flex-1">
        <h4 class="font-bold text-lg">Mohon Maaf</h4>
        <p>{{ session('error') }}</p>
        {{-- Progress bar animasi --}}
        <div class="mt-2 h-1 w-full bg-red-200 dark:bg-red-800 rounded-full overflow-hidden">
          <div class="h-full bg-red-500 transition-all duration-[5000ms] ease-linear w-0" x-init="$nextTick(() => $el.style.width = '100%')"></div>
        </div>
      </div>
      <button @click="show = false" class="absolute top-4 right-4 text-red-500 hover:text-red-700 dark:hover:text-red-200">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
      </button>
    </div>
    @endif