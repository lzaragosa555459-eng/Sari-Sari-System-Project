<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Inventory Management') }}
            </h2>
            <button
                x-data
                x-on:click="$dispatch('open-modal', 'add-product')"
                class="text-blue-500 hover:text-blue-700 transition duration-300"
            >
                + Add Product
            </button>
        </div>
  
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border-b-4 border-blue-500">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 bg-blue-100 dark:bg-blue-900 rounded-full">
                                <svg class="w-6 h-6 text-blue-600 dark:text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase">Total Products</p>
                                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $totalProducts->total }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border-b-4 border-yellow-500">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 bg-yellow-100 dark:bg-yellow-900 rounded-full">
                                <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase">Low Stock</p>
                                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $lowStock->total }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border-b-4 border-red-600">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 bg-red-100 dark:bg-red-900 rounded-full">
                                <svg class="w-6 h-6 text-red-600 dark:text-red-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase">Out of Stock</p>
                                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $outOfStock->total }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg overflow-hidden">
                <div class="p-6 overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th class="px-6 py-4">Product</th>
                                <th class="px-6 py-4">Category</th>
                                <th class="px-6 py-4">Brand</th>
                                <th class="px-6 py-4">Price</th>
                                <th class="px-6 py-4">Stock</th>
                                <th class="px-6 py-4">Reorder</th>
                                <th class="px-6 py-4">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach ($products as $product)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ $product->product_name }}</td>
                                <td class="px-6 py-4">{{ $product->category_name }}</td>
                                <td class="px-6 py-4">{{ $product->brand_name }}</td>
                                <td class="px-6 py-4 text-gray-900 dark:text-white font-semibold">₱{{ number_format($product->price, 2) }}</td>
                                <td class="px-6 py-4">{{ $product->quantity_on_hand }}</td>
                                <td class="px-6 py-4 text-xs">{{ $product->reorder_level }}</td>
                                <td class="px-6 py-4">
                                    @if ($product->quantity_on_hand <= 0)
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">Out of Stock</span>
                                    @elseif ($product->quantity_on_hand <= $product->reorder_level)
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">Low Stock</span>
                                    @else
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">In Stock</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
<x-modal name="add-product" :show="false" focusable>
    <div class="relative overflow-hidden bg-white p-0 sm:rounded-2xl">
        <div class="border-b border-gray-100 px-8 py-6">
            <h2 class="text-xl font-bold tracking-tight text-gray-900">
                Add New Product
            </h2>
            <p class="mt-1 text-sm leading-6 text-gray-500">
                Enter the details to list a new item in your inventory.
            </p>
        </div>

        <form method="POST" action="{{ route('products.store') }}" class="px-8 py-6">
            @csrf

            <div class="space-y-6">

                <!-- Product Name -->
                <div>
                    <label class="block text-sm font-semibold text-gray-900">
                        Product Name
                    </label>
                    <input
                        type="text"
                        name="product_name"
                        class="w-full rounded-lg border-gray-300 shadow-sm"
                        required
                    >
                </div>

                <!-- Price -->
                <div>
                    <label class="block text-sm font-semibold text-gray-900">
                        Price
                    </label>
                    <input
                        type="number"
                        step="0.01"
                        name="price"
                        class="w-full rounded-lg border-gray-300 shadow-sm"
                        required
                    >
                </div>

                <!-- Brand & Category -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                    <!-- Brand -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-900">
                            Brand
                        </label>
                        <select name="brand_id" class="w-full rounded-lg border-gray-300 shadow-sm" required>
                            <option value="" disabled selected>Select Brand</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}">
                                    {{ $brand->brand_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Category -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-900">
                            Category
                        </label>
                        <select name="category_id" class="w-full rounded-lg border-gray-300 shadow-sm" required>
                            <option value="" disabled selected>Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">
                                    {{ $category->category_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Expiration Date (optional) -->
                <div>
                    <label class="block text-sm font-semibold text-gray-900">
                        Expiration Date
                    </label>
                    <input
                        type="date"
                        name="expiration_date"
                        class="w-full rounded-lg border-gray-300 shadow-sm"
                    >
                </div>
                <!-- Initial quantity (optional) -->
                <div>
                    <label class="block text-sm font-semibold text-gray-900">
                        Initial Stock
                    </label>
                    <input
                        type="number"
                        name="initial_stock"
                        class="w-full rounded-lg border-gray-300 shadow-sm"
                    >
                </div>
            </div>

            <!-- Buttons -->
            <div class="mt-8 flex justify-end gap-3 border-t pt-6">
                <button type="button" x-on:click="$dispatch('close')" class="text-gray-600">
                    Cancel
                </button>

                <button type="submit" class="bg-indigo-600 text-white px-5 py-2 rounded-lg">
                    Save Product
                </button>
            </div>
        </form>
    </div>
</x-modal>
</x-app-layout>