<x-student-layout>
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4 pb-8 md:pt-6 md:pb-12">

    {{-- NAVIGASI KEMBALI --}}
    <div class="hidden md:block mb-6 md:mb-8">
      <a href="{{ route('student.dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2 md:px-5 md:py-2.5 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-full text-xs md:text-sm font-semibold text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-green-600 dark:hover:text-green-400 hover:border-green-200 dark:hover:border-green-900 transition-all duration-300 shadow-sm group">
        <svg class="w-3 h-3 md:w-4 md:h-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        Kembali
      </a>
    </div>

    {{-- HEADER --}}
    <div class="mb-6 md:mb-8">
      <h1 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white tracking-tight">Cari Pengajar</h1>
      <p class="text-gray-500 dark:text-gray-400 mt-1 md:mt-2 text-sm md:text-lg">Temukan pembimbing di wilayah Anda.</p>
    </div>

    {{-- KOTAK FILTER PENCARIAN --}}
    <div class="bg-white dark:bg-gray-800 p-4 md:p-6 rounded-2xl md:rounded-3xl border border-gray-200 dark:border-gray-700 shadow-sm mb-8 md:mb-10" x-data="wilayahFilter()">
      <form action="{{ route('student.teachers.index') }}" method="GET">
        
        {{-- Baris 1: 4 Dropdown Wilayah --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3 md:gap-4 mb-3 md:mb-4">
          
          {{-- Dropdown Provinsi --}}
          <div>
            <label class="block text-[10px] md:text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5 ml-1">Provinsi</label>
            <select name="province" x-model="selectedProvName" @change="fetchCities($event)" 
                    class="w-full px-4 py-2.5 md:py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-700 dark:text-gray-300 text-sm focus:bg-white dark:focus:bg-gray-800 focus:border-green-500 focus:ring-2 focus:ring-green-200 transition appearance-none cursor-pointer">
              <option value="">Semua Provinsi</option>
              <template x-for="prov in provinces" :key="prov.id">
                <option :value="prov.name" :data-id="prov.id" x-text="toTitleCase(prov.name)" :selected="prov.name == '{{ request('province') }}'"></option>
              </template>
            </select>
          </div>

          {{-- Dropdown Kota/Kabupaten --}}
          <div>
            <label class="block text-[10px] md:text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5 ml-1">Kab/Kota</label>
            <select name="city" x-model="selectedCityName" @change="fetchDistricts($event)" :disabled="cities.length === 0"
                    class="w-full px-4 py-2.5 md:py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-700 dark:text-gray-300 text-sm focus:bg-white dark:focus:bg-gray-800 focus:border-green-500 focus:ring-2 focus:ring-green-200 transition appearance-none disabled:opacity-50 disabled:cursor-not-allowed cursor-pointer">
              <option value="">Semua Kab/Kota</option>
              <template x-for="city in cities" :key="city.id">
                <option :value="city.name" :data-id="city.id" x-text="toTitleCase(city.name)" :selected="city.name == '{{ request('city') }}'"></option>
              </template>
            </select>
          </div>

          {{-- Dropdown Kecamatan --}}
          <div>
            <label class="block text-[10px] md:text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5 ml-1">Kecamatan</label>
            <select name="district" x-model="selectedDistrictName" @change="fetchVillages($event)" :disabled="districts.length === 0"
                    class="w-full px-4 py-2.5 md:py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-700 dark:text-gray-300 text-sm focus:bg-white dark:focus:bg-gray-800 focus:border-green-500 focus:ring-2 focus:ring-green-200 transition appearance-none disabled:opacity-50 disabled:cursor-not-allowed cursor-pointer">
              <option value="">Semua Kecamatan</option>
              <template x-for="dist in districts" :key="dist.id">
                <option :value="dist.name" :data-id="dist.id" x-text="toTitleCase(dist.name)" :selected="dist.name == '{{ request('district') }}'"></option>
              </template>
            </select>
          </div>

          {{-- Dropdown Desa/Kelurahan --}}
          <div>
            <label class="block text-[10px] md:text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5 ml-1">Desa/Kelurahan</label>
            <select name="village" x-model="selectedVillageName" :disabled="villages.length === 0"
                    class="w-full px-4 py-2.5 md:py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-700 dark:text-gray-300 text-sm focus:bg-white dark:focus:bg-gray-800 focus:border-green-500 focus:ring-2 focus:ring-green-200 transition appearance-none disabled:opacity-50 disabled:cursor-not-allowed cursor-pointer">
              <option value="">Semua Desa</option>
              <template x-for="vill in villages" :key="vill.id">
                <option :value="vill.name" x-text="toTitleCase(vill.name)" :selected="vill.name == '{{ request('village') }}'"></option>
              </template>
            </select>
          </div>

        </div>

        {{-- Baris 2: Pencarian Nama & Tombol Cari --}}
        <div class="flex flex-col md:flex-row gap-3 md:gap-4 items-end">
          
          <div class="w-full flex-grow">
            <label class="block text-[10px] md:text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5 ml-1">Nama Guru</label>
            
            <div class="relative group">
              <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Ketik nama ustadz / ustadzah..."
                class="w-full pl-10 pr-4 py-2.5 md:py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-200 text-sm focus:bg-white dark:focus:bg-gray-800 focus:border-green-500 focus:ring-2 focus:ring-green-200 transition shadow-sm group-hover:border-green-300 dark:group-hover:border-green-700">
              
              <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 group-hover:text-green-600 dark:group-hover:text-green-400 transition pointer-events-none">
                <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
              </div>
            </div>
          </div>

          <button type="submit" class="w-full md:w-auto px-8 py-2.5 md:py-3 bg-green-600 hover:bg-green-700 text-white text-sm md:text-base font-bold rounded-xl shadow-md transition-all flex items-center justify-center gap-2 shrink-0">
            <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            Terapkan Filter
          </button>
          
          {{-- Tombol Reset Cepat --}}
          @if(request()->anyFilled(['province', 'city', 'district', 'village', 'search']))
          <a href="{{ route('student.teachers.index') }}" class="w-full md:w-auto px-4 py-2.5 md:py-3 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-600 dark:text-gray-300 text-sm md:text-base font-bold rounded-xl transition-all text-center shrink-0">
            Reset
          </a>
          @endif
        </div>

      </form>
    </div>

    {{-- GRID GURU [PERBAIKAN: Diubah jadi grid-cols-1 di HP agar tombol Detail & Daftar tidak tergencet] --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6 mb-12">
      @forelse($teachers as $guru)
      
      {{-- [PERBAIKAN] Struktur Card Wrapper dirapikan agar konten dan footer lebih kokoh --}}
      <div class="bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-2xl md:rounded-3xl overflow-hidden shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col h-full group">

        <div class="p-4 md:p-6 flex-grow flex flex-col">
          <div class="flex justify-between items-start mb-4">
            
            {{-- LOGIKA FOTO PROFIL --}}
            <div class="w-12 h-12 md:w-14 md:h-14 rounded-full bg-gray-100 dark:bg-gray-700 overflow-hidden border-2 border-green-50 dark:border-gray-600 flex-shrink-0">
              @if($guru->photo_url)
              <img src="{{ $guru->photo_url }}"
                alt="{{ $guru->user->name ?? 'Pengajar' }}"
                class="w-full h-full object-cover">
              @else
              <div class="w-full h-full bg-green-100 dark:bg-green-900 flex items-center justify-center text-green-700 dark:text-green-400 font-bold text-lg">
                {{-- [PERBAIKAN AMAN] Mencegah error null jika nama kosong --}}
                {{ substr($guru->user->name ?? 'G', 0, 1) }}
              </div>
              @endif
            </div>

            <span class="px-2 py-1 md:px-3 text-[10px] md:text-xs font-bold rounded-full {{ ($guru->method ?? '') == 'online' ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300' : 'bg-orange-100 text-orange-700 dark:bg-orange-900/30 dark:text-orange-300' }}">
              {{-- [PERBAIKAN AMAN] Mencegah PHP Fatal Error ucfirst(null) --}}
              {{ ucfirst($guru->method ?? 'Belum Diatur') }}
            </span>
          </div>

          {{-- Nama Guru --}}
          <div class="flex items-center gap-1.5 mb-1">
            <h3 class="font-bold text-gray-900 dark:text-white text-base md:text-sm group-hover:text-green-600 dark:group-hover:text-green-400 transition line-clamp-1">
              {{ $guru->user->name ?? 'Tanpa Nama' }}
            </h3>

            @if($guru->user->is_verified ?? true)
            <div class="group/tooltip relative inline-flex items-center">
              <img width="18" height="18" src="https://img.icons8.com/fluency/48/verified-account--v1.png" alt="verified-account--v1" />
              <span class="absolute bottom-full left-1/2 -translate-x-1/2 mb-1.5 px-2 py-1 text-[10px] font-semibold text-white bg-gray-900 rounded opacity-0 group-hover/tooltip:opacity-100 transition-opacity duration-200 pointer-events-none whitespace-nowrap shadow-lg z-10">
                Verified Teacher
                <span class="absolute top-full left-1/2 -translate-x-1/2 -mt-1 border-4 border-transparent border-t-gray-900"></span>
              </span>
            </div>
            @endif
          </div>

          <p class="text-green-600 dark:text-green-400 text-[9px] md:text-[10px] font-bold uppercase tracking-wider mb-2 md:mb-4 line-clamp-1">
              {{ Str::limit($guru->specialization ?? 'Guru Ngaji', 20) }}
          </p>

          {{-- Bio Singkat --}}
          <div class="relative hidden md:block mb-3">
            <p class="text-gray-500 dark:text-gray-400 text-sm leading-relaxed line-clamp-2 opacity-90">
              {{ $guru->bio ?? 'Belum ada deskripsi singkat.' }}
            </p>
          </div>
          
          {{-- Indikator Wilayah Guru --}}
          @if(!empty($guru->user->city) || !empty($guru->user->province))
          <div class="flex flex-col gap-0.5 mt-1 mb-3 text-[10px] md:text-xs text-gray-500 dark:text-gray-400 border-l-2 border-green-200 dark:border-green-800 pl-2">
             {{-- [PERBAIKAN AMAN] Mencegah Fatal Error jika PHP mencoba melowercase nilai NULL (Fatal TypeError di PHP 8.1+) --}}
             <span class="font-semibold text-gray-700 dark:text-gray-300 line-clamp-1">{{ ucwords(strtolower($guru->user->district ?? $guru->user->city ?? '')) }}</span>
             <span class="text-[9px] md:text-[10px] line-clamp-1">{{ ucwords(strtolower($guru->user->province ?? '')) }}</span>
          </div>
          @endif

          {{-- INDIKATOR PROGRAM MENGAJAR --}}
          <div class="mt-auto pt-2">
            <div class="flex flex-wrap gap-1.5">
              @if(!empty($guru->teaching_levels) && is_array($guru->teaching_levels))
                @php
                $allowedPrograms = ['iqra', 'tahsin', 'tahfidz', 'sanad', 'bahasa'];
                $validLevels = array_filter($guru->teaching_levels, fn($l) => in_array($l, $allowedPrograms));
                $validLevels = array_values($validLevels); 
                @endphp

                @if(count($validLevels) > 0)
                  @foreach(array_slice($validLevels, 0, 2) as $level)
                    @php
                    $levelColor = match($level) {
                    'iqra' => 'bg-emerald-50 text-emerald-600 border-emerald-100 dark:bg-emerald-900/30 dark:text-emerald-400 dark:border-emerald-800',
                    'tahsin' => 'bg-blue-50 text-blue-600 border-blue-100 dark:bg-blue-900/30 dark:text-blue-400 dark:border-blue-800',
                    'tahfidz' => 'bg-amber-50 text-amber-600 border-amber-100 dark:bg-amber-900/30 dark:text-amber-400 dark:border-amber-800',
                    'sanad' => 'bg-purple-50 text-purple-600 border-purple-100 dark:bg-purple-900/30 dark:text-purple-400 dark:border-purple-800',
                    'bahasa' => 'bg-indigo-50 text-indigo-600 border-indigo-100 dark:bg-indigo-900/30 dark:text-indigo-400 dark:border-indigo-800',
                    };
                    $levelLabel = match($level) {
                    'iqra' => 'Iqra', 'tahsin' => 'Tahsin', 'tahfidz' => 'Tahfidz', 'sanad' => 'Sanad', 'bahasa' => 'Bahasa',
                    };
                    @endphp
                    <span class="px-2 py-0.5 text-[9px] md:text-[10px] font-bold rounded border {{ $levelColor }}">
                      {{ $levelLabel }}
                    </span>
                  @endforeach
                  @if(count($validLevels) > 2)
                  <span class="px-2 py-0.5 text-[9px] md:text-[10px] font-bold rounded border bg-gray-50 text-gray-500 border-gray-200">
                    +{{ count($validLevels) - 2 }}
                  </span>
                  @endif
                @else
                <span class="px-2 py-0.5 text-[9px] md:text-[10px] font-bold rounded border bg-gray-50 text-gray-400">Belum Ditentukan</span>
                @endif
              @else
              <span class="px-2 py-0.5 text-[9px] md:text-[10px] font-bold rounded border bg-gray-50 text-gray-400">Belum Ditentukan</span>
              @endif
            </div>
          </div>

        </div>

        {{-- Footer Card [PERBAIKAN STRUKTUR PADDING] --}}
        <div class="p-3 md:p-4 border-t border-gray-100 dark:border-gray-700 bg-gray-50/80 dark:bg-gray-800/80">
          <div class="flex justify-between items-center mb-3 px-1">
            <span class="text-[10px] md:text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-widest">Kuota</span>
            @if($guru->is_full)
            <span class="text-[10px] md:text-xs font-bold text-red-600 dark:text-red-400 bg-red-50 dark:bg-red-900/20 px-2 py-0.5 rounded border border-red-100 dark:border-red-900/50">Penuh</span>
            @else
            <span class="text-[10px] md:text-xs font-bold text-green-600 dark:text-green-400 bg-green-50 dark:bg-green-900/20 px-2 py-0.5 rounded border border-green-100 dark:border-green-900/50">{{ $guru->remaining_quota ?? 0 }} Sisa</span>
            @endif
          </div>

          <div class="flex gap-2">
            <a href="{{ route('student.teachers.show', $guru->id) }}" class="flex-1 py-2 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-center rounded-lg text-xs md:text-sm font-bold border border-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600 transition shadow-sm min-w-0">
              Detail
            </a>

            @if($guru->is_full)
            <button disabled class="flex-1 py-2 bg-gray-200 dark:bg-gray-800 text-gray-400 dark:text-gray-500 text-center rounded-lg text-xs md:text-sm font-bold cursor-not-allowed border border-transparent min-w-0">
              Tutup
            </button>
            @else
            <a href="{{ route('booking.create', $guru->id) }}" class="flex-1 py-2 bg-green-600 text-white text-center rounded-lg text-xs md:text-sm font-bold hover:bg-green-700 transition shadow-md shadow-green-200 dark:shadow-none min-w-0">
              Daftar
            </a>
            @endif
          </div>
        </div>
      </div>

      @empty
      <div class="col-span-full py-12 md:py-20 text-center">
        <div class="inline-flex items-center justify-center w-16 h-16 md:w-24 md:h-24 rounded-full bg-gray-100 dark:bg-gray-800 mb-4 md:mb-6">
          <svg class="w-8 h-8 md:w-10 md:h-10 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
          </svg>
        </div>
        <h3 class="text-base md:text-xl font-medium text-gray-900 dark:text-white">Tidak ada pengajar ditemukan</h3>
        <p class="text-gray-500 mt-2 text-sm">Coba sesuaikan pencarian atau perluas cakupan filter wilayah Anda.</p>
        <a href="{{ route('student.teachers.index') }}" class="inline-block mt-4 md:mt-6 px-4 py-2 md:px-6 md:py-2 bg-green-600 text-white rounded-full text-xs md:text-sm font-bold hover:bg-green-700 transition shadow-lg shadow-green-500/30">Reset Pencarian</a>
      </div>
      @endforelse
    </div>

    {{-- PAGINATION --}}
    <div class="mt-6 md:mt-8 flex justify-center">
      {{ $teachers->withQueryString()->links() }}
    </div>

  </div>

  {{-- SCRIPT ALPINE.JS 4 LEVEL (Prov, Kota, Kec, Desa) --}}
  <script>
    document.addEventListener('alpine:init', () => {
      Alpine.data('wilayahFilter', () => ({
        provinces: [], cities: [], districts: [], villages: [],
        selectedProvName: '{{ request("province") }}',
        selectedCityName: '{{ request("city") }}',
        selectedDistrictName: '{{ request("district") }}',
        selectedVillageName: '{{ request("village") }}',

        // Fungsi Pembantu untuk Mengubah Teks menjadi Capitalize (Title Case)
        toTitleCase(str) {
            if (!str) return '';
            return str.toLowerCase().replace(/\b\w/g, s => s.toUpperCase());
        },

        init() {
          // Ambil Provinsi
          fetch('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json')
            .then(res => res.json())
            .then(data => {
              this.provinces = data;
              if(this.selectedProvName) {
                setTimeout(() => {
                  const sel = document.querySelector('select[name="province"]');
                  if (sel && sel.options[sel.selectedIndex]) {
                    this.loadCities(sel.options[sel.selectedIndex].dataset.id);
                  }
                }, 100);
              }
            });
        },

        fetchCities(e) {
          this.selectedCityName = ''; this.selectedDistrictName = ''; this.selectedVillageName = '';
          this.cities = []; this.districts = []; this.villages = [];
          const id = e.target.options[e.target.selectedIndex].dataset.id;
          if(id) this.loadCities(id);
        },

        loadCities(id) {
          fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${id}.json`)
            .then(res => res.json())
            .then(data => {
              this.cities = data;
              if(this.selectedCityName) {
                setTimeout(() => {
                  const sel = document.querySelector('select[name="city"]');
                  if (sel && sel.options[sel.selectedIndex]) {
                    this.loadDistricts(sel.options[sel.selectedIndex].dataset.id);
                  }
                }, 100);
              }
            });
        },

        fetchDistricts(e) {
          this.selectedDistrictName = ''; this.selectedVillageName = '';
          this.districts = []; this.villages = [];
          const id = e.target.options[e.target.selectedIndex].dataset.id;
          if(id) this.loadDistricts(id);
        },

        loadDistricts(id) {
          fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/districts/${id}.json`)
            .then(res => res.json())
            .then(data => {
              this.districts = data;
              if(this.selectedDistrictName) {
                setTimeout(() => {
                  const sel = document.querySelector('select[name="district"]');
                  if (sel && sel.options[sel.selectedIndex]) {
                    this.loadVillages(sel.options[sel.selectedIndex].dataset.id);
                  }
                }, 100);
              }
            });
        },

        fetchVillages(e) {
          this.selectedVillageName = '';
          this.villages = [];
          const id = e.target.options[e.target.selectedIndex].dataset.id;
          if(id) this.loadVillages(id);
        },

        loadVillages(id) {
          fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/villages/${id}.json`)
            .then(res => res.json())
            .then(data => this.villages = data);
        }
      }))
    })
  </script>
</x-student-layout>