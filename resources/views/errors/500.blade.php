@extends('errors::layout')

@section('title', 'Kesalahan Server')
@section('code', '500')
@section('eyebrow', 'Kesalahan Server')
@section('heading', 'Terjadi kesalahan pada server')
@section('message', 'Kami tidak dapat memproses permintaan Anda saat ini. Silakan coba beberapa saat lagi. Jika masalah berlanjut, sampaikan laporan melalui halaman kontak resmi UNMARIS.')
@section('hint', 'Sertakan alamat halaman yang Anda buka serta waktu kejadian saat menghubungi kami, agar laporan dapat ditelusuri lebih cepat.')

@section('actions')
    <a class="btn btn-primary" href="{{ url('/') }}">
        <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Kembali ke Beranda
    </a>
    <a class="btn btn-outline" href="{{ url('/kontak') }}">Laporkan Masalah</a>
@endsection
