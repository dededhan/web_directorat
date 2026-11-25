@extends('admin_pemeringkatan.index')
@section('contentadmin_pemeringkatan')
@vite(['resources/js/admin/international_lecture_dashboard.js'])

<div class="min-h-screen bg-gray-50 p-4 sm:p-6 lg:p-8">
    <div class="max-w-[1400px] mx-auto space-y-6">
        <div>
            @include('admin_pemeringkatan.international-lecture.partials.back-button', [
                'backRoute' => 'admin_pemeringkatan.international-lecture.index',
                'backParams' => ['table' => 1],
                'backLabel' => 'Kembali ke International Lecture',
            ])
        </div>
        @if($errors->any())
            <div id="formValidationAlert" class="relative overflow-hidden bg-red-50 border-l-4 border-red-500 p-4 rounded-xl shadow-xs transition-all duration-300 ease-out" role="alert">
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

        {{-- Card Form Edit Dosen --}}
        <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
            {{-- Header (1 warna solid, tanpa gradient, tanpa tombol kembali) --}}
            <div class="bg-blue-600 px-6 py-4">
                <h2 class="text-xl font-bold text-white">Edit International Lecturer</h2>
                <p class="text-blue-100 text-sm mt-0.5">{{ $lecturer->nama }} &middot; {{ $lecturer->universitas_asal }}</p>
            </div>

            <form action="{{ route('admin_pemeringkatan.international-lecture.update', $lecturer->id) }}" method="POST" id="editLecturerForm" class="px-6 pb-6 pt-3.5 sm:px-8 sm:pb-8 sm:pt-4 space-y-6">
                @csrf 
                @method('PUT')

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
                            <input type="text" name="nama" value="{{ old('nama', $lecturer->nama) }}" required 
                                   placeholder="Contoh: Prof. John Smith, Ph.D."
                                   oninvalid="this.setCustomValidity('Nama Dosen Asing wajib diisi.')" 
                                   oninput="this.setCustomValidity('')" 
                                   class="input">
                        </div>

                        {{-- Jenis Kelamin * --}}
                        <div>
                            <label class="label">Jenis Kelamin <span class="text-red-500">*</span></label>
                            @php
                                $currentGender = old('jenis_kelamin', $lecturer->jenis_kelamin);
                            @endphp
                            <select name="jenis_kelamin" required class="input"
                                    oninvalid="this.setCustomValidity('Jenis Kelamin wajib dipilih.')" 
                                    oninput="this.setCustomValidity('')">
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="Male" @selected($currentGender === 'Male')>Male</option>
                                <option value="Female" @selected($currentGender === 'Female')>Female</option>
                                <option value="Other" @selected($currentGender === 'Other')>Other</option>
                            </select>
                        </div>

                        {{-- Jabatan * (Dropdown with Academic & Employer Designations) --}}
                        <div>
                            <label class="label">Jabatan <span class="text-red-500">*</span></label>
                            @php
                                $currentJabatan = old('jabatan', $lecturer->jabatan);
                                $allPreset = array_merge($academicDesignations ?? [], $employerDesignations ?? []);
                                $isPresetJabatan = in_array($currentJabatan, $allPreset);
                                $isCustomJabatan = $currentJabatan && !$isPresetJabatan;
                            @endphp
                            <select id="jabatan_select" class="input" required 
                                    oninvalid="this.setCustomValidity('Jabatan wajib dipilih.')" 
                                    oninput="this.setCustomValidity('')"
                                    onchange="handleJabatanChange()">
                                <option value="">Pilih Jabatan</option>
                                <optgroup label="Academic Designations">
                                    @foreach($academicDesignations as $desig)
                                        <option value="{{ $desig }}" @selected($currentJabatan === $desig)>{{ $desig }}</option>
                                    @endforeach
                                </optgroup>
                                <optgroup label="Employer Designations">
                                    @foreach($employerDesignations as $desig)
                                        <option value="{{ $desig }}" @selected($currentJabatan === $desig)>{{ $desig }}</option>
                                    @endforeach
                                </optgroup>
                                <option value="Other" @selected($currentJabatan === 'Other' || $isCustomJabatan)>Other (Input Manual)</option>
                            </select>

                            {{-- Input Manual jika pilih Other / custom --}}
                            <div id="jabatan_custom_wrapper" class="{{ ($currentJabatan === 'Other' || $isCustomJabatan) ? '' : 'hidden' }} mt-2">
                                <input type="text" id="jabatan_custom_input" 
                                       value="{{ $isCustomJabatan ? $currentJabatan : ($currentJabatan === 'Other' ? '' : '') }}" 
                                       placeholder="Ketik jabatan secara manual..." 
                                       class="input border-blue-400 bg-blue-50/30"
                                       oninput="syncJabatanValue()">
                            </div>

                            <input type="hidden" name="jabatan" id="jabatan_final" value="{{ $currentJabatan }}">
                        </div>

                        {{-- Institusi Asal * --}}
                        <div>
                            <label class="label">Institusi Asal <span class="text-red-500">*</span></label>
                            <input type="text" name="universitas_asal" value="{{ old('universitas_asal', $lecturer->universitas_asal) }}" required 
                                   placeholder="Contoh: National University of Singapore"
                                   oninvalid="this.setCustomValidity('Institusi Asal wajib diisi.')" 
                                   oninput="this.setCustomValidity('')" 
                                   class="input">
                        </div>

                        {{-- Negara * --}}
                        @include('admin_pemeringkatan.international-lecture.partials.country-select', [
                            'selectedCountry' => old('negara', $lecturer->negara),
                            'countryOptions' => $countryOptions ?? null,
                        ])

                        {{-- Email * --}}
                        <div>
                            <label class="label">Email <span class="text-red-500">*</span></label>
                            <input type="email" name="email" value="{{ old('email', $lecturer->email) }}" required 
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
                                    <option value="{{ $subject }}" @selected(old('subject_1', $lecturer->subject_1) === $subject)>{{ $subject }}</option>
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
                                    <option value="{{ $key }}" @selected(old('fakultas', $lecturer->fakultas) === $key)>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Program Studi --}}
                        <div>
                            <label class="label">Program Studi</label>
                            <select name="prodi" id="prodi" data-selected="{{ old('prodi', $lecturer->prodi) }}" class="input">
                                <option value="">Pilih Program Studi (Opsional)</option>
                            </select>
                        </div>

                        {{-- Tahun Dosen Datang * --}}
                        <div>
                            <label class="label">Tahun Dosen Datang <span class="text-red-500">*</span></label>
                            <input type="text" name="tahun" value="{{ old('tahun', $lecturer->tahun) }}" required 
                                   placeholder="Contoh: 2026" 
                                   oninvalid="this.setCustomValidity('Tahun Dosen Datang wajib diisi.')" 
                                   oninput="this.setCustomValidity('')" 
                                   class="input">
                        </div>

                        {{-- Sesi (Semester) - Input Manual * --}}
                        <div>
                            <label class="label">Sesi (Semester) <span class="text-red-500">*</span></label>
                            <input type="text" name="sesi" value="{{ old('sesi', $lecturer->sesi) }}" required 
                                   placeholder="Contoh: 125" 
                                   oninvalid="this.setCustomValidity('Sesi (Semester) wajib diisi.')" 
                                   oninput="this.setCustomValidity('')" 
                                   class="input">
                        </div>

                    </div>
                </div>

                {{-- Action Buttons untuk Form Edit Dosen --}}
                <div class="flex items-center justify-end gap-3 pt-4">
                    <a href="{{ route('admin_pemeringkatan.international-lecture.index', ['table' => 1]) }}" 
                       onclick="try{sessionStorage.setItem('intl_lecture_show_table', 'true')}catch(e){}"
                       class="px-5 py-2.5 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-lg text-center transition-colors">
                        Batal
                    </a>
                    <button type="submit" 
                            class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-sm hover:shadow transition-all flex items-center justify-center gap-2">
                        <i class='bx bx-save text-lg'></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>

        {{-- Card Kegiatan Dosen di Kampus (Kotak Putih Terpisah) --}}
        <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6 sm:p-8">
            {{-- Kotak di dalamnya sama persis seperti bagian Academic Details --}}
            <div class="bg-slate-50/60 p-5 sm:p-6 rounded-xl border border-slate-200/70">
                <div class="border-b-2 border-emerald-500 pb-3 mb-6 flex flex-col sm:flex-row justify-between sm:items-center gap-3">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-6 bg-emerald-600 rounded-full inline-block"></span>
                        <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                            Kegiatan Dosen di Kampus
                        </h3>
                        <span class="text-xs font-semibold px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200">
                            {{ $lecturer->activities->count() }} Kegiatan
                        </span>
                    </div>
                    <button type="button" onclick="toggleActivityForm()" 
                            class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-lg transition-colors flex items-center gap-1.5 shadow-xs">
                        <i class='bx bx-plus text-base'></i> Tambah Kegiatan Baru
                    </button>
                </div>

                {{-- Form Tambah Kegiatan Terpisah --}}
                <form id="activityForm" action="{{ route('admin_pemeringkatan.international-lecture.activities.store', $lecturer->id) }}" method="POST" class="hidden p-5 border border-emerald-200 rounded-xl bg-white mb-5 shadow-xs">
                    @csrf
                    <div class="mb-4 pb-2 border-b border-emerald-200/60 flex items-center justify-between">
                        <div class="font-bold text-gray-800 text-sm flex items-center gap-2">
                            <i class='bx bx-plus-circle text-emerald-600 text-lg'></i>
                            Form Tambah Kegiatan Dosen di Kampus & Bukti Kegiatan
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        {{-- Jenis Kegiatan --}}
                        <div>
                            <label class="label">Kegiatan Dosen di Kampus <span class="text-red-500">*</span></label>
                            <select id="new_kegiatan_select" class="input" required onchange="handleNewKegiatanChange()">
                                <option value="">Pilih Kegiatan di Kampus</option>
                                @foreach($activityTypes as $type)
                                    <option value="{{ $type }}">{{ $type }}</option>
                                @endforeach
                                <option value="Other">Other (Input Manual)</option>
                            </select>

                            <div id="new_kegiatan_custom_wrapper" class="hidden mt-2">
                                <input type="text" id="new_kegiatan_custom_input" 
                                       placeholder="Ketik nama kegiatan secara manual..." 
                                       class="input border-emerald-400 bg-emerald-50/30"
                                       oninput="syncNewKegiatanValue()">
                            </div>

                            <input type="hidden" name="jenis_kegiatan" id="new_kegiatan_final">
                        </div>

                        {{-- Link Bukti Kegiatan --}}
                        <div>
                            <label class="label">Link Bukti Kegiatan</label>
                            <div class="relative">
                                <input type="url" name="link_bukti_kegiatan" 
                                       placeholder="https://drive.google.com/... atau tautan bukti lainnya" 
                                       class="input pl-9">
                                <i class='bx bx-link absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-lg'></i>
                            </div>
                        </div>

                        {{-- Tanggal Kegiatan * --}}
                        <div>
                            <label class="label">Tanggal Kegiatan <span class="text-red-500">*</span></label>
                            <input type="date" name="tanggal" required
                                   oninvalid="this.setCustomValidity('Tanggal Kegiatan wajib diisi.')" 
                                   oninput="this.setCustomValidity('')" 
                                   class="input">
                        </div>
                    </div>

                    <div class="flex justify-end gap-2 pt-4 border-t border-emerald-200/60 mt-4">
                        <button type="button" onclick="toggleActivityForm(false)" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 text-sm font-medium rounded-lg transition-colors">
                            Batal
                        </button>
                        <button type="submit" class="px-5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-lg shadow-xs flex items-center gap-1.5 transition-colors">
                            <i class='bx bx-check text-base'></i> Simpan Kegiatan Baru
                        </button>
                    </div>
                </form>

                {{-- List Riwayat Kegiatan --}}
                <div class="space-y-3">
                    @forelse($lecturer->activities->sortBy('id') as $activity)
                        @php
                            $actLink = $activity->link_bukti_kegiatan ?: ($loop->first && $activity->jenis_kegiatan === $lecturer->status ? $lecturer->link_bukti_kegiatan : null);
                            $activityCurrentType = $activity->jenis_kegiatan ?: $activity->judul ?: '';
                            $isPresetActivityType = in_array($activityCurrentType, $activityTypes ?? []);
                        @endphp
                        <div class="border border-gray-200 rounded-xl hover:border-emerald-300 transition-all bg-white overflow-hidden shadow-2xs">
                            {{-- Baris Utama --}}
                            <div class="p-4 flex flex-col sm:flex-row justify-between sm:items-center gap-3">
                                <div class="space-y-1 flex-1">
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <span class="text-sm font-bold text-gray-900">
                                            {{ $activityCurrentType ?: 'Kegiatan' }}
                                        </span>
                                        @if($activity->tanggal)
                                            <span class="text-xs text-gray-500 flex items-center gap-1">
                                                <i class='bx bx-calendar text-gray-400'></i>
                                                {{ $activity->tanggal->format('d M Y') }}
                                            </span>
                                        @endif
                                    </div>

                                    @if($actLink)
                                        <div class="pt-0.5">
                                            <a href="{{ $actLink }}" target="_blank" rel="noopener noreferrer" 
                                               class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-xs font-medium bg-blue-50 text-blue-700 border border-blue-200 hover:bg-blue-100 hover:underline transition-colors">
                                                <i class='bx bx-link-external'></i> Buka Tautan Bukti Kegiatan
                                            </a>
                                        </div>
                                    @endif
                                </div>

                                <div class="flex-shrink-0 flex items-center gap-2">
                                    {{-- Tombol Edit --}}
                                    <button type="button" onclick="toggleEditActivity({{ $activity->id }})" 
                                            id="editBtn-{{ $activity->id }}"
                                            class="text-emerald-600 hover:text-emerald-700 text-sm font-medium hover:underline flex items-center gap-1 px-2.5 py-1 rounded hover:bg-emerald-50 transition">
                                        <i class='bx bx-edit-alt'></i> Edit
                                    </button>
                                    {{-- Tombol Hapus --}}
                                    <form action="{{ route('admin_pemeringkatan.international-lecture.activities.destroy', [$lecturer->id, $activity->id]) }}" method="POST">
                                        @csrf 
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-700 text-sm font-medium hover:underline flex items-center gap-1 px-2.5 py-1 rounded hover:bg-red-50 transition" onclick="return confirm('Apakah Anda yakin ingin menghapus kegiatan ini?')">
                                            <i class='bx bx-trash'></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>

                            {{-- Form Edit Inline (Hidden by default) --}}
                            <div id="editForm-{{ $activity->id }}" class="hidden border-t border-emerald-100 bg-emerald-50/30 p-4">
                                <form action="{{ route('admin_pemeringkatan.international-lecture.activities.update', [$lecturer->id, $activity->id]) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        {{-- Kegiatan Dosen di Kampus --}}
                                        <div>
                                            <label class="label">Kegiatan Dosen di Kampus <span class="text-red-500">*</span></label>
                                            <select id="edit_kegiatan_select_{{ $activity->id }}" class="input" required onchange="handleEditKegiatanChange({{ $activity->id }})">
                                                <option value="">Pilih Kegiatan</option>
                                                @foreach($activityTypes as $type)
                                                    <option value="{{ $type }}" @selected($activityCurrentType === $type)>{{ $type }}</option>
                                                @endforeach
                                                <option value="Other" @selected(!$isPresetActivityType && $activityCurrentType !== '')>Other (Input Manual)</option>
                                            </select>

                                            <div id="edit_kegiatan_custom_wrapper_{{ $activity->id }}" class="{{ (!$isPresetActivityType && $activityCurrentType !== '') ? '' : 'hidden' }} mt-2">
                                                <input type="text" id="edit_kegiatan_custom_input_{{ $activity->id }}" 
                                                       value="{{ (!$isPresetActivityType && $activityCurrentType !== '') ? $activityCurrentType : '' }}" 
                                                       placeholder="Ketik nama kegiatan secara manual..." 
                                                       class="input border-emerald-400 bg-emerald-50/30"
                                                       oninput="syncEditKegiatanValue({{ $activity->id }})">
                                            </div>

                                            <input type="hidden" name="jenis_kegiatan" id="edit_kegiatan_final_{{ $activity->id }}" value="{{ $activityCurrentType }}">
                                        </div>

                                        {{-- Link Bukti Kegiatan --}}
                                        <div>
                                            <label class="label">Link Bukti Kegiatan</label>
                                            <div class="relative">
                                                <input type="url" name="link_bukti_kegiatan" 
                                                       value="{{ $activity->link_bukti_kegiatan }}" 
                                                       placeholder="https://... atau http://..." 
                                                       class="input pl-9">
                                                <i class='bx bx-link absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-lg'></i>
                                            </div>
                                        </div>

                                        {{-- Tanggal Kegiatan * --}}
                                        <div>
                                            <label class="label">Tanggal Kegiatan <span class="text-red-500">*</span></label>
                                            <input type="date" name="tanggal" value="{{ optional($activity->tanggal)->format('Y-m-d') }}" required
                                                   oninvalid="this.setCustomValidity('Tanggal Kegiatan wajib diisi.')" 
                                                   oninput="this.setCustomValidity('')" 
                                                   class="input">
                                        </div>
                                    </div>

                                    <div class="flex justify-end gap-2 mt-4">
                                        <button type="button" onclick="toggleEditActivity({{ $activity->id }})" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 text-sm font-medium rounded-lg transition-colors">
                                            Batal
                                        </button>
                                        <button type="submit" class="px-5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-lg shadow-xs flex items-center gap-1.5 transition-colors">
                                            <i class='bx bx-check text-base'></i> Simpan Perubahan
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8 text-gray-400 bg-white rounded-xl border border-dashed border-gray-300">
                            <i class='bx bx-calendar-x text-4xl mb-1.5 block text-gray-300'></i>
                            <p class="font-medium text-sm text-gray-600">Belum ada catatan kegiatan terdaftar untuk dosen ini.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function handleJabatanChange() {
    const select = document.getElementById('jabatan_select');
    const customWrapper = document.getElementById('jabatan_custom_wrapper');
    const customInput = document.getElementById('jabatan_custom_input');
    const finalInput = document.getElementById('jabatan_final');

    if (!select) return;

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
    if (select && select.value === 'Other') {
        finalInput.value = customInput.value.trim();
    }
}

function toggleActivityForm(forceShow) {
    const form = document.getElementById('activityForm');
    if (!form) return;
    if (typeof forceShow === 'boolean') {
        if (forceShow) {
            form.classList.remove('hidden');
            form.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        } else {
            form.classList.add('hidden');
        }
    } else {
        form.classList.toggle('hidden');
        if (!form.classList.contains('hidden')) {
            form.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }
    }
}

function handleNewKegiatanChange() {
    const select = document.getElementById('new_kegiatan_select');
    const customWrapper = document.getElementById('new_kegiatan_custom_wrapper');
    const customInput = document.getElementById('new_kegiatan_custom_input');
    const finalInput = document.getElementById('new_kegiatan_final');

    if (!select) return;

    if (select.value === 'Other') {
        customWrapper.classList.remove('hidden');
        finalInput.value = customInput.value.trim();
        customInput.focus();
    } else {
        customWrapper.classList.add('hidden');
        finalInput.value = select.value;
    }
}

function syncNewKegiatanValue() {
    const select = document.getElementById('new_kegiatan_select');
    const customInput = document.getElementById('new_kegiatan_custom_input');
    const finalInput = document.getElementById('new_kegiatan_final');
    if (select && select.value === 'Other') {
        finalInput.value = customInput.value.trim();
    }
}

function toggleEditActivity(activityId) {
    const editForm = document.getElementById('editForm-' + activityId);
    const editBtn = document.getElementById('editBtn-' + activityId);
    if (!editForm) return;

    editForm.classList.toggle('hidden');

    if (!editForm.classList.contains('hidden')) {
        editBtn.innerHTML = "<i class='bx bx-x'></i> Tutup";
        editForm.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    } else {
        editBtn.innerHTML = "<i class='bx bx-edit-alt'></i> Edit";
    }
}

function handleEditKegiatanChange(activityId) {
    const select = document.getElementById('edit_kegiatan_select_' + activityId);
    const customWrapper = document.getElementById('edit_kegiatan_custom_wrapper_' + activityId);
    const customInput = document.getElementById('edit_kegiatan_custom_input_' + activityId);
    const finalInput = document.getElementById('edit_kegiatan_final_' + activityId);

    if (!select) return;

    if (select.value === 'Other') {
        customWrapper.classList.remove('hidden');
        finalInput.value = customInput.value.trim();
        customInput.focus();
    } else {
        customWrapper.classList.add('hidden');
        finalInput.value = select.value;
    }
}

function syncEditKegiatanValue(activityId) {
    const select = document.getElementById('edit_kegiatan_select_' + activityId);
    const customInput = document.getElementById('edit_kegiatan_custom_input_' + activityId);
    const finalInput = document.getElementById('edit_kegiatan_final_' + activityId);
    if (select && select.value === 'Other') {
        finalInput.value = customInput.value.trim();
    }
}

document.addEventListener('DOMContentLoaded', function() {
    handleJabatanChange();

    const editForm = document.getElementById('editLecturerForm');
    if (editForm) {
        editForm.addEventListener('submit', function(e) {
            syncJabatanValue();

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
        });
    }

    const activityForm = document.getElementById('activityForm');
    if (activityForm) {
        activityForm.addEventListener('submit', function(e) {
            syncNewKegiatanValue();
            const finalVal = document.getElementById('new_kegiatan_final').value.trim();
            if (!finalVal) {
                e.preventDefault();
                alert('Kegiatan dosen di kampus wajib dipilih atau diisi.');
                document.getElementById('new_kegiatan_select').focus();
                return false;
            }
        });
    }

    // Validasi form edit per-kegiatan
    document.querySelectorAll('form[id^="editForm-"] form, [id^="editForm-"] form').forEach(function(form) {
        form.addEventListener('submit', function(e) {
            const hiddenInput = form.querySelector('input[name="jenis_kegiatan"]');
            if (hiddenInput && !hiddenInput.value.trim()) {
                e.preventDefault();
                alert('Kegiatan dosen di kampus wajib dipilih atau diisi.');
                return false;
            }
        });
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
