@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Dashboard Overview</h1>
        <div class="text-sm text-gray-500">
            {{ \Carbon\Carbon::now()->format('l, F j, Y') }}
        </div>
    </div>

    <!-- Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Transactions Card -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden border-l-4 border-blue-500">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 text-blue-500 mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-gray-500 text-sm font-medium">Total Transactions</h3>
                        <p class="text-2xl font-semibold text-gray-800">{{ $data['all_transaction'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Paid Transactions Card -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden border-l-4 border-green-500">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 text-green-500 mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-gray-500 text-sm font-medium">Paid Transactions</h3>
                        <p class="text-2xl font-semibold text-gray-800">{{ $data['paid_transaction'] }}</p>
                        <p class="text-sm text-green-600">{{ $data['paid_transaction_percent'] }}% of total transaction</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Arrears Transactions Card -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden border-l-4 border-red-500">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-red-100 text-red-500 mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-gray-500 text-sm font-medium">Arrears Transactions</h3>
                        <p class="text-2xl font-semibold text-gray-800">{{ $data['arrears_transaction'] }}</p>
                        <p class="text-sm text-red-600">{{ $data['arrears_transaction_percent'] }}% of total transaction</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Medicine Types Card -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden border-l-4 border-purple-500">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-purple-100 text-purple-500 mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-gray-500 text-sm font-medium">Medicine Types</h3>
                        <p class="text-2xl font-semibold text-gray-800">{{ $data['all_medicine'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Expired Medicine Card -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden border-l-4 border-yellow-500">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-yellow-100 text-yellow-500 mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-gray-500 text-sm font-medium">Expired Medicine</h3>
                        <p class="text-2xl font-semibold text-gray-800">{{ $data['expired_batch_stock'] }}</p>
                        <p class="text-sm text-yellow-600">{{ $data['expired_batch_stock_percent'] }}% of total batch</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- About to Expire Card -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden border-l-4 border-orange-500">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-orange-100 text-orange-500 mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-gray-500 text-sm font-medium">About to Expire</h3>
                        <p class="text-2xl font-semibold text-gray-800">{{ $data['ate_batch_stock'] }}</p>
                        <p class="text-sm text-orange-600">{{ $data['ate_batch_stock_percent'] }}% of total batch</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Usable Medicine Card -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden border-l-4 border-green-500">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 text-green-500 mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-gray-500 text-sm font-medium">Usable Medicine</h3>
                        <p class="text-2xl font-semibold text-gray-800">{{ $data['usable_batch_stock'] }}</p>
                        <p class="text-sm text-green-600">{{ $data['usable_batch_stock_percent'] }}% of total batch</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection