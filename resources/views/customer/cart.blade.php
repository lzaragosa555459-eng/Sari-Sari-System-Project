<x-customer-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-gray-900 dark:text-white tracking-tight">
                {{ __('Shopping Cart') }}
            </h2>
            <a href="{{ route('order') }}"
               class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-indigo-600 transition-colors">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                Continue Shopping
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            @if(count($cart))
                <div class="bg-white dark:bg-gray-800 shadow-xl rounded-2xl overflow-hidden border border-gray-100 dark:border-gray-700">
                    
                    <div class="divide-y divide-gray-100 dark:divide-gray-700">
                        @foreach($cart as $id => $item)
                            <div class="p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                <div class="flex items-center space-x-4">
                                    <div class="h-16 w-16 bg-gray-100 dark:bg-gray-700 rounded-lg flex-shrink-0 flex items-center justify-center">
                                        <span class="text-2xl">📦</span>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $item['name'] }}</h3>
                                        <p class="text-sm text-gray-500 italic">Unit Price: ₱{{ number_format($item['price'], 2) }}</p>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between sm:justify-end space-x-8">
                                    <div class="text-center">
                                        <span class="block text-xs uppercase tracking-wider text-gray-400 font-bold">Qty</span>
                                        <span class="text-gray-700 dark:text-gray-200 font-medium">{{ $item['quantity'] }}</span>
                                    </div>
                                    <div class="text-right">
                                        <span class="block text-xs uppercase tracking-wider text-gray-400 font-bold">Subtotal</span>
                                        <span class="text-indigo-600 dark:text-indigo-400 font-bold text-lg">₱{{ number_format($item['subtotal'], 2) }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-900/50 p-8 border-t border-gray-100 dark:border-gray-700">
                        <div class="flex flex-col items-end space-y-4">
                            <div class="flex justify-between w-full max-w-xs">
                                <span class="text-gray-500">Order Total:</span>
                                <span class="text-2xl font-black text-gray-900 dark:text-white">₱{{ number_format($total, 2) }}</span>
                            </div>

                            <div class="flex items-center space-x-4 w-full justify-end">
                                <form action="{{ route('cart-clear') }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this order and empty your cart?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-sm font-semibold text-red-500 hover:text-red-700 px-4 py-2 transition-all">
                                        Cancel Session
                                    </button>
                                </form>

                                <form action="{{ route('customer.cart.checkout') }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="inline-flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-xl text-white bg-indigo-600 hover:bg-indigo-700 shadow-lg shadow-indigo-200 dark:shadow-none transition-all transform hover:-translate-y-0.5">
                                        Checkout Now
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-20 bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-dashed border-gray-300 dark:border-gray-700">
                    <div class="text-6xl mb-4">🛒</div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">Your cart is empty</h3>
                    <p class="text-gray-500 mt-2">Looks like you haven't added anything to your cart yet.</p>
                    <a href="{{ route('order') }}" class="mt-6 inline-block text-indigo-600 font-semibold hover:underline">Go discover products →</a>
                </div>
            @endif

        </div>
    </div>
</x-customer-app-layout>