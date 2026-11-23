@extends('errors::layout')

@section('title', 'Layanan Tidak Tersedia')
@section('code', '503')
@section('eyebrow', 'Pemeliharaan Layanan')
@section('heading', 'Layanan sedang tidak tersedia')
@section('message', 'Situs Universitas Stella Maris Sumba sedang dalam pemeliharaan atau menerima permintaan yang sangat tinggi. Kami berupaya memulihkan layanan secepat mungkin.')
@section('hint', 'Silakan kembali beberapa saat lagi. Terima kasih atas kesabaran Anda.')

@section('actions')
    <button type="button" class="btn btn-primary" onclick="location.reload()">
        <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
        </svg>
        Muat Ulang Halaman
    </button>
    <a class="btn btn-outline" href="{{ url('/kontak') }}">Hubungi Kami</a>
@endsection
