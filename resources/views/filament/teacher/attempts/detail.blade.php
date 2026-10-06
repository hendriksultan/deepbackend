<div class="space-y-6">
  <div class="grid grid-cols-2 gap-4 p-4 bg-gray-50 dark:bg-gray-800 rounded-lg">
    <div>
      <p class="text-sm text-gray-500">Nama Siswa</p>
      <p class="font-bold text-lg">{{ $record->user->name }}</p>
    </div>
    <div class="text-right">
      <p class="text-sm text-gray-500">Nilai Akhir</p>
      <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold
                {{ $record->score >= 70 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
        {{ $record->score }}
      </span>
    </div>
  </div>

  <div class="space-y-4">
    @foreach($record->exam->questions as $index => $q)
    @php
    // Ambil jawaban siswa dari JSON
    $studentAnswer = $record->answers[$q->id] ?? null;
    // Cek benar/salah (Logika sederhana)
    $isCorrect = false;
    if($q->type == 'essay') {
    $isCorrect = null; // Essay butuh koreksi manual (anggap netral)
    } else {
    $isCorrect = strtolower(trim((string)$studentAnswer)) == strtolower(trim((string)$q->correct_answer));
    }
    @endphp

    <div class="p-4 border rounded-xl {{ $isCorrect === true ? 'border-green-200 bg-green-50/50' : ($isCorrect === false ? 'border-red-200 bg-red-50/50' : 'border-gray-200') }}">

      {{-- Soal --}}
      <div class="flex gap-3 mb-2">
        <span class="font-bold text-gray-500">#{{ $index + 1 }}</span>
        <div class="flex-1">
          <p class="font-medium text-gray-800 dark:text-white">{!! nl2br(e($q->question)) !!}</p>

          {{-- Jika ada gambar --}}
          @if($q->image)
          <img src="{{ asset('storage/'.$q->image) }}" class="mt-2 h-32 rounded object-cover">
          @endif
        </div>
      </div>

      {{-- Jawaban --}}
      <div class="ml-8 mt-3 text-sm grid grid-cols-1 md:grid-cols-2 gap-4">

        {{-- Jawaban Siswa --}}
        <div>
          <span class="block text-xs font-bold uppercase text-gray-400 mb-1">Jawaban Siswa:</span>
          @if($studentAnswer)
          <span class="font-bold {{ $isCorrect ? 'text-green-600' : 'text-red-600' }}">
            @if($q->type == 'multiple_choice')
            ({{ strtoupper($studentAnswer) }}) {{ $q->options[$studentAnswer] ?? '' }}
            @elseif($q->type == 'true_false')
            {{ $studentAnswer == 'true' ? 'BENAR' : 'SALAH' }}
            @else
            {{ $studentAnswer }}
            @endif
          </span>
          @else
          <span class="text-red-400 italic">Tidak dijawab</span>
          @endif
        </div>

        {{-- Kunci Jawaban (Hanya muncul untuk PG/TF) --}}
        @if($q->type != 'essay')
        <div>
          <span class="block text-xs font-bold uppercase text-gray-400 mb-1">Kunci Jawaban:</span>
          <span class="font-bold text-gray-700 dark:text-gray-300">
            @if($q->type == 'multiple_choice')
            ({{ strtoupper($q->correct_answer) }}) {{ $q->options[$q->correct_answer] ?? '' }}
            @elseif($q->type == 'true_false')
            {{ $q->correct_answer == 'true' ? 'BENAR' : 'SALAH' }}
            @endif
          </span>
        </div>
        @endif
      </div>
    </div>
    @endforeach
  </div>
</div>