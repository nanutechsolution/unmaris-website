@extends('errors::layout')

@section('title', 'Halaman Tidak Ditemukan')
@section('code', '404')
@section('eyebrow', 'Halaman Tidak Ditemukan')
@section('heading', 'Halaman yang Anda cari tidak tersedia')
@section('message', 'Alamat yang Anda buka mungkin telah dipindahkan, diganti namanya, atau tidak pernah ada. Periksa kembali tautan yang Anda gunakan, atau kembali ke beranda untuk menemukan informasi yang Anda butuhkan.')
@section('hint', 'Beberapa halaman hanya tersedia melalui menu navigasi. Gunakan menu utama di beranda untuk menjelajahi profil, akademik, kemahasiswaan, dan berita kampus.')

@section('actions')
    <a class="btn btn-primary" href="{{ url('/') }}">
        <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Kembali ke Beranda
    </a>
    <a class="btn btn-outline" href="{{ url('/kontak') }}">Hubungi Kami</a>
@endsection
