@extends('admin_inovasi.index')

@section('contentadmin_inovasi')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-5xl mx-auto">
        {{-- Header --}}
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Form Berita Acara Penilaian</h1>
            <p class="text-gray-600">Dokumen resmi hasil penilaian inovasi</p>
        </div>

        {{-- Alert --}}
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded">
                {{ session('success') }}
            </div>
        @endif

        {{-- Form --}}
        <form action="{{ route('admin_inovasi.katsinov-v2.form-berita-acara.store', $katsinov->id) }}" method="POST" class="bg-white shadow-lg rounded-lg p-8">
            @csrf

            <div class="space-y-6">
                {{-- Section 1: Tanggal & Tempat --}}
                <div class="border-b pb-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Tanggal & Tempat</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Hari <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="day" value="{{ old('day', $beritaAcara->day ?? '') }}" required
                                   placeholder="Senin"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('day')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Tanggal <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="date" value="{{ old('date', $beritaAcara->date ?? '') }}" required
                                   placeholder="01"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('date')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Bulan <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="month" value="{{ old('month', $beritaAcara->month ?? '') }}" required
                                   placeholder="Januari"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('month')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Tahun <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="year" value="{{ old('year', $beritaAcara->year ?? date('Y')) }}" required
                                   placeholder="2024"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('year')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Tahun Penuh <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="yearfull" value="{{ old('yearfull', $beritaAcara->yearfull ?? date('Y')) }}" required
                                   placeholder="2024"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('yearfull')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Tempat <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="place" value="{{ old('place', $beritaAcara->place ?? '') }}" required
                                   placeholder="Ruang Rapat Gedung A"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('place')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Section 2: Dokumen & Inovasi --}}
                <div class="border-b pb-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Informasi Dokumen</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Nomor Surat Keputusan <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="decree" value="{{ old('decree', $beritaAcara->decree ?? '') }}" required
                                   placeholder="No. SK/123/DIR/2024"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('decree')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Judul Inovasi <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="title" value="{{ old('title', $beritaAcara->title ?? $katsinov->title) }}" required
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('title')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Jenis Inovasi <span class="text-red-500">*</span>
                            </label>
                            <select name="type" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">Pilih Jenis</option>
                                <option value="Produk" {{ old('type', $beritaAcara->type ?? '') == 'Produk' ? 'selected' : '' }}>Produk</option>
                                <option value="Proses" {{ old('type', $beritaAcara->type ?? '') == 'Proses' ? 'selected' : '' }}>Proses</option>
                                <option value="Layanan" {{ old('type', $beritaAcara->type ?? '') == 'Layanan' ? 'selected' : '' }}>Layanan</option>
                            </select>
                            @error('type')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Nilai TKI <span class="text-red-500">*</span>
                            </label>
                            <input type="number" step="0.01" name="tki" value="{{ old('tki', $beritaAcara->tki ?? '') }}" required
                                   placeholder="85.50"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('tki')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Section 3: Opini & Penutupan --}}
                <div class="border-b pb-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Hasil Penilaian</h2>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Opini Penilai <span class="text-red-500">*</span>
                            </label>
                            <textarea name="opinion" rows="6" required
                                      placeholder="Tuliskan opini dan rekomendasi penilai terhadap inovasi ini..."
                                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('opinion', $beritaAcara->opinion ?? '') }}</textarea>
                            @error('opinion')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Tanggal Penutupan <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="sign_date" value="{{ old('sign_date', $beritaAcara->sign_date ?? date('Y-m-d')) }}" required
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('sign_date')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Section 4: Tim Penilai dengan Tanda Tangan --}}
                <div>
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Tim Penilai & Tanda Tangan</h2>
                    
                    {{-- Penanggung Jawab --}}
                    <div class="mb-6 p-4 border border-gray-200 rounded-lg bg-gray-50">
                        <h3 class="font-semibold text-gray-700 mb-3">Penanggung Jawab</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Nama <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="penanggungjawab" value="{{ old('penanggungjawab', $beritaAcara->penanggungjawab ?? '') }}" required
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                @error('penanggungjawab')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Tanda Tangan Digital
                                </label>
                                <div class="border-2 border-gray-300 rounded-lg bg-white">
                                    <canvas id="signature-penanggungjawab" class="signature-pad" width="400" height="150"></canvas>
                                </div>
                                <div class="mt-2 flex gap-2">
                                    <button type="button" onclick="clearSignature('penanggungjawab')" 
                                            class="text-sm px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600">
                                        Clear
                                    </button>
                                </div>
                                <input type="hidden" name="penanggungjawab_signature" id="penanggungjawab_signature">
                            </div>
                        </div>
                    </div>

                    {{-- Ketua Tim --}}
                    <div class="mb-6 p-4 border border-gray-200 rounded-lg bg-gray-50">
                        <h3 class="font-semibold text-gray-700 mb-3">Ketua Tim</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Nama <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="ketua" value="{{ old('ketua', $beritaAcara->ketua ?? '') }}" required
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                @error('ketua')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Tanda Tangan Digital
                                </label>
                                <div class="border-2 border-gray-300 rounded-lg bg-white">
                                    <canvas id="signature-ketua" class="signature-pad" width="400" height="150"></canvas>
                                </div>
                                <div class="mt-2 flex gap-2">
                                    <button type="button" onclick="clearSignature('ketua')" 
                                            class="text-sm px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600">
                                        Clear
                                    </button>
                                </div>
                                <input type="hidden" name="ketua_signature" id="ketua_signature">
                            </div>
                        </div>
                    </div>

                    {{-- Anggota 1 --}}
                    <div class="mb-6 p-4 border border-gray-200 rounded-lg bg-gray-50">
                        <h3 class="font-semibold text-gray-700 mb-3">Anggota 1</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Nama <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="anggota1" value="{{ old('anggota1', $beritaAcara->anggota1 ?? '') }}" required
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                @error('anggota1')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Tanda Tangan Digital
                                </label>
                                <div class="border-2 border-gray-300 rounded-lg bg-white">
                                    <canvas id="signature-anggota1" class="signature-pad" width="400" height="150"></canvas>
                                </div>
                                <div class="mt-2 flex gap-2">
                                    <button type="button" onclick="clearSignature('anggota1')" 
                                            class="text-sm px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600">
                                        Clear
                                    </button>
                                </div>
                                <input type="hidden" name="anggota1_signature" id="anggota1_signature">
                            </div>
                        </div>
                    </div>

                    {{-- Anggota 2 --}}
                    <div class="mb-6 p-4 border border-gray-200 rounded-lg bg-gray-50">
                        <h3 class="font-semibold text-gray-700 mb-3">Anggota 2</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Nama <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="anggota2" value="{{ old('anggota2', $beritaAcara->anggota2 ?? '') }}" required
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                @error('anggota2')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Tanda Tangan Digital
                                </label>
                                <div class="border-2 border-gray-300 rounded-lg bg-white">
                                    <canvas id="signature-anggota2" class="signature-pad" width="400" height="150"></canvas>
                                </div>
                                <div class="mt-2 flex gap-2">
                                    <button type="button" onclick="clearSignature('anggota2')" 
                                            class="text-sm px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600">
                                        Clear
                                    </button>
                                </div>
                                <input type="hidden" name="anggota2_signature" id="anggota2_signature">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="flex items-center justify-between mt-8 pt-6 border-t">
                <a href="{{ route('admin_inovasi.katsinov-v2.show', $katsinov->id) }}" 
                   class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                    Kembali
                </a>
                
                <div class="flex gap-3">
                    <button type="submit" name="save_as_draft" value="1"
                            class="px-6 py-3 bg-yellow-500 hover:bg-yellow-600 text-white font-semibold rounded-lg transition duration-300 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                        </svg>
                        Simpan Draft
                    </button>
                    
                    <button type="submit" 
                            class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Simpan & Selesai
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Signature Pad Library --}}
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.7/dist/signature_pad.umd.min.js"></script>

<script>
// Initialize signature pads
const signaturePads = {};
const members = ['penanggungjawab', 'ketua', 'anggota1', 'anggota2'];

members.forEach(member => {
    const canvas = document.getElementById(`signature-${member}`);
    if (canvas) {
        // Make canvas responsive
        function resizeCanvas() {
            const ratio = Math.max(window.devicePixelRatio || 1, 1);
            canvas.width = canvas.offsetWidth * ratio;
            canvas.height = canvas.offsetHeight * ratio;
            canvas.getContext("2d").scale(ratio, ratio);
            
            // Reload signature if exists
            const hiddenInput = document.getElementById(`${member}_signature`);
            if (hiddenInput.value) {
                const signaturePad = signaturePads[member];
                if (signaturePad) {
                    signaturePad.fromDataURL(hiddenInput.value);
                }
            }
        }
        
        // Initialize signature pad
        signaturePads[member] = new SignaturePad(canvas, {
            backgroundColor: 'rgb(255, 255, 255)',
            penColor: 'rgb(0, 0, 0)',
            minWidth: 1,
            maxWidth: 2.5
        });
        
        // Save signature to hidden input on end stroke
        signaturePads[member].addEventListener("endStroke", () => {
            const dataURL = signaturePads[member].toDataURL('image/png');
            document.getElementById(`${member}_signature`).value = dataURL;
        });
        
        // Resize canvas on window resize
        window.addEventListener("resize", resizeCanvas);
        resizeCanvas();
        
        // Load existing signature if editing
        @if(isset($beritaAcara))
            @if(isset($beritaAcara->{$member . '_signature'}))
                const existingSignature_{{ $member }} = "{{ $beritaAcara->{$member . '_signature'} ?? '' }}";
                if (existingSignature_{{ $member }}) {
                    signaturePads['{{ $member }}'].fromDataURL(existingSignature_{{ $member }});
                    document.getElementById('{{ $member }}_signature').value = existingSignature_{{ $member }};
                }
            @endif
        @endif
    }
});

// Clear signature function
function clearSignature(member) {
    if (signaturePads[member]) {
        signaturePads[member].clear();
        document.getElementById(`${member}_signature`).value = '';
    }
}

// Validate form before submit
document.querySelector('form').addEventListener('submit', function(e) {
    let hasErrors = false;
    let errorMessage = '';
    
    members.forEach(member => {
        const signaturePad = signaturePads[member];
        const hiddenInput = document.getElementById(`${member}_signature`);
        
        // Check if signature is empty
        if (signaturePad && signaturePad.isEmpty() && !hiddenInput.value) {
            hasErrors = true;
            errorMessage += `- Tanda tangan ${member.replace('_', ' ')} belum diisi\n`;
        }
    });
    
    if (hasErrors) {
        e.preventDefault();
        alert('Mohon lengkapi tanda tangan berikut:\n\n' + errorMessage);
        return false;
    }
});
</script>

<style>
.signature-pad {
    width: 100%;
    height: 150px;
    touch-action: none;
    cursor: crosshair;
}
</style>

@endsection
