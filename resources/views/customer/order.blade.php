<x-customer-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">

            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Place Order') }}
            </h2>

            <a href="{{ route('customer.cart.index') }}"
            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                View Cart
            </a>

        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Search --}}
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                <form method="GET" action="{{ route('order') }}">
                    <div class="flex gap-4">
                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Search products..."
                            class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white"
                        >

                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md">
                            Search
                        </button>
                    </div>
                </form>
            </div>

            {{-- Products --}}
            @if(count($products))
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

                    @foreach($products as $product)
                        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">

                            <img src="https://via.placeholder.com/300x200"
                                 class="w-full h-40 object-cover rounded mb-4">

                            {{-- PRODUCT NAME (RAW SQL SAFE) --}}
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                                {{ $product->name }}
                            </h3>

                            {{-- STOCK --}}
                            <p class="text-sm text-gray-500 mt-1">
                                Stock: {{ $product->quantity_on_hand ?? 0 }}
                            </p>

                            {{-- PRICE --}}
                            <p class="text-blue-600 font-bold text-xl mt-2">
                                ₱{{ number_format($product->price, 2) }}
                            </p>

                            {{-- ADD TO CART --}}
                            <form action="{{ route('customer.cart.store') }}" method="POST" class="mt-4">
                                @csrf

                                <input type="hidden" name="product_id" value="{{ $product->id }}">

                                <input type="number"
                                       name="quantity"
                                       min="1"
                                       max="{{ $product->quantity_on_hand ?? 1 }}"
                                       value="1"
                                       class="w-full rounded border-gray-300 dark:bg-gray-900 dark:text-white">

                                <button type="submit"
                                        class="w-full mt-3 bg-green-600 hover:bg-green-700 text-white py-2 rounded">
                                    Add to Cart
                                </button>
                            </form>

                        </div>
                    @endforeach

                </div>
            @else
                <p class="text-center text-gray-500">No products found.</p>
            @endif

        </div>
    </div>
</x-customer-app-layout>