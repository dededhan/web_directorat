@extends('admin_equity.index')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 p-6" x-data="{ rejectionModal: false }">
    <div class="max-w-4xl mx-auto">
        
        <header class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Detail Pengajuan Proposal</h1>
            <p class="mt-2 text-gray-600">Review detail proposal dan berikan status persetujuan atau lihat laporan akhir.</p>
        </header>

        {{-- Detail Proposal --}}
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 mb-8">
            <div class="p-8 space-y-6">
                <div>
                    <h3 class="text-xs font-bold uppercase text-gray-500">Judul Proposal</h3>
                    <p class="mt-1 text-gray-800 font-semibold text-lg">{{ $submission->judul_proposal }}</p>
                </div>
                <div>
                    <h3 class="text-xs font-bold uppercase text-gray-500">Dosen Ketua</h3>
                    <p class="mt-1 text-gray-800">{{ $submission->user->name ?? 'N/A' }}</p>
                </div>
                 <div>
                    <h3 class="text-xs font-bold uppercase text-gray-500">Sesi</h3>
                    <p class="mt-1 text-gray-800">{{ $submission->session->nama_sesi ?? 'N/A' }}</p>
                </div>
            </div>
        </div>

        {{-- Detail Anggota Tim --}}
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 mb-8">
            <div class="p-8">
                <h2 class="text-xl font-bold text-gray-800 mb-6">Anggota Tim Peneliti</h2>
                <div class="space-y-4">
                    @foreach($submission->members as $member)
                        <div class="p-4 border rounded-lg bg-gray-50">
                            @if($member->type === 'unj')
                                <p class="font-semibold text-gray-800">{{ $member->user->name ?? 'Dosen UNJ' }}</p>
                                <p class="text-sm text-gray-500">Dosen UNJ</p>

                                <div class="mt-3 text-sm text-gray-700 border-t pt-3 space-y-2">
                                    <p><strong>NIP/NIDN:</strong> {{ $member->user->identifier_number ?? '-' }}</p>
                                    <p><strong>Fakultas:</strong> {{ $member->user->fakultas ?? '-' }}</p>
                                    <p><strong>Program Studi:</strong> {{ $member->user->prodi ?? '-' }}</p>
                                </div>
                            @elseif($member->type === 'international')
                                @php $details = $member->details; @endphp
                                <p class="font-semibold text-teal-700">{{ $details['name'] ?? 'Mitra Internasional' }}</p>
                                <p class="text-sm text-gray-500">Mitra Internasional - {{ $details['institution'] ?? '' }} ({{ $details['country'] ?? '' }})</p>
                                
                                <div class="mt-3 text-sm text-gray-700 border-t pt-3 space-y-2">
                                    <p><strong>Keahlian:</strong> {{ $details['expertise'] ?? '-' }}</p>
                                    
                                    @if(isset($details['scopus_link']))
                                        <p><strong>Link Scopus:</strong> <a href="{{ $details['scopus_link'] }}" target="_blank" class="text-blue-600 hover:underline">Lihat Profil</a></p>
                                    @endif

                                    @if(isset($details['journal_name']))
                                        <p><strong>Nama Jurnal:</strong> {{ $details['journal_name'] }}</p>
                                    @endif
                                    
                                    @if(isset($details['scimago_link']))
                                        <p><strong>Link Scimago:</strong> <a href="{{ $details['scimago_link'] }}" target="_blank" class="text-blue-600 hover:underline">Lihat Jurnal</a></p>
                                    @endif

                                    @if(isset($details['organization_name']))
                                        <p><strong>Nama Organisasi:</strong> {{ $details['organization_name'] }}</p>
                                    @endif
                                    
                                    @if(isset($details['organization_link']))
                                        <p><strong>Link Organisasi:</strong> <a href="{{ $details['organization_link'] }}" target="_blank" class="text-blue-600 hover:underline">Lihat Organisasi</a></p>
                                    @endif

                                     @if(isset($details['membership_id']))
                                        <p><strong>ID Keanggotaan:</strong> {{ $details['membership_id'] }}</p>
                                     @endif

                                     @if(isset($details['academy_name']))
                                        <p><strong>Nama Akademi:</strong> {{ $details['academy_name'] }}</p>
                                     @endif

                                     @if(isset($details['membership_year']))
                                        <p><strong>Tahun Keanggotaan:</strong> {{ $details['membership_year'] }}</p>
                                     @endif

                                    @if(isset($details['membership_proof']))
                                        <p><strong>Bukti Keanggotaan:</strong> <a href="{{ Storage::url($details['membership_proof']) }}" target="_blank" class="text-blue-600 hover:underline">Unduh Bukti</a></p>
                                    @endif
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        

        <div class="bg-white rounded-2xl shadow-lg border border-gray-100">
            @if ($submission->status === 'diajukan')
                <div class="p-8 flex items-center justify-end space-x-4">
                    <button @click="rejectionModal = true" type="button" class="px-6 py-2.5 bg-red-100 text-red-700 font-semibold rounded-xl hover:bg-red-200">
                        Tolak
                    </button>
                    <form action="{{ route('admin_equity.matchresearch.submission.updateStatus', $submission->id) }}" method="POST">
                        @csrf
                        <button type="submit" name="status" value="diterima" class="px-8 py-2.5 bg-teal-600 text-white font-semibold rounded-xl hover:bg-teal-700">
                            Terima Proposal
                        </button>
                    </form>
                </div>
            @else
                <div class="p-8 flex items-center justify-between">
                    <p class="text-gray-600">Proposal ini sudah diproses dengan status: <strong class="font-semibold">{{ ucwords(str_replace('_', ' ', $submission->status)) }}</strong></p>
                    
           
                    @if(in_array($submission->status, ['menunggu_penilaian', 'lolos', 'revisi', 'tolak']))
                         <a href="{{ route('admin_equity.matchresearch.submission.report.show', $submission->id) }}" class="px-6 py-2.5 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700">
                            Lihat Laporan Akhir
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </div>


    <div x-show="rejectionModal" @keydown.escape.window="rejectionModal = false" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4" style="display: none;">
        <div @click.outside="rejectionModal = false" class="bg-white rounded-2xl shadow-xl w-full max-w-lg p-8">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Alasan Penolakan</h2>
            <p class="text-sm text-gray-600 mb-6">Berikan alasan mengapa proposal ini ditolak. Catatan ini akan dapat dilihat oleh dosen pengusul.</p>
            <form action="{{ route('admin_equity.matchresearch.submission.updateStatus', $submission->id) }}" method="POST">
                @csrf
                <input type="hidden" name="status" value="ditolak_awal">
                <div>
                    <label for="rejection_note" class="sr-only">Catatan Penolakan</label>
                    <textarea name="rejection_note" id="rejection_note" rows="4" class="w-full border-gray-300 rounded-lg" placeholder="Tuliskan alasan penolakan di sini..." required></textarea>
                </div>
                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" @click="rejectionModal = false" class="px-5 py-2 bg-gray-200 text-gray-800 font-semibold rounded-lg hover:bg-gray-300">Batal</button>
                    <button type="submit" class="px-5 py-2 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700">Kirim Penolakan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
