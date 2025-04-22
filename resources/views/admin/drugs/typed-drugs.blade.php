@extends('layouts.app')

@section('title', 'Daftar Obat')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <!-- Header with Title and Buttons -->
        <div class="px-6 py-4 border-b border-gray-200 flex flex-col md:flex-row justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-800 flex items-center">
                <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                </svg>
                Daftar Obat
            </h1>
            <div class="mt-2 md:mt-0">
                <a href="/admin/drugs/from-typed-drugs" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Tambah Obat
                </a>
            </div>
        </div>

        <!-- Search and Filter Section -->
        <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
            <form action="/admin/drugs/typed" method="GET" class="flex flex-col md:flex-row gap-4">
                <!-- Search Bar -->
                <div class="flex-1">
                    <div class="relative">
                        <input type="text" name="search" placeholder="Search Drugs..." value="{{ request('search') }}"
                               class="w-full pl-10 pr-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <div class="absolute left-3 top-2.5 text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                
                <!-- Category Filter -->
                <div class="w-full md:w-64">
                    <select name="category_id" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                        <option value="" disabled selected>Semua Kategori</option>
                        @foreach ($category as $item)
                        <option value="{{ $item->id }}" {{ request('category_id') == $item->id ? 'selected' : '' }}>
                            {{ $item->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- Submit Button -->
                <div class="w-full md:w-auto">
                    <button type="submit" class="w-full md:w-auto px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-200">
                        <span class="flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            Cari
                        </span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Obat</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stok</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Min. Stok</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">Deskripsi</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($data as $item)
                    <tr class="hover:bg-gray-50">
                        <!-- Image Column -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="h-12 w-12 rounded-md overflow-hidden bg-gray-100 flex items-center justify-center">
                                @if($item->image)
                                    <img src="{{$item->image}}" alt="{{ $item->name }}" class="h-full w-full object-cover">
                                @else
                                    <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                @endif
                            </div>
                        </td>
                        
                        <!-- Name Column -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="font-medium text-gray-900">{{ $item->name }}</div>
                        </td>
                        
                        <!-- Stock Column -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                {{ $item->stock }}
                            </span>
                        </td>
                        
                        <!-- Min Stock Column -->
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $item->min_stock }}
                        </td>
                        
                        <!-- Price Column -->
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            Rp {{ number_format($item->price, 0, ',', '.') }}
                        </td>
                        
                        <!-- Status Column -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $item->stock <= $item->min_stock ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                {{ $item->stock <= $item->min_stock ? 'Perlu Restock' : 'Tersedia' }}
                            </span>
                        </td>
                        
                        <!-- Description Column (hidden on mobile) -->
                        <td class="px-6 py-4 text-sm text-gray-500 max-w-xs truncate hidden md:table-cell">
                            {{ $item->description }}
                        </td>
                        
                        <!-- Actions Column -->
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex justify-end space-x-2">
                                <!-- View Button -->
                                <a href="/admin/drugs/from-typed-drugs/{{ $item->id }}/batch" class="text-blue-600 hover:text-blue-900" title="View">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </a>
                                
                                <!-- Edit Button -->
                                <a href="/admin/drugs/from-typed-drugs/{{ $item->id }}" class="text-yellow-600 hover:text-yellow-900" title="Edit">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>
                                
                                <!-- Delete Button -->
                                <form action="/admin/drugs/typed/{{ $item->id }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" title="Delete" onclick="return confirm('Apakah Anda yakin ingin menghapus obat ini?')">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex items-center justify-between">
            {{ $data->appends(request()->input())->links() }}
        </div>
    </div>
</div>
@endsection