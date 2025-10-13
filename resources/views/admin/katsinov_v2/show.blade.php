@extends('admin.admin')

@section('contentadmin')
<div class="p-6 max-w-7xl mx-auto">
    {{-- Header with Status --}}
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">{{ $katsinov->title }}</h1>
                <p class="text-gray-600 mt-1">{{ $katsinov->project_name }} - {{ $katsinov->institution }}</p>
            </div>
            
            @php
                $statusConfig = [
                    'draft' => ['bg' => 'bg-gray-100', 'text' => 'text-gray-800', 'label' => 'Draft'],
                    'submitted' => ['bg' => 'bg-purple-100', 'text' => 'text-purple-800', 'label' => 'Submitted'],
                    'assigned' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-800', 'label' => 'Assigned to Reviewer'],
                    'under_review' => ['bg' => 'bg-orange-100', 'text' => 'text-orange-800', 'label' => 'Under Review'],
                    'completed' => ['bg' => 'bg-green-100', 'text' => 'text-green-800', 'label' => 'Review Completed'],
                ];
                $config = $statusConfig[$katsinov->status] ?? ['bg' => 'bg-gray-100', 'text' => 'text-gray-800', 'label' => $katsinov->status];
            @endphp
            
            <div class="text-right">
                <span class="px-4 py-2 inline-flex text-sm leading-5 font-semibold rounded-full {{ $config['bg'] }} {{ $config['text'] }}">
                    {{ $config['label'] }}
                </span>
            </div>
        </div>
    </div>

    {{-- Action Buttons --}}
    <div class="bg-white rounded-lg shadow p-4 mb-6">
        <div class="flex flex-wrap gap-3 items-center justify-between">
            <a href="{{ route('admin.katsinov-v2.index') }}" 
               class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold rounded-lg transition duration-300 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali
            </a>

            <div class="flex gap-3">
                {{-- Button untuk mengisi form pendukung --}}
                @if(in_array($katsinov->status, ['draft', 'submitted', 'assigned']))
                    <div class="relative">
                        <button id="formMenuBtn" 
                                class="px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white font-semibold rounded-lg transition duration-300 flex items-center gap-2">
                            Form Pendukung
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div id="formMenu" class="hidden absolute right-0 mt-2 w-64 bg-white rounded-lg shadow-xl z-50 py-2">
                            <a href="{{ route('admin.katsinov-v2.form-inovasi', $katsinov->id) }}" 
                               class="block px-4 py-2 text-sm text-gray-700 hover:bg-purple-50 transition">
                                📝 Form Judul Inovasi
                            </a>
                            <a href="{{ route('admin.katsinov-v2.form-lampiran', $katsinov->id) }}" 
                               class="block px-4 py-2 text-sm text-gray-700 hover:bg-purple-50 transition">
                                📎 Form Lampiran
                            </a>
                            <a href="{{ route('admin.katsinov-v2.form-informasi-dasar', $katsinov->id) }}" 
                               class="block px-4 py-2 text-sm text-gray-700 hover:bg-purple-50 transition">
                                📋 Form Informasi Dasar
                            </a>
                            <a href="{{ route('admin.katsinov-v2.form-berita-acara', $katsinov->id) }}" 
                               class="block px-4 py-2 text-sm text-gray-700 hover:bg-purple-50 transition">
                                📄 Form Berita Acara
                            </a>
                            <a href="{{ route('admin.katsinov-v2.form-record-hasil', $katsinov->id) }}" 
                               class="block px-4 py-2 text-sm text-gray-700 hover:bg-purple-50 transition">
                                📊 Form Record Hasil
                            </a>
                        </div>
                    </div>
                @endif

                {{-- Reviewer Actions --}}
                @if(Auth::user()->role === 'validator' && $katsinov->reviewer_id === Auth::id())
                    @if($katsinov->status === 'assigned')
                        <button onclick="startReview()" 
                                class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg transition duration-300">
                            Mulai Review
                        </button>
                    @elseif($katsinov->status === 'under_review')
                        <button onclick="openCompleteModal()" 
                                class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition duration-300">
                            Selesaikan Review
                        </button>
                    @endif
                @endif

                {{-- User Actions --}}
                @if($katsinov->user_id === Auth::id() && $katsinov->status === 'draft')
                    <button onclick="submitForReview()" 
                            class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition duration-300">
                        Submit untuk Review
                    </button>
                @endif

                {{-- Print Button (Muncul setelah submitted) --}}
                @if(in_array($katsinov->status, ['submitted', 'assigned', 'in_review', 'completed']))
                    <a href="{{ route('admin.katsinov-v2.print', $katsinov->id) }}" 
                       target="_blank"
                       class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg transition duration-300 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                        </svg>
                        Print Proposal
                    </a>
                @endif
            </div>
        </div>
    </div>

    {{-- Information Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="bg-blue-100 rounded-full p-3 mr-4">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Dibuat oleh</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $katsinov->user->name ?? '-' }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="bg-green-100 rounded-full p-3 mr-4">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Reviewer</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $katsinov->reviewer->name ?? 'Belum ditugaskan' }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="bg-purple-100 rounded-full p-3 mr-4">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Tanggal Submit</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $katsinov->submitted_at ? $katsinov->submitted_at->format('d M Y') : '-' }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Button View Summary (Muncul setelah submit) --}}
    @if(in_array($katsinov->status, ['submitted', 'assigned', 'in_review', 'completed']) && $katsinov->responses->count() > 0)
    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-lg shadow-lg p-8 mb-6 border border-blue-200">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-800 mb-2">📊 Summary Keseluruhan Penilaian</h2>
                <p class="text-gray-600">Lihat detail lengkap penilaian per indikator dan aspek dengan visualisasi grafik</p>
            </div>
            <a href="{{ route('admin.katsinov-v2.summary', $katsinov->id) }}" 
               class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition duration-300 flex items-center gap-2 shadow-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                View Summary
            </a>
    </div>
    @endif

    {{-- Main Content --}}
    <div class="bg-white rounded-lg shadow p-8 mb-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Informasi Detail</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Judul Inovasi</label>
                <p class="text-gray-900">{{ $katsinov->title }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Fokus Area</label>
                <p class="text-gray-900">{{ $katsinov->focus_area }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Nama Proyek</label>
                <p class="text-gray-900">{{ $katsinov->project_name }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Institusi</label>
                <p class="text-gray-900">{{ $katsinov->institution }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Alamat</label>
                <p class="text-gray-900">{{ $katsinov->address }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Kontak</label>
                <p class="text-gray-900">{{ $katsinov->contact }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Tanggal Penilaian</label>
                <p class="text-gray-900">{{ $katsinov->assessment_date->format('d M Y') }}</p>
            </div>
        </div>
    </div>

    {{-- Scores Summary --}}
    @if($katsinov->scores->count() > 0)
    <div class="bg-white rounded-lg shadow p-8 mb-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Ringkasan Skor</h2>
        
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-4">
            @php
                $aspects = [
                    'technology' => ['label' => 'Teknologi', 'icon' => 'M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z'],
                    'organization' => ['label' => 'Organisasi', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z'],
                    'risk' => ['label' => 'Risiko', 'icon' => 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z'],
                    'market' => ['label' => 'Pasar', 'icon' => 'M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z'],
                    'partnership' => ['label' => 'Kemitraan', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z'],
                    'manufacturing' => ['label' => 'Manufaktur', 'icon' => 'M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z'],
                    'investment' => ['label' => 'Investasi', 'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
                ];
                
                $avgScores = [];
                foreach($aspects as $key => $aspect) {
                    $avgScores[$key] = $katsinov->scores->avg($key);
                }
            @endphp
            
            @foreach($aspects as $key => $aspect)
                @php
                    $score = $avgScores[$key];
                    $colorClass = $score >= 80 ? 'bg-green-100 text-green-800' : ($score >= 60 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800');
                @endphp
                <div class="bg-gray-50 rounded-lg p-4 text-center">
                    <div class="flex justify-center mb-2">
                        <svg class="w-8 h-8 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $aspect['icon'] }}"/>
                        </svg>
                    </div>
                    <p class="text-xs text-gray-600 mb-1">{{ $aspect['label'] }}</p>
                    <p class="text-2xl font-bold {{ $colorClass }} rounded px-2 py-1">{{ number_format($score, 1) }}%</p>
                </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Reviewer Notes --}}
    @if($katsinov->reviewer_notes && $katsinov->status === 'completed')
    <div class="bg-white rounded-lg shadow p-8 mb-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Catatan Reviewer</h2>
        <div class="bg-blue-50 border-l-4 border-blue-500 p-4">
            <p class="text-gray-700">{{ $katsinov->reviewer_notes }}</p>
        </div>
        <p class="text-sm text-gray-500 mt-2">Direview oleh: {{ $katsinov->reviewer->name }} pada {{ $katsinov->reviewed_at->format('d M Y H:i') }}</p>
    </div>
    @endif
</div>

{{-- Modal Complete Review --}}
<div id="completeModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Selesaikan Review</h3>
            <form id="completeForm">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Catatan Review (Opsional)</label>
                    <textarea name="reviewer_notes" rows="4" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                              placeholder="Tambahkan catatan atau feedback untuk submitter..."></textarea>
                </div>
                <div class="flex gap-2 justify-end">
                    <button type="button" onclick="closeCompleteModal()" 
                            class="px-4 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400">
                        Batal
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Selesai
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function startReview() {
    if (confirm('Mulai review untuk katsinov ini?')) {
        fetch(`/admin/katsinov-v2/{{ $katsinov->id }}/start-review`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                location.reload();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan');
        });
    }
}

function submitForReview() {
    if (confirm('Submit data ini untuk review?')) {
        fetch(`/admin/katsinov-v2/{{ $katsinov->id }}/submit`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                location.reload();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan');
        });
    }
}

function openCompleteModal() {
    document.getElementById('completeModal').classList.remove('hidden');
}

function closeCompleteModal() {
    document.getElementById('completeModal').classList.add('hidden');
    document.getElementById('completeForm').reset();
}

document.getElementById('completeForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const reviewerNotes = formData.get('reviewer_notes');
    
    fetch(`/admin/katsinov-v2/{{ $katsinov->id }}/complete-review`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ reviewer_notes: reviewerNotes })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            location.reload();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan');
    });
});

// Dropdown form menu
document.getElementById('formMenuBtn')?.addEventListener('click', function(e) {
    e.stopPropagation();
    document.getElementById('formMenu').classList.toggle('hidden');
});

document.addEventListener('click', function(e) {
    if (!e.target.closest('#formMenuBtn') && !e.target.closest('#formMenu')) {
        document.getElementById('formMenu')?.classList.add('hidden');
    }
});
</script>
@endsection
