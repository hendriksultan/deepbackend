<x-mail::layout>
  {{-- Header --}}
  <x-slot:header>
    <x-mail::header :url="config('app.url')">
      {{-- [PERBAIKAN] Mengganti teks/logo default dengan Logo DQA --}}
      <img src="{{ asset('images/d3.png') }}" alt="Deep Quran Academy" style="max-height: 65px; width: auto; object-fit: contain;">
    </x-mail::header>
  </x-slot:header>

  {{-- Body --}}
  {!! $slot !!}

  {{-- Subcopy --}}
  @isset($subcopy)
  <x-slot:subcopy>
    <x-mail::subcopy>
      {!! $subcopy !!}
    </x-mail::subcopy>
  </x-slot:subcopy>
  @endisset

  {{-- Footer --}}
  <x-slot:footer>
    <x-mail::footer>
      {{-- [PERBAIKAN] Mengubah teks footer ke Bahasa Indonesia --}}
      © {{ date('Y') }} Deep Quran Academy. Hak Cipta Dilindungi Undang-Undang.
    </x-mail::footer>
  </x-slot:footer>
</x-mail::layout>