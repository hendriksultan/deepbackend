{{-- ========================================== --}}
{{-- FLOATING AI CHAT WIDGET (EMERALD EDITION)  --}}
{{-- ========================================== --}}

<style>
  /* Scrollbar Custom */
  .chat-scrollbar::-webkit-scrollbar { width: 5px; }
  .chat-scrollbar::-webkit-scrollbar-track { background: transparent; }
  .chat-scrollbar::-webkit-scrollbar-thumb { background-color: #6ee7b7; border-radius: 10px; }
  .dark .chat-scrollbar::-webkit-scrollbar-thumb { background-color: #065f46; }
  .chat-scrollbar::-webkit-inner-spin-button,
  .chat-scrollbar::-webkit-outer-spin-button { -webkit-appearance: none; margin: 0; }

  /* Perbaikan Responsivitas Mobile & Desktop */
  @media (max-width: 767px) {
      .chat-box-mobile-custom {
          position: fixed !important;
          inset: auto !important; /* Reset inset-0 */
          bottom: 5rem !important; /* Beri jarak di atas navbar bawah */
          right: 1rem !important;
          left: 1rem !important;
          width: auto !important;
          height: 70vh !important; /* Jangan full screen agar user tidak bingung */
          border-radius: 1.5rem !important;
          z-index: 9999 !important; /* Pastikan di atas segalanya */
      }
  }

  @media (min-width: 768px) {
      .chat-box-desktop-override {
          position: absolute !important;
          inset: auto !important;
          bottom: 4rem !important; 
          right: 0 !important; 
          width: 400px !important;
          height: 500px !important;
          max-height: 80vh !important;
          border-radius: 1rem !important; 
          z-index: 50 !important;
      }
  }
</style>

{{-- SCRIPT DIPISAH AGAR TIDAK MERUSAK HTML --}}
<script>
  function formatAiMessage(text) {
    if (!text) return '';
    let safeText = text.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
    let urlRegex = /(https?:\/\/[^\s]+)/g;
    return safeText.replace(urlRegex, '<a href="$1" target="_blank" class="text-emerald-600 dark:text-emerald-400 font-bold underline hover:opacity-75" title="Buka link di tab baru">$1</a>');
  }
</script>

<div x-data="{ 
          isOpen: false,
          query: '', 
          isLoading: false,
          messages: [], 
          
          scrollToBottom() {
              setTimeout(() => {
                  let chatBox = document.getElementById('ai-chat-response-box');
                  if(chatBox) chatBox.scrollTop = chatBox.scrollHeight;
              }, 100);
          },

          askAi() {
              if(!this.query.trim()) return;
              
              let currentQuery = this.query.trim();
              this.messages.push({ role: 'user', text: currentQuery });
              
              this.query = '';
              this.isLoading = true;
              this.scrollToBottom();
              
              fetch('{{ route('ai.ask') }}', {
                  method: 'POST',
                  headers: {
                      'Content-Type': 'application/json',
                      'X-CSRF-TOKEN': '{{ csrf_token() }}'
                  },
                  body: JSON.stringify({ message: currentQuery })
              })
              .then(res => res.json())
              .then(data => {
                  if(data.success) {
                      this.messages.push({ role: 'ai', text: data.reply.trim() });
                  } else {
                      this.messages.push({ role: 'ai', text: 'Terjadi kesalahan: ' + data.error });
                  }
              })
              .catch(err => {
                  this.messages.push({ role: 'ai', text: 'Gagal menghubungi server AI. Pastikan internet stabil.' });
              })
              .finally(() => {
                  this.isLoading = false;
                  this.scrollToBottom();
              });
          }
      }"
  @click.outside="isOpen = false"
  class="fixed bottom-20 md:bottom-6 right-4 md:right-6 z-[60] font-sans">

  {{-- TOMBOL MENGAMBANG --}}
  <button @click="isOpen = !isOpen"
    class="bg-emerald-600 hover:bg-emerald-700 text-white p-4 rounded-full shadow-2xl transition-all duration-300 transform hover:scale-110 focus:outline-none flex items-center justify-center relative">
    <svg x-show="!isOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
    </svg>
    <svg x-show="isOpen" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
    </svg>
    <span x-show="!isOpen" class="absolute top-0 right-0 block h-3 w-3 rounded-full bg-red-500 ring-2 ring-white animate-pulse"></span>
  </button>

  {{-- KOTAK CHAT UTAMA --}}
  <div x-show="isOpen"
    x-cloak
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 translate-y-8 scale-95"
    x-transition:enter-end="opacity-100 translate-y-0 scale-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 translate-y-0 scale-100"
    x-transition:leave-end="opacity-0 translate-y-8 scale-95"
    
    class="bg-white dark:bg-gray-800 shadow-2xl border border-gray-100 dark:border-gray-700 overflow-hidden flex flex-col chat-box-mobile-custom chat-box-desktop-override origin-bottom-right">

    {{-- Header Kotak Chat --}}
    <div class="shrink-0 bg-gradient-to-r from-emerald-600 to-emerald-800 p-4 text-white flex items-center justify-between">
      <div class="flex items-center gap-3">
        <div class="bg-white/20 p-2 rounded-lg">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
          </svg>
        </div>
        <div>
          <h3 class="font-bold text-sm">Asisten Cerdas</h3>
          <p class="text-[11px] text-emerald-100 opacity-90">Deep Quran Academy</p>
        </div>
      </div>
      
      {{-- Tombol Close Khusus HP --}}
      <button @click="isOpen = false" class="md:hidden p-2 bg-white/10 hover:bg-white/20 rounded-full transition-colors focus:outline-none">
        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
      </button>
    </div>

    {{-- Area Scrollable (History Chat) --}}
    <div id="ai-chat-response-box" class="p-4 flex-1 overflow-y-auto chat-scrollbar bg-gray-50/50 dark:bg-gray-800/50 flex flex-col gap-4">

      {{-- Pesan Pembuka (Default) --}}
      <div x-show="messages.length === 0" class="text-center py-8 my-auto">
        <img src="https://cdn-icons-png.flaticon.com/512/8943/8943377.png" alt="AI Robot" class="w-16 h-16 mx-auto mb-3 opacity-80 mix-blend-multiply dark:mix-blend-normal">
        <p class="text-sm text-gray-500 dark:text-gray-400">Halo! Ada yang bisa saya bantu terkait aplikasi ini?</p>
      </div>

      {{-- Looping Pesan --}}
      <template x-for="(msg, index) in messages" :key="index">
        <div class="flex w-full" :class="msg.role === 'user' ? 'justify-end' : 'justify-start'">

          {{-- Gelembung Chat AI (Kiri) --}}
          <div x-show="msg.role === 'ai'"
            x-html="formatAiMessage(msg.text)"
            class="max-w-[85%] bg-white dark:bg-gray-700 px-3.5 py-2.5 rounded-2xl rounded-tl-none shadow-sm border border-transparent dark:border-gray-600 text-[13px] text-gray-700 dark:text-gray-200 whitespace-pre-line leading-snug break-words"></div>

          {{-- Gelembung Chat User (Kanan) --}}
          <div x-show="msg.role === 'user'"
            x-html="formatAiMessage(msg.text)"
            class="max-w-[85%] bg-emerald-600 px-3.5 py-2.5 rounded-2xl rounded-tr-none shadow-sm text-[13px] text-white whitespace-pre-line leading-snug break-words"></div>

        </div>
      </template>

      {{-- Status Loading --}}
      <div x-show="isLoading" class="flex w-full justify-start">
        <div class="max-w-[85%] bg-white dark:bg-gray-700 p-4 rounded-2xl rounded-tl-none shadow-sm border border-transparent dark:border-gray-600 flex items-center space-x-2">
          <div class="w-2 h-2 bg-emerald-500 rounded-full animate-bounce" style="animation-delay: -0.3s"></div>
          <div class="w-2 h-2 bg-emerald-500 rounded-full animate-bounce" style="animation-delay: -0.15s"></div>
          <div class="w-2 h-2 bg-emerald-500 rounded-full animate-bounce"></div>
        </div>
      </div>

    </div>

    {{-- Area Input Pertanyaan --}}
    <div class="shrink-0 p-3 bg-white dark:bg-gray-800 border-t border-gray-100 dark:border-gray-700 pb-safe">
      <div class="relative flex items-end gap-2">

        <textarea
          x-model="query"
          @keydown.enter.prevent="askAi()"
          rows="1"
          class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-2xl py-3 px-4 text-sm text-gray-700 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-emerald-500/50 resize-none max-h-24 overflow-y-auto"
          placeholder="Ketik pesan..."
          style="min-height: 44px;"
          x-on:input="$el.style.height = 'auto'; $el.style.height = $el.scrollHeight + 'px'"></textarea>

        <button @click="askAi()" :disabled="isLoading || !query.trim()"
          class="flex-shrink-0 w-11 h-11 bg-emerald-600 text-white rounded-full flex items-center justify-center hover:bg-emerald-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors shadow-sm mb-0.5">
          <svg class="w-5 h-5 transform translate-x-[-1px] translate-y-[1px] rotate-45" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
          </svg>
        </button>
      </div>
      <p class="text-[10px] text-gray-400 text-center mt-2 px-4 pb-2 md:pb-0">AI dapat membuat kesalahan. Selalu periksa informasi penting.</p>
    </div>

  </div>
</div>
