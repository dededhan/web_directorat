@extends('equity_fakultas.index')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h3 class="text-3xl font-medium text-gray-700">Manajemen Proposal: Employer Meeting</h3>
    {{-- Ganti route ke joint-supervision.create --}}
    <a href="{{ route('equity_fakultas.employer-meetings.create') }}"
       class="inline-flex items-center px-4 py-2 bg-teal-500 hover:bg-teal-600 text-white font-bold rounded-lg shadow-md transition-colors duration-200">
        <i class='bx bxs-file-plus mr-2'></i>
        Ajukan Proposal Baru
    </a>
</div>

<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full leading-normal">
            {{-- ... (Isi tabel sama persis seperti visiting_professor/index.blade.php) ... --}}
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama Pengunggah</th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tanggal Diajukan</th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($submissions as $submission)
                    <tr class="hover:bg-gray-50">
                        <td class="px-5 py-4 border-b border-gray-200 bg-white text-sm">
                            <p class="text-gray-900 whitespace-no-wrap">{{ $submission->nama_pengunggah }}</p>
                        </td>
                        <td class="px-5 py-4 border-b border-gray-200 bg-white text-sm">
                            <p class="text-gray-900 whitespace-no-wrap">{{ $submission->created_at->format('d F Y') }}</p>
                        </td>
                        <td class="px-5 py-4 border-b border-gray-200 bg-white text-sm text-center">
                             <span class="relative inline-block px-3 py-1 font-semibold leading-tight @switch($submission->status) @case('diajukan') bg-blue-100 text-blue-900 @break @case('diverifikasi') bg-yellow-100 text-yellow-900 @break @case('disetujui') bg-green-100 text-green-900 @break @case('ditolak') bg-red-100 text-red-900 @break @case('selesai') bg-gray-200 text-gray-800 @break @endswitch rounded-full">
                                {{ ucfirst($submission->status) }}
                            </span>
                        </td>
                        <td class="px-5 py-4 border-b border-gray-200 bg-white text-sm text-center">
                             @if ($submission->status == 'disetujui')
                                 {{-- Ganti route ke joint-supervision.edit --}}
                                 <a href="{{ route('equity_fakultas.employer-meetings.edit', $submission->id) }}" class="text-teal-600 hover:text-teal-900 font-semibold">
                                     Lengkapi Data
                                 </a>
                             @else
                                 <a href="#" class="text-indigo-600 hover:text-indigo-900">
                                     Detail
                                 </a>
                             @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-10 text-gray-500">
                            Belum ada proposal yang diajukan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-5 py-5 bg-white border-t flex flex-col xs:flex-row items-center xs:justify-between">
        {{ $submissions->links() }}
    </div>
</div>
@endsection