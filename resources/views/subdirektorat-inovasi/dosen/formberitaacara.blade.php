<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Berita Acara Pengukuran</title>
    {{-- <link rel="stylesheet" href="/inovasi/formberitaacara.css"> --}}
    <link rel="stylesheet" href="{{ asset('inovasi/dashboard/form_katsinov/css/berita_acara.css') }}">
    <link rel="stylesheet" href="{{ asset('inovasi/dashboard/form_katsinov/css/formberitaacara.css') }}">
</head>

@extends('subdirektorat-inovasi.dosen.index')


@section('contentdosen')


<header class="header">
    <h1>Berita Acara Pengukuran Tingkat Kesiapan Teknologi</h1>
</header>
<form action="{{ route('admin.Katsinov.berita.store', $id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    <section class="form-section">
        <p>
            Pada hari ini, <input type="text" class="input-inline" name="text_day" value="{{ !is_null($berita)? $berita->day: '' }}">,
            tanggal <input type="text" class="input-inline" name="text_date" value="{{ !is_null($berita)? $berita->date: '' }}">
            bulan <input type="text" class="input-inline" name="text_month" value="{{ !is_null($berita)? $berita->month: '' }}">
            tahun <input type="text" class="input-inline" name="text_year" value="{{ !is_null($berita)? $berita->year: '' }}">
            (<input type="text" class="input-inline" name="text_yearfull" value="{{ !is_null($berita)? $berita->yearfull: '' }}">),
        </p>
        <p>
            bertempat di <input type="text" class="input-inline" name="text_place" value="{{ !is_null($berita)? $berita->place: '' }}">,
            dari hasil pengukuran Tingkat Kesiapan Inovasi (KATSINOV) yang dilakukan oleh Tim yang dibentuk
            berdasarkan Surat Keputusan <input type="text" class="input-inline" name="text_decree" value="{{ !is_null($berita)? $berita->decree: '' }}"> menyatakan:
        </p>
    </section>
    
    <!-- Innovation Details Section -->
    <section class="form-section">
        <div class="form-row">
            <label class="label">Judul Inovasi</label>
            <input type="text" class="input-field" name="innovation_title" value="{{ !is_null($berita)? $berita->title: '' }}">
        </div>
    
        <div class="form-row">
            <label class="label">Jenis Inovasi</label>
            <input type="text" class="input-field" name="innovation_type" value="{{ !is_null($berita)? $berita->type: '' }}">
        </div>
    
        <div class="form-row">
            <label class="label">Nilai TKI</label>
            <input type="text" class="input-field" name="innovation_tki" value="{{ !is_null($berita)? $berita->tki: '' }}">
        </div>
    
        <div class="form-row">
            <label class="label">Opini Penilai</label>
            <textarea class="input-field" name="innovation_opinion">
                {{ !is_null($berita)? $berita->opinion: '' }}
            </textarea>
        </div>
    </section>
    
    <!-- Closing Statement -->
    <section class="form-section">
        <p>
            Demikian Berita Acara Pengukuran Tingkat Kesiapan Inovasi (KATSINOV) ini dibuat dengan
            sebenar-benarnya,
            kemudian ditutup dan ditandatangani di
            pada <input type="date" class="input-inline date-picker" style="min-width: 180px;" name="innovation_date" value="{{ !is_null($berita)? $berita->sign_date: '' }}">
            pada hari dan tanggal, bulan, tahun tersebut di atas.
        </p>
    </section>
    
    <!-- Signature Section -->
    <section class="signature-section">
        <div class="signature-box" data-signature-id="penanggung-jawab">
            <h3 class="signature-box-title">Penanggungjawab Inovasi</h3>
            
            
    
            <div class="pdf-upload-container">
                <input type="file" class="pdf-upload-input" name="penanggungjawab_pdf" id="penanggungjawab_pdf" accept=".pdf">
                @if(isset($berita) && $berita->penanggungjawab_pdf)
                    <div class="pdf-preview">
                        <div class="mt-2">
                            <span>File terupload:</span>
                            <a href="{{ route('admin.Katsinov.signature.view', ['id' => $berita->id, 'type' => 'penanggungjawab']) }}" 
                               target="_blank" 
                               class="document-preview">
                               Lihat Dokumen
                            </a>
                        </div>
                    </div>
                @endif
            </div>

            <input type="text" class="input-field" name="penanggungjawab" value="{{ !is_null($berita)? $berita->penanggungjawab: '' }}">
            
        </div>
    
        <div class="signature-box" data-signature-id="tim-penilai">
            <h3 class="signature-box-title">Tim Penilai</h3>
    
            <div data-signature-role="ketua">
                <p class="signature-subtitle">Ketua Tim Penilai</p>
              {{-- here i want add pdf and preview --}}

              <div class="pdf-upload-container">
                    <input type="file" class="pdf-upload-input" name="ketua_pdf" id="ketua_pdf" accept=".pdf">
                    @if(isset($berita) && $berita->ketua_pdf)
                        <div class="pdf-preview">
                            <span>File terupload:</span>
                            <a href="{{ route('admin.Katsinov.signature.view', ['id' => $berita->id, 'type' => 'ketua']) }}" 
                            target="_blank" 
                            class="document-preview">
                            Lihat Dokumen
                            </a>
                        </div>
                    @endif
              </div>

                <input type="text" class="input-field" name="ketua" value="{{ !is_null($berita)? $berita->ketua: '' }}">
                
            </div>
    
            <div data-signature-role="anggota-1">
                <p class="signature-subtitle">Anggota 1</p>
              {{-- here i want add pdf and preview --}}

              <div class="pdf-upload-container">
                <input type="file" class="pdf-upload-input" name="anggota1_pdf" id="anggota1_pdf" accept=".pdf">
                @if(isset($berita) && $berita->anggota1_pdf)
                    <div class="pdf-preview">
                        <span>File terupload:</span>
                            <a href="{{ route('admin.Katsinov.signature.view', ['id' => $berita->id, 'type' => 'anggota1']) }}" 
                            target="_blank" 
                            class="document-preview">
                            Lihat Dokumen
                            </a>
                    </div>
                @endif
            </div>

                <input type="text" class="input-field" name="anggota1" value="{{ !is_null($berita)? $berita->anggota1: '' }}">
                
            </div>
    
            <div data-signature-role="anggota-2">
                <p class="signature-subtitle">Anggota 2</p>
               {{-- here i want add pdf and preview --}}
               <div class="pdf-upload-container">
                <input type="file" class="pdf-upload-input" name="anggota2_pdf" id="anggota2_pdf" accept=".pdf">
                @if(isset($berita) && $berita->anggota2_pdf)
                    <div class="pdf-preview">
                        <span>File terupload:</span>
                            <a href="{{ route('admin.Katsinov.signature.view', ['id' => $berita->id, 'type' => 'anggota1']) }}" 
                            target="_blank" 
                            class="document-preview">
                            Lihat Dokumen
                            </a>
                    </div>
                @endif
            </div>
                <input type="text" class="input-field"  name="anggota2" value="{{ !is_null($berita)? $berita->anggota2: '' }}">
                
            </div>
        </div>
    </section>
   
    <!-- Submit Button Section -->
    <section class="form-section" style="text-align: center;">
        <button id="submitBtn" class="submit-btn" type="submit">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none"
                viewBox="0 0 24 24" stroke="currentColor" style="margin-right: 8px;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            {{ $berita ? 'Update Form' : 'Submit Form' }}
        </button>
    </section>
    
</form>
@endsection


{{-- <script src="{{ asset('inovasi/dashboard/form_katsinov/js/berita_acara.js') }}"></script> --}}



</html>
