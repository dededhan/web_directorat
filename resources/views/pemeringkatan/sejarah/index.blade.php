@extends('layouts.pemeringkatan')

@section('title', 'Sejarah - Direktorat Pemeringkatan')

@push('styles')
    @vite('resources/css/pemeringkatan/sejarah.css')
@endpush

@section('content')

<div class="main-content">
    <div class="sidebar">
        <div class="sidebar-item active" data-section="sejarah">Sejarah</div>
        <div class="sidebar-item" data-section="visi-misi">Visi Misi</div>
        <div class="sidebar-item" data-section="tujuan">Tujuan</div>
        <div class="sidebar-item" data-section="rencana">Rencana Strategis</div>
    </div>
    
    <div class="content">
        <div id="sejarah" class="content-section active">
            <h1 class="main-title">Sejarah</h1>
            <div class="content-text">
                @if(isset($contents['sejarah']))
                    {!! $contents['sejarah']->content !!}
                @else
                    <p>Konten sejarah belum tersedia.</p>
                @endif
            </div>
        </div>
        
        <div id="visi-misi" class="content-section">
            <h1 class="main-title">Visi Misi</h1>
            <div class="content-text">
                @if(isset($contents['visi-misi']))
                    {!! $contents['visi-misi']->content !!}
                @else
                    <p>Konten visi misi belum tersedia.</p>
                @endif
            </div>
        </div>
        
        
        <div id="tujuan" class="content-section">
            <h1 class="main-title">Tujuan</h1>
            <div class="content-text">
                @if(isset($contents['tujuan']))
                    {!! $contents['tujuan']->content !!}
                @else
                    <p>Konten tujuan belum tersedia.</p>
                @endif
            </div>
        </div>
        
        
        <div id="rencana" class="content-section">
            <h1 class="main-title">Rencana Strategis</h1>
            <div class="content-text">
                @if(isset($contents['rencana']))
                    {!! $contents['rencana']->content !!}
                @else
                    <p>Konten rencana strategis belum tersedia.</p>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Adding margin before footer -->
<div style="margin-top: 50px"></div>
@endsection

@push('scripts')
    @vite('resources/js/pemeringkatan/sejarah.js')
@endpush