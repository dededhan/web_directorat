@extends('admin_pemeringkatan.index')

@section('contentadmin_pemeringkatan')
<div class="px-4 sm:px-6 lg:px-8 py-8">
    <div>
        <nav class="hidden sm:flex" aria-label="Breadcrumb">
            <ol role="list" class="flex items-center space-x-4">
                <li>
                    <a href="{{ route('admin_pemeringkatan.dashboard') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700">Dashboard</a>
                </li>
                <li>
                    <i class="fas fa-chevron-right flex-shrink-0 h-5 w-5 text-gray-400"></i>
                    <a href="{{ route('admin_pemeringkatan.question_banks.index') }}" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700">Bank Soal</a>
                </li>
                 <li>
                    <i class="fas fa-chevron-right flex-shrink-0 h-5 w-5 text-gray-400"></i>
                    <a href="{{ route('admin_pemeringkatan.question_banks.show', $question->question_bank_id) }}" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700">Kelola: {{ $question->questionBank->name }}</a>
                </li>
            </ol>
        </nav>
        <div class="mt-2 md:flex md:items-center md:justify-between">
            <div class="min-w-0 flex-1">
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">Edit Soal</h2>
            </div>
        </div>
    </div>

    <div class="mt-8">
        @include('admin_pemeringkatan.question_banks._question-form', ['question' => $question, 'questionBank' => $question->questionBank])
    </div>
</div>
@endsection

