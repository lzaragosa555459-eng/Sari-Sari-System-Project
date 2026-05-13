<x-employee-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Transactions') }}
            </h2>
            <div class="text-sm font-medium text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-900/30 px-3 py-1 rounded-full">
                Terminal Active
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

                <div class="lg:col-span-7 space-y-4">
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-lg font-bold text-gray-800 dark:text-white">Product Catalog</h2>
                            <span class="text-xs text-gray-500 uppercase tracking-widest font-semibold">Select items</span>
                        </div>

                        <div class="relative mb-6">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </span>
                            <input type="text"
                                   class="w-full pl-10 border-gray-200 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition-all"
                                   placeholder="Scan barcode or type product name...">
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 max-h-[600px] overflow-y-auto pr-2 custom-scrollbar">
                            @foreach($products as $product)
                                <div class="group flex justify-between items-center border border-gray-100 dark:border-gray-700 p-4 rounded-2xl hover:bg-indigo-50/50 dark:hover:bg-gray-700/50 transition duration-150">
                                    <div>
                                        <p class="font-bold text-gray-800 dark:text-gray-200 leading-tight">
                                            {{ $product->product_name }}
                                        </p>
                                        <p class="text-indigo-600 dark:text-indigo-400 font-bold text-lg">
                                            ₱{{ number_format($product->price, 2) }}
                                        </p>
                                        <p class="text-[10px] font-bold text-gray-400 uppercase mt-1">Stock: {{ $product->available_stock }}</p>
                                    </div>

                                    <form method="POST" action="{{ route('pos.add') }}" class="flex items-center gap-2">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <input
                                            type="number"
                                            name="quantity"
                                            min="1"
                                            max="{{ $product->available_stock }}"
                                            value="1"
                                            class="w-16 rounded-lg border-gray-200 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 text-sm font-bold"
                                        >
                                        <button class="bg-indigo-600 hover:bg-indigo-700 text-white p-2 rounded-lg shadow-md transition-all active:scale-90">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                              <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-5">
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 sticky top-6">
                        <div class="p-6 border-b dark:border-gray-700 flex justify-between items-center">
                            <h2 class="text-lg font-black text-gray-800 dark:text-white uppercase tracking-tight">Current Cart</h2>
                            <span class="bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 px-2 py-1 rounded text-xs font-bold">{{ count($cart) }} Items</span>
                        </div>

                        <div class="p-6">
                            @php $total = 0; @endphp
                            <div class="space-y-4 max-h-[350px] overflow-y-auto mb-6 custom-scrollbar">
                                @forelse($cart as $item)
                                    @php
                                        $subtotal = $item['price'] * $item['quantity'];
                                        $total += $subtotal;
                                    @endphp
                                    <div class="flex justify-between items-center group">
                                        <div class="flex-1">
                                            <p class="font-bold text-gray-800 dark:text-gray-200">{{ $item['name'] }}</p>
                                            <p class="text-xs text-gray-500 font-medium">
                                                ₱{{ number_format($item['price'], 2) }} × {{ $item['quantity'] }}
                                            </p>
                                        </div>
                                        <div class="text-right flex items-center gap-4">
                                            <p class="font-black text-gray-900 dark:text-white">₱{{ number_format($subtotal, 2) }}</p>
                                            <a href="{{ route('pos.remove', $item['id']) }}" class="text-gray-300 hover:text-red-500 transition-colors">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-10">
                                        <div class="bg-gray-50 dark:bg-gray-900/50 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                                            <svg class="h-8 w-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                        </div>
                                        <p class="text-gray-400 font-medium italic">Your cart is empty</p>
                                    </div>
                                @endforelse
                            </div>

                            <div class="border-t border-dashed dark:border-gray-700 pt-4 space-y-2">
                                <div class="flex justify-between text-gray-500 text-sm font-semibold uppercase tracking-wider">
                                    <span>Subtotal</span>
                                    <span>₱{{ number_format($total, 2) }}</span>
                                </div>
                                <div class="flex justify-between items-center pt-2">
                                    <span class="text-lg font-black text-gray-900 dark:text-white uppercase tracking-tighter">Total Amount</span>
                                    <span class="text-3xl font-black text-indigo-600 dark:text-indigo-400">₱{{ number_format($total, 2) }}</span>
                                </div>
                            </div>

                            <form method="POST" action="{{ route('pos.checkout') }}" class="mt-8 space-y-4">
                                @csrf
                                <div>
                                    <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest ml-1">Customer Selection</label>
                                    <select name="customer_id" class="w-full mt-1 border-gray-200 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-xl font-semibold">
                                        <option value="">Walk-in Customer</option>
                                    </select>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest ml-1">Amount Paid</label>
                                        <input type="number" name="amount_paid" step="0.01" class="w-full mt-1 border-gray-200 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-xl font-bold" placeholder="0.00">
                                    </div>
                                    <div>
                                        <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest ml-1">Payment Method</label>
                                        <select name="payment_method" class="w-full mt-1 border-gray-200 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-xl font-bold">
                                            <option value="cash">Cash</option>
                                            <option value="credit">Credit</option>
                                        </select>
                                    </div>
                                </div>

                                <button class="w-full bg-green-600 hover:bg-green-700 text-white font-black py-4 rounded-2xl shadow-lg shadow-green-200 dark:shadow-none transform transition active:scale-95 uppercase tracking-widest mt-2">
                                    Complete Transaction
                                </button>
                            </form>

                            <div class="flex justify-center mt-6">
                                <a href="{{ route('pos.clear') }}" class="text-xs text-gray-400 hover:text-red-500 transition-colors uppercase font-bold tracking-widest flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    Clear Cart
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(session('showReceipt'))
    <div id="receiptModal" class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm flex items-center justify-center z-50 p-4 no-print-bg">
        <div class="bg-white dark:bg-gray-900 w-full max-w-[380px] rounded-3xl shadow-2xl overflow-hidden transform transition-all">
            <div class="h-2 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500"></div>
            <div class="p-8">
                <div class="text-center mb-8">
                    <div class="inline-flex items-center justify-center w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-full mb-3">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-black text-gray-800 dark:text-white tracking-tight">Success!</h2>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mt-1">Transaction Completed</p>
                </div>

                <div class="flex justify-between items-end mb-6 pb-4 border-b border-dashed border-gray-200 dark:border-gray-700">
                    <div>
                        <p class="text-[10px] text-gray-400 uppercase font-bold tracking-tighter">Date</p>
                        <p class="text-xs font-mono text-gray-600 dark:text-gray-300">{{ now()->format('M d, Y • h:i A') }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-[10px] text-gray-400 uppercase font-bold tracking-tighter">Receipt #</p>
                        <p class="text-xs font-mono text-gray-600 dark:text-gray-300">{{ rand(100000, 999999) }}</p>
                    </div>
                </div>

                <div class="space-y-4 mb-8 max-h-48 overflow-y-auto pr-2 custom-scrollbar">
                    @foreach(session('receipt.items') as $item)
                    <div class="flex justify-between items-start text-sm">
                        <div class="flex-1">
                            <p class="font-bold text-gray-700 dark:text-gray-200 leading-tight">{{ $item['name'] }}</p>
                            <p class="text-xs text-gray-400 font-mono">Qty: {{ $item['quantity'] }}</p>
                        </div>
                        <span class="font-mono font-bold text-gray-900 dark:text-white">₱{{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                    </div>
                    @endforeach
                </div>

                <div class="bg-gray-50 dark:bg-gray-800/50 rounded-2xl p-5 space-y-3">
                    <div class="flex justify-between text-xs font-bold text-gray-500 uppercase">
                        <span>Subtotal</span>
                        <span>₱{{ number_format(session('receipt.subtotal'), 2) }}</span>
                    </div>
                    <div class="pt-2 border-t border-gray-200 dark:border-gray-700 flex justify-between items-center">
                        <span class="text-sm font-black text-gray-800 dark:text-white uppercase">Total</span>
                        <span class="text-xl font-black text-indigo-600">₱{{ number_format(session('receipt.total'), 2) }}</span>
                    </div>
                </div>

                <div class="mt-8 grid grid-cols-2 gap-3 no-print">
                    <button onclick="window.print()" class="flex items-center justify-center gap-2 bg-gray-900 text-white py-3 rounded-xl font-bold text-xs uppercase tracking-widest hover:opacity-90 transition-all active:scale-95">
                        Print
                    </button>
                    <button onclick="closeReceipt()" class="bg-gray-100 text-gray-500 py-3 rounded-xl font-bold text-xs uppercase tracking-widest hover:bg-gray-200 transition-all">
                        Done
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    <div
        x-data="{ open: {{ session('openCreditModal') ? 'true' : 'false' }} }"
        x-init="if(open) document.body.style.overflow='hidden'"
        x-show="open"
        x-cloak
        class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm flex items-center justify-center z-50 p-4"
    >
        <div class="bg-white dark:bg-gray-800 rounded-3xl w-full max-w-md shadow-2xl border border-gray-100 dark:border-gray-700 overflow-hidden transform transition-all" @click.away="open = false">
            <div class="p-8">
                <div class="mb-6">
                    <h2 class="text-2xl font-black text-gray-900 dark:text-white tracking-tight">Credit Details</h2>
                    <p class="text-sm text-gray-500 font-medium mt-1 uppercase tracking-widest text-[10px]">Information Required</p>
                </div>

                <form method="POST" action="{{ route('credit.store') }}" class="space-y-4">
                    @csrf
                    <input type="hidden" name="sale_id" value="{{ session('credit_checkout.sale_id') }}">

                    <div class="space-y-4">
                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1 ml-1">Customer Full Name</label>
                            <input type="text" name="customer_name" placeholder="Juan Dela Cruz" class="w-full bg-gray-50 dark:bg-gray-900 border-none rounded-xl p-3 font-semibold focus:ring-2 focus:ring-indigo-500 transition-all dark:text-white" required>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1 ml-1">Contact No.</label>
                                <input type="text" name="contact_number" placeholder="0912..." class="w-full bg-gray-50 dark:bg-gray-900 border-none rounded-xl p-3 font-semibold focus:ring-2 focus:ring-indigo-500 transition-all dark:text-white">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1 ml-1">Due Date</label>
                                <input type="date" name="due_date" class="w-full bg-gray-50 dark:bg-gray-900 border-none rounded-xl p-3 font-semibold focus:ring-2 focus:ring-indigo-500 transition-all dark:text-white" required>
                            </div>
                        </div>

                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1 ml-1">Address</label>
                            <textarea name="address" rows="2" placeholder="Street, City..." class="w-full bg-gray-50 dark:bg-gray-900 border-none rounded-xl p-3 font-semibold focus:ring-2 focus:ring-indigo-500 transition-all dark:text-white"></textarea>
                        </div>

                        <div class="p-4 bg-indigo-50 dark:bg-indigo-900/20 rounded-2xl">
                            <label class="block text-[10px] font-bold text-indigo-400 uppercase mb-1">Total Balance to Settle</label>
                            <input type="number" name="balance" value="{{ session('credit_checkout.total') }}" class="w-full bg-transparent border-none p-0 text-2xl font-black text-indigo-600 dark:text-indigo-400 focus:ring-0">
                        </div>
                    </div>

                    <div class="mt-8 flex gap-3">
                        <button type="button" @click="open = false" class="flex-1 py-4 bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-300 rounded-2xl font-bold uppercase tracking-widest text-xs hover:bg-gray-200 transition-all">
                            Cancel
                        </button>
                        <button class="flex-2 px-8 py-4 bg-indigo-600 text-white rounded-2xl font-bold uppercase tracking-widest text-xs shadow-lg shadow-indigo-200 dark:shadow-none hover:bg-indigo-700 transition-all active:scale-95">
                            Save Credit Record
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        @media print {
            .no-print { display: none !important; }
            .no-print-bg { background: white !important; backdrop-filter: none !important; }
            body * { visibility: hidden; }
            #receiptModal, #receiptModal * { visibility: visible; }
            #receiptModal { position: absolute; left: 0; top: 0; width: 100%; border: none; }
        }
        .custom-scrollbar::-webkit-scrollbar { width: 5px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #e5e7eb; border-radius: 10px; }
        .dark .custom-scrollbar::-webkit-scrollbar-thumb { background: #374151; }
    </style>

    <script>
    function closeReceipt() {
        const modal = document.getElementById('receiptModal');
        if(modal) modal.remove();
    }
    </script>
</x-employee-app-layout>