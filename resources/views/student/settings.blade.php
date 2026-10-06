<x-student-layout>
  <div class="container mx-auto px-4 py-6">
    {{-- Card Container: bg-white -> dark:bg-gray-800, border -> dark:border-gray-700 --}}
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-8 text-center py-20 transition-colors duration-300">

      {{-- Icon Container: bg-gray-100 -> dark:bg-gray-700, text-gray-400 -> dark:text-gray-300 --}}
      <div class="w-20 h-20 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-6 text-gray-400 dark:text-gray-300">
        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
        </svg>
      </div>

      {{-- Title: text-gray-800 -> dark:text-white --}}
      <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-2">Pengaturan</h2>

      {{-- Description: text-gray-500 -> dark:text-gray-400 --}}
      <p class="text-gray-500 dark:text-gray-400 max-w-md mx-auto">Fitur pengaturan notifikasi, tema, dan bahasa sedang dalam pengembangan. Silakan cek kembali nanti.</p>
    </div>
  </div>
</x-student-layout>