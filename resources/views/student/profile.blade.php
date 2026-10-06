<x-student-layout>
  <div class="container mx-auto px-4 py-6">
    {{-- Card Container --}}
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 md:p-8 max-w-3xl mx-auto transition-colors duration-300">

      {{-- Header --}}
      <div class="flex items-center justify-between mb-6 border-b border-gray-100 dark:border-gray-700 pb-4">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Profil Saya</h2>
        <span class="text-sm text-gray-500 dark:text-gray-400">Update data diri Anda</span>
      </div>

      {{-- Success Alert --}}
      @if(session('success'))
      <div class="bg-green-100 dark:bg-green-900 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-300 px-4 py-3 rounded-xl mb-6 flex items-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
        </svg>
        {{ session('success') }}
      </div>
      @endif

      <form action="{{ route('student.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8" x-data="wilayahProfile()">
        @csrf

        {{-- 1. BAGIAN FOTO PROFIL --}}
        <div class="flex flex-col sm:flex-row items-center gap-6 p-4 bg-gray-50 dark:bg-gray-700/50 rounded-2xl border border-gray-100 dark:border-gray-600 transition-colors">
          <div class="relative group">
            <div class="w-24 h-24 rounded-full bg-white dark:bg-gray-600 overflow-hidden border-4 border-white dark:border-gray-600 shadow-md">
              @if($user->profile_photo_path)
              <img src="{{ asset('storage/' . $user->profile_photo_path) }}" class="w-full h-full object-cover">
              @else
              <div class="w-full h-full flex items-center justify-center text-green-600 dark:text-green-400 bg-green-50 dark:bg-green-900 font-bold text-3xl">
                {{ substr($user->name, 0, 1) }}
              </div>
              @endif
            </div>
          </div>

          <div class="flex-1 w-full text-center sm:text-left">
            <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Ganti Foto Profil</label>
            <input type="file" name="photo" class="block w-full text-sm text-gray-500 dark:text-gray-400
                            file:mr-4 file:py-2 file:px-4
                            file:rounded-full file:border-0
                            file:text-sm file:font-semibold
                            file:bg-green-600 file:text-white
                            hover:file:bg-green-700 transition cursor-pointer
                        ">
            <p class="text-xs text-gray-400 dark:text-gray-500 mt-2">Format: JPG, PNG. Ukuran Max: 2MB.</p>
          </div>
        </div>

        {{-- 2. INFORMASI AKUN --}}
        <div>
          <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4 flex items-center gap-2">
            <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
            </svg>
            Informasi Akun
          </h3>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Nama --}}
            <div>
              <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Nama Lengkap</label>
              <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:border-green-500 focus:ring-2 focus:ring-green-200 dark:focus:ring-green-800 outline-none transition">
            </div>

            {{-- Email --}}
            <div>
              <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Email</label>
              <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:border-green-500 focus:ring-2 focus:ring-green-200 dark:focus:ring-green-800 outline-none transition">
            </div>

            {{-- Telepon --}}
            <div>
              <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">No. Telepon / WA</label>
              <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="0812..."
                class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:border-green-500 focus:ring-2 focus:ring-green-200 dark:focus:ring-green-800 outline-none transition">
            </div>

            {{-- Jenis Kelamin --}}
            <div>
              <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Jenis Kelamin</label>
              <select name="gender" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:border-green-500 focus:ring-2 focus:ring-green-200 dark:focus:ring-green-800 outline-none transition appearance-none">
                <option value="" disabled {{ !$user->gender ? 'selected' : '' }}>Pilih Gender</option>
                <option value="L" {{ old('gender', $user->gender) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                <option value="P" {{ old('gender', $user->gender) == 'P' ? 'selected' : '' }}>Perempuan</option>
              </select>
            </div>
          </div>
        </div>

        {{-- 3. BIODATA LENGKAP & ALAMAT --}}
        <div class="pt-4 border-t border-gray-100 dark:border-gray-700">
          <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4 flex items-center gap-2">
            <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path>
            </svg>
            Biodata Kelahiran & Alamat Domisili
          </h3>
          
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Tempat Lahir --}}
            <div>
              <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Tempat Lahir</label>
              <input type="text" name="birth_place" value="{{ old('birth_place', $user->birth_place) }}" placeholder="Contoh: Jakarta"
                class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:border-green-500 focus:ring-2 focus:ring-green-200 dark:focus:ring-green-800 outline-none transition">
            </div>

            {{-- Tanggal Lahir --}}
            <div>
              <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Tanggal Lahir</label>
              <input type="date" name="birth_date" value="{{ old('birth_date', optional($user->birth_date)->format('Y-m-d')) }}"
                class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:border-green-500 focus:ring-2 focus:ring-green-200 dark:focus:ring-green-800 outline-none transition [color-scheme:light] dark:[color-scheme:dark]">
            </div>

            {{-- Alamat --}}
            <div class="md:col-span-2">
              <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Alamat Lengkap / Detail Jalan</label>
              <textarea name="address" rows="3" placeholder="Jl. Raya..."
                class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:border-green-500 focus:ring-2 focus:ring-green-200 dark:focus:ring-green-800 outline-none transition">{{ old('address', $user->address) }}</textarea>
            </div>

            {{-- [DIPERBARUI] DROPDOWN WILAYAH DENGAN X-TEXT CAPITALIZE --}}
            
            {{-- Provinsi --}}
            <div>
              <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Provinsi</label>
              <select name="province" x-model="selectedProvName" @change="fetchCities($event)" 
                  class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:border-green-500 focus:ring-2 focus:ring-green-200 dark:focus:ring-green-800 outline-none transition appearance-none">
                  <option value="">Pilih Provinsi</option>
                  <template x-for="prov in provinces" :key="prov.id">
                      <option :value="prov.name" :data-id="prov.id" x-text="toTitleCase(prov.name)" :selected="prov.name == '{{ old('province', $user->province) }}'"></option>
                  </template>
              </select>
            </div>

            {{-- Kota/Kab --}}
            <div>
              <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Kota/Kabupaten</label>
              <select name="city" x-model="selectedCityName" @change="fetchDistricts($event)" :disabled="cities.length === 0"
                  class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:border-green-500 focus:ring-2 focus:ring-green-200 dark:focus:ring-green-800 outline-none transition appearance-none disabled:opacity-50">
                  <option value="">Pilih Kab/Kota</option>
                  <template x-for="city in cities" :key="city.id">
                      <option :value="city.name" :data-id="city.id" x-text="toTitleCase(city.name)" :selected="city.name == '{{ old('city', $user->city) }}'"></option>
                  </template>
              </select>
            </div>

            {{-- Kecamatan --}}
            <div>
              <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Kecamatan</label>
              <select name="district" x-model="selectedDistrictName" @change="fetchVillages($event)" :disabled="districts.length === 0"
                  class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:border-green-500 focus:ring-2 focus:ring-green-200 dark:focus:ring-green-800 outline-none transition appearance-none disabled:opacity-50">
                  <option value="">Pilih Kecamatan</option>
                  <template x-for="dist in districts" :key="dist.id">
                      <option :value="dist.name" :data-id="dist.id" x-text="toTitleCase(dist.name)" :selected="dist.name == '{{ old('district', $user->district) }}'"></option>
                  </template>
              </select>
            </div>

            {{-- Desa --}}
            <div>
              <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Desa/Kelurahan</label>
              <select name="village" x-model="selectedVillageName" :disabled="villages.length === 0"
                  class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:border-green-500 focus:ring-2 focus:ring-green-200 dark:focus:ring-green-800 outline-none transition appearance-none disabled:opacity-50">
                  <option value="">Pilih Desa/Kelurahan</option>
                  <template x-for="vill in villages" :key="vill.id">
                      <option :value="vill.name" x-text="toTitleCase(vill.name)" :selected="vill.name == '{{ old('village', $user->village) }}'"></option>
                  </template>
              </select>
            </div>

          </div>
        </div>

        {{-- TOMBOL SIMPAN --}}
        <div class="pt-6 border-t border-gray-100 dark:border-gray-700 flex justify-end">
          <button type="submit" class="bg-green-600 text-white px-8 py-3 rounded-xl font-bold hover:bg-green-700 dark:hover:bg-green-500 shadow-lg hover:shadow-green-200 dark:hover:shadow-green-900 transition transform active:scale-95 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            Simpan Perubahan
          </button>
        </div>
      </form>
    </div>
  </div>

  {{-- SCRIPT ALPINE.JS 4 LEVEL UNTUK PROFIL --}}
  <script>
    document.addEventListener('alpine:init', () => {
      Alpine.data('wilayahProfile', () => ({
        provinces: [], cities: [], districts: [], villages: [],
        selectedProvName: '{{ old("province", $user->province) }}',
        selectedCityName: '{{ old("city", $user->city) }}',
        selectedDistrictName: '{{ old("district", $user->district) }}',
        selectedVillageName: '{{ old("village", $user->village) }}',

        // [BARU] Fungsi Pembantu untuk Mengubah Teks menjadi Capitalize (Title Case)
        toTitleCase(str) {
            if (!str) return '';
            return str.toLowerCase().replace(/\b\w/g, s => s.toUpperCase());
        },

        init() {
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