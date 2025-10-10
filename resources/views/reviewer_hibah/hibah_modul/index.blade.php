@extends('reviewer_hibah.index')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <header class="mb-10">
            <h1 class="text-3xl font-bold text-gray-800">Review Hibah Modul Ajar</h1>
            <p class="mt-2 text-gray-600">Proposal yang ditugaskan kepada Anda untuk direview</p>
        </header>

        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-purple-500 to-purple-600 px-6 py-6">
                <div class="flex items-center justify-between text-white">
                    <h2 class="text-xl font-bold flex items-center">
                        <i class='bx bx-task mr-3 text-2xl'></i>
                        Daftar Assignment
                    </h2>
                    <span class="text-purple-100 text-sm">Total: <span class="font-semibold text-white">{{ $proposals->total() }}</span></span>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">No</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Judul Modul</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Pengusul</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Sesi</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Status</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-600 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($proposals as $index => $proposal)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $proposals->firstItem() + $index }}</td>
                            <td class="px-6 py-4">
                                <div class="font-semibold text-gray-800">{{ $proposal->judul_modul }}</div>
                                @if($proposal->ringkasan_modul)
                                <div class="text-sm text-gray-500 mt-1">{{ Str::limit($proposal->ringkasan_modul, 60) }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <div class="font-medium text-gray-800">{{ $proposal->user->name }}</div>
                                <div class="text-xs text-gray-500">{{ $proposal->user->email }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $proposal->sesi->nama_sesi }}</td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 text-xs font-semibold rounded-full 
                                    @if($proposal->status === 'sedang_direview') bg-purple-100 text-purple-800
                                    @elseif($proposal->status === 'menunggu_direview') bg-yellow-100 text-yellow-800
                                    @elseif($proposal->status === 'lolos') bg-green-100 text-green-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    {{ ucwords(str_replace('_', ' ', $proposal->status)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('reviewer_hibah.hibah_modul.show', $proposal->id) }}" class="inline-flex items-center px-4 py-2 bg-purple-600 text-white text-sm rounded-lg hover:bg-purple-700">
                                    <i class='bx bx-edit-alt mr-1'></i> Review
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <i class='bx bx-inbox text-6xl text-gray-300 mb-4'></i>
                                    <p class="text-gray-500 text-lg font-medium">Belum ada proposal yang ditugaskan</p>
                                    <p class="text-gray-400 text-sm mt-2">Proposal akan muncul di sini setelah admin menugaskan Anda sebagai reviewer</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($proposals->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                {{ $proposals->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
