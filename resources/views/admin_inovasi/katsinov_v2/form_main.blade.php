@extends('admin_inovasi.dashboard')

@section('contentadmin_inovasi')
<div class="p-6 max-w-7xl mx-auto">
    {{-- Header --}}
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">PENGUKURAN TINGKAT KESIAPAN INOVASI (KATSINOV)</h1>
        <p class="text-gray-600 mt-1">Innovation Readiness Level - Meter</p>
    </div>

    {{-- Penjelasan KATSINOV --}}
    <div class="bg-white rounded-lg shadow-lg p-8 mb-6">
        <div class="border-l-4 border-blue-500 pl-4 mb-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Penjelasan KATSINOV</h2>
        </div>
        
        <div class="prose max-w-none">
            <p class="text-gray-700 mb-4">
                <strong>IRL-Meter (Innovation Readiness Level - Meter)</strong> atau
                <strong>KATSINOV-Meter (Tingkat Kesiapan Inovasi - Meter)</strong>
                adalah sebuah alat ukur yang digunakan untuk mengukur tingkat kesiapan atau kematangan
                inovasi yang dilakukan oleh suatu perusahaan dan/atau proyek/program/kegiatan.
                KATSINOV-Meter menggunakan pendekatan siklus hidup inovasi, dimana dapat menggambarkan
                perkembangan inovasi.
            </p>

            <p class="text-gray-700 mb-4">
                Kerangka konseptual IRL adalah model <strong>6"C" (Concept, Component,
                Completion, Chasin, Competition, Changeover/ Closedown)</strong>, yang memisahkan secara
                komprehensif siklus hidup inovasi ke dalam 6 fase (tingkat kesiapan), dan memberikan
                arah bagi manajemen dalam melaksanakan proses inovasi dengan memperhatikan 7 aspek
                kunci (teknologi, pasar, organisasi, manufaktur, investment, kemitraan dan risiko).
            </p>

            <p class="text-gray-700 mb-4">Pengukuran IRL sangat penting untuk:</p>
            <ul class="list-disc list-inside space-y-2 text-gray-700 mb-4">
                <li>Menggambarkan perkembangan inovasi</li>
                <li>Membantu mengimplementasikan inovasi diatas siklus-hidup yang lebih efektif</li>
                <li>Mengantisipasi persaingan pasar yang semakin sengit</li>
                <li>Mengantisipasi tingkat inovasi atau siklus hidup teknologi yang lebih cepat</li>
            </ul>

            {{-- Keterangan Aspek --}}
            <div class="bg-blue-50 rounded-lg p-6 mb-6">
                <h3 class="text-xl font-bold text-gray-800 mb-4">Keterangan Aspek (7 Aspek Kunci)</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="flex items-center gap-3 p-3 bg-white rounded-lg shadow-sm">
                        <div class="w-4 h-4 rounded" style="background: linear-gradient(135deg, #fad961 0%, #f76b1c 100%);"></div>
                        <span class="font-semibold text-gray-700">Teknologi (T)</span>
                    </div>
                    <div class="flex items-center gap-3 p-3 bg-white rounded-lg shadow-sm">
                        <div class="w-4 h-4 rounded" style="background: linear-gradient(135deg, #84fab0 0%, #8fd3f4 100%);"></div>
                        <span class="font-semibold text-gray-700">Organisasi (O)</span>
                    </div>
                    <div class="flex items-center gap-3 p-3 bg-white rounded-lg shadow-sm">
                        <div class="w-4 h-4 rounded" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);"></div>
                        <span class="font-semibold text-gray-700">Risiko (R)</span>
                    </div>
                    <div class="flex items-center gap-3 p-3 bg-white rounded-lg shadow-sm">
                        <div class="w-4 h-4 rounded" style="background: linear-gradient(135deg, #ff9a9e 0%, #fad0c4 100%);"></div>
                        <span class="font-semibold text-gray-700">Pasar (M)</span>
                    </div>
                    <div class="flex items-center gap-3 p-3 bg-white rounded-lg shadow-sm">
                        <div class="w-4 h-4 rounded" style="background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);"></div>
                        <span class="font-semibold text-gray-700">Kemitraan (P)</span>
                    </div>
                    <div class="flex items-center gap-3 p-3 bg-white rounded-lg shadow-sm">
                        <div class="w-4 h-4 rounded" style="background: linear-gradient(135deg, #fbc2eb 0%, #a6c1ee 100%);"></div>
                        <span class="font-semibold text-gray-700">Manufaktur (Mf)</span>
                    </div>
                    <div class="flex items-center gap-3 p-3 bg-white rounded-lg shadow-sm">
                        <div class="w-4 h-4 rounded" style="background: linear-gradient(135deg, #fdcbf1 0%, #e6dee9 100%);"></div>
                        <span class="font-semibold text-gray-700">Investasi (I)</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Form --}}
    <div class="bg-white rounded-lg shadow-lg p-8">
        <form id="katsinovForm">
            @csrf
            @if($katsinov)
                <input type="hidden" name="id" value="{{ $katsinov->id }}">
            @endif

            {{-- Informasi Dasar --}}
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-6 pb-2 border-b-2 border-blue-500">Informasi Dasar</h2>
                
                {{-- Hidden ID field for edit mode --}}
                @if($katsinov)
                    <input type="hidden" name="id" value="{{ $katsinov->id }}">
                @endif
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama/Judul <span class="text-red-500">*</span></label>
                        <input type="text" name="title" value="{{ $katsinov->title ?? '' }}" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Fokus Bidang <span class="text-red-500">*</span></label>
                        <input type="text" name="focus_area" value="{{ $katsinov->focus_area ?? '' }}" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Proyek <span class="text-red-500">*</span></label>
                        <input type="text" name="project_name" value="{{ $katsinov->project_name ?? '' }}" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lembaga/Perusahaan <span class="text-red-500">*</span></label>
                        <input type="text" name="institution" value="{{ $katsinov->institution ?? '' }}" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Alamat <span class="text-red-500">*</span></label>
                        <textarea name="address" rows="2" required
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ $katsinov->address ?? '' }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Kontak <span class="text-red-500">*</span></label>
                        <input type="text" name="contact" value="{{ $katsinov->contact ?? '' }}" required
                               placeholder="Telp / Fax / email"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Penilaian <span class="text-red-500">*</span></label>
                        <input type="date" name="assessment_date" value="{{ $katsinov->assessment_date ?? date('Y-m-d') }}" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                </div>
            </div>

            {{-- Kriteria Capaian --}}
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-6 pb-2 border-b-2 border-blue-500">Kriteria Capaian</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-blue-50 rounded-lg p-4">
                        <div class="flex justify-between items-center">
                            <span class="font-semibold text-gray-700">Batas Minimum Capaian</span>
                            <span class="bg-blue-600 text-white px-4 py-2 rounded-lg font-bold" id="minThreshold">{{ $min_percentage_js ?? 80.0 }}%</span>
                        </div>
                    </div>
                    <div class="bg-green-50 rounded-lg p-4">
                        <div class="flex justify-between items-center">
                            <span class="font-semibold text-gray-700">Batas Maksimum Capaian</span>
                            <span class="bg-green-600 text-white px-4 py-2 rounded-lg font-bold">100.0%</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Indicator Tabs with Progress --}}
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-6 pb-2 border-b-2 border-blue-500">Penilaian Indikator</h2>
                
                {{-- Progress Indicator --}}
                <div class="mb-6">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-medium text-gray-700">Progress Pengisian</span>
                        <span class="text-sm font-medium text-gray-700" id="progressText">Indikator <span id="currentIndicator">1</span> dari 6</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-3">
                        <div id="progressBar" class="bg-blue-600 h-3 rounded-full transition-all duration-300" style="width: 16.67%"></div>
                    </div>
                </div>

                {{-- Tabs --}}
                <div class="border-b border-gray-200 mb-6">
                    <nav class="flex flex-wrap gap-2">
                        @for($i = 1; $i <= 6; $i++)
                            <button type="button" 
                                    id="tab-{{ $i }}"
                                    onclick="showIndicator({{ $i }})" 
                                    class="indicator-tab flex items-center gap-2 px-4 py-3 border-b-2 font-medium text-sm transition-all {{ $i === 1 ? 'border-blue-500 text-blue-600 bg-blue-50' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 cursor-not-allowed opacity-50' }}"
                                    data-indicator="{{ $i }}"
                                    {{ $i > 1 ? 'disabled' : '' }}>
                                <span class="flex items-center justify-center w-6 h-6 rounded-full text-xs {{ $i === 1 ? 'bg-blue-600 text-white' : 'bg-gray-300 text-gray-600' }}" id="badge-{{ $i }}">{{ $i }}</span>
                                <span>Indikator {{ $i }}</span>
                                <span class="hidden" id="check-{{ $i }}">✓</span>
                            </button>
                        @endfor
                    </nav>
                </div>

                {{-- Warning Alert --}}
                <div id="scoreWarning" class="hidden bg-yellow-50 border-l-4 border-yellow-500 p-4 mb-6">
                    <div class="flex items-start">
                        <svg class="w-6 h-6 text-yellow-600 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        <div>
                            <p class="font-medium text-yellow-800">Perhatian!</p>
                            <p class="text-sm text-yellow-700 mt-1" id="warningMessage"></p>
                        </div>
                    </div>
                </div>

                {{-- Indicator Content --}}
                <div id="indicatorsContent">
                    @for($i = 1; $i <= 6; $i++)
                        <div id="indicator{{ $i }}" class="indicator-content {{ $i === 1 ? '' : 'hidden' }}">
                            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border-l-4 border-blue-500 p-6 mb-6 rounded-lg">
                                <h3 class="text-xl font-bold text-blue-900 mb-2">KATSINOV {{ $i }}</h3>
                                <p class="text-sm text-blue-700">Silakan isi penilaian untuk setiap pertanyaan di bawah ini. <strong>Total score indikator</strong> harus mencapai minimum <strong id="minThresholdText">80%</strong> untuk melanjutkan ke indikator berikutnya.</p>
                            </div>

                            {{-- Total Score Display --}}
                            <div class="bg-gradient-to-r from-green-50 to-blue-50 rounded-lg p-4 mb-4 border-2 border-green-200">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <div class="text-sm text-gray-600">Total Score Indikator {{ $i }}</div>
                                        <div class="text-xs text-gray-500 mt-1">Harus mencapai minimum <strong>{{ $minThreshold ?? 80 }}%</strong> untuk lanjut ke indikator berikutnya</div>
                                    </div>
                                    <div class="text-2xl font-bold" id="total-score-{{ $i }}">
                                        <span class="text-gray-400">-%</span>
                                    </div>
                                </div>
                            </div>

                            {{-- Aspek Scores Display (Detail per Aspek) --}}
                            <div class="mb-2">
                                <div class="text-xs text-gray-600 font-medium mb-2">Detail Score per Aspek (informasi):</div>
                            </div>
                            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-3 mb-6">
                                @foreach(['T' => 'Teknologi', 'O' => 'Organisasi', 'R' => 'Risiko', 'M' => 'Pasar', 'P' => 'Kemitraan', 'Mf' => 'Manufaktur', 'I' => 'Investasi'] as $code => $label)
                                    <div class="bg-white rounded-lg p-3 shadow-sm border border-gray-200">
                                        <div class="text-xs text-gray-600 mb-1">{{ $label }}</div>
                                        <div class="text-lg font-bold aspect-score" data-indicator="{{ $i }}" data-aspect="{{ $code }}" id="score-{{ $i }}-{{ $code }}">
                                            <span class="text-gray-400">-%</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            {{-- Form Pertanyaan dengan Radio Buttons --}}
                            @php
                                $questions = include(resource_path('views/admin/katsinov_v2/includes/indicator_questions.php'));
                                $indicatorQuestions = $questions[$i] ?? [];
                                
                                // Aspect color mapping
                                $aspectColors = [
                                    'T' => ['bg' => 'bg-orange-100', 'text' => 'text-orange-800'],
                                    'M' => ['bg' => 'bg-pink-100', 'text' => 'text-pink-800'],
                                    'O' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-800'],
                                    'Mf' => ['bg' => 'bg-indigo-100', 'text' => 'text-indigo-800'],
                                    'P' => ['bg' => 'bg-teal-100', 'text' => 'text-teal-800'],
                                    'I' => ['bg' => 'bg-purple-100', 'text' => 'text-purple-800'],
                                    'R' => ['bg' => 'bg-red-100', 'text' => 'text-red-800'],
                                ];
                            @endphp
                            
                            @if(count($indicatorQuestions) > 0)
                                {{-- Contoh untuk Indikator 1 (dapat direplikasi untuk indikator lainnya) --}}
                                <div class="overflow-x-auto">
                                    <table class="min-w-full bg-white border border-gray-300 rounded-lg">
                                        <thead class="bg-gray-100">
                                            <tr>
                                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border-b">No</th>
                                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border-b">Aspek</th>
                                                <th class="px-3 py-3 text-center text-xs font-medium text-gray-700 uppercase tracking-wider border-b">0</th>
                                                <th class="px-3 py-3 text-center text-xs font-medium text-gray-700 uppercase tracking-wider border-b">1</th>
                                                <th class="px-3 py-3 text-center text-xs font-medium text-gray-700 uppercase tracking-wider border-b">2</th>
                                                <th class="px-3 py-3 text-center text-xs font-medium text-gray-700 uppercase tracking-wider border-b">3</th>
                                                <th class="px-3 py-3 text-center text-xs font-medium text-gray-700 uppercase tracking-wider border-b">4</th>
                                                <th class="px-3 py-3 text-center text-xs font-medium text-gray-700 uppercase tracking-wider border-b">5</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border-b">Deskripsi</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-200">
                                            @foreach($indicatorQuestions as $q)
                                                @php
                                                    $aspectColor = $aspectColors[$q['aspect']] ?? ['bg' => 'bg-gray-100', 'text' => 'text-gray-800'];
                                                @endphp
                                                <tr class="hover:bg-blue-50 transition">
                                                    <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">{{ $q['no'] }}</td>
                                                    <td class="px-4 py-3 whitespace-nowrap">
                                                        <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $aspectColor['bg'] }} {{ $aspectColor['text'] }}">
                                                            {{ $q['aspect'] }}
                                                        </span>
                                                    </td>
                                                    @for($score = 0; $score <= 5; $score++)
                                                        <td class="px-3 py-3 text-center">
                                                            <input type="radio" 
                                                                   name="indikator{{ $i }}_row{{ $q['no'] }}" 
                                                                   value="{{ $score }}" 
                                                                   class="w-4 h-4 text-blue-600 radio-input cursor-pointer" 
                                                                   data-indicator="{{ $i }}" 
                                                                   data-aspect="{{ $q['aspect'] }}" 
                                                                   data-row="{{ $q['no'] }}">
                                                        </td>
                                                    @endfor
                                                    <td class="px-6 py-3 text-sm text-gray-700">{{ $q['desc'] }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                {{-- No questions found --}}
                                <div class="bg-yellow-50 rounded-lg p-8 text-center border-2 border-yellow-200">
                                    <svg class="w-16 h-16 text-yellow-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                    </svg>
                                    <p class="text-yellow-800 font-medium mb-2">Data pertanyaan untuk Indikator {{ $i }} belum tersedia</p>
                                    <p class="text-sm text-yellow-700 mb-4">Tambahkan data di file: includes/indicator_questions.php</p>
                                </div>
                            @endif

                            {{-- Note Area --}}
                            <div class="mt-6">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Catatan untuk Indikator {{ $i }}</label>
                                <textarea name="notes[{{ $i }}]" rows="3" 
                                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                          placeholder="Tambahkan catatan atau komentar untuk indikator ini..."></textarea>
                            </div>

                            {{-- Info Box tentang Button Indikator Berikutnya --}}
                            <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                                <div class="flex items-start gap-3">
                                    <svg class="w-6 h-6 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <div class="text-sm text-blue-800">
                                        <p class="font-semibold mb-1">ℹ️ Fungsi Button "Validasi & Lanjut":</p>
                                        <ul class="list-disc list-inside space-y-1 ml-2">
                                            <li>Menghitung <strong>TOTAL SCORE</strong> dari seluruh pertanyaan di indikator ini</li>
                                            <li>Rumus: (Total Score Terjawab / Total Maksimal) × 100%</li>
                                            <li>Memvalidasi: <strong>Apakah total score ≥ {{ $min_percentage_js ?? 80 }}%?</strong></li>
                                            <li>✅ Jika YA: Tab indikator berikutnya akan AKTIF (dapat melanjutkan)</li>
                                            <li>❌ Jika TIDAK: Tab indikator berikutnya tetap TERKUNCI (harus perbaiki nilai dulu)</li>
                                        </ul>
                                        <div class="mt-2 pt-2 border-t border-blue-200">
                                            <p class="text-xs"><strong>Note:</strong> Score per aspek (T, M, O, dll) adalah informasi saja. Yang menentukan bisa lanjut atau tidak adalah <strong>TOTAL SCORE INDIKATOR</strong>.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Navigation Buttons --}}
                            <div class="flex justify-between mt-6">
                                <button type="button" 
                                        onclick="previousIndicator()" 
                                        {{ $i === 1 ? 'disabled' : '' }}
                                        class="px-6 py-3 bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold rounded-lg transition duration-300 disabled:opacity-50 disabled:cursor-not-allowed">
                                    ← Indikator Sebelumnya
                                </button>
                                
                                <button type="button" 
                                        onclick="nextIndicator()" 
                                        id="nextBtn-{{ $i }}"
                                        class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition duration-300 flex items-center gap-2">
                                    <span>{{ $i === 6 ? 'Selesai Semua Indikator' : 'Validasi & Lanjut ke Indikator Berikutnya' }}</span>
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    @endfor
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                <a href="{{ route('admin_inovasi.katsinov-v2.index') }}" 
                   class="px-6 py-3 bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold rounded-lg transition duration-300">
                    Kembali
                </a>
                
                <div class="flex gap-3">
                    <button type="button" onclick="saveAsDraft()" 
                            class="px-6 py-3 bg-yellow-500 hover:bg-yellow-600 text-white font-semibold rounded-lg transition duration-300 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                        </svg>
                        Simpan Draft
                    </button>
                    
                    <button type="button" onclick="submitForm()" 
                            class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition duration-300 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Submit untuk Review
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
let currentIndicatorNum = 1;
const minThreshold = {{ $min_percentage_js ?? 80.0 }};
let indicatorScores = {};

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    updateMinThresholdText();
});

function updateMinThresholdText() {
    document.querySelectorAll('#minThresholdText').forEach(el => {
        el.textContent = minThreshold + '%';
    });
}

function showIndicator(num) {
    // Hide all
    document.querySelectorAll('.indicator-content').forEach(el => {
        el.classList.add('hidden');
    });
    
    // Show selected
    document.getElementById('indicator' + num).classList.remove('hidden');
    
    // Update tabs
    document.querySelectorAll('.indicator-tab').forEach(tab => {
        const tabNum = parseInt(tab.getAttribute('data-indicator'));
        if (tabNum === num) {
            tab.classList.remove('border-transparent', 'text-gray-500');
            tab.classList.add('border-blue-500', 'text-blue-600', 'bg-blue-50');
        } else {
            tab.classList.remove('border-blue-500', 'text-blue-600', 'bg-blue-50');
            tab.classList.add('border-transparent', 'text-gray-500');
        }
    });
    
    currentIndicatorNum = num;
    updateProgress();
}

function updateProgress() {
    const progress = (currentIndicatorNum / 6) * 100;
    document.getElementById('progressBar').style.width = progress + '%';
    document.getElementById('currentIndicator').textContent = currentIndicatorNum;
}

// Event listener untuk radio buttons
document.addEventListener('change', function(e) {
    if (e.target.classList.contains('radio-input')) {
        const indicator = e.target.getAttribute('data-indicator');
        if (indicator) {
            calculateIndicatorScore(parseInt(indicator));
        }
    }
});

function calculateIndicatorScore(indicatorNum) {
    const aspects = ['T', 'O', 'R', 'M', 'P', 'Mf', 'I'];
    const scores = {};
    
    // Get total questions for this indicator (berdasarkan jumlah row yang ada)
    const totalRowsPerIndicator = {
        1: 22,
        2: 21,
        3: 21,
        4: 22,
        5: 24,
        6: 14
    };
    
    const totalRows = totalRowsPerIndicator[indicatorNum] || 22;
    
    // Calculate total score for entire indicator
    let totalScoreSum = 0;
    let totalQuestionsAnswered = 0;
    
    aspects.forEach(aspect => {
        // Hitung score dari radio buttons yang checked
        const radios = document.querySelectorAll(`.radio-input[data-indicator="${indicatorNum}"][data-aspect="${aspect}"]:checked`);
        let aspectScore = 0;
        let aspectCount = 0;
        
        radios.forEach(radio => {
            const value = parseInt(radio.value);
            aspectScore += value;
            aspectCount++;
            totalScoreSum += value;
            totalQuestionsAnswered++;
        });
        
        // Calculate percentage per aspect (for display only)
        const maxPossible = aspectCount * 5;
        const percentage = maxPossible > 0 ? (aspectScore / maxPossible) * 100 : 0;
        scores[aspect] = {
            score: aspectScore,
            count: aspectCount,
            percentage: percentage
        };
        
        // Update display per aspek (tanpa warna, hanya informasi)
        const scoreEl = document.getElementById(`score-${indicatorNum}-${aspect}`);
        if (scoreEl) {
            scoreEl.innerHTML = `<span class="text-gray-700">${percentage.toFixed(1)}%</span>`;
        }
    });
    
    // Calculate total indicator percentage
    // Rumus: (Total Score Terjawab / (Total Rows × 5)) × 100%
    const maxPossibleTotal = totalRows * 5;
    const totalPercentage = maxPossibleTotal > 0 ? (totalScoreSum / maxPossibleTotal) * 100 : 0;
    const indicatorPass = totalPercentage >= minThreshold;
    
    // Update total indicator score display (dengan warna berdasarkan threshold)
    const totalScoreEl = document.getElementById(`total-score-${indicatorNum}`);
    if (totalScoreEl) {
        const colorClass = indicatorPass ? 'text-green-600 font-bold' : 'text-red-600 font-bold';
        totalScoreEl.innerHTML = `<span class="${colorClass}">Total: ${totalPercentage.toFixed(1)}% ${indicatorPass ? '✓' : '✗'}</span>`;
    }
    
    indicatorScores[indicatorNum] = { 
        scores, 
        totalPercentage,
        totalScore: totalScoreSum,
        totalQuestions: totalQuestionsAnswered,
        indicatorPass
    };
    
    return indicatorPass;
}

function nextIndicator() {
    // Calculate scores for current indicator
    const indicatorPass = calculateIndicatorScore(currentIndicatorNum);
    const indicatorData = indicatorScores[currentIndicatorNum];
    
    if (!indicatorPass && currentIndicatorNum < 6) {
        // Show warning dengan detail score
        const warningDiv = document.getElementById('scoreWarning');
        const warningMsg = document.getElementById('warningMessage');
        const totalPercentage = indicatorData.totalPercentage.toFixed(1);
        warningMsg.innerHTML = `
            <strong>Total score Indikator ${currentIndicatorNum}: ${totalPercentage}%</strong><br>
            Belum mencapai batas minimum ${minThreshold}%.<br>
            Perbaiki nilai untuk melanjutkan ke indikator berikutnya.
        `;
        warningDiv.classList.remove('hidden');
        
        // Disable next indicators
        for(let i = currentIndicatorNum + 1; i <= 6; i++) {
            const tab = document.getElementById(`tab-${i}`);
            tab.disabled = true;
            tab.classList.add('cursor-not-allowed', 'opacity-50');
        }
        
        return;
    } else {
        document.getElementById('scoreWarning').classList.add('hidden');
    }
    
    if (currentIndicatorNum < 6) {
        // Enable next indicator
        const nextNum = currentIndicatorNum + 1;
        const nextTab = document.getElementById(`tab-${nextNum}`);
        nextTab.disabled = false;
        nextTab.classList.remove('cursor-not-allowed', 'opacity-50');
        
        // Mark current as checked
        const badge = document.getElementById(`badge-${currentIndicatorNum}`);
        badge.classList.remove('bg-blue-600');
        badge.classList.add('bg-green-600');
        document.getElementById(`check-${currentIndicatorNum}`).classList.remove('hidden');
        
        showIndicator(nextNum);
    } else {
        // All indicators complete
        alert('Semua indikator selesai! Silakan klik Submit untuk Review.');
    }
}

function previousIndicator() {
    if (currentIndicatorNum > 1) {
        showIndicator(currentIndicatorNum - 1);
    }
}

function saveAsDraft() {
    if (confirm('Simpan sebagai draft? Data Anda akan tersimpan dan dapat dilanjutkan nanti.')) {
        const formData = new FormData(document.getElementById('katsinovForm'));
        formData.append('save_as_draft', '1');
        sendData(formData, 'Draft berhasil disimpan');
    }
}

function submitForm() {
    // Check if at least indicator 1 is complete
    if (!indicatorScores[1]) {
        alert('Mohon lengkapi minimal Indikator 1 sebelum submit.');
        return;
    }
    
    // Find highest completed indicator
    let highestCompleted = 1;
    for (let i = 1; i <= 6; i++) {
        if (indicatorScores[i] && indicatorScores[i].allPass) {
            highestCompleted = i;
        } else {
            break;
        }
    }
    
    const msg = `Anda akan submit hingga Indikator ${highestCompleted}. ${highestCompleted < 6 ? 'Indikator selanjutnya dapat dilengkapi setelah memperbaiki nilai yang kurang.' : 'Semua indikator telah lengkap.'}\n\nLanjutkan submit?`;
    
    if (confirm(msg)) {
        const formData = new FormData(document.getElementById('katsinovForm'));
        formData.append('highest_indicator', highestCompleted);
        sendData(formData, 'Data berhasil disubmit untuk review');
    }
}

function sendData(formData, successMessage) {
    // Collect all radio button responses
    const responses = [];
    document.querySelectorAll('.radio-input:checked').forEach(radio => {
        const indicator = radio.getAttribute('data-indicator');
        const aspect = radio.getAttribute('data-aspect');
        const row = radio.getAttribute('data-row');
        const score = radio.value;
        
        responses.push({
            indicator: parseInt(indicator),
            row: parseInt(row),
            aspect: aspect,
            score: parseInt(score),
            dropdown: null
        });
    });
    
    // Collect notes
    const notes = {};
    for (let i = 1; i <= 6; i++) {
        const noteField = document.querySelector(`textarea[name="notes[${i}]"]`);
        if (noteField && noteField.value.trim()) {
            notes[i] = noteField.value.trim();
        }
    }
    
    // Build JSON data
    const jsonData = {
        title: formData.get('title'),
        focus_area: formData.get('focus_area'),
        project_name: formData.get('project_name'),
        institution: formData.get('institution'),
        address: formData.get('address'),
        contact: formData.get('contact'),
        assessment_date: formData.get('assessment_date'),
        responses: responses,
        notes: notes,
        save_as_draft: formData.get('save_as_draft') === '1'
    };
    
    // Add ID if editing existing
    const idField = formData.get('id');
    if (idField) {
        jsonData.id = parseInt(idField);
    }
    
    fetch('{{ route("admin_inovasi.katsinov-v2.store") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(jsonData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.id) {
            alert(successMessage);
            window.location.href = '{{ route("admin_inovasi.katsinov-v2.index") }}';
        } else {
            alert('Error: ' + (data.message || 'Terjadi kesalahan'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat menyimpan data');
    });
}

// Load existing data if editing
@if($katsinov && ($indicatorOne->isNotEmpty() || $indicatorTwo->isNotEmpty() || $indicatorThree->isNotEmpty() || $indicatorFour->isNotEmpty() || $indicatorFive->isNotEmpty() || $indicatorSix->isNotEmpty()))
document.addEventListener('DOMContentLoaded', function() {
    // Load existing responses
    const existingResponses = [
        @foreach([$indicatorOne, $indicatorTwo, $indicatorThree, $indicatorFour, $indicatorFive, $indicatorSix] as $index => $indicator)
            @foreach($indicator as $response)
                {
                    indicator: {{ $index + 1 }},
                    row: {{ $response->row_number }},
                    aspect: '{{ $response->aspect }}',
                    score: {{ $response->score }}
                },
            @endforeach
        @endforeach
    ];
    
    // Check radio buttons based on existing data
    existingResponses.forEach(response => {
        const radio = document.querySelector(
            `.radio-input[data-indicator="${response.indicator}"]` +
            `[data-row="${response.row}"]` +
            `[value="${response.score}"]`
        );
        if (radio) {
            radio.checked = true;
        }
    });
    
    // Calculate scores for all indicators with data
    for (let i = 1; i <= 6; i++) {
        const hasData = existingResponses.some(r => r.indicator === i);
        if (hasData) {
            calculateIndicatorScore(i);
        }
    }
    
    console.log('Loaded existing data:', existingResponses.length, 'responses');
});
@endif
</script>
@endsection
