@extends('admin.admin')

@section('contentadmin')
<div class="p-6">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">KATSINOV V2 - Settings Threshold</h1>
        <p class="text-gray-600 mt-1">Atur batas minimum nilai untuk akses indikator selanjutnya</p>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-md p-6">
        <form action="{{ route('admin.katsinov-v2.settings.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <h2 class="text-xl font-semibold text-gray-700 mb-4">Threshold Indikator</h2>
                <p class="text-sm text-gray-600 mb-4">
                    Tentukan nilai minimum yang harus dicapai pada setiap indikator sebelum dapat melanjutkan ke indikator berikutnya.
                    Nilai dalam rentang 0.00 - 100.00
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @for($i = 1; $i <= 6; $i++)
                <div class="border border-gray-200 rounded-lg p-4 hover:border-blue-300 transition">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <span class="flex items-center gap-2">
                            <span class="bg-blue-100 text-blue-600 px-3 py-1 rounded-full text-xs font-semibold">Indikator {{ $i }}</span>
                            Batas Minimum (%)
                        </span>
                    </label>
                    <div class="flex items-center gap-3">
                        <input 
                            type="number" 
                            name="threshold_indicator_{{ $i }}" 
                            value="{{ old('threshold_indicator_' . $i, $settings->{"threshold_indicator_$i"} ?? 0) }}" 
                            min="0" 
                            max="100" 
                            step="0.01"
                            class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="0.00">
                        <span class="text-gray-500 font-medium">%</span>
                    </div>
                    @error('threshold_indicator_' . $i)
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-gray-500 mt-2">
                        @if($i < 6)
                            User harus mencapai nilai ini untuk dapat mengakses Indikator {{ $i + 1 }}
                        @else
                            User harus mencapai nilai ini untuk menyelesaikan semua indikator
                        @endif
                    </p>
                </div>
                @endfor
            </div>

            <div class="mt-8 pt-6 border-t border-gray-200">
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-yellow-700">
                                <strong>Catatan Penting:</strong>
                                Perubahan threshold akan mempengaruhi semua user yang sedang mengisi form assessment.
                                Pastikan nilai yang Anda tetapkan sudah sesuai dengan standar penilaian.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <a href="{{ route('admin.katsinov-v2.index') }}" 
                       class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                        Kembali
                    </a>
                    <button type="submit" 
                            class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition shadow-md">
                        <i class="fas fa-save mr-2"></i>
                        Simpan Pengaturan
                    </button>
                </div>
            </div>
        </form>
    </div>

    {{-- Current Threshold Overview --}}
    <div class="mt-6 bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-semibold text-gray-700 mb-4">Overview Threshold Saat Ini</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Indikator</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Threshold</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @for($i = 1; $i <= 6; $i++)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="bg-blue-100 text-blue-600 px-3 py-1 rounded-full text-xs font-semibold">Indikator {{ $i }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-lg font-semibold text-gray-800">{{ $settings->{"threshold_indicator_$i"} ?? 0 }}%</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $threshold = $settings->{"threshold_indicator_$i"} ?? 0;
                            @endphp
                            @if($threshold == 0)
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                    Tidak Ada Batasan
                                </span>
                            @elseif($threshold < 50)
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Rendah
                                </span>
                            @elseif($threshold < 75)
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    Sedang
                                </span>
                            @else
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                    Tinggi
                                </span>
                            @endif
                        </td>
                    </tr>
                    @endfor
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
