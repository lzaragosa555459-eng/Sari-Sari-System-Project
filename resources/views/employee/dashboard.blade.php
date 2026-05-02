<x-employee-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Employee Dashboard') }}
            </h2>
            <span class="text-sm text-gray-500 dark:text-gray-400">
                {{ now()->format('l, F j, Y') }}
            </span>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-blue-500 p-6">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Today's Sales</p>
                    <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">
                        ₱{{ number_format($todaySales->total ?? 0, 2) }}
                    </p>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-purple-500 p-6">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Transactions</p>
                    <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">
                        {{ $todayTransactions->total }}
                    </p>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-green-500 p-6">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Cash on Hand</p>
                    <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">
                        ₱{{ number_format($cashSales->total ?? 0, 2) }}
                    </p>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Your Recent Sales</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th class="px-6 py-3">Customer</th>
                                    <th class="px-6 py-3">Total Amount</th>
                                    <th class="px-6 py-3">Payment Method</th>
                                    <th class="px-6 py-3 text-right">Time</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($recentSales as $sale)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                        {{ $sale->customer_name }}
                                    </td>
                                    <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                                        ₱{{ number_format($sale->total_amount, 2) }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-1 text-xs rounded bg-gray-100 dark:bg-gray-900">
                                            {{ $sale->payment_method }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        {{ \Carbon\Carbon::parse($sale->sale_date)->diffForHumans() }}
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                                        No sales recorded yet today.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{-- $recentSales->links() --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-employee-app-layout>