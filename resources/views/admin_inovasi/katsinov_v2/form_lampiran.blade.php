@extends('admin_inovasi.dashboard')

@section('contentadmin')
<div class="p-6 max-w-7xl mx-auto">
    {{-- Header --}}
    <div class="mb-6">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin_inovasi.katsinov-v2.show', $katsinov->id) }}" 
               class="p-2 hover:bg-gray-100 rounded-lg transition">
                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Form Lampiran Dokumen</h1>
                <p class="text-gray-600 mt-1">Upload dokumen pendukung untuk setiap aspek</p>
            </div>
        </div>
    </div>

    {{-- Info Alert --}}
    <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6">
        <div class="flex">
            <svg class="w-6 h-6 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div>
                <p class="text-sm text-blue-700">
                    <strong>Catatan:</strong> Upload dokumen pendukung (PDF, DOC, DOCX) untuk masing-masing aspek. File maksimal 2MB per dokumen.
                </p>
            </div>
        </div>
    </div>

    {{-- Form --}}
    <div class="bg-white rounded-lg shadow-lg p-8">
        <form action="{{ route('admin_inovasi.katsinov-v2.form-lampiran.store', $katsinov->id) }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Aspek Teknologi --}}
            <div class="mb-8">
                <h2 class="text-xl font-bold text-gray-800 mb-4 pb-2 border-b-2 border-blue-500 flex items-center gap-2">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    Aspek Teknologi
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach(range(0, 6) as $i)
                        <div class="p-4 border border-gray-200 rounded-lg hover:border-blue-500 transition">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Dokumen {{ $i + 1 }}
                            </label>
                            <input type="file" name="aspek_teknologi[{{ $i }}]" accept=".pdf,.doc,.docx"
                                   class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            @if(isset($groupedLampiran['aspek_teknologi'][$i]))
                                <p class="text-xs text-green-600 mt-1">✓ File sudah diupload</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Aspek Pasar --}}
            <div class="mb-8">
                <h2 class="text-xl font-bold text-gray-800 mb-4 pb-2 border-b-2 border-green-500 flex items-center gap-2">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                    Aspek Pasar
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach(range(0, 6) as $i)
                        <div class="p-4 border border-gray-200 rounded-lg hover:border-green-500 transition">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Dokumen {{ $i + 1 }}
                            </label>
                            <input type="file" name="aspek_pasar[{{ $i }}]" accept=".pdf,.doc,.docx"
                                   class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                            @if(isset($groupedLampiran['aspek_pasar'][$i]))
                                <p class="text-xs text-green-600 mt-1">✓ File sudah diupload</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Aspek Organisasi --}}
            <div class="mb-8">
                <h2 class="text-xl font-bold text-gray-800 mb-4 pb-2 border-b-2 border-purple-500 flex items-center gap-2">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    Aspek Organisasi
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach(range(0, 6) as $i)
                        <div class="p-4 border border-gray-200 rounded-lg hover:border-purple-500 transition">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Dokumen {{ $i + 1 }}
                            </label>
                            <input type="file" name="aspek_organisasi[{{ $i }}]" accept=".pdf,.doc,.docx"
                                   class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100">
                            @if(isset($groupedLampiran['aspek_organisasi'][$i]))
                                <p class="text-xs text-green-600 mt-1">✓ File sudah diupload</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Aspek Mitra --}}
            <div class="mb-8">
                <h2 class="text-xl font-bold text-gray-800 mb-4 pb-2 border-b-2 border-yellow-500 flex items-center gap-2">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    Aspek Kemitraan
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach(range(0, 6) as $i)
                        <div class="p-4 border border-gray-200 rounded-lg hover:border-yellow-500 transition">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Dokumen {{ $i + 1 }}
                            </label>
                            <input type="file" name="aspek_mitra[{{ $i }}]" accept=".pdf,.doc,.docx"
                                   class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-yellow-50 file:text-yellow-700 hover:file:bg-yellow-100">
                            @if(isset($groupedLampiran['aspek_mitra'][$i]))
                                <p class="text-xs text-green-600 mt-1">✓ File sudah diupload</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Aspek Risiko --}}
            <div class="mb-8">
                <h2 class="text-xl font-bold text-gray-800 mb-4 pb-2 border-b-2 border-red-500 flex items-center gap-2">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    Aspek Risiko
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach(range(0, 6) as $i)
                        <div class="p-4 border border-gray-200 rounded-lg hover:border-red-500 transition">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Dokumen {{ $i + 1 }}
                            </label>
                            <input type="file" name="aspek_risiko[{{ $i }}]" accept=".pdf,.doc,.docx"
                                   class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100">
                            @if(isset($groupedLampiran['aspek_risiko'][$i]))
                                <p class="text-xs text-green-600 mt-1">✓ File sudah diupload</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Aspek Manufaktur --}}
            <div class="mb-8">
                <h2 class="text-xl font-bold text-gray-800 mb-4 pb-2 border-b-2 border-indigo-500 flex items-center gap-2">
                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                    </svg>
                    Aspek Manufaktur
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach(range(0, 6) as $i)
                        <div class="p-4 border border-gray-200 rounded-lg hover:border-indigo-500 transition">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Dokumen {{ $i + 1 }}
                            </label>
                            <input type="file" name="aspek_manufaktur[{{ $i }}]" accept=".pdf,.doc,.docx"
                                   class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                            @if(isset($groupedLampiran['aspek_manufaktur'][$i]))
                                <p class="text-xs text-green-600 mt-1">✓ File sudah diupload</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Aspek Investasi --}}
            <div class="mb-8">
                <h2 class="text-xl font-bold text-gray-800 mb-4 pb-2 border-b-2 border-pink-500 flex items-center gap-2">
                    <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Aspek Investasi
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach(range(0, 6) as $i)
                        <div class="p-4 border border-gray-200 rounded-lg hover:border-pink-500 transition">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Dokumen {{ $i + 1 }}
                            </label>
                            <input type="file" name="aspek_investasi[{{ $i }}]" accept=".pdf,.doc,.docx"
                                   class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-pink-50 file:text-pink-700 hover:file:bg-pink-100">
                            @if(isset($groupedLampiran['aspek_investasi'][$i]))
                                <p class="text-xs text-green-600 mt-1">✓ File sudah diupload</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                <a href="{{ route('admin_inovasi.katsinov-v2.show', $katsinov->id) }}" 
                   class="px-6 py-3 bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold rounded-lg transition duration-300">
                    Kembali
                </a>
                
                <button type="submit" 
                        class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition duration-300 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                    </svg>
                    Upload Lampiran
                </button>
            </div>
        </form>
    </div>
</div>

@if(session('success'))
<script>
    alert('{{ session("success") }}');
</script>
@endif

@if(session('error'))
<script>
    alert('{{ session("error") }}');
</script>
@endif
@endsection
