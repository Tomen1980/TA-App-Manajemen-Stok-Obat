@extends('layouts.app')

@section('title', 'Create Transaction')

@section('content')
<div class="flex flex-col md:flex-row">
    <!-- Sidebar -->
    
    <!-- Main Content -->
    <div class="flex-1 p-4 md:p-6">
        @include('layouts.alerts.error')
        @include('layouts.alerts.success')
        <div class="max-w-md mx-auto bg-white rounded-lg shadow-md overflow-hidden">
            <!-- Header -->
            <div class="bg-blue-600 px-4 py-3 text-white">
                <h2 class="text-xl font-semibold">Create New Transaction</h2>
            </div>

            <!-- Transaction Form -->
            <div class="p-6">
                <form class="space-y-6" method="POST" action="/employee/transaction-outgoing/">
                    @csrf
                    @method('POST')
                    <!-- Date Input -->
                    <div>
                        <label for="transaction_date" class="block text-sm font-medium text-gray-700">
                            Transaction Date
                        </label>
                        <div class="mt-1">
                            <input type="date" id="transaction_date" name="transaction_date" value="{{ date('Y-m-d') }}"
                                   class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        
                    </div>

                    <!-- Submit Button -->
                    <div>
                        <button type="submit" 
                                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Create Transaction
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection