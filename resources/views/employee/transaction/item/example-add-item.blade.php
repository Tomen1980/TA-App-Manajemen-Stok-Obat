@extends('layouts.app')

@section('title', 'Create Transaction')

@section('content')
<div class="flex flex-col md:flex-row">
    <!-- Sidebar -->
    
    <!-- Main Content -->
    <div class="flex-1 p-4 md:p-6">
        @include('layouts.alerts.error')
        @include('layouts.alerts.success')
        
        <!-- Search and Filter Section -->
        <div class="bg-white rounded-lg shadow-md p-4 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Search Input -->
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700">Search Medicine</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <input type="text" name="search" id="search" 
                               class="block w-full pr-10 sm:text-sm border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Search by name...">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                </div>
                
                <!-- Category Filter -->
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
                    <select id="category" name="category" 
                            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                        <option value="">All Categories</option>
                        <option value="analgesic">Analgesic</option>
                        <option value="antibiotic">Antibiotic</option>
                        <option value="antihistamine">Antihistamine</option>
                        <option value="antacid">Antacid</option>
                    </select>
                </div>
                
                <!-- Sort By -->
                <div>
                    <label for="sort" class="block text-sm font-medium text-gray-700">Sort By</label>
                    <select id="sort" name="sort" 
                            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                        <option value="name_asc">Name (A-Z)</option>
                        <option value="name_desc">Name (Z-A)</option>
                        <option value="price_asc">Price (Low-High)</option>
                        <option value="price_desc">Price (High-Low)</option>
                        <option value="stock_asc">Stock (Low-High)</option>
                        <option value="stock_desc">Stock (High-Low)</option>
                    </select>
                </div>
            </div>
        </div>
        
        <!-- Medicine Cards Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8" id="medicine-grid">
            <!-- Sample Medicine Card 1 -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200">
                <div class="p-4">
                    <div class="flex justify-center mb-4">
                        <img src="https://via.placeholder.com/150" alt="Medicine" class="h-32 w-32 object-contain">
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-1">Paracetamol 500mg</h3>
                    <p class="text-sm text-gray-500 mb-2">Analgesic</p>
                    <div class="flex justify-between items-center mb-3">
                        <span class="text-sm font-medium text-gray-700">Stock: <span class="text-blue-600">150</span></span>
                        <span class="text-lg font-bold text-gray-900">Rp 5,000</span>
                    </div>
                    <button class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-md transition duration-200 select-btn" 
                            data-id="1" data-name="Paracetamol 500mg" data-image="https://via.placeholder.com/150">
                        Select
                    </button>
                </div>
            </div>
            
            <!-- Sample Medicine Card 2 -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200">
                <div class="p-4">
                    <div class="flex justify-center mb-4">
                        <img src="https://via.placeholder.com/150" alt="Medicine" class="h-32 w-32 object-contain">
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-1">Amoxicillin 500mg</h3>
                    <p class="text-sm text-gray-500 mb-2">Antibiotic</p>
                    <div class="flex justify-between items-center mb-3">
                        <span class="text-sm font-medium text-gray-700">Stock: <span class="text-blue-600">80</span></span>
                        <span class="text-lg font-bold text-gray-900">Rp 15,000</span>
                    </div>
                    <button class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-md transition duration-200 select-btn" 
                            data-id="2" data-name="Amoxicillin 500mg" data-image="https://via.placeholder.com/150">
                        Select
                    </button>
                </div>
            </div>
            
            <!-- Add more medicine cards as needed -->
        </div>
        
        <!-- Batch Selection Modal (hidden by default) -->
        <div id="batch-modal" class="fixed inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                        <span id="selected-medicine-name">Medicine Name</span> - Select Batch
                                    </h3>
                                    <button type="button" class="close-modal text-gray-400 hover:text-gray-500">
                                        <span class="sr-only">Close</span>
                                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                                
                                <div class="mt-2">
                                    <div class="overflow-x-auto">
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead class="bg-gray-50">
                                                <tr>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Select</th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Batch No.</th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Production Date</th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Expiry Date</th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Batch Stock</th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200" id="batch-table-body">
                                                <!-- Batch data will be inserted here by JavaScript -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm add-to-cart-btn">
                            Add to Cart
                        </button>
                        <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm close-modal">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Shopping Cart Section -->
        <div class="bg-white rounded-lg shadow-md p-6 mt-8" id="cart-section" style="display: none;">
            <h2 class="text-xl font-semibold mb-4">Shopping Cart</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Medicine</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Batch No.</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Expiry Date</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200" id="cart-items">
                        <!-- Cart items will be inserted here by JavaScript -->
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-right font-medium text-gray-900">Subtotal</td>
                            <td class="px-6 py-4 font-medium text-gray-900" id="cart-subtotal">Rp 0</td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            
            <div class="mt-6 flex justify-end space-x-3">
                <button type="button" class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Clear Cart
                </button>
                <button type="button" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Checkout
                </button>
            </div>
        </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Sample batch data for medicines
        const batchData = {
            1: [ // Paracetamol batches
                { id: 101, batchNo: 'PC-2023-001', prodDate: '2023-01-15', expDate: '2024-01-15', stock: 50, price: 5000 },
                { id: 102, batchNo: 'PC-2023-002', prodDate: '2023-03-20', expDate: '2024-03-20', stock: 70, price: 5000 },
                { id: 103, batchNo: 'PC-2023-003', prodDate: '2023-06-10', expDate: '2024-06-10', stock: 30, price: 5000 }
            ],
            2: [ // Amoxicillin batches
                { id: 201, batchNo: 'AM-2023-001', prodDate: '2023-02-05', expDate: '2024-02-05', stock: 40, price: 15000 },
                { id: 202, batchNo: 'AM-2023-002', prodDate: '2023-05-15', expDate: '2024-05-15', stock: 40, price: 15000 }
            ]
        };
        
        let selectedMedicineId = null;
        let selectedMedicineName = '';
        let selectedMedicineImage = '';
        let cartItems = [];
        
        // Handle select button clicks
        document.querySelectorAll('.select-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                selectedMedicineId = this.getAttribute('data-id');
                selectedMedicineName = this.getAttribute('data-name');
                selectedMedicineImage = this.getAttribute('data-image');
                
                // Update modal title
                document.getElementById('selected-medicine-name').textContent = selectedMedicineName;
                
                // Populate batch table
                const batchTableBody = document.getElementById('batch-table-body');
                batchTableBody.innerHTML = '';
                
                if (batchData[selectedMedicineId]) {
                    batchData[selectedMedicineId].forEach(batch => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td class="px-6 py-4 whitespace-nowrap">
                                <input type="radio" name="selected-batch" value="${batch.id}" class="batch-radio h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${batch.batchNo}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${batch.prodDate}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${batch.expDate}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${batch.stock}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <input type="number" min="1" max="${batch.stock}" value="1" class="batch-quantity w-20 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </td>
                        `;
                        batchTableBody.appendChild(row);
                    });
                }
                
                // Show modal
                document.getElementById('batch-modal').classList.remove('hidden');
            });
        });
        
        // Close modal handlers
        document.querySelectorAll('.close-modal').forEach(btn => {
            btn.addEventListener('click', function() {
                document.getElementById('batch-modal').classList.add('hidden');
            });
        });
        
        // Add to cart handler
        document.querySelector('.add-to-cart-btn').addEventListener('click', function() {
            const selectedBatchRadio = document.querySelector('input[name="selected-batch"]:checked');
            
            if (selectedBatchRadio) {
                const batchId = selectedBatchRadio.value;
                const batchRow = selectedBatchRadio.closest('tr');
                const quantityInput = batchRow.querySelector('.batch-quantity');
                const quantity = parseInt(quantityInput.value);
                
                // Find the batch data
                const batch = batchData[selectedMedicineId].find(b => b.id == batchId);
                
                // Add to cart
                cartItems.push({
                    medicineId: selectedMedicineId,
                    medicineName: selectedMedicineName,
                    medicineImage: selectedMedicineImage,
                    batchId: batch.id,
                    batchNo: batch.batchNo,
                    expDate: batch.expDate,
                    price: batch.price,
                    quantity: quantity
                });
                
                // Update cart display
                updateCartDisplay();
                
                // Close modal
                document.getElementById('batch-modal').classList.add('hidden');
            } else {
                alert('Please select a batch first');
            }
        });
        
        // Update cart display
        function updateCartDisplay() {
            const cartItemsContainer = document.getElementById('cart-items');
            cartItemsContainer.innerHTML = '';
            
            if (cartItems.length === 0) {
                document.getElementById('cart-section').style.display = 'none';
                return;
            }
            
            document.getElementById('cart-section').style.display = 'block';
            
            let subtotal = 0;
            
            cartItems.forEach((item, index) => {
                const total = item.price * item.quantity;
                subtotal += total;
                
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10">
                                <img class="h-10 w-10 rounded-full" src="${item.medicineImage}" alt="">
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">${item.medicineName}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${item.batchNo}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${item.expDate}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${item.quantity}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Rp ${item.price.toLocaleString()}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Rp ${total.toLocaleString()}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <button class="text-red-600 hover:text-red-900 remove-item" data-index="${index}">Remove</button>
                    </td>
                `;
                cartItemsContainer.appendChild(row);
            });
            
            // Update subtotal
            document.getElementById('cart-subtotal').textContent = `Rp ${subtotal.toLocaleString()}`;
            
            // Add event listeners to remove buttons
            document.querySelectorAll('.remove-item').forEach(btn => {
                btn.addEventListener('click', function() {
                    const index = parseInt(this.getAttribute('data-index'));
                    cartItems.splice(index, 1);
                    updateCartDisplay();
                });
            });
        }
        
        // Filter functionality would be implemented here
        // This would typically involve AJAX calls to the server
    });
</script>
@endsection