<x-customer-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-gray-900 dark:text-white tracking-tight">
                {{ __('Place Order') }}
            </h2>

            <a href="{{ route('customer.cart.index') }}"
               class="relative inline-flex items-center px-5 py-2.5 text-sm font-medium text-center text-white bg-indigo-600 rounded-xl hover:bg-indigo-700 focus:ring-4 focus:outline-none focus:ring-indigo-300 transition-all">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                View Cart
                @if(session('cart') && count(session('cart')) > 0)
                    <span class="absolute inline-flex items-center justify-center w-6 h-6 text-xs font-bold text-white bg-red-500 border-2 border-white rounded-full -top-2 -right-2 dark:border-gray-900">
                        {{ count(session('cart')) }}
                    </span>
                @endif
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            {{-- Modern Search Bar --}}
            <div class="max-w-2xl mx-auto">
                <form method="GET" action="{{ route('order') }}" class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}"
                           class="block w-full p-4 pl-12 text-sm text-gray-900 border border-gray-200 rounded-2xl bg-white focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:placeholder-gray-400" 
                           placeholder="Search for items...">
                    <button type="submit" 
                            class="text-white absolute right-2.5 bottom-2.5 bg-indigo-600 hover:bg-indigo-700 focus:ring-4 focus:outline-none focus:ring-indigo-300 font-medium rounded-xl text-sm px-4 py-2 transition-all">
                        Search
                    </button>
                </form>
            </div>

            {{-- Product Grid --}}
            @if(count($products))
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">

                    @foreach($products as $product)
                        <div class="group bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-5 transition-all hover:shadow-xl hover:-translate-y-1">
                            
                            {{-- Icon Placeholder (Like the Cart) --}}
                            <div class="w-full h-40 bg-gray-50 dark:bg-gray-900/50 rounded-xl flex items-center justify-center mb-5 group-hover:bg-indigo-50 dark:group-hover:bg-indigo-900/20 transition-colors">
                                <span class="text-5xl transform group-hover:scale-110 transition-transform">📦</span>
                            </div>

                            <div class="space-y-2">
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white line-clamp-1">
                                    {{ $product->name }}
                                </h3>
                                
                                <div class="flex items-center justify-between">
                                    <span class="text-xs font-bold uppercase tracking-wider text-gray-400">Availability</span>
                                    <span class="text-sm {{ ($product->quantity_on_hand ?? 0) > 0 ? 'text-emerald-500 font-medium' : 'text-red-500' }}">
                                        {{ $product->quantity_on_hand ?? 0 }} in stock
                                    </span>
                                </div>

                                <div class="pt-2">
                                    <p class="text-2xl font-black text-indigo-600 dark:text-indigo-400">
                                        ₱{{ number_format($product->price, 2) }}
                                    </p>
                                </div>

                                {{-- Add to Cart Form --}}
                                <form action="{{ route('customer.cart.store') }}" method="POST" class="mt-4 space-y-3">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    
                                    <div class="flex items-center bg-gray-50 dark:bg-gray-900 rounded-lg p-1 border border-gray-200 dark:border-gray-700">
                                        <label class="px-3 text-xs font-bold text-gray-400 uppercase">Qty</label>
                                        <input type="number" name="quantity" min="1" 
                                               max="{{ $product->quantity_on_hand ?? 1 }}" value="1"
                                               class="w-full border-none bg-transparent focus:ring-0 text-right font-bold text-gray-900 dark:text-white">
                                    </div>

                                    <button type="submit"
                                            class="w-full flex items-center justify-center bg-gray-900 dark:bg-indigo-600 hover:bg-gray-800 dark:hover:bg-indigo-700 text-white font-bold py-3 px-4 rounded-xl transition-all active:scale-95">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                        Add to Cart
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach

                </div>
            @else
                <div class="text-center py-20 bg-white dark:bg-gray-800 rounded-2xl border border-dashed border-gray-300 dark:border-gray-700">
                    <p class="text-gray-500 text-lg">No products match your search.</p>
                    <a href="{{ route('order') }}" class="text-indigo-600 font-medium hover:underline mt-2 inline-block">Clear filters</a>
                </div>
            @endif

        </div>
    </div>
</x-customer-app-layout>