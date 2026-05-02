<x-employee-app-layout>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <h2 class="text-2xl font-black mb-8 text-gray-800 dark:text-white tracking-tight">
            Transaction History
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

            @foreach($sales as $sale)

                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 hover:shadow-md transition-shadow">

                    <p class="font-mono text-xs text-gray-400 font-bold uppercase tracking-widest">#{{ $sale->id }}</p>
                    <p class="font-bold text-gray-900 dark:text-white text-lg">
                        {{ $sale->customer_name ?? 'Walk-in' }}
                    </p>

                    <p class="text-indigo-600 dark:text-indigo-400 font-black text-xl mt-3">
                        ₱{{ number_format($sale->total_amount, 2) }}
                    </p>

                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-tighter mt-1">
                        {{ $sale->payment_method }}
                    </p>

                    <button 
                        onclick="openReceipt({{ $sale->id }})"
                        class="mt-5 w-full bg-indigo-600 hover:bg-indigo-700 text-white py-3 rounded-xl text-xs font-black uppercase tracking-widest transition-all active:scale-95 shadow-lg shadow-indigo-100 dark:shadow-none">
                        View Receipt
                    </button>

                </div>

            @endforeach

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
function openReceipt(id) {
    document.getElementById('receiptModal').classList.remove('hidden');

    fetch('/employee/receipt-data/' + id)
        .then(res => res.json())
        .then(data => {

            let html = `
                <p class="text-light">${new Date(data.sale.sale_date).toLocaleDateString('en-US', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                })}</p>
                <p class="font-bold text-gray-900 dark:text-white">Sale #${data.sale.id}</p>
                <p class="text-xs text-gray-500 mb-4">
                    Customer: ${data.sale.customer_name ?? 'Walk-in'}
                </p>

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

                <div class="flex justify-between text-lg font-black text-gray-900 dark:text-white">
                    <span>Total</span>
                    <span class="text-indigo-600">₱${total.toFixed(2)}</span>
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