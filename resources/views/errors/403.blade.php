@extends('errors::layout')

@section('title', 'Akses Ditolak')
@section('code', '403')
@section('eyebrow', 'Akses Dibatasi')
@section('heading', 'Anda tidak memiliki izin')
@section('message', 'Halaman atau sumber daya ini hanya dapat diakses oleh pengguna dengan peran tertentu. Jika Anda yakin seharusnya memiliki akses, silakan hubungi administrator situs.')
@section('hint', 'Pastikan Anda masuk menggunakan akun yang sesuai. Beberapa halaman memang dikhususkan untuk administrator, dosen, atau staf tertentu.')

@section('actions')
    <a class="btn btn-primary" href="{{ url('/') }}">
        <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Kembali ke Beranda
    </a>
    <a class="btn btn-outline" href="{{ url('/kontak') }}">Hubungi Kami</a>
@endsection
