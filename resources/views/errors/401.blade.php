@extends('errors::layout')

@section('title', 'Tidak Terautentikasi')
@section('code', '401')
@section('eyebrow', 'Autentikasi Diperlukan')
@section('heading', 'Anda perlu masuk terlebih dahulu')
@section('message', 'Halaman ini hanya dapat diakses setelah Anda masuk dengan akun yang sah. Silakan masuk kembali, lalu buka halaman yang Anda tuju.')
@section('hint', 'Jika Anda merasa sudah masuk tetapi tetap melihat pesan ini, sesi Anda mungkin telah berakhir. Muat ulang halaman, lalu coba lagi.')

@section('actions')
    <a class="btn btn-primary" href="{{ url('/') }}">
        <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Kembali ke Beranda
    </a>
    <a class="btn btn-outline" href="{{ url('/kontak') }}">Hubungi Kami</a>
@endsection
