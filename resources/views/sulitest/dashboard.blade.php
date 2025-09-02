@extends('sulitest.index')

@section('content')
    <header class="bg-white shadow-sm">
        <div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
            <h1 class="text-lg font-semibold leading-6 text-gray-900">Dashboard Peserta</h1>
            <p class="mt-1 text-sm text-gray-600">Selamat datang, {{ Auth::user()->name }}. Silakan pilih tes yang tersedia di bawah ini.</p>
        </div>
    </header>

    <main class="py-10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="space-y-8">
                @forelse ($exams as $exam)
                    <div class="overflow-hidden rounded-lg bg-white shadow">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <span class="flex h-12 w-12 items-center justify-center rounded-lg bg-teal-500">
                                        <i class="fas fa-file-alt text-white text-xl"></i>
                                    </span>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="truncate text-lg font-semibold text-gray-900">{{ $exam->title }}</dt>
                                        <dd class="text-sm text-gray-500">{{ $exam->description }}</dd>
                                    </dl>
                                </div>
                            </div>
                            <div class="mt-6 flex items-center justify-between">
                                <div class="flex space-x-4 text-sm text-gray-600">
                                    <div>
                                        <i class="fas fa-clock mr-1.5 text-gray-400"></i>
                                        Durasi: <strong>{{ $exam->duration }} Menit</strong>
                                    </div>
                                    <div>
                                        <i class="fas fa-list-ol mr-1.5 text-gray-400"></i>
                                        Jumlah Soal: <strong>{{ $exam->number_of_questions }} Soal</strong>
                                    </div>
                                </div>
                                <form action="{{ route('sulitest.test.start', $exam->id) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="rounded-md bg-teal-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-teal-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-teal-600">
                                        Mulai Tes
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center rounded-lg border-2 border-dashed border-gray-300 p-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-semibold text-gray-900">Tidak Ada Tes</h3>
                        <p class="mt-1 text-sm text-gray-500">Saat ini belum ada tes yang tersedia untuk Anda.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </main>
@endsection
