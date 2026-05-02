<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Sales Transactions') }}
            </h2>
            </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th class="px-4 py-3">ID</th>
                                    <th class="px-4 py-3">Date</th>
                                    <th class="px-4 py-3">Customer</th>
                                    <th class="px-4 py-3">Employee</th>
                                    <th class="px-4 py-3">Total</th>
                                    <th class="px-4 py-3">Paid</th>
                                    <th class="px-4 py-3">Change</th>
                                    <th class="px-4 py-3 text-center">Method</th>
                                    <th class="px-4 py-3 text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach ($sales as $sale)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                    <td class="px-4 py-4 font-mono text-xs text-gray-400">#{{ $sale->id }}</td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        {{ \Carbon\Carbon::parse($sale->sale_date)->format('M d, Y') }}
                                    </td>
                                    <td class="px-4 py-4 font-medium text-gray-900 dark:text-white">
                                        {{ $sale->customer_name ?? 'Walk-in' }}
                                    </td>
                                    <td class="px-4 py-4">{{ $sale->employee_name }}</td>
                                    <td class="px-4 py-4 font-semibold text-gray-900 dark:text-white">
                                        ₱{{ number_format($sale->total_amount, 2) }}
                                    </td>
                                    <td class="px-4 py-4 text-green-600 dark:text-green-400">
                                        ₱{{ number_format($sale->amount_paid, 2) }}
                                    </td>
                                    <td class="px-4 py-4">
                                        ₱{{ number_format($sale->change, 2) }}
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        <span class="px-2 py-1 bg-gray-100 dark:bg-gray-700 rounded text-xs uppercase font-bold">
                                            {{ $sale->payment_method }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 text-right">
                                        <a href="/sales/{{ $sale->id }}" 
                                           class="inline-flex items-center px-3 py-1.5 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                                            View Items
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4">
                        {{-- $sales->links() --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>