<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Credit Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th class="px-6 py-4">Credit ID</th>
                                    <th class="px-6 py-4">Customer</th>
                                    <th class="px-6 py-4">Total Amount</th>
                                    <th class="px-6 py-4">Amount paid</th>
                                    <th class="px-6 py-4">Balance</th>
                                    <th class="px-6 py-4">Due Date</th>
                                    <th class="px-6 py-4 text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($credits as $credit)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                    <td class="px-6 py-4 font-mono text-xs text-gray-400">#{{ $credit->id }}</td>
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                        {{ $credit->customer_name }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-600 dark:text-gray-300">
                                        ₱{{ number_format($credit->total_amount, 2) }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-600 dark:text-gray-300">
                                        ₱{{ number_format($credit->amount_paid, 2) }}
                                    </td>
                                    <td class="px-6 py-4 font-bold text-gray-900 dark:text-white">
                                        ₱{{ number_format($credit->balance, 2) }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="{{ strtotime($credit->due_date) < time() && $credit->balance > 0 ? 'text-red-500 font-semibold' : '' }}">
                                            {{ \Carbon\Carbon::parse($credit->due_date)->format('M d, Y') }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if ($credit->balance <= 0)
                                            <span class="px-3 py-1 text-xs font-bold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                                Paid
                                            </span>
                                        @elseif (strtotime($credit->due_date) < time())
                                            <span class="px-3 py-1 text-xs font-bold rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200 animate-pulse">
                                                Overdue
                                            </span>
                                        @else
                                            <span class="px-3 py-1 text-xs font-bold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                                Active
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-10 text-center text-gray-500 italic">
                                        No credit records found.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>