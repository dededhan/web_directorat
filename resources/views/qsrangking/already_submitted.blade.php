@extends('qsrangking.qs_layout')

@section('form')
    <div class="text-center" style="padding: 40px;">
        <div class="mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-unj-accent mx-auto" viewBox="0 0 20 20"
                fill="currentColor">
                <path fill-rule="evenodd"
                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                    clip-rule="evenodd" />
            </svg>
        </div>
                <p style="font-size: 1.1rem; margin-top: 1rem;">Anda telah Mengisi Survey Ini</p>
        <p style="font-size: 1.1rem; margin-top: 1rem;">Terima kasih atas partisipasi Anda. Anda sudah pernah mengisi survei
            ini.</p>
        <p class="text-slate-600">Jawaban Anda telah kami catat.</p>
        <a href="{{ route('home') }}" class="btn-submit"
            style="text-decoration: none; display: inline-block; margin-top: 25px; max-width: 250px;">Kembali ke Halaman
            Utama</a>
    </div>
@stop
