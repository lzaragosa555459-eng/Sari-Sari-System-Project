<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Maintenance') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- BRANDS --}}
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-2xl p-6 border border-gray-100 dark:border-gray-700">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="text-lg font-black text-gray-900 dark:text-white uppercase tracking-tight">Brands</h3>
                        <p class="text-xs text-gray-500">Manage product manufacturers and brand names.</p>
                    </div>
                    <button class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-[10px] font-black uppercase tracking-widest rounded-xl transition-all active:scale-95 shadow-md shadow-indigo-100 dark:shadow-none">
                        + Add Brand
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-[10px] uppercase tracking-widest font-black text-gray-400 bg-gray-50 dark:bg-gray-700/50">
                            <tr>
                                <th class="px-4 py-3">ID</th>
                                <th class="px-4 py-3">Brand Name</th>
                                <th class="px-4 py-3">Created</th>
                                <th class="px-4 py-3 text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @foreach($brands as $brand)
                                <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-700/30 transition-colors">
                                    <td class="px-4 py-4 font-mono text-xs text-gray-400">#{{ $brand->id }}</td>
                                    <td class="px-4 py-4 font-bold text-gray-900 dark:text-white">{{ $brand->brand_name }}</td>
                                    <td class="px-4 py-4 text-gray-500 text-xs">{{ \Carbon\Carbon::parse($brand->created_at)->format('M d, Y') }}</td>
                                    <td class="px-4 py-4 text-right space-x-2">
                                        <button class="text-indigo-600 hover:text-indigo-900 font-bold text-xs uppercase tracking-tighter">Edit</button>
                                        <button class="text-red-600 hover:text-red-900 font-bold text-xs uppercase tracking-tighter">Delete</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $brands->links() }}
                </div>
            </div>

            {{-- CATEGORIES --}}
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-2xl p-6 border border-gray-100 dark:border-gray-700">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="text-lg font-black text-gray-900 dark:text-white uppercase tracking-tight">Categories</h3>
                        <p class="text-xs text-gray-500">Organize your inventory by groupings.</p>
                    </div>
                    <button class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-[10px] font-black uppercase tracking-widest rounded-xl transition-all active:scale-95">
                        + Add Category
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-[10px] uppercase tracking-widest font-black text-gray-400 bg-gray-50 dark:bg-gray-700/50">
                            <tr>
                                <th class="px-4 py-3">ID</th>
                                <th class="px-4 py-3">Category Name</th>
                                <th class="px-4 py-3 text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @foreach($categories as $cat)
                                <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-700/30 transition-colors">
                                    <td class="px-4 py-4 font-mono text-xs text-gray-400">#{{ $cat->id }}</td>
                                    <td class="px-4 py-4 font-bold text-gray-900 dark:text-white">{{ $cat->category_name }}</td>
                                    <td class="px-4 py-4 text-right space-x-2">
                                        <button class="text-indigo-600 hover:text-indigo-900 font-bold text-xs uppercase tracking-tighter">Edit</button>
                                        <button class="text-red-600 hover:text-red-900 font-bold text-xs uppercase tracking-tighter">Delete</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $categories->links() }}
                </div>
            </div>

            {{-- SUPPLIERS --}}
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-2xl p-6 border border-gray-100 dark:border-gray-700">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="text-lg font-black text-gray-900 dark:text-white uppercase tracking-tight">Suppliers</h3>
                        <p class="text-xs text-gray-500">Contact information for your vendors.</p>
                    </div>
                    <button class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-[10px] font-black uppercase tracking-widest rounded-xl transition-all active:scale-95">
                        + Add Supplier
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-[10px] uppercase tracking-widest font-black text-gray-400 bg-gray-50 dark:bg-gray-700/50">
                            <tr>
                                <th class="px-4 py-3">Supplier</th>
                                <th class="px-4 py-3">Contact</th>
                                <th class="px-4 py-3">Address</th>
                                <th class="px-4 py-3 text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @foreach($suppliers as $sup)
                                <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-700/30 transition-colors">
                                    <td class="px-4 py-4">
                                        <div class="font-bold text-gray-900 dark:text-white">{{ $sup->supplier_name }}</div>
                                        <div class="text-[10px] text-gray-400 font-mono">ID: #{{ $sup->id }}</div>
                                    </td>
                                    <td class="px-4 py-4 text-gray-600 dark:text-gray-400 font-medium">{{ $sup->contact_number }}</td>
                                    <td class="px-4 py-4 text-gray-500 text-xs max-w-xs truncate">{{ $sup->address }}</td>
                                    <td class="px-4 py-4 text-right space-x-2">
                                        <button class="text-indigo-600 hover:text-indigo-900 font-bold text-xs uppercase tracking-tighter">Edit</button>
                                        <button class="text-red-600 hover:text-red-900 font-bold text-xs uppercase tracking-tighter">Delete</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $suppliers->links() }}
                </div>
            </div>
        </div>
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        {{-- SUPPLIER PRODUCTS --}}
        <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-2xl p-6 border border-gray-100 dark:border-gray-700">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h3 class="text-lg font-black text-gray-900 dark:text-white uppercase tracking-tight">Supplier Product Catalog</h3>
                    <p class="text-xs text-gray-500">Mapping products to their respective suppliers and costs.</p>
                </div>
                <button class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-[10px] font-black uppercase tracking-widest rounded-xl transition-all active:scale-95 shadow-md shadow-indigo-100 dark:shadow-none">
                    + Add Product Entry
                </button>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-[10px] uppercase tracking-widest font-black text-gray-400 bg-gray-50 dark:bg-gray-700/50">
                        <tr>
                            <th class="px-4 py-3">Supplier</th>
                            <th class="px-4 py-3">Product</th>
                            <th class="px-4 py-3">Cost Price</th>
                            <th class="px-4 py-3">Lead Time</th>
                            <th class="px-4 py-3 text-right">Action</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @foreach($supplierProducts as $sp)
                        <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-700/30 transition-colors">
                            <td class="px-4 py-4 font-bold text-gray-900 dark:text-white">
                                {{ $sp->supplier_name }}
                            </td>
                            <td class="px-4 py-4 text-gray-600 dark:text-gray-400">
                                {{ $sp->product_name }}
                            </td>
                            <td class="px-4 py-4">
                                <span class="px-2 py-1 bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-400 rounded-md font-bold text-xs">
                                    ₱{{ number_format($sp->cost_price, 2) }}
                                </span>
                            </td>
                            <td class="px-4 py-4 text-gray-500 text-xs">
                                <span class="font-medium text-gray-700 dark:text-gray-300">{{ $sp->lead_time }}</span> days
                            </td>

                            <td class="px-4 py-4 text-right space-x-3">
                                <button class="text-indigo-600 hover:text-indigo-900 font-bold text-xs uppercase tracking-tighter transition-colors">
                                    Edit
                                </button>
                                <button class="text-red-600 hover:text-red-900 font-bold text-xs uppercase tracking-tighter transition-colors">
                                    Delete
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
    </div>
</x-app-layout>