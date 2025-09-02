@extends('admin_pemeringkatan.index')

@section('contentadmin_pemeringkatan')
<div class="px-4 sm:px-6 lg:px-8 py-8" x-data="{ activeTab: 'questions' }">
    <div>
        <nav class="hidden sm:flex" aria-label="Breadcrumb">
            <ol role="list" class="flex items-center space-x-4">
                <li>
                    <div class="flex">
                        <a href="{{ route('admin_pemeringkatan.dashboard') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700">Dashboard</a>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right flex-shrink-0 h-5 w-5 text-gray-400"></i>
                        <a href="{{ route('admin_pemeringkatan.question_banks.index') }}" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700">Bank Soal</a>
                    </div>
                </li>
            </ol>
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
                <a href="#" @click.prevent="activeTab = 'questions'" 
                   :class="{'border-teal-500 text-teal-600': activeTab === 'questions', 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700': activeTab !== 'questions'}" 
                   class="whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium">
                   Daftar Soal ({{ count($questionBank->questions) }})
                </a>
                <a href="#" @click.prevent="activeTab = 'add_question'" 
                   :class="{'border-teal-500 text-teal-600': activeTab === 'add_question', 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700': activeTab !== 'add_question'}" 
                   class="whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium">
                   Tambah Soal Baru
                </a>
            </nav>
        </div>
    </div>

    <div class="mt-8">
        <div x-show="activeTab === 'add_question'" x-cloak>
            @include('admin_pemeringkatan.question_banks._question-form', ['questionBank' => $questionBank])
        </div>
        <div x-show="activeTab === 'questions'">
            @include('admin_pemeringkatan.question_banks._question-list', ['questionBank' => $questionBank])
        </div>
    </div>
</div>

@push('scripts')
<script>
    function confirmDelete(questionId) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Soal yang akan dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#14b8a6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + questionId).submit();
            }
        });
    }
</script>
@endpush
@endsection

