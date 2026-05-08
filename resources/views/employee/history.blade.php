<x-employee-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Transaction History') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-100 dark:border-gray-700">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 dark:bg-gray-700/50 border-b border-gray-100 dark:border-gray-700">
                                <th class="px-6 py-4 text-xs font-black uppercase tracking-widest text-gray-500 dark:text-gray-400">ID</th>
                                <th class="px-6 py-4 text-xs font-black uppercase tracking-widest text-gray-500 dark:text-gray-400">Customer</th>
                                <th class="px-6 py-4 text-xs font-black uppercase tracking-widest text-gray-500 dark:text-gray-400">Date</th>
                                <th class="px-6 py-4 text-xs font-black uppercase tracking-widest text-gray-500 dark:text-gray-400">Items</th>
                                <th class="px-6 py-4 text-xs font-black uppercase tracking-widest text-gray-500 dark:text-gray-400 text-right">Total</th>
                                <th class="px-6 py-4 text-xs font-black uppercase tracking-widest text-gray-500 dark:text-gray-400 text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @foreach($sales as $sale)
                                <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-700/30 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="font-mono text-xs text-gray-400 font-bold">#{{ $sale->id }}</span>
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="font-bold text-gray-900 dark:text-white">
                                            {{ $sale->customer_name ?? 'Walk-in' }}
                                        </div>
                                        <div class="text-[10px] font-bold text-gray-400 uppercase tracking-tighter">
                                            {{ $sale->payment_method }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="font-mono text-xs text-gray-400 font-bold">
                                       {{ \Carbon\Carbon::parse($sale->created_at)->format('M d, Y h:i A') }}
                                    </span>
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="text-xs text-gray-500 max-w-xs">
                                            @php $saleItems = collect($items[$sale->id] ?? []); @endphp

                                            @foreach($saleItems->take(2) as $item)
                                                <div class="truncate">
                                                    {{ $item->product_name ?? $item['product_name'] }} 
                                                    (x{{ $item->quantity ?? $item['quantity'] }})
                                                </div>
                                            @endforeach

                                            @if($saleItems->count() > 2)
                                                <span class="text-[10px] text-indigo-500 italic">
                                                    +{{ $saleItems->count() - 2 }} more items
                                                </span>
                                            @endif
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 text-right whitespace-nowrap">
                                        <span class="text-indigo-600 dark:text-indigo-400 font-black">
                                            ₱{{ number_format($sale->total_amount, 2) }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4 text-center">
                                        <button 
                                            onclick="openReceipt({{ $sale->id }})"
                                            class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-[10px] font-black uppercase tracking-widest rounded-lg transition-all active:scale-95 shadow-sm">
                                            Receipt
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center mt-3">
                         {{ $sales->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="receiptModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm" onclick="closeModal()"></div>
        <div class="bg-white dark:bg-gray-800 w-full max-w-md p-8 rounded-3xl shadow-2xl relative z-10">
            <button onclick="closeModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 dark:hover:text-white transition-colors text-xl">
                &times;
            </button>
            <h2 class="text-xl font-black mb-6 text-gray-800 dark:text-white uppercase tracking-tighter">Receipt</h2>
            <div id="receiptContent" class="font-mono text-sm text-gray-600 dark:text-gray-300">
                <div class="flex justify-center py-4">
                    <div class="animate-pulse">Loading...</div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // ... Your existing openReceipt and closeModal JS functions go here ...
        function openReceipt(id) {
            document.getElementById('receiptModal').classList.remove('hidden');
            fetch('/employee/receipt-data/' + id)
                .then(res => res.json())
                .then(data => {
                    let html = `
                        <p class="text-light">${new Date(data.sale.sale_date).toLocaleDateString('en-US', {
                            year: 'numeric', month: 'long', day: 'numeric'
                        })}</p>
                        <p class="font-bold text-gray-900 dark:text-white">Sale #${data.sale.id}</p>
                        <p class="text-xs text-gray-500 mb-4">Customer: ${data.sale.customer_name ?? 'Walk-in'}</p>
                        <div class="border-t border-dashed border-gray-200 dark:border-gray-700 my-4"></div>
                        <div class="space-y-2">
                    `;

                    let total = 0;
                    data.items.forEach(item => {
                        let subtotal = Number(item.subtotal);
                        total += subtotal;
                        html += `
                            <div class="flex justify-between text-xs">
                                <span class="pr-4">${item.product_name} <span class="text-gray-400">x${item.quantity}</span></span>
                                <span class="font-bold text-gray-900 dark:text-white">₱${subtotal.toFixed(2)}</span>
                            </div>
                        `;
                    });
                    
                    html += `
                        </div>
                        <div class="border-t-2 border-dashed border-gray-200 dark:border-gray-700 my-4"></div>
                        <div class="space-y-1 text-sm">
                            <div class="flex justify-between font-bold text-gray-900 dark:text-white">
                                <span>Total</span>
                                <span class="text-indigo-600">₱${total.toFixed(2)}</span>
                            </div>
                            <div class="flex justify-between font-bold text-gray-900 dark:text-white">
                                <span>Change</span>
                                <span class="text-green-600">₱${Number(data.sale.change).toFixed(2)}</span>
                            </div>
                        </div>
                    `;
                    document.getElementById('receiptContent').innerHTML = html;
                });
        }

        function closeModal() {
            document.getElementById('receiptModal').classList.add('hidden');
        }
    </script>
</x-employee-app-layout>