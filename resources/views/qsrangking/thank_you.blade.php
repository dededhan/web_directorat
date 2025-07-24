@extends('qsrangking.qs_layout')

@section('form')
    <div class="form-section text-center" style="padding: 40px;">
        <h2 class="section-title" style="font-size: 2rem; color: #4CAF50;">Terima Kasih!</h2>
        <p style="font-size: 1.2rem; margin-top: 1rem;">Survei Anda telah berhasil dikirimkan.</p>
        <p>Partisipasi Anda sangat kami hargai.</p>
        <a href="{{ route('home') }}" class="btn-submit" style="text-decoration: none; display: inline-block; margin-top: 20px;">Kembali ke Halaman Utama</a>
    </div>
@stop
