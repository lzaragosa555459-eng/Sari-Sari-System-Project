<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Inventory Movements
            </h2>

            <a href="{{ route('inventory') }}"
               class="text-blue-500 hover:text-blue-700 transition duration-300">
                ← Back to Inventory
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <!-- STOCK IN TABLE -->
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-bold text-green-600 dark:text-green-400">
                        Stock In History
                    </h3>
                    <p class="text-sm text-gray-500">
                        Records of products added to inventory.
                    </p>
                </div>

                <div class="p-6 overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-green-50 dark:bg-green-900/20 dark:text-gray-400">
                            <tr>
                                <th class="px-6 py-4">Date & Time</th>
                                <th class="px-6 py-4">Product</th>
                                <th class="px-6 py-4">Quantity</th>
                                <th class="px-6 py-4">Reference Type</th>
                                <th class="px-6 py-4">Reference ID</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @php
                                $stockIn = collect($movements)
                                    ->where('movement_type', 'Stock In');
                            @endphp

                            @forelse ($stockIn as $movement)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                    <td class="px-6 py-4">
                                        {{ \Carbon\Carbon::parse($movement->movement_date)->format('M d, Y h:i A') }}
                                    </td>

                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                        {{ $movement->product_name }}
                                    </td>

                                    <td class="px-6 py-4 font-semibold text-green-600 dark:text-green-400">
                                        +{{ $movement->quantity }}
                                    </td>

                                    <td class="px-6 py-4">
                                        {{ ucfirst($movement->reference_type) }}
                                    </td>

                                    <td class="px-6 py-4">
                                        {{ $movement->reference_id }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                        No stock in records found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- STOCK OUT TABLE -->
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-bold text-red-600 dark:text-red-400">
                        Stock Out History
                    </h3>
                    <p class="text-sm text-gray-500">
                        Records of products removed from inventory.
                    </p>
                </div>

                <div class="p-6 overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-red-50 dark:bg-red-900/20 dark:text-gray-400">
                            <tr>
                                <th class="px-6 py-4">Date</th>
                                <th class="px-6 py-4">Product</th>
                                <th class="px-6 py-4">Quantity</th>
                                <th class="px-6 py-4">Reference Type</th>
                                <th class="px-6 py-4">Reference ID</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @php
                                $stockOut = collect($movements)
                                    ->where('movement_type', 'Stock Out');
                            @endphp

                            @forelse ($stockOut as $movement)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                    <td class="px-6 py-4">
                                         {{ \Carbon\Carbon::parse($movement->movement_date)->format('M d, Y h:i A') }}
                                    </td>

                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                        {{ $movement->product_name }}
                                    </td>

                                    <td class="px-6 py-4 font-semibold text-red-600 dark:text-red-400">
                                        -{{ $movement->quantity }}
                                    </td>

                                    <td class="px-6 py-4">
                                        {{ ucfirst($movement->reference_type) }}
                                    </td>

                                    <td class="px-6 py-4">
                                        {{ $movement->reference_id }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                        No stock out records found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>