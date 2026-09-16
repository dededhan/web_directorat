@extends('admin_hackaton.index')

@section('contentadmin_hackaton')
    <div class="space-y-8">
        {{-- Breadcrumb & Header --}}
        <div class="border-b-4 border-gray-950 pb-6 flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
            <div>
                <p class="mb-2 text-sm font-bold uppercase tracking-[0.18em] text-gray-600">Admin Hackaton / Sesi</p>
                <h1 class="text-3xl font-black text-gray-950 sm:text-4xl">Daftar Sesi Hackaton</h1>
                <p class="mt-2 text-base text-gray-700">Kelola periode pelaksanaan, kuota anggota tim, dan tahapan evaluasi Hackaton.</p>
            </div>
            <a href="{{ route('admin_hackaton.sessions.create') }}"
                class="inline-flex items-center justify-center bg-gray-950 px-5 py-3 text-sm font-bold uppercase tracking-wider text-white hover:bg-gray-800 transition">
                <i class="fas fa-plus mr-2 text-xs"></i> Buat Sesi Baru
            </a>
        </div>

        {{-- Sessions Table --}}
        <div class="border-2 border-gray-950 bg-white overflow-hidden">
            <div class="border-b-2 border-gray-950 bg-gray-100 px-6 py-4 flex items-center justify-between">
                <h2 class="font-bold text-gray-900 uppercase tracking-wider text-sm flex items-center gap-2">
                    <i class="fas fa-calendar-alt"></i> Semua Sesi
                </h2>
                <span class="bg-gray-950 text-white text-xs font-bold px-2.5 py-1">{{ $sessions->total() }} Sesi</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b-2 border-gray-950 bg-white text-xs uppercase tracking-wider text-gray-700">
                            <th class="p-4 w-12 text-center">#</th>
                            <th class="p-4">Nama Sesi</th>
                            <th class="p-4">Periode</th>
                            <th class="p-4 text-center">Batas Anggota</th>
                            <th class="p-4 text-center">Proposal Masuk</th>
                            <th class="p-4 text-center">Status</th>
                            <th class="p-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 text-sm">
                        @forelse ($sessions as $session)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="p-4 text-center text-gray-500 font-semibold">
                                    {{ $loop->iteration + ($sessions->currentPage() - 1) * $sessions->perPage() }}
                                </td>
                                <td class="p-4">
                                    <a href="{{ route('admin_hackaton.sessions.show', $session) }}" class="font-bold text-gray-950 hover:underline">
                                        {{ $session->nama_sesi }}
                                    </a>
                                    @if ($session->deskripsi)
                                        <p class="text-xs text-gray-500 mt-0.5 line-clamp-1">{{ $session->deskripsi }}</p>
                                    @endif
                                </td>
                                <td class="p-4 text-gray-700 whitespace-nowrap text-xs font-medium">
                                    {{ $session->periode_awal->format('d M Y') }} — {{ $session->periode_akhir->format('d M Y') }}
                                </td>
                                <td class="p-4 text-center text-xs text-gray-700">
                                    {{ $session->min_anggota }} - {{ $session->max_anggota }} orang
                                </td>
                                <td class="p-4 text-center">
                                    <a href="{{ route('admin_hackaton.submissions.index', $session) }}" class="inline-flex items-center px-2.5 py-1 text-xs font-bold bg-amber-100 text-amber-900 border border-amber-300 hover:bg-amber-200">
                                        {{ $session->submissions_count }} Proposal
                                    </a>
                                </td>
                                <td class="p-4 text-center">
                                    @if ($session->status === 'active')
                                        <span class="inline-flex items-center px-2.5 py-0.5 text-xs font-bold bg-emerald-100 text-emerald-800 border border-emerald-300">
                                            AKTIF
                                        </span>
                                    @elseif ($session->status === 'closed')
                                        <span class="inline-flex items-center px-2.5 py-0.5 text-xs font-bold bg-rose-100 text-rose-800 border border-rose-300">
                                            DITUTUP
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 text-xs font-bold bg-gray-100 text-gray-700 border border-gray-300">
                                            DRAFT
                                        </span>
                                    @endif
                                </td>
                                <td class="p-4 text-right whitespace-nowrap">
                                    <div class="inline-flex items-center gap-1">
                                        <a href="{{ route('admin_hackaton.sessions.show', $session) }}" class="p-2 text-xs font-bold text-gray-700 hover:text-black border border-gray-300 hover:border-black bg-white" title="Lihat Sesi">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin_hackaton.sessions.edit', $session) }}" class="p-2 text-xs font-bold text-gray-700 hover:text-black border border-gray-300 hover:border-black bg-white" title="Edit Sesi">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        @if ($session->status === 'draft')
                                            <form action="{{ route('admin_hackaton.sessions.activate', $session) }}" method="POST" class="inline">
                                                @csrf @method('PATCH')
                                                <button type="submit" class="p-2 text-xs font-bold text-emerald-700 hover:text-white hover:bg-emerald-700 border border-emerald-500 bg-white" title="Aktifkan Sesi">
                                                    <i class="fas fa-play"></i>
                                                </button>
                                            </form>
                                        @elseif ($session->status === 'active')
                                            <form action="{{ route('admin_hackaton.sessions.close', $session) }}" method="POST" class="inline">
                                                @csrf @method('PATCH')
                                                <button type="submit" class="p-2 text-xs font-bold text-rose-700 hover:text-white hover:bg-rose-700 border border-rose-500 bg-white" title="Tutup Sesi" onclick="return confirm('Yakin ingin menutup sesi ini?')">
                                                    <i class="fas fa-stop"></i>
                                                </button>
                                            </form>
                                        @endif

                                        <form action="{{ route('admin_hackaton.sessions.destroy', $session) }}" method="POST" class="inline" onsubmit="return confirm('Hapus sesi ini beserta semua tahapan dan proposal terkait?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="p-2 text-xs font-bold text-rose-600 hover:bg-rose-600 hover:text-white border border-rose-300 bg-white" title="Hapus Sesi">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="p-8 text-center text-gray-500 italic">
                                    Belum ada sesi Hackaton yang dibuat. Klik tombol "Buat Sesi Baru" untuk memulai.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($sessions->hasPages())
                <div class="p-4 border-t-2 border-gray-950 bg-gray-50">
                    {{ $sessions->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
