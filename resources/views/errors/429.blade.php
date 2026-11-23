@extends('errors::layout')

@section('title', 'Terlalu Banyak Permintaan')
@section('code', '429')
@section('eyebrow', 'Batas Permintaan')
@section('heading', 'Terlalu banyak permintaan')
@section('message', 'Anda mengirim terlalu banyak permintaan dalam waktu singkat. Sistem membatasi jumlah permintaan untuk menjaga layanan tetap stabil dan aman.')
@section('hint', 'Tunggu beberapa saat sebelum mencoba lagi. Hindari memuat ulang halaman secara berulang dalam waktu bersamaan.')

@section('actions')
    <a class="btn btn-primary" href="{{ url('/') }}">
        <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Kembali ke Beranda
    </a>
    <a class="btn btn-outline" href="{{ url('/kontak') }}">Hubungi Kami</a>
@endsection
