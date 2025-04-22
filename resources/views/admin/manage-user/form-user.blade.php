@extends('layouts.app')

@section('title', 'Create User')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-lg mx-auto bg-white rounded-lg shadow-md overflow-hidden">
        <!-- Header -->
        <div class="bg-blue-800 py-4 px-6">
            <h1 class="text-2xl font-bold text-white">{{ isset($id) ? 'Edit User' : 'Create New User' }}</h1>
        </div>

        @include('layouts.alerts.error')
        @include('layouts.alerts.success')

        <!-- Form Section -->
        <div class="p-6">
            <form action="{{ isset($id) ? '/admin/user/form-user/'.$id : '/admin/user/form-user/' }}" method="POST" class="space-y-6">
                @csrf
                @if(isset($id))
                    @method('PUT')
                @else
                    @method('POST')
                @endif
                
                <!-- Name Field -->
                <div>
                    <label for="name" class="block text-gray-700 font-medium mb-2">Full Name</label>
                    <input type="text" id="name" name="name" value="{{ isset($data) ? old('name', $data->name) : old('name') }}"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                </div>

                <!-- Email Field -->
                <div>
                    <label for="email" class="block text-gray-700 font-medium mb-2">Email Address</label>
                    <input type="email" id="email" name="email" value="{{ isset($data) ? old('email', $data->email) : old('email') }}"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                </div>

                <!-- Password Field -->
                <div>
                    <label for="password" class="block text-gray-700 font-medium mb-2">Password</label>
                    <input type="password" id="password" name="password"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        {{ !isset($id) ? 'required' : '' }}>
                    {{-- @if(isset($id))
                        <p class="text-sm text-gray-500 mt-1">Leave blank to keep current password</p>
                    @endif --}}
                </div>

                <!-- Password Confirmation Field -->
                <div>
                    <label for="password_confirmation" class="block text-gray-700 font-medium mb-2">Confirm Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                </div>

                <!-- Buttons -->
                <div class="flex justify-between items-center">
                    <a href="/admin/user/list-user"
                        class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium py-2 px-4 rounded-lg transition duration-150">
                        Back
                    </a>
                    <button type="submit"
                        class="bg-blue-800 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg focus:outline-none focus:shadow-outline transition duration-150">
                        {{ isset($id) ? 'Update User' : 'Create User' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection