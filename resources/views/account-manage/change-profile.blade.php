@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-md overflow-hidden">
        <!-- Header -->
        <div class="bg-blue-800 py-4 px-6">
            <h1 class="text-2xl font-bold text-white">Profile Settings</h1>
        </div>

        @include('layouts.alerts.error')
        @include('layouts.alerts.success')

        <!-- Form Section -->
        <div class="p-6">
            
            <form action="/manager/update/change-profile" method="POST">
                @csrf
                @method('PUT')

                <!-- Name Field -->
                <div class="mb-6">
                    <label for="name" class="block text-gray-700 font-medium mb-2">Full Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}"
                           class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                           required>
                           
                </div>

                <!-- Email Field -->
                <div class="mb-6">
                    <label for="email" class="block text-gray-700 font-medium mb-2">Email Address</label>
                    <input type="text" id="email" name="email" value="{{ old('email', $user->email) }}"
                           class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                           required>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-between items-center">
                    <button type="submit"
                            class="bg-blue-800 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg focus:outline-none focus:shadow-outline transition duration-150">
                        Update Profile
                    </button>

                    <!-- Change Password Button (Modal Trigger) -->
                    <button type="button" onclick="openPasswordModal()"
                            class="text-blue-800 hover:text-blue-700 font-medium py-2 px-4 rounded-lg focus:outline-none transition duration-150">
                        Change Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Change Password Modal -->
<div id="passwordModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Change Password</h3>
            
            @if (Auth::user()->role->value == 'employee')
            <form action="/employee/update/change-password" method="POST" class="mt-4">
        @elseif (Auth::user()->role->value == 'admin')
            <form action="/admin/update/change-password" method="POST" class="mt-4">
        @elseif (Auth::user()->role->value == 'manager')
             <form action="/manager/update/change-password" method="POST" class="mt-4">
        @endif
            
                @csrf
                @method('PUT')
                
                <!-- Current Password -->
                <div class="mb-4 text-left">
                    <label for="current_password" class="block text-gray-700 text-sm font-bold mb-2">Current Password</label>
                    <input type="password" id="current_password" name="current_password" 
                           class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                           @error('current_password')
                           <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                       @enderror
                    </div>
                
                
                <!-- New Password -->
                <div class="mb-4 text-left">
                    <label for="new_password" class="block text-gray-700 text-sm font-bold mb-2">New Password</label>
                    <input type="password" id="new_password" name="new_password" 
                           class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                           @error('new_password')
                           <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                       @enderror
                        </div>
                
                <!-- Confirm New Password -->
                <div class="mb-6 text-left">
                    <label for="confirm_password" class="block text-gray-700 text-sm font-bold mb-2">Confirm New Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" 
                           class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                           @error('confirm_password')
                           <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                       @enderror
                        </div>
                
                <div class="flex justify-between px-4 py-3">
                    <button type="button" onclick="closePasswordModal()"
                            class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Cancel
                    </button>
                    <button type="submit"
                            class="bg-blue-800 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Update Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openPasswordModal() {
        document.getElementById('passwordModal').classList.remove('hidden');
    }

    function closePasswordModal() {
        document.getElementById('passwordModal').classList.add('hidden');
    }

    // Close modal when clicking outside
    window.onclick = function(event) {
        const modal = document.getElementById('passwordModal');
        if (event.target === modal) {
            closePasswordModal();
        }
    }
</script>
@endsection