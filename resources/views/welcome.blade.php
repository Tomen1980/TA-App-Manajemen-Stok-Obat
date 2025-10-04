@extends('layouts.app')

@section('title', 'Klinik Azzahra')

@section('content')
<div class="h-screen bg-gradient-to-r from-teal-500 to-green-600 flex items-center justify-center">
    <div class="text-center text-white px-4">
        <h1 class="text-5xl font-bold mb-4">Selamat Datang di Klinik Azzahra</h1>
        <p class="text-lg mb-8">Pelayanan kesehatan terbaik untuk keluarga Anda</p>
        <a href="{{ route('login') }}"
           class="bg-white text-green-600 font-semibold px-6 py-3 rounded-lg shadow-lg hover:bg-green-100 transition">
            Login
        </a>
    </div>
</div>
@endsection
