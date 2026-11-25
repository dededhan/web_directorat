@extends('admin_pemeringkatan.index')

@section('contentadmin_pemeringkatan')
<div class="min-h-screen bg-gray-50 p-4 sm:p-6 lg:p-8">
    <div class="max-w-[1500px] mx-auto">
        <div class="mb-3">
            @include('admin_pemeringkatan.international-lecture.partials.back-button', [
                'backRoute' => 'admin_pemeringkatan.international-lecture.index',
                'backParams' => request('from_table') ? ['table' => 1] : [],
                'backLabel' => 'Kembali ke International Lecture',
            ])
        </div>
        <div class="mb-6">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">International Lecture — Greeting</h1>
            <p class="mt-1 text-sm text-gray-600">Kirim ucapan khusus kepada dosen asing, seperti ulang tahun UNJ atau ucapan ulang tahun dosen.</p>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg text-green-700">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg text-red-700">
                <ul class="list-disc list-inside space-y-1 text-sm">
                    @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 xl:grid-cols-5 gap-6">
            <div class="xl:col-span-2 bg-white rounded-xl shadow-md overflow-hidden">
                <div class="bg-gradient-to-r from-indigo-600 to-indigo-700 px-6 py-5 text-white">
                    <h2 class="text-lg font-semibold">Buat Greeting</h2>
                    <p class="text-indigo-100 text-sm mt-1">Maksimal 250 email dalam satu kali pengiriman.</p>
                </div>

                <form action="{{ route('admin_pemeringkatan.international-lecture.greeting.store') }}" method="POST" class="p-6 space-y-5" id="greetingForm">
                    @csrf
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Jenis Greeting</label>
                        <select name="greeting_type" id="greetingType" class="w-full border border-gray-300 rounded-lg px-3 py-2.5">
                            <option value="unj_anniversary" @selected(old('greeting_type') === 'unj_anniversary')>UNJ Anniversary / Ulang Tahun UNJ</option>
                            <option value="lecturer_birthday" @selected(old('greeting_type') === 'lecturer_birthday')>Birthday Greeting untuk Dosen Asing</option>
                            <option value="general" @selected(old('greeting_type') === 'general')>General Greeting</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Subject Email</label>
                        <input type="text" name="subject" id="greetingSubject" value="{{ old('subject', 'Warm Greetings from Universitas Negeri Jakarta') }}" maxlength="255" required class="w-full border border-gray-300 rounded-lg px-3 py-2.5">
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <label class="block text-sm font-semibold text-gray-700">Email Penerima</label>
                            <span id="recipientCounter" class="text-xs font-semibold text-indigo-600">0 / 250</span>
                        </div>
                        <textarea name="recipients" id="recipients" rows="9" required placeholder="Satu email per baris, atau pisahkan dengan koma / titik koma.&#10;&#10;contoh:&#10;lecturer1@example.com&#10;lecturer2@example.com" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 font-mono text-sm">{{ old('recipients') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Isi Greeting</label>
                        <textarea name="message" id="greetingMessage" rows="11" required class="w-full border border-gray-300 rounded-lg px-3 py-2.5">{{ old('message', "On behalf of Universitas Negeri Jakarta, we would like to send our warmest greetings to you.\n\nIt is a pleasure to share this special moment with our international academic partners. We wish you happiness, good health, and continued success.\n\nWarm regards,\nUniversitas Negeri Jakarta") }}</textarea>
                    </div>


                    <button type="submit" class="w-full inline-flex items-center justify-center px-5 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg">
                        <i class='bx bx-send mr-2'></i> Kirim Greeting
                    </button>
                </form>
            </div>

            <div class="xl:col-span-3 bg-white rounded-xl shadow-md overflow-hidden">
                <div class="px-6 py-5 border-b flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-800">Riwayat & Status Email Greeting</h2>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-800">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs text-gray-200 uppercase">Waktu</th>
                                <th class="px-4 py-3 text-left text-xs text-gray-200 uppercase">Penerima</th>
                                <th class="px-4 py-3 text-left text-xs text-gray-200 uppercase">Greeting</th>
                                <th class="px-4 py-3 text-center text-xs text-gray-200 uppercase">Status Email</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                        @forelse($greetings as $greeting)
                            @php
                                $status = $greeting->email_status ?: 'not_sent';
                                $statusClass = match($status) {
                                    'sent' => 'bg-green-50 text-green-700 border-green-200',
                                    'queued' => 'bg-yellow-50 text-yellow-700 border-yellow-200',
                                    'sending' => 'bg-blue-50 text-blue-700 border-blue-200',
                                    'failed' => 'bg-red-50 text-red-700 border-red-200',
                                    default => 'bg-gray-100 text-gray-600 border-gray-200',
                                };
                                $statusLabel = match($status) {
                                    'sent' => 'Terkirim',
                                    'queued' => 'Menunggu',
                                    'sending' => 'Mengirim',
                                    'failed' => 'Gagal',
                                    default => 'Belum Dikirim',
                                };
                            @endphp
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-4 text-xs text-gray-500 whitespace-nowrap">{{ $greeting->created_at->format('d M Y, H:i') }}</td>
                                <td class="px-4 py-4">
                                    <div class="text-sm font-semibold text-gray-900">{{ $greeting->recipient_name ?: 'International Lecturer' }}</div>
                                    <div class="text-xs text-gray-500">{{ $greeting->recipient_email }}</div>
                                </td>
                                <td class="px-4 py-4">
                                    <div class="text-sm font-medium text-gray-800">{{ $greeting->subject }}</div>
                                    <div class="text-xs text-gray-500">{{ str_replace('_', ' ', ucfirst($greeting->greeting_type)) }}</div>
                                </td>
                                <td class="px-4 py-4 text-center">
                                    <span class="inline-flex items-center justify-center min-w-[95px] px-3 py-1.5 rounded-lg border text-xs font-medium {{ $statusClass }}">
                                        @if($status === 'sent')<i class='bx bx-check mr-1'></i>@elseif($status === 'failed')<i class='bx bx-x mr-1'></i>@elseif($status === 'sending')<i class='bx bx-loader-alt bx-spin mr-1'></i>@elseif($status === 'queued')<i class='bx bx-time-five mr-1'></i>@else<i class='bx bx-envelope mr-1'></i>@endif
                                        {{ $statusLabel }}
                                    </span>
                                    @if($status === 'sent' && $greeting->email_sent_at)
                                        <div class="text-[10px] text-gray-400 mt-1">{{ $greeting->email_sent_at->format('d M Y, H:i') }}</div>
                                    @elseif($status === 'failed' && $greeting->email_error)
                                        <div title="{{ $greeting->email_error }}" class="text-[10px] text-red-500 mt-1 cursor-help">Lihat error</div>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="px-6 py-12 text-center text-gray-500">Belum ada email greeting.</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                @if($greetings->hasPages())
                    <div class="p-4 border-t">{{ $greetings->links() }}</div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const type = document.getElementById('greetingType');
    const subject = document.getElementById('greetingSubject');
    const message = document.getElementById('greetingMessage');
    const recipients = document.getElementById('recipients');
    const counter = document.getElementById('recipientCounter');

    const presets = {
        unj_anniversary: {
            subject: 'Warm Greetings on the Anniversary of Universitas Negeri Jakarta',
            message: "On behalf of Universitas Negeri Jakarta, we would like to extend our warmest greetings on the anniversary of Universitas Negeri Jakarta.\n\nWe are grateful for the valuable friendship and academic collaboration we share with our international partners. May this special occasion bring continued inspiration, progress, and success to our academic community.\n\nWarm regards,\nUniversitas Negeri Jakarta"
        },
        lecturer_birthday: {
            subject: 'Warm Birthday Wishes from Universitas Negeri Jakarta',
            message: "Universitas Negeri Jakarta would like to wish you a very happy birthday.\n\nMay this special day bring you happiness, good health, and continued success in your academic and professional journey. We are grateful for your connection with Universitas Negeri Jakarta.\n\nWarmest wishes,\nUniversitas Negeri Jakarta"
        },
        general: {
            subject: 'Warm Greetings from Universitas Negeri Jakarta',
            message: "On behalf of Universitas Negeri Jakarta, we would like to send our warmest greetings to you.\n\nWe wish you happiness, good health, and continued success. Thank you for being part of our international academic community.\n\nWarm regards,\nUniversitas Negeri Jakarta"
        }
    };

    type.addEventListener('change', function () {
        const preset = presets[this.value];
        if (!preset) return;
        subject.value = preset.subject;
        message.value = preset.message;
    });

    function updateCounter() {
        const emails = recipients.value.split(/[\\s,;]+/).map(v => v.trim().toLowerCase()).filter(Boolean);
        const unique = [...new Set(emails)];
        counter.textContent = unique.length + ' / 250';
        counter.classList.toggle('text-red-600', unique.length > 250);
        counter.classList.toggle('text-indigo-600', unique.length <= 250);
    }
    recipients.addEventListener('input', updateCounter);
    updateCounter();
});
</script>
@endsection
