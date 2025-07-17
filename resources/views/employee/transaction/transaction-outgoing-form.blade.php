@php
    use App\Enums\TransactionStatus;
@endphp
@extends('layouts.app')

@section('title', 'Create Transaction')

@section('content')
<div class="flex flex-col md:flex-row">
    <!-- Sidebar -->
    
    <!-- Main Content -->
    <div class="flex-1 p-2 sm:p-4 md:p-6">
        @include('layouts.alerts.error')
        @include('layouts.alerts.success')
        <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-md overflow-hidden">
            <!-- Header -->
            <div class="bg-blue-600 px-3 py-2 sm:px-4 sm:py-3 text-white">
                <h2 class="text-lg sm:text-xl font-semibold">Invoice</h2>
            </div>

            <!-- Transaction Info Card -->
            <div class="p-3 sm:p-6 border-b border-gray-200">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-2 sm:gap-4">
                    <div class="bg-gray-50 p-2 sm:p-4 rounded-lg">
                        <p class="text-xs sm:text-sm font-medium text-gray-500">Transaction Type</p>
                        <select class="mt-1 text-xs sm:text-sm block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="sale" selected disabled>Transaction {{$data->type}}</option>
                        </select>
                    </div>
                    <div class="bg-gray-50 p-2 sm:p-4 rounded-lg">
                        <p class="text-xs sm:text-sm font-medium text-gray-500">Total Price</p>
                        <p class="mt-1 text-sm sm:text-lg font-semibold">Rp {{number_format($data->total_price)}}</p>
                    </div>
                    <div class="bg-gray-50 p-2 sm:p-4 rounded-lg">
                        <p class="text-xs sm:text-sm font-medium text-gray-500">Date</p>
                        <input type="date" class="mt-1 text-xs sm:text-sm block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" value="{{ $data->date}}" readonly>
                    </div>
                    <div class="bg-gray-50 p-2 sm:p-4 rounded-lg">
                        <p class="text-xs sm:text-sm font-medium text-gray-500">Status</p>
                        <p class="mt-1 text-sm sm:text-lg font-semibold {{$data->status === "arrears" ? "text-red-600" : "text-green-600" }}">{{ucfirst($data->status)}}</p>
                    </div>
                </div>
            </div>

            <!-- Medicine Table -->
            <div class="p-3 sm:p-6">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-3 sm:mb-4 gap-2">
                    <h3 class="text-base sm:text-lg font-medium">Medicine Items</h3>
                    @if($data->status === TransactionStatus::ARREARS->value)
                    <a href="/employee/transaction-outgoing/{{$data->id}}/add-item"
                       class="w-full sm:w-auto px-3 py-1 sm:px-4 sm:py-2 text-xs sm:text-sm bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        Add Medicine
                    </a>
                {{-- @else
                    <button disabled
                            class="w-full sm:w-auto px-3 py-1 sm:px-4 sm:py-2 text-xs sm:text-sm bg-gray-400 text-white rounded-md opacity-50 cursor-not-allowed">
                        Add Medicine
                    </button> --}}
                @endif
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-xs sm:text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-2 py-1 sm:px-4 sm:py-2 text-left font-medium text-gray-500 uppercase tracking-wider">Medicine</th>
                                <th class="px-2 py-1 sm:px-4 sm:py-2 text-left font-medium text-gray-500 uppercase tracking-wider">Qty</th>
                                <th class="px-2 py-1 sm:px-4 sm:py-2 text-left font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                <th class="px-2 py-1 sm:px-4 sm:py-2 text-left font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                @if($data->status === 'arrears')
                                <th class="px-2 py-1 sm:px-4 sm:py-2 text-left font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <!-- Sample Data Row -->
                            @foreach ($data->transactionsItem as $item)
                           
                            <tr>
                                <td class="px-2 py-1 sm:px-4 sm:py-3 whitespace-nowrap">
                                   
                                   {{$item->batchDrug->medicineMaster->name}} ({{$item->batchDrug->no_batch}})
                                </td>
                                <td class="px-2 py-1 sm:px-4 sm:py-3 whitespace-nowrap">
                                   {{$item->item_amount}}
                                </td>
                                <td class="px-2 py-1 sm:px-4 sm:py-3 whitespace-nowrap">
                                   Rp {{$item->batchDrug->medicineMaster->price}}
                                </td>
                                <td class="px-2 py-1 sm:px-4 sm:py-3 whitespace-nowrap font-medium">
                                    {{$item->total_price}}
                                </td>
                                @if($data->status === 'arrears')
                                <td class="px-2 py-1 sm:px-4 sm:py-3 whitespace-nowrap">
                                    <form action="/employee/transaction-outgoing/{{$idParam}}/item/{{$item->id}}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 text-xs sm:text-sm">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                                @endif
                            </tr>
                                 
                            @endforeach
                            <!-- Empty State -->
                            <tr class="empty-state" style="display: none;">
                                <td colspan="{{$data->status === 'arrears' ? 5 : 4}}" class="px-4 py-3 text-center text-gray-500 text-xs sm:text-sm">
                                    No medicine items added yet
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="px-3 py-3 sm:px-6 sm:py-4 bg-gray-50 flex flex-col sm:flex-row justify-end space-y-2 sm:space-y-0 sm:space-x-3">
                <a href={{$data->status === TransactionStatus::PAID->value ? "/employee/history-transaction-outgoing/" : "/employee/transaction-outgoing/"}} class="w-full sm:w-auto px-3 py-1 sm:px-4 sm:py-2 text-xs sm:text-sm border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    {{$data->status === TransactionStatus::PAID->value ? "Kembali" : "Cancel"}} 
                </a>
                @if($data->status === 'arrears')
                <form action="" method="POST">
                    @csrf
                    @method('PUT') 
                    <button type="submit" class="w-full sm:w-auto px-3 py-1 sm:px-4 sm:py-2 text-xs sm:text-sm border border-transparent rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 {{$itemCount === 0 ? 'opacity-50 cursor-not-allowed bg-gray-500' : ''}} " {{$itemCount === 0 ? 'disabled' : ''}}>
                        Submit Transaction
                    </button>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection