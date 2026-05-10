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
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs uppercase bg-gray-100 dark:bg-gray-700">
                        <tr>
                            <th class="px-4 py-2">ID</th>
                            <th class="px-4 py-2">Customer</th>
                            <th class="px-4 py-2">Date & Time</th>
                            <th class="px-4 py-2">Items</th>
                            <th class="px-4 py-2">Total Amount</th>
                            <th class="px-4 py-2">Method</th>
                            <th class="px-4 py-2 text-center">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($sales as $sale)
                        <tr class="border-b dark:border-gray-700">
                            <td class="px-4 py-2">
                                #{{ $sale->id }}
                            </td>

                            <td class="px-4 py-2">
                                {{ $sale->customer_name ?? 'Walk-in' }}
                            </td>

                            <td class="px-4 py-2 whitespace-nowrap">
                                {{ \Carbon\Carbon::parse($sale->created_at)->format('M d, Y h:i A') }}
                            </td>

                            <td class="px-4 py-2">
                                @php $saleItems = collect($items[$sale->id] ?? []); @endphp
                                @foreach($saleItems->take(2) as $item)
                                    <div>
                                        {{ $item->product_name ?? $item['product_name'] }} {{ $item->quantity ?? $item['quantity'] }}x
                                    </div>
                                @endforeach
                                @if($saleItems->count() > 2)
                                    <div class="text-xs text-indigo-500 italic">
                                        +{{ $saleItems->count() - 2 }} more
                                    </div>
                                @endif
                            </td>

                            <td class="px-4 py-2 font-bold text-gray-900 dark:text-white">
                                ₱{{ number_format($sale->total_amount, 2) }}
                            </td>

                            <td class="px-4 py-2 uppercase text-xs">
                                {{ $sale->payment_method }}
                            </td>

                            <td class="px-4 py-2 text-center">
                                <button type="button"
                                    onclick="openReceipt({{ $sale->id }})"
                                    class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded">
                                    Receipt
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-6 text-gray-500">
                                No transactions found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $sales->links() }}
                </div>
            </div>
        </div>
    </div>

    <div id="receiptModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm" onclick="closeModal()"></div>
        <div class="bg-white dark:bg-gray-800 w-full max-w-md p-8 rounded-3xl shadow-2xl relative z-10">
            <h2 class="text-xl font-black mb-6 text-gray-800 dark:text-white uppercase tracking-tighter border-b pb-2">Receipt</h2>
            
            <div id="receiptContent" class="text-sm text-gray-600 dark:text-gray-300">
                </div>

            <div class="mt-6 flex gap-3">
                <button onclick="closeModal()" class="flex-1 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 px-4 py-2 rounded-xl font-bold">
                    Close
                </button>
            </div>
        </div>
    </div>

    <script>
        function openReceipt(id) {
            document.getElementById('receiptModal').classList.remove('hidden');
            fetch('/employee/receipt-data/' + id)
                .then(res => res.json())
                .then(data => {
                    let itemsHtml = '';
                    data.items.forEach(item => {
                        itemsHtml += `<div class="flex justify-between py-1">
                            <span>${item.product_name} x${item.quantity}</span>
                            <span>₱${Number(item.subtotal).toFixed(2)}</span>
                        </div>`;
                    });

                    document.getElementById('receiptContent').innerHTML = `
                        <div class="space-y-1 mb-4">
                            <p class="font-bold text-lg text-gray-900 dark:text-white">Sale #${data.sale.id}</p>
                            <p class="text-xs text-gray-500">${new Date(data.sale.created_at).toLocaleString()}</p>
                        </div>
                        <div class="border-t border-dashed py-4">
                            ${itemsHtml}
                        </div>
                        <div class="border-t pt-4 font-bold text-gray-900 dark:text-white flex justify-between">
                            <span>Total</span>
                            <span class="text-indigo-600 text-lg">₱${Number(data.sale.total_amount).toFixed(2)}</span>
                        </div>
                    `;
                });
        }

        function closeModal() {
            document.getElementById('receiptModal').classList.add('hidden');
        }
    </script>
</x-employee-app-layout>