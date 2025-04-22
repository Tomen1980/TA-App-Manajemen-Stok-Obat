@extends('layouts.app')

@section('title', 'Add New Medicine')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-md overflow-hidden">
        <!-- Header -->
        <div class="bg-blue-800 py-4 px-6">
            <h1 class="text-2xl font-bold text-white">Add New Medicine</h1>
        </div>

        @include('layouts.alerts.error')
        @include('layouts.alerts.success')

        <!-- Form Section -->
        <div class="p-6">
            <form action="{{ isset($id) ? '/admin/drugs/from-typed-drugs/' . $id : '/admin/drugs/from-typed-drugs/' }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if (isset($id))
                    @method('PUT')
                @else
                    @method('POST')
                @endif
                <!-- Name Field -->
                <div class="mb-6">
                    <label for="name" class="block text-gray-700 font-medium mb-2">Medicine Name*</label>
                    <input type="text" id="name" name="name" value="{{ isset($data->name) ? old('name',$data->name) : old('name') }}"
                           class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                           required>
                </div>

                <!-- Stock and Price Fields -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Minimum Stock Field -->
                    <div>
                        <label for="min_stock" class="block text-gray-700 font-medium mb-2">Minimum Stock*</label>
                        <input type="number" id="min_stock" name="min_stock" value="{{ isset($data->min_stock) ? old('min_stock',$data->min_stock) : old('min_stock') }}"
                               class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                               required min="0">
                    </div>
                    
                    <!-- Price Field -->
                    <div>
                        <label for="price" class="block text-gray-700 font-medium mb-2">Price*</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-700">Rp</span>
                            <input type="number" id="price" name="price" value="{{isset($data->price) ? old('price',$data->price) :  old('price') }}"
                                   class="w-full pl-10 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   required min="0">
                        </div>
                    </div>
                </div>

                <!-- Description Field -->
                <div class="mb-6">
                    <label for="description" class="block text-gray-700 font-medium mb-2">Description</label>
                    <textarea id="description" name="description" rows="3"
                              class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">{{ isset($data->description) ? old('price',$data->description) : old('description') }}</textarea>
                </div>

                <!-- Category and Supplier Dropdowns -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Category Dropdown -->
                    <div>
                        <label for="category_id" class="block text-gray-700 font-medium mb-2">Category*</label>
                        <select id="category_id" name="category_id"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            <option value="" @if(isset($data)) disabled @endif >Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" 
                                    @if(old('category_id', isset($data) ? $data->category_id : '') == $category->id) selected @endif>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Supplier Dropdown -->
                    <div>
                        <label for="supplier_id" class="block text-gray-700 font-medium mb-2">Supplier*</label>
                        <select id="supplier_id" name="supplier_id"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            <option value="" @if(isset($data)) disabled @endif >Select Supplier</option>
                            @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->id }}" 
                                    @if(old('supplier_id', isset($data) ? $data->supplier_id : '') == $supplier->id) selected @endif
                                    >
                                    {{ $supplier->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Image Upload Field -->
                <div class="mb-6">
                    <label for="image" class="block text-gray-700 font-medium mb-2">Medicine Image</label>
                    <div class="flex items-center">
                        <input type="file" id="image" name="image"
                               class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                               accept="image/*">
                            @if(isset($data->image))
                                <input type="hidden" name="old_image" value="{{$data->image}}">
                            @endif
                    </div>
                    <p class="mt-1 text-sm text-gray-500">Upload a clear image of the medicine (JPEG, PNG, JPG)</p>
                </div>

                <!-- Submit and Cancel Buttons -->
                <div class="flex justify-end space-x-4">
                    <a href="/admin/drugs/typed"
                       class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-6 rounded-lg focus:outline-none focus:shadow-outline transition duration-150">
                        Cancel
                    </a>
                    <button type="submit"
                            class="bg-blue-800 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg focus:outline-none focus:shadow-outline transition duration-150">
                        Save Medicine
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection