@extends('admin_pemeringkatan.index')
@section('contentadmin_pemeringkatan')
@vite(['resources/js/admin/international_lecture_dashboard.js'])

<div class="min-h-screen bg-gray-50 p-4 sm:p-6 lg:p-8">
    <div class="max-w-[1200px] mx-auto">
        <div class="mb-4">
            @include('admin_pemeringkatan.international-lecture.partials.back-button', [
                'backRoute' => 'admin_pemeringkatan.international-lecture.index',
                'backParams' => ['table' => 1],
                'backLabel' => 'Kembali ke International Lecture',
            ])
        </div>
        {{-- Alert Errors --}}
        @if($errors->any())
            <div id="formValidationAlert" class="mb-6 relative overflow-hidden bg-red-50 border-l-4 border-red-500 p-4 rounded-xl shadow-xs transition-all duration-300 ease-out" role="alert">
                <div class="flex items-start">
                    <i class='bx bx-error-circle text-red-500 text-xl mr-3 mt-0.5 flex-shrink-0'></i>
                    <div>
                        <h4 class="text-sm font-semibold text-red-800">Mohon periksa kembali form berikut:</h4>
                        <ul class="list-disc ml-5 mt-1 text-sm text-red-700 space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                {{-- Progress Bar Timer --}}
                <div class="absolute bottom-0 left-0 w-full h-1 bg-red-200/70 overflow-hidden">
                    <div id="alertProgressBar" class="h-full bg-red-500 transition-all duration-100 ease-linear" style="width: 100%;"></div>
                </div>
            </div>

            <script>
                (function() {
                    const alertEl = document.getElementById('formValidationAlert');
                    const progressBar = document.getElementById('alertProgressBar');
                    if (!alertEl) return;

                    // Durasi timer 15 detik agar pengguna memiliki cukup waktu membaca pesan
                    const totalDuration = 15000;
                    let remainingTime = totalDuration;
                    const intervalStep = 100;
                    let isPaused = false;

                    const timerInterval = setInterval(() => {
                        if (isPaused) return;

                        remainingTime -= intervalStep;
                        if (remainingTime <= 0) {
                            clearInterval(timerInterval);
                            window.dismissValidationAlert();
                            return;
                        }

                        // Update lebar progress bar
                        const percent = (remainingTime / totalDuration) * 100;
                        if (progressBar) {
                            progressBar.style.width = percent + '%';
                        }
                    }, intervalStep);

                    // Jeda timer saat kursor mouse diarahkan ke pop up
                    alertEl.addEventListener('mouseenter', () => {
                        isPaused = true;
                    });

                    // Lanjutkan timer saat kursor mouse keluar dari pop up
                    alertEl.addEventListener('mouseleave', () => {
                        isPaused = false;
                    });

                    window.dismissValidationAlert = function() {
                        clearInterval(timerInterval);
                        alertEl.style.opacity = '0';
                        alertEl.style.transform = 'translateY(-6px)';
                        setTimeout(() => {
                            alertEl.style.maxHeight = alertEl.scrollHeight + 'px';
                            alertEl.style.overflow = 'hidden';
                            alertEl.style.transition = 'all 0.3s ease-out';
                            requestAnimationFrame(() => {
                                alertEl.style.maxHeight = '0';
                                alertEl.style.paddingTop = '0';
                                alertEl.style.paddingBottom = '0';
                                alertEl.style.marginTop = '0';
                                alertEl.style.marginBottom = '0';
                                setTimeout(() => alertEl.remove(), 350);
                            });
                        }, 150);
                    };
                })();
            </script>
        @endif

        <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
            {{-- Header (1 warna solid, tanpa gradient, tanpa tombol kembali) --}}
            <div class="bg-blue-600 px-6 py-4">
                <h2 class="text-xl font-bold text-white">Add New International Lecturer</h2>
            </div>

            <form action="{{ route('admin_pemeringkatan.international-lecture.store') }}" method="POST" id="lecturerForm" class="px-6 pb-6 pt-3.5 sm:px-8 sm:pb-8 sm:pt-4 space-y-6">
                @csrf

                {{-- Section 1: Identitas Dosen --}}
                <div class="bg-slate-50/60 p-5 sm:p-6 rounded-xl border border-slate-200/70">
                    <div class="border-b-2 border-blue-500 pb-3 mb-6">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-6 bg-blue-600 rounded-full inline-block"></span>
                            <h3 class="text-lg font-bold text-gray-800">Identitas Dosen</h3>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        {{-- Nama Dosen Asing * --}}
                        <div class="md:col-span-2">
                            <label class="label">Nama Dosen Asing <span class="text-red-500">*</span></label>
                            <input type="text" name="nama" value="{{ old('nama') }}" required 
                                   placeholder="Contoh: Prof. John Smith, Ph.D."
                                   oninvalid="this.setCustomValidity('Nama Dosen Asing wajib diisi.')" 
                                   oninput="this.setCustomValidity('')" 
                                   class="input">
                        </div>

                        {{-- Jenis Kelamin * --}}
                        <div>
                            <label class="label">Jenis Kelamin <span class="text-red-500">*</span></label>
                            <select name="jenis_kelamin" required class="input" 
                                    oninvalid="this.setCustomValidity('Jenis Kelamin wajib dipilih.')" 
                                    oninput="this.setCustomValidity('')">
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="Male" @selected(old('jenis_kelamin') === 'Male')>Male</option>
                                <option value="Female" @selected(old('jenis_kelamin') === 'Female')>Female</option>
                                <option value="Other" @selected(old('jenis_kelamin') === 'Other')>Other</option>
                            </select>
                        </div>

                        {{-- Jabatan * (Dropdown with Academic & Employer Designations) --}}
                        <div>
                            <label class="label">Jabatan <span class="text-red-500">*</span></label>
                            @php
                                $oldJabatan = old('jabatan');
                                $allPreset = array_merge($academicDesignations ?? [], $employerDesignations ?? []);
                                $isCustomJabatan = $oldJabatan && !in_array($oldJabatan, $allPreset) && $oldJabatan !== 'Other';
                            @endphp
                            <select id="jabatan_select" class="input" required 
                                    oninvalid="this.setCustomValidity('Jabatan wajib dipilih.')" 
                                    oninput="this.setCustomValidity('')"
                                    onchange="handleJabatanChange()">
                                <option value="">Pilih Jabatan</option>
                                <optgroup label="Academic Designations">
                                    @foreach($academicDesignations as $desig)
                                        <option value="{{ $desig }}" @selected($oldJabatan === $desig)>{{ $desig }}</option>
                                    @endforeach
                                </optgroup>
                                <optgroup label="Employer Designations">
                                    @foreach($employerDesignations as $desig)
                                        <option value="{{ $desig }}" @selected($oldJabatan === $desig)>{{ $desig }}</option>
                                    @endforeach
                                </optgroup>
                                <option value="Other" @selected($oldJabatan === 'Other' || $isCustomJabatan)>Other (Input Manual)</option>
                            </select>

                            {{-- Input Manual jika pilih Other / custom --}}
                            <div id="jabatan_custom_wrapper" class="{{ ($oldJabatan === 'Other' || $isCustomJabatan) ? '' : 'hidden' }} mt-2">
                                <input type="text" id="jabatan_custom_input" 
                                       value="{{ $isCustomJabatan ? $oldJabatan : ($oldJabatan === 'Other' ? '' : '') }}" 
                                       placeholder="Ketik jabatan secara manual..." 
                                       class="input border-blue-400 bg-blue-50/30"
                                       oninput="syncJabatanValue()">
                            </div>

                            {{-- Hidden input yang dikirim ke controller --}}
                            <input type="hidden" name="jabatan" id="jabatan_final" value="{{ $oldJabatan }}">
                        </div>

                        {{-- Institusi Asal * --}}
                        <div>
                            <label class="label">Institusi Asal <span class="text-red-500">*</span></label>
                            <input type="text" name="universitas_asal" value="{{ old('universitas_asal') }}" required 
                                   placeholder="Contoh: National University of Singapore"
                                   oninvalid="this.setCustomValidity('Institusi Asal wajib diisi.')" 
                                   oninput="this.setCustomValidity('')" 
                                   class="input">
                        </div>

                        {{-- Negara * --}}
                        @include('admin_pemeringkatan.international-lecture.partials.country-select', [
                            'selectedCountry' => old('negara'),
                            'countryOptions' => $countryOptions ?? null,
                        ])

                        {{-- Email * --}}
                        <div>
                            <label class="label">Email <span class="text-red-500">*</span></label>
                            <input type="email" name="email" value="{{ old('email') }}" required 
                                   placeholder="lecturer@institution.edu" 
                                   oninvalid="this.setCustomValidity('Email valid wajib diisi.')" 
                                   oninput="this.setCustomValidity('')" 
                                   class="input">
                            <p class="text-[11px] text-gray-500 mt-1">Email harus fix resmi yang dituju.</p>
                        </div>

                        {{-- Subject * (Dipindahkan ke Identitas Dosen) --}}
                        <div>
                            <label class="label">Subject (Bidang Ilmu) <span class="text-red-500">*</span></label>
                            <select name="subject_1" required class="input"
                                    oninvalid="this.setCustomValidity('Subject wajib dipilih.')" 
                                    oninput="this.setCustomValidity('')">
                                <option value="">Pilih Subject</option>
                                @foreach($subjects as $subject)
                                    <option value="{{ $subject }}" @selected(old('subject_1') === $subject)>{{ $subject }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                {{-- Section 2: Academic Details --}}
                <div class="bg-slate-50/60 p-5 sm:p-6 rounded-xl border border-slate-200/70">
                    <div class="border-b-2 border-emerald-500 pb-3 mb-6">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-6 bg-emerald-600 rounded-full inline-block"></span>
                            <h3 class="text-lg font-bold text-gray-800">Academic Details</h3>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        {{-- Fakultas * --}}
                        <div>
                            <label class="label">Fakultas <span class="text-red-500">*</span></label>
                            <select name="fakultas" id="fakultas" required class="input"
                                    oninvalid="this.setCustomValidity('Fakultas wajib dipilih.')" 
                                    oninput="this.setCustomValidity('')">
                                <option value="">Pilih Fakultas</option>
                                @foreach(['pascasarjana'=>'PASCASARJANA','fip'=>'FIP','fmipa'=>'FMIPA','fppsi'=>'FPPsi','fbs'=>'FBS','ft'=>'FT','fik'=>'FIK','fis'=>'FIS','fe'=>'FE','profesi'=>'PROFESI','lainnya'=>'LAINNYA'] as $key => $label)
                                    <option value="{{ $key }}" @selected(old('fakultas') === $key)>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Program Studi --}}
                        <div>
                            <label class="label">Program Studi</label>
                            <select name="prodi" id="prodi" disabled data-selected="{{ old('prodi') }}" class="input">
                                <option value="">Pilih Program Studi (Opsional)</option>
                            </select>
                        </div>

                        {{-- Tahun Dosen Datang * --}}
                        <div>
                            <label class="label">Tahun Dosen Datang <span class="text-red-500">*</span></label>
                            <input type="text" name="tahun" value="{{ old('tahun') }}" required 
                                   placeholder="Contoh: 2026" 
                                   oninvalid="this.setCustomValidity('Tahun Dosen Datang wajib diisi.')" 
                                   oninput="this.setCustomValidity('')" 
                                   class="input">
                        </div>

                        {{-- Sesi (Semester) - Input Manual * --}}
                        <div>
                            <label class="label">Sesi (Semester) <span class="text-red-500">*</span></label>
                            <input type="text" name="sesi" value="{{ old('sesi') }}" required 
                                   placeholder="Contoh: 125" 
                                   oninvalid="this.setCustomValidity('Sesi (Semester) wajib diisi.')" 
                                   oninput="this.setCustomValidity('')" 
                                   class="input">
                        </div>

                        {{-- Kegiatan Dosen di Kampus * --}}
                        <div>
                            <label class="label">Kegiatan Dosen di Kampus <span class="text-red-500">*</span></label>
                            @php
                                $oldStatus = old('status');
                                $isCustomStatus = $oldStatus && !in_array($oldStatus, $activityTypes ?? []) && $oldStatus !== 'Other';
                            @endphp
                            <select id="kegiatan_select" class="input" required 
                                    oninvalid="this.setCustomValidity('Kegiatan dosen di kampus wajib dipilih.')" 
                                    oninput="this.setCustomValidity('')"
                                    onchange="handleKegiatanChange()">
                                <option value="">Pilih Kegiatan di Kampus</option>
                                @foreach($activityTypes as $type)
                                    <option value="{{ $type }}" @selected($oldStatus === $type)>{{ $type }}</option>
                                @endforeach
                                <option value="Other" @selected($oldStatus === 'Other' || $isCustomStatus)>Other (Input Manual)</option>
                            </select>

                            {{-- Input Manual jika pilih Other / custom --}}
                            <div id="kegiatan_custom_wrapper" class="{{ ($oldStatus === 'Other' || $isCustomStatus) ? '' : 'hidden' }} mt-2">
                                <input type="text" id="kegiatan_custom_input" 
                                       value="{{ $isCustomStatus ? $oldStatus : ($oldStatus === 'Other' ? '' : '') }}" 
                                       placeholder="Ketik nama kegiatan secara manual..." 
                                       class="input border-emerald-400 bg-emerald-50/30"
                                       oninput="syncKegiatanValue()">
                            </div>

                            <input type="hidden" name="status" id="status_final" value="{{ $oldStatus }}">
                        </div>

                        {{-- Tanggal Kegiatan * (Bersebelahan dengan Kegiatan Dosen di Kampus) --}}
                        <div>
                            <label class="label">Tanggal Kegiatan <span class="text-red-500">*</span></label>
                            <input type="date" name="tanggal" value="{{ old('tanggal') }}" required
                                   oninvalid="this.setCustomValidity('Tanggal Kegiatan wajib diisi.')" 
                                   oninput="this.setCustomValidity('')" 
                                   class="input">
                        </div>

                        {{-- Link Bukti Kegiatan (Di Bawah, Membentang Penuh dengan gap lebih rapat) --}}
                        <div class="md:col-span-2 -mt-2">
                            <label class="label">Link Bukti Kegiatan</label>
                            <div class="relative">
                                <input type="url" name="link_bukti_kegiatan" value="{{ old('link_bukti_kegiatan') }}" 
                                       placeholder="https://... atau http://..." 
                                       class="input pl-9">
                                <i class='bx bx-link absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-lg'></i>
                            </div>
                            <p class="text-[11px] text-gray-500 mt-1">Opsional (Format: https://... atau http://...)</p>
                        </div>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="flex items-center justify-end gap-3 pt-6">
                    <a href="{{ route('admin_pemeringkatan.international-lecture.index', ['table' => 1]) }}" 
                       onclick="try{sessionStorage.setItem('intl_lecture_show_table', 'true')}catch(e){}"
                       class="px-5 py-2.5 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-lg text-center transition-colors">
                        Batal
                    </a>
                    <button type="submit" 
                            class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-sm hover:shadow transition-all flex items-center justify-center gap-2">
                        <i class='bx bx-save text-lg'></i> Simpan Dosen
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function handleJabatanChange() {
    const select = document.getElementById('jabatan_select');
    const customWrapper = document.getElementById('jabatan_custom_wrapper');
    const customInput = document.getElementById('jabatan_custom_input');
    const finalInput = document.getElementById('jabatan_final');

    if (select.value === 'Other') {
        customWrapper.classList.remove('hidden');
        finalInput.value = customInput.value.trim();
        customInput.focus();
    } else {
        customWrapper.classList.add('hidden');
        finalInput.value = select.value;
    }
}

function syncJabatanValue() {
    const select = document.getElementById('jabatan_select');
    const customInput = document.getElementById('jabatan_custom_input');
    const finalInput = document.getElementById('jabatan_final');
    if (select.value === 'Other') {
        finalInput.value = customInput.value.trim();
    }
}

function handleKegiatanChange() {
    const select = document.getElementById('kegiatan_select');
    const customWrapper = document.getElementById('kegiatan_custom_wrapper');
    const customInput = document.getElementById('kegiatan_custom_input');
    const finalInput = document.getElementById('status_final');

    if (select.value === 'Other') {
        customWrapper.classList.remove('hidden');
        finalInput.value = customInput.value.trim();
        customInput.focus();
    } else {
        customWrapper.classList.add('hidden');
        finalInput.value = select.value;
    }
}

function syncKegiatanValue() {
    const select = document.getElementById('kegiatan_select');
    const customInput = document.getElementById('kegiatan_custom_input');
    const finalInput = document.getElementById('status_final');
    if (select.value === 'Other') {
        finalInput.value = customInput.value.trim();
    }
}

document.addEventListener('DOMContentLoaded', function() {
    handleJabatanChange();
    handleKegiatanChange();

    document.getElementById('lecturerForm').addEventListener('submit', function(e) {
        syncJabatanValue();
        syncKegiatanValue();

        const jabatanFinal = document.getElementById('jabatan_final').value.trim();
        if (!jabatanFinal) {
            e.preventDefault();
            alert('Jabatan wajib dipilih atau diisi.');
            document.getElementById('jabatan_select').focus();
            return false;
        }

        const negaraFinal = document.getElementById('negara_final').value.trim();
        if (!negaraFinal) {
            e.preventDefault();
            alert('Negara wajib dipilih.');
            const negaraTrigger = document.getElementById('negara_trigger');
            if (negaraTrigger) negaraTrigger.click();
            return false;
        }

        const statusFinal = document.getElementById('status_final').value.trim();
        if (!statusFinal) {
            e.preventDefault();
            alert('Kegiatan dosen di kampus wajib dipilih atau diisi.');
            document.getElementById('kegiatan_select').focus();
            return false;
        }
    });
});
</script>

<style>
.label {
    display: block;
    font-size: 0.875rem;
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.35rem;
}
.input {
    width: 100%;
    padding: 0.625rem 0.875rem;
    border: 1px solid #d1d5db;
    border-radius: 0.5rem;
    background-color: #ffffff;
    font-size: 0.875rem;
    color: #1f2937;
    transition: all 0.15s ease-in-out;
}
.input:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
}
</style>
@endsection
