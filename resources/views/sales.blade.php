<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Sales Transactions') }}
            </h2>
            </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th class="px-4 py-3">ID</th>
                                    <th class="px-4 py-3">Date</th>
                                    <th class="px-4 py-3">Customer</th>
                                    <th class="px-4 py-3">Employee</th>
                                    <th class="px-4 py-3">Total</th>
                                    <th class="px-4 py-3">Paid</th>
                                    <th class="px-4 py-3">Change</th>
                                    <th class="px-4 py-3 text-center">Method</th>
                                    <th class="px-4 py-3 text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach ($sales as $sale)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                    <td class="px-4 py-4 font-mono text-xs text-gray-400">#{{ $sale->id }}</td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        {{ \Carbon\Carbon::parse($sale->sale_date)->format('M d, Y') }}
                                    </td>
                                    <td class="px-4 py-4 font-medium text-gray-900 dark:text-white">
                                        {{ $sale->customer_name ?? 'Walk-in' }}
                                    </td>
                                    <td class="px-4 py-4">{{ $sale->employee_name }}</td>
                                    <td class="px-4 py-4 font-semibold text-gray-900 dark:text-white">
                                        ₱{{ number_format($sale->total_amount, 2) }}
                                    </td>
                                    <td class="px-4 py-4 text-green-600 dark:text-green-400">
                                        ₱{{ number_format($sale->amount_paid, 2) }}
                                    </td>
                                    <td class="px-4 py-4">
                                        ₱{{ number_format($sale->change, 2) }}
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        <span class="px-2 py-1 bg-gray-100 dark:bg-gray-700 rounded text-xs uppercase font-bold">
                                            {{ $sale->payment_method }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 text-right">
                                    <button type="button"
                                        onclick="openItemsModal({{ $sale->id }})"
                                        class="inline-flex items-center px-3 py-1.5 bg-indigo-600 text-white rounded-md text-xs">
                                        View Items
                                    </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="d-flex justify-content-center mt-3">
                         {{ $sales->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
<div id="itemsModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" onclick="closeItemsModal()"></div>

    <div class="bg-white dark:bg-gray-800 w-full max-w-lg rounded-3xl shadow-2xl relative z-10 overflow-hidden transform transition-all">
        
        <div class="px-8 pt-8 pb-4 flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-black text-gray-800 dark:text-white tracking-tight">Order Details</h2>
                <p class="text-xs font-bold text-indigo-500 uppercase tracking-widest mt-1">Items Breakdown</p>
            </div>
            <button onclick="closeItemsModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-white transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <div class="px-8 py-4">
            <div id="itemsContainer" class="space-y-3 max-h-[400px] overflow-y-auto pr-2 custom-scrollbar">
                <div class="flex flex-col items-center py-10 opacity-20">
                    <svg class="w-12 h-12 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    <p class="text-sm font-bold">Loading items...</p>
                </div>
            </div>
        </div>

        <div class="px-8 py-6 bg-gray-50 dark:bg-gray-700/30 mt-4 flex justify-between items-center">
            <div class="text-xs text-gray-500 font-medium">
                Please verify items before closing.
            </div>
            <button onclick="closeItemsModal()"
                class="px-8 py-3 bg-gray-900 dark:bg-white dark:text-gray-900 text-white text-xs font-black uppercase tracking-widest rounded-xl hover:opacity-90 transition-all active:scale-95">
                Close
            </button>
        </div>
    </div>
</div>

<style>
    /* Clean Scrollbar for the items list */
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #e5e7eb; border-radius: 10px; }
    .dark .custom-scrollbar::-webkit-scrollbar-thumb { background: #374151; }
</style>
<script>
const saleItems = @json($items);
function openItemsModal(saleId) {

    let container = document.getElementById('itemsContainer');
    container.innerHTML = '';

    let items = saleItems[saleId] || [];

    if (items.length === 0) {
        container.innerHTML = '<p class="text-gray-500">No items found.</p>';
    } else {
        items.forEach(item => {
            container.innerHTML += `
                <div class="flex justify-between border-b py-1">
                    <span class="text-white">${item.product_name} ${item.quantity}x</span>
                    <span class="text-white">₱${parseFloat(item.subtotal).toFixed(2)}</span>
                </div>
            `;
        });
    }

    document.getElementById('itemsModal').classList.remove('hidden');
}

function closeItemsModal() {
    document.getElementById('itemsModal').classList.add('hidden');
}
</script>
</x-app-layout>