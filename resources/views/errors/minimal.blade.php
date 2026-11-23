@extends('errors::layout')

@php
    $statusCode = isset($exception) && method_exists($exception, 'getStatusCode')
        ? (string) $exception->getStatusCode()
        : '500';
@endphp

@section('title', 'Terjadi Kesalahan')
@section('code', $statusCode)
@section('eyebrow', 'Permintaan Tidak Dapat Diproses')
@section('heading', 'Permintaan Anda tidak dapat diproses')
@section('message', 'Server tidak dapat menyelesaikan permintaan Anda saat ini. Silakan kembali ke beranda atau coba beberapa saat lagi.')
@section('hint', 'Jika masalah terus terjadi, hubungi administrator situs melalui halaman kontak resmi UNMARIS.')

@section('actions')
    <a class="btn btn-primary" href="{{ url('/') }}">
        <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Kembali ke Beranda
    </a>
    <a class="btn btn-outline" href="{{ url('/kontak') }}">Hubungi Kami</a>
@endsection
