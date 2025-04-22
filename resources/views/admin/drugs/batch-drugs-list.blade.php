@extends('layouts.app')

@section('title', 'Batch Stock Obat')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <!-- Header with Title and Buttons -->
        <div class="px-4 sm:px-6 py-4 border-b border-gray-200 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
            <h1 class="text-xl sm:text-2xl font-bold text-gray-800 flex items-center">
                <svg class="w-5 h-5 sm:w-6 sm:h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                </svg>
                Batch Stock Obat
            </h1>
            <div class="flex flex-col sm:flex-row gap-3">
                <!-- Add Batch Button -->
                <a href="/admin/drugs/from-typed-drugs/{{$id}}/form-batch-drugs" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg inline-flex items-center mb-2 sm:mb-0">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Tambah Batch
                </a>
                <!-- Back Button -->
                <a href="/admin/drugs/typed" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg inline-flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali
                </a>
            </div>
        </div>

        <!-- Rest of your content remains the same -->
        <!-- Drug Information Section -->
        <div class="px-4 sm:px-6 py-4 bg-gray-50 border-b border-gray-200">
            <div class="flex flex-col md:flex-row gap-4">
                <!-- Drug Image -->
                <div class="w-full md:w-32 flex-shrink-0">
                    <img src="{{ $data->image}}" alt="{{ $data->name }}" class="w-full h-32 object-cover rounded-lg border border-gray-200">
                </div>
                
                <!-- Drug Details - Responsive Grid -->
                <div class="flex-1 grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">{{ $data->name }}</h3>
                        <p class="text-sm text-gray-600 mt-1">
                            <span class="font-medium">Kategori:</span> {{ $data->category->name }}
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">
                            <span class="font-medium">Supplier:</span> {{ $data->supplier->name ?? 'N/A' }}
                        </p>
                        <p class="text-sm text-gray-600 mt-1">
                            <span class="font-medium">Harga:</span> Rp {{ number_format($data->price, 0, ',', '.') }}
                        </p>
                    </div>
                    <div class="sm:col-span-2">
                        <p class="text-sm text-gray-600">
                            <span class="font-medium">Total Stok:</span> 
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $data->stock <= $data->min_stock ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                {{ $data->stock }} 
                            </span>
                        </p>
                        <p class="text-sm text-gray-600 mt-1">
                            <span class="font-medium">Minimal Stok:</span> {{ $data->min_stock }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search and Filter Section -->
        <div class="px-4 sm:px-6 py-4 bg-gray-50 border-b border-gray-200">
            <form action="/admin/drugs/from-typed-drugs/{{ $data->id }}/batch" method="GET" class="flex flex-col sm:flex-row gap-3 justify-end">
                <!-- Status Filter -->
                <div class="w-full sm:w-48">
                    <select name="status" class="w-full px-3 py-2 text-sm border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                        <option value="" selected>All</option>
                        <option value="usable" {{ request('status') == 'usable' ? 'selected' : '' }}>Usable</option>
                        <option value="ate" {{ request('status') == 'ate' ? 'selected' : '' }}>About to Expire</option>
                        <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Expired</option>
                    </select>
                </div>

                <!-- Submit Button -->
                <div class="w-full sm:w-auto">
                    <button type="submit" class="w-full sm:w-auto px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                        <span class="flex items-center justify-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            Search
                        </span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Responsive Table Container -->
        <div class="overflow-x-auto">
            <div class="inline-block min-w-full align-middle">
                @include('layouts.alerts.error')
                @include('layouts.alerts.success')
                <!-- Table - Hidden columns on mobile -->
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No Batch</th>
                            <th scope="col" class="hidden sm:table-cell px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produksi</th>
                            <th scope="col" class="hidden sm:table-cell px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kadaluarsa</th>
                            <th scope="col" class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stok</th>
                            <th scope="col" class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-4 sm:px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($data->batch_drugs as $batch)
                        <tr class="hover:bg-gray-50">
                            <!-- Batch Number - Always visible -->
                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                <div class="font-medium text-gray-900">{{ $batch->no_batch }}</div>
                                <!-- Mobile-only dates -->
                                <div class="sm:hidden text-xs text-gray-500 mt-1">
                                    <div>Prod: {{ \Carbon\Carbon::parse($batch->production_date)->format('d M Y') }}</div>
                                    <div>Exp: {{ \Carbon\Carbon::parse($batch->expired_date)->format('d M Y') }}</div>
                                </div>
                            </td>
                            
                            <!-- Production Date - Hidden on mobile -->
                            <td class="hidden sm:table-cell px-4 sm:px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ \Carbon\Carbon::parse($batch->production_date)->format('d M Y') }}
                            </td>
                            
                            <!-- Expiry Date - Hidden on mobile -->
                            <td class="hidden sm:table-cell px-4 sm:px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ \Carbon\Carbon::parse($batch->expired_date)->format('d M Y') }}
                            </td>
                            
                            <!-- Stock -->
                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $batch->batch_stock }}
                            </td>
                            
                            <!-- Status -->
                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                @php
                                    $now = now();
                                    $expiryDate = \Carbon\Carbon::parse($batch->expired_date);
                                    
                                    if ($expiryDate->isPast()) {
                                        $statusClass = 'bg-red-100 text-red-800';
                                        $statusText = 'Expired';
                                    } else {
                                        $monthsUntilExpiry = $now->diffInMonths($expiryDate, false);
                                        
                                        if ($monthsUntilExpiry <= 3) {
                                            $statusClass = 'bg-yellow-100 text-yellow-800';
                                            $statusText = 'About to Expire';
                                        } else {
                                            $statusClass = 'bg-green-100 text-green-800';
                                            $statusText = 'Usable';
                                        }
                                    }
                                @endphp
                            
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                    {{ $statusText }}
                                </span>
                            </td>
                            
                            <!-- Actions -->
                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
     
                                <form class="text-red-600 hover:text-red-900" action="/employee/drugs/stock-list/{{$data->id}}/batch-drugs/{{$batch->id}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" >
                                        Delete
                                    </button>
                                </form>
                         
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="px-4 sm:px-6 py-4 bg-gray-50 border-t border-gray-200 flex items-center justify-between">
            {{-- {{ $batches->appends(request()->input())->links() }} --}}
        </div>
    </div>
</div>
@endsection