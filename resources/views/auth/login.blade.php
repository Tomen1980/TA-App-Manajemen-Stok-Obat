@extends('layouts.app')

@section('title', 'Login')

@section('content')

<section class="bg-stone-300 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
        <!-- Judul -->
        <h1 class="text-2xl font-bold text-center mb-6">Sign In</h1>

        @if (session()->has('error'))
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
            <button class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.remove()">
                <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <title>Close</title>
                    <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/>
                </svg>
            </button>
        </div>
    @endif
        <!-- Form Login -->
        <form action="/auth/login" method="POST">
            @csrf
            @method('POST')
            <!-- Input email -->
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input
                    name="email"
                    type="text"
                    id="email"
                    placeholder="email"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                />
            </div>

            <!-- Input Password -->
            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input
                    name="password"
                    type="password"
                    id="password"
                    placeholder="Password"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                />
            </div>

            <!-- Tombol Sign In -->
            <button
                type="submit"
                class="w-full bg-blue-400 text-white py-2 px-4 rounded-md hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
            >
                Sign In
            </button>
        </form>

        <!-- Opsi Remember Me dan Forgot Password -->
        {{-- <div class="mt-4 flex items-center justify-between">
            <div class="flex items-center">
                <input
                    type="checkbox"
                    id="remember-me"
                    class="h-4 w-4 text-blue-400 focus:ring-blue-500 border-gray-300 rounded"
                />
                <label for="remember-me" class="ml-2 block text-sm text-gray-900">Remember Me</label>
            </div>
            <a href="#" class="text-sm text-blue-400 hover:text-blue-500">Forgot Password?</a>
        </div>

        <!-- Pesan Selamat Datang -->
        <div class="mt-6 text-center">
            <p class="text-sm text-gray-600">Don't have an account? <a href="#" class="text-blue-600 hover:text-blue-500">Sign Up</a></p>
        </div> --}}
    </div>
</section>
@endsection

