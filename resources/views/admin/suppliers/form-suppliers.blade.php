@extends('layouts.app')

@section('title', 'Create Category')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-lg mx-auto bg-white rounded-lg shadow-md overflow-hidden">
        <!-- Header -->
        <div class="bg-blue-800 py-4 px-6">
            <h1 class="text-2xl font-bold text-white">Create New suppliers</h1>
        </div>

        @include('layouts.alerts.error')
        @include('layouts.alerts.success')

        <!-- Form Section -->
        <div class="p-6">
            <form action="{{ isset($id) ? '/admin/suppliers/form-supplier/'.$id : '/admin/suppliers/form-supplier' }}" method="POST" class="space-y-6">
                @csrf
                @if(isset($id))
                    @method('PUT')
                @else
                    @method('POST')
                @endif  
                
                <!-- Name Field -->
                <div>
                    <label for="name" class="block text-gray-700 font-medium mb-2">Name</label>
                    <input type="text" id="name" name="name" value="{{ isset($data) ? old('name', $data->name) : old('name') }}"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                </div>

                <!-- Address Field -->
                <div>
                    <label for="address" class="block text-gray-700 font-medium mb-2">Address</label>
                    <textarea id="address" name="address" rows="3"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>{{ isset($data) ? old('address', $data->address) : old('address') }}</textarea>
                </div>

                <!-- Contact Field -->
                <div>
                    <label for="contact" class="block text-gray-700 font-medium mb-2">Contact</label>
                    <input type="number" id="contact" name="contact" value="{{ isset($data) ? old('contact', $data->contact) : old('contact') }}"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                </div>

                <!-- Buttons -->
                <div class="flex justify-between items-center">
                    <a href="/admin/suppliers/list-supplier"
                        class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium py-2 px-4 rounded-lg transition duration-150">
                        Back
                    </a>
                    <button type="submit"
                        class="bg-blue-800 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg focus:outline-none focus:shadow-outline transition duration-150">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection