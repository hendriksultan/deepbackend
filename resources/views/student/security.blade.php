<x-student-layout>
  <div class="container mx-auto px-4 py-6">
    {{-- Card Container --}}
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 md:p-8 max-w-2xl mx-auto transition-colors duration-300">

      {{-- Header --}}
      <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-6 border-b border-gray-100 dark:border-gray-700 pb-4">
        Keamanan Akun
      </h2>

      {{-- Success Alert --}}
      @if(session('success'))
      <div class="bg-green-100 dark:bg-green-900 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-300 px-4 py-3 rounded-xl mb-6">
        {{ session('success') }}
      </div>
      @endif

      <form action="{{ route('student.password.update') }}" method="POST" class="space-y-5">
        @csrf

        {{-- Password Saat Ini --}}
        <div>
          <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Password Saat Ini</label>
          <input type="password" name="current_password" required placeholder="••••••••"
            class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:border-green-500 focus:ring-2 focus:ring-green-200 dark:focus:ring-green-800 outline-none transition placeholder-gray-400 dark:placeholder-gray-500">
          @error('current_password') <span class="text-red-500 dark:text-red-400 text-sm mt-1 block">{{ $message }}</span> @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
          {{-- Password Baru --}}
          <div>
            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Password Baru</label>
            <input type="password" name="password" required placeholder="Minimal 8 karakter"
              class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:border-green-500 focus:ring-2 focus:ring-green-200 dark:focus:ring-green-800 outline-none transition placeholder-gray-400 dark:placeholder-gray-500">
            @error('password') <span class="text-red-500 dark:text-red-400 text-sm mt-1 block">{{ $message }}</span> @enderror
          </div>

          {{-- Konfirmasi Password --}}
          <div>
            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" required placeholder="Ulangi password baru"
              class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:border-green-500 focus:ring-2 focus:ring-green-200 dark:focus:ring-green-800 outline-none transition placeholder-gray-400 dark:placeholder-gray-500">
          </div>
        </div>

        {{-- Tombol Update --}}
        <div class="pt-4 flex justify-end">
          <button type="submit" class="bg-gray-800 dark:bg-gray-700 text-white px-8 py-3 rounded-xl font-bold hover:bg-black dark:hover:bg-gray-600 shadow-lg hover:shadow-gray-400 dark:hover:shadow-gray-900 transition transform active:scale-95">
            Update Password
          </button>
        </div>
      </form>
    </div>
  </div>
</x-student-layout>