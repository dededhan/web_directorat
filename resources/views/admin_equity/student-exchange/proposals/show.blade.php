@extends('admin_equity.index')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Header --}}
        <header class="mb-8">
            <nav class="text-sm text-gray-500 mb-3">
                <ol class="list-none p-0 inline-flex items-center space-x-2">
                    <li><a href="{{ route('admin_equity.dashboard') }}" class="hover:text-teal-600">Dashboard</a></li>
                    <li><i class='bx bx-chevron-right'></i></li>
                    <li><a href="{{ route('admin_equity.student_exchange.sesi.index') }}" class="hover:text-teal-600">Student Exchange</a></li>
                    <li><i class='bx bx-chevron-right'></i></li>
                    <li><a href="{{ route('admin_equity.student_exchange.proposals.index', $sesi->id) }}" class="hover:text-teal-600">Proposal</a></li>
                    <li><i class='bx bx-chevron-right'></i></li>
                    <li class="font-medium text-gray-800">Detail</li>
                </ol>
            </nav>
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <h1 class="text-3xl font-bold text-gray-800">Detail Proposal</h1>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('admin_equity.student_exchange.proposals.index', $sesi->id) }}" class="inline-flex items-center px-4 py-2.5 bg-gray-200 text-gray-700 font-semibold rounded-xl hover:bg-gray-300 transition-all">
                        <i class='bx bx-arrow-back mr-2'></i>
                        Kembali
                    </a>
                </div>
            </div>
        </header>

        {{-- Alert Messages --}}
        @if(session('success'))
        <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg">
            <div class="flex items-center">
                <i class='bx bx-check-circle text-green-500 text-2xl mr-3'></i>
                <p class="text-green-800 font-medium">{{ session('success') }}</p>
            </div>
        </div>
        @endif

        @if($errors->any())
        <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg">
            <div class="flex items-start">
                <i class='bx bx-error-circle text-red-500 text-2xl mr-3'></i>
                <div>
                    <p class="text-red-800 font-medium mb-2">Terdapat kesalahan:</p>
                    <ul class="list-disc list-inside text-red-700">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Main Content --}}
            <div class="lg:col-span-2 space-y-6">
                {{-- Proposal Information --}}
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 py-4">
                        <h2 class="text-xl font-bold text-white flex items-center">
                            <i class='bx bx-file-blank mr-3 text-2xl'></i>
                            Informasi Proposal
                        </h2>
                    </div>
                    <div class="p-6 space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-2">Judul Kegiatan</label>
                            <p class="text-gray-800 text-lg font-medium">{{ $proposal->judul_kegiatan }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-2">Ringkasan Kegiatan</label>
                            <p class="text-gray-700 leading-relaxed">{{ $proposal->ringkasan_kegiatan ?? '-' }}</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-600 mb-2">Jenis Kegiatan</label>
                                @if($proposal->jenis_kegiatan === 'inbound')
                                <span class="px-4 py-2 text-sm font-semibold rounded-full bg-purple-100 text-purple-800 inline-flex items-center">
                                    <i class='bx bx-log-in mr-2'></i>Inbound
                                </span>
                                @else
                                <span class="px-4 py-2 text-sm font-semibold rounded-full bg-indigo-100 text-indigo-800 inline-flex items-center">
                                    <i class='bx bx-log-out mr-2'></i>Outbound
                                </span>
                                @endif
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-600 mb-2">Jumlah Peserta</label>
                                <p class="text-gray-800 flex items-center">
                                    <i class='bx bx-user text-teal-500 mr-2 text-xl'></i>
                                    <span class="font-semibold">{{ $proposal->jumlah_peserta }} mahasiswa</span>
                                </p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-600 mb-2">SKS</label>
                                <p class="text-gray-800 font-semibold">{{ $proposal->sks }} SKS</p>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-600 mb-2">Tanggal Online</label>
                                <p class="text-gray-800">{{ $proposal->tanggal_online ? $proposal->tanggal_online->format('d F Y') : '-' }}</p>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-2">Tanggal Onsite</label>
                            <p class="text-gray-800">{{ $proposal->tanggal_onsite ? $proposal->tanggal_onsite->format('d F Y') : '-' }}</p>
                        </div>

                        @if($proposal->sdgs_fokus && is_array($proposal->sdgs_fokus))
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-2">SDGs Fokus</label>
                            <div class="flex flex-wrap gap-2">
                                @foreach($proposal->sdgs_fokus as $sdg)
                                <span class="px-3 py-1 bg-teal-100 text-teal-800 rounded-full text-sm font-semibold">SDG {{ $sdg }}</span>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        @if($proposal->sdgs_pendukung && is_array($proposal->sdgs_pendukung))
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-2">SDGs Pendukung</label>
                            <div class="flex flex-wrap gap-2">
                                @foreach($proposal->sdgs_pendukung as $sdg)
                                <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">SDG {{ $sdg }}</span>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                {{-- Partner Information --}}
                @if($proposal->mitra)
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4">
                        <h2 class="text-xl font-bold text-white flex items-center">
                            <i class='bx bx-buildings mr-3 text-2xl'></i>
                            Informasi Mitra
                        </h2>
                    </div>
                    <div class="p-6 space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-2">Nama Institusi</label>
                            <p class="text-gray-800 text-lg font-medium">{{ $proposal->mitra->nama_mitra }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-2">Negara</label>
                            <p class="text-gray-800">{{ $proposal->mitra->negara }}</p>
                        </div>
                        <div class="border-t pt-4">
                            <label class="block text-sm font-semibold text-gray-600 mb-3">Person in Charge (PIC)</label>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-semibold text-gray-500 mb-1">Nama</label>
                                    <p class="text-gray-800">{{ $proposal->mitra->nama_pic }}</p>
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-500 mb-1">Nomor Kontak</label>
                                    <p class="text-gray-800">{{ $proposal->mitra->nomor_kontak_pic }}</p>
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-xs font-semibold text-gray-500 mb-1">Email</label>
                                    <p class="text-gray-800">{{ $proposal->mitra->email_pic }}</p>
                                </div>
                            </div>
                        </div>
                        @if($proposal->mitra->kesediaan_mitra_path)
                        <div class="border-t pt-4">
                            <label class="block text-sm font-semibold text-gray-600 mb-2">Surat Kesediaan Mitra</label>
                            <a href="{{ Storage::url($proposal->mitra->kesediaan_mitra_path) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-teal-50 text-teal-700 rounded-lg hover:bg-teal-100 transition-colors">
                                <i class='bx bx-file-pdf mr-2 text-xl'></i>
                                Lihat Dokumen
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                {{-- Team Members --}}
                @if($proposal->anggota && $proposal->anggota->count() > 0)
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-purple-500 to-purple-600 px-6 py-4">
                        <h2 class="text-xl font-bold text-white flex items-center">
                            <i class='bx bx-group mr-3 text-2xl'></i>
                            Anggota Tim
                        </h2>
                    </div>
                    <div class="p-6">
                        <div class="space-y-3">
                            @foreach($proposal->anggota->sortBy('urutan') as $anggota)
                            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-500 mb-1">Nama Dosen</label>
                                        <p class="text-gray-800 font-medium">{{ $anggota->nama_dosen }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-500 mb-1">NIP</label>
                                        <p class="text-gray-800">{{ $anggota->nip ?? '-' }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-500 mb-1">Fakultas</label>
                                        <p class="text-gray-800">{{ $anggota->fakultas ?? '-' }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-500 mb-1">Prodi</label>
                                        <p class="text-gray-800">{{ $anggota->prodi ?? '-' }}</p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif

                {{-- Files --}}
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-orange-500 to-orange-600 px-6 py-4">
                        <h2 class="text-xl font-bold text-white flex items-center">
                            <i class='bx bx-folder-open mr-3 text-2xl'></i>
                            Dokumen Pendukung
                        </h2>
                    </div>
                    <div class="p-6 space-y-3">
                        @if($proposal->nama_mahasiswa_path)
                        <a href="{{ Storage::url($proposal->nama_mahasiswa_path) }}" target="_blank" class="flex items-center justify-between p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors group">
                            <div class="flex items-center">
                                <i class='bx bx-file text-2xl text-blue-600 mr-3'></i>
                                <div>
                                    <p class="font-semibold text-gray-800">Daftar Nama Mahasiswa</p>
                                    <p class="text-sm text-gray-600">{{ basename($proposal->nama_mahasiswa_path) }}</p>
                                </div>
                            </div>
                            <i class='bx bx-download text-2xl text-blue-600 group-hover:scale-110 transition-transform'></i>
                        </a>
                        @endif
                        @if($proposal->mata_kuliah_path)
                        <a href="{{ Storage::url($proposal->mata_kuliah_path) }}" target="_blank" class="flex items-center justify-between p-4 bg-green-50 rounded-lg hover:bg-green-100 transition-colors group">
                            <div class="flex items-center">
                                <i class='bx bx-book text-2xl text-green-600 mr-3'></i>
                                <div>
                                    <p class="font-semibold text-gray-800">Mata Kuliah</p>
                                    <p class="text-sm text-gray-600">{{ basename($proposal->mata_kuliah_path) }}</p>
                                </div>
                            </div>
                            <i class='bx bx-download text-2xl text-green-600 group-hover:scale-110 transition-transform'></i>
                        </a>
                        @endif
                        @if($proposal->rab_path)
                        <a href="{{ Storage::url($proposal->rab_path) }}" target="_blank" class="flex items-center justify-between p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors group">
                            <div class="flex items-center">
                                <i class='bx bx-dollar-circle text-2xl text-purple-600 mr-3'></i>
                                <div>
                                    <p class="font-semibold text-gray-800">RAB (Rencana Anggaran Biaya)</p>
                                    <p class="text-sm text-gray-600">{{ basename($proposal->rab_path) }}</p>
                                </div>
                            </div>
                            <i class='bx bx-download text-2xl text-purple-600 group-hover:scale-110 transition-transform'></i>
                        </a>
                        @endif
                        @if(!$proposal->nama_mahasiswa_path && !$proposal->mata_kuliah_path && !$proposal->rab_path)
                        <p class="text-center text-gray-500 py-4">Belum ada dokumen yang diunggah</p>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="space-y-6">
                {{-- Status Card --}}
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-gray-700 to-gray-800 px-6 py-4">
                        <h2 class="text-lg font-bold text-white flex items-center">
                            <i class='bx bx-info-circle mr-2 text-xl'></i>
                            Status Proposal
                        </h2>
                    </div>
                    <div class="p-6 space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-2">Status Saat Ini</label>
                            @include('admin_equity.student-exchange.partials.status-badge', ['status' => $proposal->status])
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-2">Pengusul</label>
                            <p class="text-gray-800 font-medium">{{ $proposal->user->name ?? 'N/A' }}</p>
                            <p class="text-sm text-gray-500">{{ $proposal->user->email ?? '' }}</p>
                        </div>
                        @if($proposal->reviewer)
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-2">Reviewer</label>
                            <p class="text-gray-800 font-medium">{{ $proposal->reviewer->name }}</p>
                            <p class="text-sm text-gray-500">{{ $proposal->reviewer->email }}</p>
                        </div>
                        @endif
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-2">Tanggal Dibuat</label>
                            <p class="text-gray-800">{{ $proposal->created_at->format('d F Y, H:i') }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-2">Terakhir Diupdate</label>
                            <p class="text-gray-800">{{ $proposal->updated_at->format('d F Y, H:i') }}</p>
                        </div>
                    </div>
                </div>

                {{-- Admin Actions --}}
                @if($proposal->status === 'menunggu_verifikasi')
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 px-6 py-4">
                        <h2 class="text-lg font-bold text-white flex items-center">
                            <i class='bx bx-shield-check mr-2 text-xl'></i>
                            Aksi Verifikasi
                        </h2>
                    </div>
                    <div class="p-6 space-y-3">
                        <button onclick="verifyProposal()" class="w-full inline-flex items-center justify-center px-4 py-3 bg-green-600 text-white font-semibold rounded-xl hover:bg-green-700 transition-all">
                            <i class='bx bx-check-circle mr-2 text-xl'></i>
                            Verifikasi Proposal
                        </button>
                        <button onclick="rejectProposal()" class="w-full inline-flex items-center justify-center px-4 py-3 bg-red-600 text-white font-semibold rounded-xl hover:bg-red-700 transition-all">
                            <i class='bx bx-x-circle mr-2 text-xl'></i>
                            Tolak Proposal
                        </button>
                    </div>
                </div>
                @endif

                {{-- Comments --}}
                @if($proposal->komentar_admin || $proposal->komentar_reviewer || $proposal->alasan_penolakan)
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 px-6 py-4">
                        <h2 class="text-lg font-bold text-white flex items-center">
                            <i class='bx bx-message-dots mr-2 text-xl'></i>
                            Komentar
                        </h2>
                    </div>
                    <div class="p-6 space-y-4">
                        @if($proposal->komentar_admin)
                        <div class="bg-blue-50 p-4 rounded-lg border-l-4 border-blue-500">
                            <label class="block text-sm font-semibold text-blue-800 mb-2">Komentar Admin</label>
                            <p class="text-gray-700">{{ $proposal->komentar_admin }}</p>
                        </div>
                        @endif
                        @if($proposal->komentar_reviewer)
                        <div class="bg-purple-50 p-4 rounded-lg border-l-4 border-purple-500">
                            <label class="block text-sm font-semibold text-purple-800 mb-2">Komentar Reviewer</label>
                            <p class="text-gray-700">{{ $proposal->komentar_reviewer }}</p>
                        </div>
                        @endif
                        @if($proposal->alasan_penolakan)
                        <div class="bg-red-50 p-4 rounded-lg border-l-4 border-red-500">
                            <label class="block text-sm font-semibold text-red-800 mb-2">Alasan Penolakan</label>
                            <p class="text-gray-700">{{ $proposal->alasan_penolakan }}</p>
                        </div>
                        @endif
                    </div>
                </div>
                @endif
            </div>
        </div>

    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function verifyProposal() {
    Swal.fire({
        title: 'Verifikasi Proposal',
        text: "Proposal akan diverifikasi dan masuk tahap review",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#10B981',
        cancelButtonColor: '#6B7280',
        confirmButtonText: 'Ya, Verifikasi!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("admin_equity.student_exchange.proposals.verify", [$sesi->id, $proposal->id]) }}';
            
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            
            form.appendChild(csrfToken);
            document.body.appendChild(form);
            form.submit();
        }
    });
}

function rejectProposal() {
    Swal.fire({
        title: 'Tolak Proposal',
        input: 'textarea',
        inputLabel: 'Alasan Penolakan',
        inputPlaceholder: 'Jelaskan alasan penolakan proposal...',
        inputAttributes: {
            'aria-label': 'Alasan penolakan'
        },
        showCancelButton: true,
        confirmButtonColor: '#EF4444',
        cancelButtonColor: '#6B7280',
        confirmButtonText: 'Tolak',
        cancelButtonText: 'Batal',
        inputValidator: (value) => {
            if (!value) {
                return 'Alasan penolakan harus diisi!'
            }
        }
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("admin_equity.student_exchange.proposals.reject", [$sesi->id, $proposal->id]) }}';
            
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            
            const alasanInput = document.createElement('input');
            alasanInput.type = 'hidden';
            alasanInput.name = 'alasan_penolakan';
            alasanInput.value = result.value;
            
            form.appendChild(csrfToken);
            form.appendChild(alasanInput);
            document.body.appendChild(form);
            form.submit();
        }
    });
}
</script>
@endpush
@endsection
