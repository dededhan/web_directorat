@extends('layouts.pemeringkatan')

@section('title', 'Program Sustainability')

@push('styles')
    @vite('resources/css/pemeringkatan/program-sustainability.css')
@endpush

@section('content')
    <div class="page-title">
        Program Sustainability UNJ
    </div>

    <div class="info-section">
        <div class="info-sidebar">
            <ul>
                <li>
                    <a href="#tagihan-listrik" class="active">
                        Tagihan Listrik
                    </a>
                </li>
                <li>
                    <a href="#bbm">
                        BBM
                    </a>
                </li>
                <li>
                    <a href="#sarpas-ramah-lingkungan">
                        Sarpas Ramah Lingkungan
                    </a>
                </li>
            </ul>
        </div>

        <!-- Content Area -->
        <div class="info-content" id="tagihan-listrik">
            <h2>Tagihan Listrik</h2>
            <p>Program pengelolaan tagihan listrik di Universitas Negeri Jakarta merupakan bagian integral dari upaya sustainability kampus. Program ini bertujuan untuk mengoptimalkan penggunaan energi listrik dan mengurangi dampak lingkungan.</p>
            
            <h3 style="color: #277177; margin: 20px 0 15px 0;">Strategi Penghematan Energi</h3>
            <ul>
                <li>Implementasi sistem monitoring konsumsi listrik real-time</li>
                <li>Penggunaan lampu LED di seluruh area kampus</li>
                <li>Sistem otomatisasi pencahayaan berbasis sensor</li>
                <li>Program edukasi hemat energi untuk civitas akademika</li>
            </ul>

            <h3 style="color: #277177; margin: 20px 0 15px 0;">Target dan Pencapaian</h3>
            <p>UNJ menargetkan pengurangan konsumsi listrik sebesar 20% dalam 5 tahun ke depan melalui berbagai inovasi teknologi hijau dan perubahan perilaku penggunaan energi di lingkungan kampus.</p>
        </div>
    </div>
@endsection

@push('scripts')
    @vite('resources/js/pemeringkatan/program-sustainability.js')
@endpush