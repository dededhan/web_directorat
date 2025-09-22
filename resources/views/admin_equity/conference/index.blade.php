@extends('admin_equity.index')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {{-- Header --}}
        <header class="mb-10">
             <nav class="text-sm text-gray-500 mb-3" aria-label="Breadcrumb">
                <ol class="list-none p-0 inline-flex items-center space-x-2">
                    <li><a href="{{ route('admin_equity.dashboard') }}" class="hover:text-teal-600">Dashboard</a></li>
                    <li><i class='bx bx-chevron-right text-base'></i></li>
                    <li class="font-medium text-gray-800">Konferensi & Match Making</li>
                </ol>
            </nav>
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl lg:text-3xl font-bold text-gray-800">Manajemen Konferensi & Match Making</h1>
                    <p class="mt-2 text-gray-600 text-base">Kelola semua acara konferensi dan match making.</p>
                </div>
                <div>
                     <a href="#" class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-teal-500 to-teal-600 text-white font-semibold rounded-xl hover:from-teal-600 hover:to-teal-700 shadow-md">
                        <i class='bx bxs-add-to-queue mr-2'></i>
                        Buat Acara Baru
                    </a>
                </div>
            </div>
        </header>

        {{-- Content --}}
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 lg:px-8 py-6">
                <h2 class="text-xl lg:text-2xl font-bold text-white flex items-center">
                    <i class='bx bx-list-ul mr-3'></i>
                    Daftar Acara
                </h2>
            </div>
            
            {{-- Desktop Table --}}
            <div class="hidden lg:block">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">No</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Nama Acara</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Tipe</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Lokasi</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Periode</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-600 uppercase">Status</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-600 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @php
                            $events = [
                                ['name' => 'International Conference on Engineering', 'type' => 'Konferensi', 'location' => 'Bali', 'start' => '2025-10-15', 'end' => '2025-10-17', 'status' => 'akan_datang'],
                                ['name' => 'Global Innovators Meetup', 'type' => 'Match Making', 'location' => 'Jakarta', 'start' => '2025-09-20', 'end' => '2025-09-21', 'status' => 'selesai'],
                            ];
                        @endphp
                        @forelse ($events as $event)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-5 text-sm">{{ $loop->iteration }}</td>
                                <td class="px-6 py-5 text-sm font-semibold">{{ $event['name'] }}</td>
                                <td class="px-6 py-5 text-sm">{{ $event['type'] }}</td>
                                <td class="px-6 py-5 text-sm">{{ $event['location'] }}</td>
                                <td class="px-6 py-5 text-sm">{{ \Carbon\Carbon::parse($event['start'])->isoFormat('D MMM') }} - {{ \Carbon\Carbon::parse($event['end'])->isoFormat('D MMM Y') }}</td>
                                <td class="px-6 py-5 text-center">
                                     @if($event['status'] == 'akan_datang')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full font-semibold bg-cyan-100 text-cyan-800">Akan Datang</span>
                                     @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full font-semibold bg-gray-100 text-gray-800">Selesai</span>
                                     @endif
                                </td>
                                <td class="px-6 py-5 text-center">
                                    <div class="flex items-center justify-center space-x-2">
                                        <a href="#" class="p-2 text-blue-600 bg-blue-100 rounded-lg hover:bg-blue-200" title="Detail"><i class='bx bx-show'></i></a>
                                        <a href="#" class="p-2 text-yellow-600 bg-yellow-100 rounded-lg hover:bg-yellow-200" title="Edit"><i class='bx bxs-edit'></i></a>
                                        <button class="p-2 text-red-600 bg-red-100 rounded-lg hover:bg-red-200" title="Hapus"><i class='bx bxs-trash'></i></button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="text-center py-10">Tidak ada data acara.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
             {{-- Mobile Cards --}}
             <div class="lg:hidden">
                @forelse ($events as $event)
                    <div class="border-b p-4">
                       <div class="flex justify-between items-start mb-2">
                            <h3 class="font-semibold text-gray-900 flex-1 mr-2">{{ $event['name'] }}</h3>
                             @if($event['status'] == 'akan_datang')
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-cyan-100 text-cyan-800">Akan Datang</span>
                             @else
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-800">Selesai</span>
                             @endif
                       </div>
                        <p class="text-sm text-gray-600 mb-1">{{ $event['type'] }} di <strong>{{ $event['location'] }}</strong></p>
                        <p class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($event['start'])->isoFormat('D MMM') }} - {{ \Carbon\Carbon::parse($event['end'])->isoFormat('D MMM Y') }}</p>
                    </div>
                @empty
                    <div class="text-center py-16 px-4">Belum ada data acara.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection