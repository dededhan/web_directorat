@extends('sulitest.index')

@section('content')
    <header class="bg-white shadow-sm">
        <div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
            <h1 class="text-lg font-semibold leading-6 text-gray-900">Dashboard Peserta</h1>
            {{-- <p class="mt-1 text-sm text-gray-600">Selamat datang, {{ Auth::user()->name }}. Silakan pilih tes yang tersedia
                di bawah ini.</p> --}}
        </div>
    </header>

    <main class="py-10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="space-y-8">
                @if (isset($tests) && count($tests) > 0)
                    @foreach ($tests as $test)
                        <div class="overflow-hidden rounded-lg bg-white shadow">
                            <div class="p-6">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <span class="flex h-12 w-12 items-center justify-center rounded-lg bg-teal-500">
                                            <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="ml-5 w-0 flex-1">
                                        <dl>
                                            <dt class="truncate text-lg font-semibold text-gray-900">{{ $test->title }}
                                            </dt>
                                            <dd class="text-sm text-gray-500">{{ $test->description }}</dd>
                                        </dl>
                                    </div>
                                </div>
                                <div class="mt-6 flex items-center justify-between">
                                    <div class="flex space-x-4 text-sm text-gray-600">
                                        <div>
                                            <svg class="mr-1.5 h-5 w-5 inline-block text-gray-400" fill="none"
                                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Durasi: <strong>{{ $test->duration }} Menit</strong>
                                        </div>
                                        <div>
                                            <svg class="mr-1.5 h-5 w-5 inline-block text-gray-400" fill="none"
                                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Jumlah Soal: <strong>{{ $test->question_count }} Soal</strong>
                                        </div>
                                    </div>
                                    <form action="{{ route('sulitest.test.start', $test->id) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="rounded-md bg-teal-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-teal-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-teal-600">
                                            Mulai Tes
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="text-center rounded-lg border-2 border-dashed border-gray-300 p-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-semibold text-gray-900">Tidak Ada Tes</h3>
                        <p class="mt-1 text-sm text-gray-500">Saat ini belum ada tes yang tersedia untuk Anda.</p>
                    </div>
                @endif
            </div>
        </div>
    </main>
@endsection
