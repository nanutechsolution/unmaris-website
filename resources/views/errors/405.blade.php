@extends('errors::layout')

@section('title', 'Metode Tidak Diizinkan')
@section('code', '405')
@section('eyebrow', 'Permintaan Tidak Didukung')
@section('heading', 'Permintaan ini tidak didukung')
@section('message', 'Halaman yang Anda tuju tidak menerima jenis permintaan yang dikirim. Kembali ke beranda, lalu akses halaman melalui navigasi yang tersedia.')
@section('hint', 'Pesan ini biasanya muncul ketika tautan atau formulir dibuka dengan cara yang tidak semestinya.')

@section('actions')
    <a class="btn btn-primary" href="{{ url('/') }}">
        <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Kembali ke Beranda
    </a>
    <a class="btn btn-outline" href="{{ url('/kontak') }}">Hubungi Kami</a>
@endsection
