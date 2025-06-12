@extends('layouts.app')

@section('title', 'Create Transaction')

@section('content')
<div class="p-4 md:p-6">
    @include('layouts.alerts.error')
        @include('layouts.alerts.success')

      <!-- Back to Cart Button -->
      <div class="mb-6">
        <a href="/employee/transaction-outgoing/{{$idTransaksi}}" 
           class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
            </svg>
            Back to Item
        </a>
    </div>

    <!-- Search and Filter -->
    <div class="bg-white rounded-lg shadow-md p-4 mb-6">
        <form action="" method="GET">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Search -->
                <div>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Search medicine..." 
                           class="w-full border rounded-md p-2 focus:border-blue-500">
                </div>
                
                <!-- Category Filter -->
                <div>
                    <select name="category" class="w-full border rounded-md p-2">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <button type="submit" class="w-full bg-blue-600 text-white p-2 rounded-md hover:bg-blue-700">
                        Filter
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Medicine Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @foreach($data as $medicine)
        <div class="bg-white rounded-lg shadow-md overflow-hidden border">
            <div class="p-4">
                <img src="{{ $medicine->image ?: 'https://via.placeholder.com/150' }}" 
                     alt="{{ $medicine->name }}" 
                     class="h-32 w-full object-contain mb-4">
                
                <h3 class="text-lg font-semibold">{{ $medicine->name }}</h3>
                <p class="text-gray-500 mb-2">{{ $medicine->category->name }}</p>
                
                <div class="flex justify-between mb-4">
                    <span>Stock: {{ $medicine->stock }}</span>
                    <span class="font-bold">Rp {{ number_format($medicine->price) }}</span>
                </div>
                
                <!-- Batch Selection Form -->
                <form action="/employee/transaction-outgoing/{{$idTransaksi}}/add-item" method="POST">
                    @csrf
                    @method("POST")
                    <input type="hidden" name="medicine_id" value="{{ $medicine->id }}">
                    
                    <div class="mb-3">
                        <label class="block mb-1">Select Batch</label>
                        <select name="batch_id" 
                                class="w-full border rounded-md p-2 batch-select"
                                onchange="updateQuantityMax(this)">
                                @foreach($medicine->batch_drugs as $batch)
                                @php
                                    $expiryDate = \Carbon\Carbon::parse($batch->expired_date);
                                    $isDisabled = $expiryDate->isPast() || $batch->batch_stock <= 0;
                                @endphp
            
                                <option value="{{ $batch->id }}" 
                                        data-stock="{{ $batch->batch_stock }}"
                                        {{ $isDisabled ? 'disabled' : '' }}>
                                    {{ $batch->no_batch }} 
                                    (Stock: {{ $batch->batch_stock }}) - 
                                    Exp: {{ $batch->expired_date }}
                                    {{ $isDisabled ? ' - Not Available' : '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="block mb-1">Quantity</label>
                        <input type="number" name="quantity" min="1" 
                               value="1" class="w-full border rounded-md p-2 quantity-input"
                               max="{{ $medicine->batch_drugs->first()->batch_stock ?? 1 }}">
                        <p class="text-sm text-gray-500 mt-1">
                            Available: <span class="available-stock">{{ $medicine->batch_drugs->first()->batch_stock ?? 0 }}</span>
                        </p>
                    </div>
                    @php
                        // Ambil batch valid (stok > 0 dan belum expired)
                        $validBatches = $medicine->batch_drugs->filter(function($batch) {
                            return \Carbon\Carbon::parse($batch->expired_date)->isFuture() && $batch->batch_stock > 0;
                        });
                        $hasValidBatch = $validBatches->isNotEmpty();
                    @endphp

                    <button type="submit"
                            class="w-full {{ $hasValidBatch ? 'bg-green-600 hover:bg-green-700' : 'bg-gray-500 cursor-not-allowed' }} text-white py-2 rounded-md"
                            {{ $hasValidBatch ? '' : 'disabled' }}>
                        Checkout
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
      <!-- Pagination -->
      <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex items-center justify-between">
        {{ $data->appends(request()->input())->links() }}
    </div>
</div>

<script>
    function updateQuantityMax(selectElement) {
        const selectedOption = selectElement.options[selectElement.selectedIndex];
        const stock = selectedOption.getAttribute('data-stock');
        const form = selectElement.closest('form');
        
        form.querySelector('.quantity-input').max = stock;
        form.querySelector('.available-stock').textContent = stock;
    }
</script>
@endsection