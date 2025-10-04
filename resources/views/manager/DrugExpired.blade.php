@extends('layouts.app')

@section('title', 'Expired Batch Drugs')

@section('content')
<div class="container mx-auto px-4 py-6">
    @include('layouts.alerts.error')
    @include('layouts.alerts.success')
    <!-- Header with Back Button and Search -->
    <div class="flex flex-col md:flex-row items-start md:items-center justify-between mb-6 gap-4">
        <div class="flex items-center">
            <a href="{{ url()->previous() }}" class="mr-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600 hover:text-gray-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <h1 class="text-2xl font-bold text-gray-800">Expired Batch Drugs</h1>
        </div>
        
        <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
            <!-- Search Box -->
            <form action="" class="flex gap-x-2 w-full md:w-auto" method="GET">
                <div class="relative flex-grow md:w-64">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input 
                        type="text" 
                        id="searchInput"
                        name="search"
                        class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-colors duration-200" 
                        placeholder="Search batches..."
                        onkeyup="searchTable()"
                    >
                </div>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-200 whitespace-nowrap flex items-center justify-center min-w-[80px]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    Search
                </button>
            </form>
            
            <!-- Delete All Button -->
            <button onclick="confirmDeleteAll()" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md flex items-center justify-center whitespace-nowrap">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
                Delete All
            </button>
        </div>
    </div>

    <!-- Responsive Table -->
    <div class="bg-white shadow-md rounded-lg overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200" id="batchesTable">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Medicine</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Batch No</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Production Date</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Expired Date</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200" id="batchesTableBody">
                @foreach ($data as $item)
                    @if ($item->batch_drugs->isNotEmpty())
                        @foreach($item->batch_drugs as $index => $batch)
                        <tr>
                            @if($index === 0)
                                <td class="px-6 py-4 whitespace-nowrap" rowspan="{{ count($item->batch_drugs) }}">
                                    <div class="text-sm font-medium text-gray-900">{{ $item->name }}</div>
                                    <div class="text-sm text-gray-500">No Id. {{ $item->id }}</div>
                                </td>
                            @endif
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $batch->no_batch }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm text-gray-600 font-medium">
                                    {{ \Carbon\Carbon::parse($batch->production_date)->format('d M Y') }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                    {{ \Carbon\Carbon::parse($batch->expired_date)->format('d M Y') }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $batch->batch_stock }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <form action="/manager/DrugExpired/{{ $batch->id }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Are you sure you want to delete this batch?')" class="text-red-600 hover:text-red-900">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    @endif
                @endforeach
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="bg-gray-50 px-4 py-3 text-xs font-semibold uppercase text-gray-400">
            {{ $data->appends(request()->input())->links() }}
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white p-6 rounded-lg shadow-xl max-w-md w-full">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Confirm Deletion</h3>
            <p class="text-sm text-gray-500 mb-6" id="modalMessage">Are you sure you want to delete this batch?</p>
            <div class="flex justify-end space-x-3">
                <button onclick="closeModal()" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                    Cancel
                </button>
                <form action="/manager/DrugExpired/" method="POST">
                    @csrf
                    @method('DELETE')
                    <button id="confirmDeleteBtn" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700">    
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // For single batch deletion
        function confirmDelete(batchNo) {
            document.getElementById('modalMessage').textContent = `Are you sure you want to delete batch ${batchNo}?`;
            document.getElementById('deleteModal').classList.remove('hidden');
            
            document.getElementById('confirmDeleteBtn').onclick = function() {
                alert(`Batch ${batchNo} would be deleted in a real application`);
                closeModal();
            };
        }
        
        // For all batches deletion
        function confirmDeleteAll() {
            document.getElementById('modalMessage').textContent = 'Are you sure you want to delete ALL expired batches? This action cannot be undone.';
            document.getElementById('deleteModal').classList.remove('hidden');
            
            document.getElementById('confirmDeleteBtn').onclick = function() {
                alert('All expired batches would be deleted in a real application');
                closeModal();
            };
        }
        
        function closeModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }
    </script>
</div>
@endsection