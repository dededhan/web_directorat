@extends('layouts.pemeringkatan')

@section('title', 'Kegiatan Sustainability')

@push('styles')
    @vite('resources/css/pemeringkatan/kegiatan-sustainability.css')
@endpush

@section('content')
    <div class="main-content-wrapper">
        <div class="header">
            <h1>Kegiatan Sustainability</h1>
            <p>Sustainable Development Goals Monitoring</p>
        </div>

        <div class="dropdown-container">
            <div class="dropdown-wrapper">
                <label for="year-select">📅 Tahun</label>
                <select id="year-select" onchange="updateCharts()" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-indigo-400 text-base font-medium bg-white shadow-sm transition">
                    {{-- Options will be populated by JavaScript --}}
                    <option value="">Memuat tahun...</option>
                </select>
            </div>
        </div>

        <div class="chart-section">
            <h2 class="chart-title" id="year-chart-title">Progress Kegiatan Sustainability</h2>
            <div class="chart-container">
                <div class="chart" id="year-chart"></div>
                <div class="chart-labels" id="year-labels"></div>
            </div>
        </div>

        <div class="faculty-section">
            <div class="dropdown-container">
                <div class="dropdown-wrapper">
                    <label for="faculty-select">🏛️ Fakultas</label>
                    <select id="faculty-select" onchange="updateFacultyChart()"  class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-indigo-400 text-base font-medium bg-white shadow-sm transition">
                        <option value="FIP">Fakultas Ilmu Pendidikan (FIP)</option>
                        <option value="FBS">Fakultas Bahasa dan Seni (FBS)</option>
                        <option value="FMIPA">Fakultas Matematika dan IPA (FMIPA)</option>
                        <option value="FT">Fakultas Teknik</option>
                        <option value="FIS">Fakultas Ilmu Sosial</option>
                        <option value="FE">Fakultas Ekonomi</option>
                        <option value="FPP">Fakultas Pendidikan Psikologi</option>
                        <option value="FIK">Fakultas Ilmu Keolahragaan</option>
                    </select>
                </div>
            </div>

            <div class="chart-section">
                <h2 class="chart-title" id="faculty-chart-title">Progress SDGs Fakultas</h2>
                <div class="chart-container">
                    <div class="chart" id="faculty-chart"></div>
                    <div class="chart-labels" id="faculty-labels"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @vite('resources/js/pemeringkatan/kegiatan-sustainability.js')
@endpush