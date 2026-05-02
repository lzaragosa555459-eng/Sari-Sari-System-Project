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
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-lg font-bold text-gray-800 dark:text-white">Product Catalog</h2>
                            <span class="text-xs text-gray-500 uppercase tracking-widest">Select items to add</span>
                        </div>

                        <div class="relative mb-6">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </span>
                            <input type="text"
                                   class="w-full pl-10 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                   placeholder="Scan barcode or type product name...">
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 max-h-[600px] overflow-y-auto pr-2">
                            @foreach($products as $product)
                                <div class="group flex justify-between items-center border dark:border-gray-700 p-4 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700/50 transition duration-150">
                                    <div>
                                        <p class="font-bold text-gray-800 dark:text-gray-200">
                                            {{ $product->product_name }}
                                        </p>
                                        <p class="text-indigo-600 dark:text-indigo-400 font-semibold">
                                            ₱{{ number_format($product->price, 2) }}
                                        </p>
                                        <p class="text-[10px] text-gray-400 uppercase mt-1">Stock: {{ $product->quantity_on_hand }}</p>
                                    </div>

                                    <form method="POST" action="{{ route('pos.add') }}">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <button class="bg-indigo-600 hover:bg-indigo-700 text-white p-2 rounded-lg shadow-md transition-all active:scale-95">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-5">
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 sticky top-6">
                        <div class="p-6 border-b dark:border-gray-700">
                            <h2 class="text-xl font-black text-gray-800 dark:text-white uppercase tracking-tight">Current Cart</h2>
                        </div>

                        <div class="p-6">
                            @php $total = 0; @endphp
                            <div class="space-y-4 max-h-[400px] overflow-y-auto mb-6">
                                @forelse($cart as $item)
                                    @php
                                        $subtotal = $item['price'] * $item['quantity'];
                                        $total += $subtotal;
                                    @endphp
                                    <div class="flex justify-between items-start">
                                        <div class="flex-1">
                                            <p class="font-bold text-gray-800 dark:text-gray-200">{{ $item['name'] }}</p>
                                            <p class="text-xs text-gray-500">
                                                ₱{{ number_format($item['price'], 2) }} × {{ $item['quantity'] }}
                                            </p>
                                        </div>
                                        <div class="text-right">
                                            <p class="font-bold text-gray-900 dark:text-white">₱{{ number_format($subtotal, 2) }}</p>
                                            <a href="{{ route('pos.remove', $item['id']) }}" class="text-[10px] text-red-500 hover:underline uppercase font-bold">Remove</a>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-10">
                                        <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                        <p class="mt-2 text-gray-500 italic">Cart is empty</p>
                                    </div>
                                @endforelse
                            </div>

                            <div class="border-t dark:border-gray-700 pt-4 space-y-2">
                                <div class="flex justify-between text-gray-600 dark:text-gray-400">
                                    <span>Subtotal</span>
                                    <span>₱{{ number_format($total, 2) }}</span>
                                </div>
                                <div class="flex justify-between text-2xl font-black text-indigo-600 dark:text-indigo-400 border-t dark:border-gray-700 pt-2">
                                    <span>TOTAL</span>
                                    <span>₱{{ number_format($total, 2) }}</span>
                                </div>
                            </div>

                            <form method="POST" action="{{ route('pos.checkout') }}" class="mt-8 space-y-4">
                                @csrf
                                
                                <div>
                                    <label class="text-xs font-bold text-gray-500 uppercase">Customer</label>
                                    <select name="customer_id" class="w-full mt-1 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-lg shadow-sm">
                                        <option value="">Walk-in Customer</option>
                                        @foreach($customers ?? [] as $customer)
                                            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="text-xs font-bold text-gray-500 uppercase">Amount Paid</label>
                                        <input type="number" name="amount_paid" step="0.01" class="w-full mt-1 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-lg" placeholder="0.00">
                                    </div>
                                    <div>
                                        <label class="text-xs font-bold text-gray-500 uppercase">Method</label>
                                        <select name="payment_method" class="w-full mt-1 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-lg">
                                            <option value="cash">Cash</option>
                                            <option value="credit">Credit</option>
                                        </select>
                                    </div>
                                </div>

                                <button class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-4 rounded-xl shadow-lg transform transition active:scale-95 uppercase tracking-widest">
                                    Complete Checkout
                                </button>
                            </form>

                            <div class="flex justify-center mt-4">
                                <a href="{{ route('pos.clear') }}" class="text-xs text-gray-400 hover:text-red-500 transition-colors uppercase font-bold tracking-tighter">
                                    Cancel & Clear Cart
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-employee-app-layout>