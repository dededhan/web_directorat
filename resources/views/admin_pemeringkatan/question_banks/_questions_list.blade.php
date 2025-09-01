@extends('admin_pemeringkatan.index')

@section('contentadmin_pemeringkatan')
@php
    $questionBank = (object)[
        'id' => 1,
        'name' => 'Soal Logika Penalaran 2024',
        'description' => 'Kumpulan soal untuk menguji kemampuan penalaran logis dan analitis calon peserta.',
        'questions' => [
            (object)[
                'id' => 101,
                'question_text' => 'Semua mamalia menyusui. Paus adalah mamalia. Kesimpulannya adalah...',
                'context' => 'Logika Deduktif',
                'weight' => 2,
                'options' => [
                    (object)['option_text' => 'Paus bertelur', 'is_correct' => false],
                    (object)['option_text' => 'Paus menyusui', 'is_correct' => true],
                    (object)['option_text' => 'Semua hewan laut adalah mamalia', 'is_correct' => false],
                    (object)['option_text' => 'Paus bukan hewan laut', 'is_correct' => false],
                ]
            ],
            (object)[
                'id' => 102,
                'question_text' => 'Jika hari ini hujan, maka jalanan basah. Hari ini tidak hujan. Kesimpulannya adalah...',
                'context' => 'Logika Proposisi',
                'weight' => 3,
                'options' => [
                    (object)['option_text' => 'Jalanan pasti kering', 'is_correct' => false],
                    (object)['option_text' => 'Jalanan mungkin basah karena sebab lain', 'is_correct' => false],
                    (object)['option_text' => 'Tidak dapat ditarik kesimpulan', 'is_correct' => true],
                    (object)['option_text' => 'Besok akan hujan', 'is_correct' => false],
                ]
            ]
        ]
    ];
@endphp

<div class="px-4 sm:px-6 lg:px-8 py-8" x-data="{ activeTab: 'questions' }">
    <div>
        <nav class="sm:hidden" aria-label="Back">
            <a href="{{ route('admin_pemeringkatan.question_banks.index') }}" class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700">
                <i class="fas fa-chevron-left text-gray-400 -ml-1 mr-1"></i>
                Kembali ke Bank Soal
            </a>
        </nav>
        <div class="mt-2 md:flex md:items-center md:justify-between">
            <div class="min-w-0 flex-1">
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">{{ $questionBank->name }}</h2>
                <p class="mt-1 text-sm text-gray-500">{{ $questionBank->description }}</p>
            </div>
        </div>
    </div>

    <div class="mt-6">
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                <a href="#" @click.prevent="activeTab = 'questions'" :class="{'border-teal-500 text-teal-600': activeTab === 'questions', 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700': activeTab !== 'questions'}" class="whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium">Daftar Soal ({{ count($questionBank->questions) }})</a>
                <a href="#" @click.prevent="activeTab = 'add_question'" :class="{'border-teal-500 text-teal-600': activeTab === 'add_question', 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700': activeTab !== 'add_question'}" class="whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium">Tambah Soal Baru</a>
            </nav>
        </div>
    </div>

    <div class="mt-8">
        <div x-show="activeTab === 'add_question'" x-cloak>
            @include('admin_pemeringkatan.question_banks._add_question_form', ['questionBank' => $questionBank])
        </div>

        <div x-show="activeTab === 'questions'">
            @include('admin_pemeringkatan.question_banks._questions_list', ['questions' => $questionBank->questions])
        </div>
    </div>
</div>
@endsection

