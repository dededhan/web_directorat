@extends('admin_pemeringkatan.index')

@section('contentadmin_pemeringkatan')
<div class="p-6 max-w-4xl mx-auto space-y-6">
    {{-- Breadcrumb & Header --}}
    <div>
        <nav class="flex text-sm text-gray-500 mb-2" aria-label="Breadcrumb">
            <a href="{{ route('admin_pemeringkatan.qs-sessions.index') }}" class="hover:text-teal-600 transition">
                QS Sessions
            </a>
            <span class="mx-2">/</span>
            <span class="text-gray-800 font-medium">Buat Sesi Baru</span>
        </nav>
        <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
            <i class="fas fa-calendar-plus text-teal-600"></i>
            Buat Sesi QS Baru
        </h1>
        <p class="text-sm text-gray-500 mt-1">
            Buat kampanye sesi baru untuk pengiriman email consent responden QS (Academic & Employer).
        </p>
    </div>

    {{-- Form Card --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 md:p-8">
        @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg mb-6">
                <div class="flex items-center mb-2">
                    <i class="fas fa-exclamation-triangle text-red-500 mr-2"></i>
                    <span class="text-sm font-semibold text-red-800">Terdapat kesalahan pada isian form:</span>
                </div>
                <ul class="list-disc list-inside text-xs text-red-700 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin_pemeringkatan.qs-sessions.store') }}" method="POST" class="space-y-6">
            @csrf

            {{-- Nama Sesi --}}
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                    Nama Sesi Campaign <span class="text-red-500">*</span>
                </label>
                <input type="text" name="name" id="name" required
                       value="{{ old('name') }}"
                       placeholder="Contoh: QS World University Rankings 2026"
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent @error('name') border-red-500 @enderror">
                <p class="text-xs text-gray-400 mt-1">Gunakan nama yang jelas mewakili periode kampanye responden.</p>
            </div>

            {{-- Deskripsi --}}
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">
                    Deskripsi / Catatan Internal
                </label>
                <textarea name="description" id="description" rows="3"
                          placeholder="Catatan mengenai target responden, batas waktu submit ke QS portal, dsb."
                          class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent">{{ old('description') }}</textarea>
            </div>

            {{-- Mode Sesi / Campaign Mode --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Metode Persetujuan (Mode Sesi) <span class="text-red-500">*</span>
                </label>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <label class="relative flex flex-col p-4 bg-white border-2 rounded-xl cursor-pointer hover:border-teal-500 transition-all has-[:checked]:border-teal-600 has-[:checked]:bg-teal-50/20 shadow-sm">
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center gap-2 text-sm font-bold text-gray-800">
                                <i class="fas fa-mouse-pointer text-teal-600"></i>
                                <span>Consent-Only (1-Click Agreement)</span>
                            </div>
                            <input type="radio" name="mode" value="consent_only" class="w-4 h-4 text-teal-600" {{ old('mode', 'consent_only') === 'consent_only' ? 'checked' : '' }}>
                        </div>
                        <p class="text-xs text-gray-500 leading-relaxed">
                            Responden hanya menerima email persetujuan cepat (1-click link). Tidak ada kuesioner tambahan.
                        </p>
                    </label>

                    <label class="relative flex flex-col p-4 bg-white border-2 rounded-xl cursor-pointer hover:border-teal-500 transition-all has-[:checked]:border-teal-600 has-[:checked]:bg-teal-50/20 shadow-sm">
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center gap-2 text-sm font-bold text-gray-800">
                                <i class="fas fa-file-signature text-emerald-600"></i>
                                <span>Form-Based (Undangan & Kuesioner)</span>
                            </div>
                            <input type="radio" name="mode" value="form_based" class="w-4 h-4 text-teal-600" {{ old('mode') === 'form_based' ? 'checked' : '' }}>
                        </div>
                        <p class="text-xs text-gray-500 leading-relaxed">
                            Responden menerima surat undangan resmi dan mengisi kuesioner (dapat dikustomisasi terpisah untuk Academic & Employee).
                        </p>
                    </label>
                </div>
            </div>

            {{-- Status & Dates Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                {{-- Status --}}
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">
                        Status Awal <span class="text-red-500">*</span>
                    </label>
                    <select name="status" id="status" required
                            class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm bg-white focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                        <option value="draft" {{ old('status', 'draft') === 'draft' ? 'selected' : '' }}>Draft (Persiapan)</option>
                        <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>Active (Siap Kirim / Live)</option>
                    </select>
                </div>

                {{-- Tanggal Mulai --}}
                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">
                        Tanggal Mulai
                    </label>
                    <input type="date" name="start_date" id="start_date"
                           value="{{ old('start_date') }}"
                           class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                </div>

                {{-- Tanggal Selesai --}}
                <div>
                    <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">
                        Tanggal Berakhir
                    </label>
                    <input type="date" name="end_date" id="end_date"
                           value="{{ old('end_date') }}"
                           class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                </div>
            </div>

            {{-- Form Actions --}}
            <div class="pt-6 border-t border-gray-100 flex items-center justify-end space-x-3">
                <a href="{{ route('admin_pemeringkatan.qs-sessions.index') }}" 
                   class="px-5 py-2.5 border border-gray-300 text-gray-700 hover:bg-gray-50 text-sm font-medium rounded-lg transition">
                    Batal
                </a>
                <button type="submit" 
                        class="px-5 py-2.5 bg-teal-600 hover:bg-teal-700 text-white text-sm font-medium rounded-lg shadow-sm hover:shadow transition">
                    <i class="fas fa-check mr-2"></i>
                    Simpan Sesi
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
