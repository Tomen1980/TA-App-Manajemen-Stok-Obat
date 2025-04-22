@extends('layouts.app')

@section('title', 'Add Batch Drug')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-md overflow-hidden">
        <!-- Header -->
        <div class="bg-blue-800 py-4 px-6 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-white">Add New Batch for </h1>
            <a href="{{ url()->previous() }}" class="text-white hover:text-blue-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </a>
        </div>

        @include('layouts.alerts.error')
        @include('layouts.alerts.success')

        <!-- Form Section -->
        <div class="p-6">
            <form action="/admin/drugs/from-typed-drugs/{{$id}}/form-batch-drugs" method="POST">
                @csrf
                @method('POST')

                <!-- Batch Number -->
                <div class="mb-6">
                    <label for="no_batch" class="block text-gray-700 font-medium mb-2">Batch Number*</label>
                    <input type="text" id="no_batch" name="no_batch" value="{{ old('no_batch') }}"
                           class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                           required placeholder="e.g. BATCH-001-2023">
                </div>

                <!-- Date Fields -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Production Date -->
                    <div>
                        <label for="production_date" class="block text-gray-700 font-medium mb-2">Production Date*</label>
                        <input type="date" id="production_date" name="production_date" value="{{ old('production_date') }}"
                               class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                               required>
                    </div>
                    
                    <!-- Expiry Date -->
                    <div>
                        <label for="expired_date" class="block text-gray-700 font-medium mb-2">Expiry Date*</label>
                        <input type="date" id="expired_date" name="expired_date" value="{{ old('expired_date') }}"
                               class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                               required>
                    </div>
                </div>

                <!-- Stock and Price Fields -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Batch Stock -->
                    <div>
                        <label for="batch_stock" class="block text-gray-700 font-medium mb-2">Batch Stock*</label>
                        <input type="number" id="batch_stock" name="batch_stock" value="{{ old('batch_stock') }}"
                               class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                               required min="1">
                    </div>
                    
                    <!-- Purchase Price -->
                    <div>
                        <label for="purchase_price" class="block text-gray-700 font-medium mb-2">Purchase Price*</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-700">Rp</span>
                            <input type="number" id="purchase_price" name="purchase_price" value="{{ old('purchase_price') }}"
                                   class="w-full pl-10 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   required min="0" step="100">
                        </div>
                    </div>
                </div>

                <!-- Submit and Cancel Buttons -->
                <div class="flex justify-end space-x-4">
                    <a href="/admin/drugs/from-typed-drugs/{{$id}}/batch"
                       class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-6 rounded-lg focus:outline-none focus:shadow-outline transition duration-150">
                        Cancel
                    </a>
                    <button type="submit"
                            class="bg-blue-800 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg focus:outline-none focus:shadow-outline transition duration-150">
                        Add Batch
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Set minimum expiry date to be after production date
    document.getElementById('production_date').addEventListener('change', function() {
        const productionDate = new Date(this.value);
        const expiryDateInput = document.getElementById('expired_date');
        
        if (this.value) {
            // Set minimum expiry date to be at least 1 day after production
            const minDate = new Date(productionDate);
            minDate.setDate(minDate.getDate() + 1);
            
            const minDateStr = minDate.toISOString().split('T')[0];
            expiryDateInput.min = minDateStr;
            
            // If current expiry date is before production date, clear it
            if (expiryDateInput.value && new Date(expiryDateInput.value) <= productionDate) {
                expiryDateInput.value = '';
            }
        } else {
            expiryDateInput.min = '';
        }
    });
</script>
@endsection