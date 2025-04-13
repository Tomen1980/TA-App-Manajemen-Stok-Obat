<!-- Sidebar -->
<div class="bg-blue-800 text-white w-64 min-h-screen transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out fixed md:relative" id="sidebar">
    <!-- Tombol Toggle untuk Mobile -->
    <button class="md:hidden p-4 text-white focus:outline-none" onclick="toggleSidebar()">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
    </button>
    

    <!-- Logo atau Judul -->
    <div class="p-4 text-2xl font-bold border-b border-blue-700">
        <a href="/{{Auth::user()->role->value}}/dashboard">
            Dashboard {{ Auth::user()->name}}
        </a>
    </div>

    <!-- Menu -->
    <nav class="p-4">
        <ul>     
        @if(Auth::user()->role->value == 'employee')
            <!-- Menu Transaction -->
            <li class="mb-2">
                <a href="#" class="flex items-center p-2 hover:bg-blue-700 rounded" onclick="toggleDropdown('transaction-dropdown')">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-8-4v8m-6-8v8m10-8v8" />
                    </svg>
                    Transaction
                </a>
                <ul id="transaction-dropdown" class="ml-6 mt-2 hidden">
                    <li class="mb-2">
                        <a href="/employee/transaction-outgoing/" class="flex items-center p-2 hover:bg-blue-700 rounded">
                            Outgoing Transactions
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="/employee/history-transaction-outgoing/" class="flex items-center p-2 hover:bg-blue-700 rounded">
                            Transaction History
                        </a>
                    </li>
                </ul>
            </li>
            <!-- Menu Drugs -->
            <li class="mb-2">
                <a href="#" class="flex items-center p-2 hover:bg-blue-700 rounded" onclick="toggleDropdown('drugs-dropdown')">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    Drugs
                </a>
                <ul id="drugs-dropdown" class="ml-6 mt-2 hidden">
                    <li class="mb-2">
                        <a href="/employee/drugs/stock-list" class="flex items-center p-2 hover:bg-blue-700 rounded">
                            Stock List
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="/employee/drugs/expired" class="flex items-center p-2 hover:bg-blue-700 rounded">
                            Stock Expired
                        </a>
                    </li>
                </ul>
            </li>
        @endif
             <!-- Menu Account -->
             <li class="mb-2">
                <a href="#" class="flex items-center p-2 hover:bg-blue-700 rounded" onclick="toggleDropdown('account-dropdown')">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Settings
                </a>
                <ul id="account-dropdown" class="ml-6 mt-2 hidden">
                    <li class="mb-2">
                        @if (Auth::user()->role->value == 'employee')
                            <a href="/employee/change-profile" class="flex items-center p-2 hover:bg-blue-700 rounded">
                                Account
                            </a>
                        @elseif (Auth::user()->role->value == 'admin')
                            <a href="/admin/change-profile" class="flex items-center p-2 hover:bg-blue-700 rounded">
                                Account
                            </a>
                        @elseif (Auth::user()->role->value == 'manager')
                            <a href="/manager/change-profile" class="flex items-center p-2 hover:bg-blue-700 rounded">
                                Account
                            </a>
                        @endif
                    </li>
                    <li class="mb-2">
                        <form action="/auth/logout" method="POST">
                        @csrf()
                        @method('DELETE')
                            <button type="submit" href="#" class="flex items-center p-2 hover:bg-blue-700 rounded w-full">
                                Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
</div>