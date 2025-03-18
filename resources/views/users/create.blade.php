@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div class="min-h-screen bg-gray-100 py-6 flex flex-col justify-center sm:py-12">
    <div class="relative py-3 sm:max-w-xl sm:mx-auto">
        <div class="relative px-4 py-10 bg-white mx-8 md:mx-0 shadow rounded-3xl sm:p-10">
            <div class="max-w-md mx-auto">
                <div class="flex items-center space-x-5">
                    <h1 class="text-2xl font-semibold text-gray-900">Create User</h1>
                    @if (session('success'))
                        <div class="text-sm text-green-600">{{ session('success') }}</div>
                    @endif
                    @if (session('error'))
                        <div class="text-sm text-red-600">{{ session('error') }}</div>
                        
                    @endif
                </div>
                <form action="/users" method="POST" class="mt-8 space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                            <input type="text" name="name" id="name" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong class="text-red-400">{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" name="email" id="email" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong class="text-red-400">{{ $message }}</strong>
                                </span>
                            @enderror
                            </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                            <input type="password" name="password" id="password" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong class="text-red-400">{{ $message }}</strong>
                                </span>
                            @enderror
                            </div>

                        <div class="pt-4">
                            <button type="submit"
                                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Create User
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection