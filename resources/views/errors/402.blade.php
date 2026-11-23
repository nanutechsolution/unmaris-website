@extends('errors::layout')

@section('title', 'Pembayaran Diperlukan')
@section('code', '402')
@section('eyebrow', 'Akses Terbatas')
@section('heading', 'Akses ini memerlukan pembayaran')
@section('message', 'Sumber daya yang Anda tuju hanya tersedia setelah kewajiban pembayaran diselesaikan. Silakan hubungi bagian administrasi untuk informasi lebih lanjut.')
@section('hint', 'Sertakan nomor pendaftaran atau nomor tagihan Anda saat menghubungi petugas agar proses pengecekan lebih cepat.')

@section('actions')
    <a class="btn btn-primary" href="{{ url('/') }}">
        <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Kembali ke Beranda
    </a>
    <a class="btn btn-outline" href="{{ url('/kontak') }}">Hubungi Kami</a>
@endsection
