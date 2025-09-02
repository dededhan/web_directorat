@extends('admin_pemeringkatan.index')

@section('contentadmin_pemeringkatan')
<div class="px-4 sm:px-6 lg:px-8 py-8" x-data="{ activeTab: 'participants' }">
    <div>
        <nav class="hidden sm:flex" aria-label="Breadcrumb">
            <ol role="list" class="flex items-center space-x-4">
                <li>
                    <a href="{{ route('admin_pemeringkatan.dashboard') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700">Dashboard</a>
                </li>
                <li>
                    <i class="fas fa-chevron-right flex-shrink-0 h-5 w-5 text-gray-400"></i>
                    <a href="{{ route('admin_pemeringkatan.sulitest_exams.index') }}" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700">Manajemen Ujian</a>
                </li>
            </ol>
        </nav>
        <div class="mt-2 md:flex md:items-center md:justify-between">
            <div class="min-w-0 flex-1">
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">Kelola Ujian: {{ $exam->title }}</h2>
            </div>
        </div>
    </div>

    <div class="mt-6">
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                <a href="#" @click.prevent="activeTab = 'details'" 
                   :class="{'border-teal-500 text-teal-600': activeTab === 'details', 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700': activeTab !== 'details'}" 
                   class="whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium">
                   Detail Ujian
                </a>
                <a href="#" @click.prevent="activeTab = 'participants'" 
                   :class="{'border-teal-500 text-teal-600': activeTab === 'participants', 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700': activeTab !== 'participants'}" 
                   class="whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium">
                   Peserta ({{ $exam->participants->count() }})
                </a>
            </nav>
        </div>
    </div>

    <div class="mt-8">
        <div x-show="activeTab === 'details'" x-cloak>
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Informasi Ujian</h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">Detail konfigurasi untuk ujian ini.</p>
                </div>
                <div class="border-t border-gray-200 px-4 py-5 sm:p-0">
                    <dl class="sm:divide-y sm:divide-gray-200">
                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Judul</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $exam->title }}</dd>
                        </div>
                         <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Jadwal</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $exam->start_time->format('d M Y, H:i') }} - {{ $exam->end_time->format('d M Y, H:i') }}</dd>
                        </div>
                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Durasi</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $exam->duration }} Menit</dd>
                        </div>
                         <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Paket Soal</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $exam->questionBank->name }} ({{ $exam->number_of_questions }} soal acak)</dd>
                        </div>
                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Deskripsi</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $exam->description ?? '-' }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>

        <div x-show="activeTab === 'participants'" x-cloak>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2">
                     <h3 class="text-lg font-medium text-gray-900 mb-4">Daftar Peserta Terdaftar</h3>
                     <div class="bg-white shadow sm:rounded-lg">
                        <ul role="list" class="divide-y divide-gray-200">
                            @forelse ($exam->participants as $participant)
                            <li class="px-6 py-4 flex items-center justify-between">
                                <div class="text-sm font-medium text-gray-800">{{ $participant->name }}</div>
                                <form action="{{ route('admin_pemeringkatan.sulitest_exams.participants.remove', ['exam' => $exam, 'user' => $participant]) }}" method="POST" onsubmit="return confirm('Hapus peserta ini dari ujian?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-sm font-medium text-red-600 hover:text-red-800">Hapus</button>
                                </form>
                            </li>
                            @empty
                            <li class="px-6 py-10 text-center text-sm text-gray-500">Belum ada peserta yang ditambahkan.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
                <div>
                    <form action="{{ route('admin_pemeringkatan.sulitest_exams.participants.assign', $exam) }}" method="POST">
                        @csrf
                        <div class="bg-white p-6 rounded-lg shadow-lg border">
                            <h3 class="text-lg font-medium text-gray-900">Tambahkan Peserta</h3>
                            <div class="mt-4">
                                <label for="participants" class="block text-sm font-medium text-gray-700">Pilih satu atau lebih peserta</label>
                                <select multiple name="participants[]" id="participants" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm h-60">
                                    @foreach ($potentialParticipants as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                                @if($potentialParticipants->isEmpty())
                                <p class="mt-2 text-sm text-gray-500">Semua user dengan role peserta sudah terdaftar.</p>
                                @endif
                            </div>
                             <div class="mt-6">
                                <button type="submit" class="w-full inline-flex items-center justify-center rounded-md bg-teal-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-teal-700">
                                    <i class="fas fa-plus mr-2"></i>
                                    Tambahkan ke Ujian
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
