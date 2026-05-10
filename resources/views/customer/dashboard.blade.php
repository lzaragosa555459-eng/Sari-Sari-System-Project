<x-customer-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-gray-800 dark:text-white tracking-tight">
                {{ __('Dashboard') }}
            </h2>
            <span
                class="text-sm font-medium px-3 py-1 bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300 rounded-full">
                Customer Account
            </span>
        </div>
    </x-slot>

    <div class="py-10 antialiased">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">

            {{-- Welcome Hero Section --}}
            <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-blue-600 to-indigo-700 p-8 shadow-lg">
                <div class="relative z-10">
                    <h3 class="text-3xl font-extrabold text-white">
                        Welcome back, {{ Auth::user()->name }}!
                    </h3>
                    <p class="text-indigo-100 mt-2 max-w-md text-lg">
                        You have
                        <span class="font-semibold text-white">
                            {{ $pendingTasks }} pending {{ $pendingTasks == 1 ? 'task' : 'tasks' }}
                        </span>.
                    </p>
                    <div class="mt-6 flex gap-3">
                        <a href="#"
                            class="inline-flex items-center px-4 py-2 bg-white text-blue-700 text-sm font-bold rounded-xl hover:bg-blue-50 transition-colors shadow-sm">
                            View Statements
                        </a>
                    </div>
                </div>

                {{-- Decorative Background Elements --}}
                <div class="absolute top-0 right-0 -mt-4 -mr-4 h-64 w-64 rounded-full bg-white/10 blur-3xl"></div>
                <div class="absolute bottom-0 right-10 -mb-8 h-40 w-40 rounded-full bg-indigo-400/20 blur-2xl"></div>
            </div>

            {{-- Modern Metric Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Credit Balance Card --}}
                <div
                    class="bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-2xl p-6 shadow-sm hover:shadow-md transition">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-2 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                                </path>
                            </svg>
                        </div>

                        <span
                            class="text-xs font-bold {{ $creditBalance > 0
                                ? 'text-amber-600 bg-amber-50 dark:bg-amber-900/20 dark:text-amber-400'
                                : 'text-green-600 bg-green-50 dark:bg-green-900/20 dark:text-green-400' }} px-2 py-1 rounded-md">
                            {{ $creditBalance > 0 ? 'Outstanding' : 'No Balance' }}
                        </span>
                    </div>

                    <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">
                        Credit Balance
                    </h4>

                    <p class="text-3xl font-bold text-gray-900 dark:text-white mt-1">
                        ₱{{ number_format($creditBalance, 2) }}
                    </p>
                </div>

                {{-- Total Purchases Card --}}
                <div
                    class="bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-2xl p-6 shadow-sm hover:shadow-md transition">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-2 bg-emerald-50 dark:bg-emerald-900/20 rounded-lg">
                            <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z">
                                </path>
                            </svg>
                        </div>

                        <span
                            class="text-xs font-bold text-blue-500 bg-blue-50 dark:bg-blue-900/20 dark:text-blue-400 px-2 py-1 rounded-md">
                            All Time
                        </span>
                    </div>

                    <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">
                        Total Purchases
                    </h4>

                    <p class="text-3xl font-bold text-gray-900 dark:text-white mt-1">
                        {{ $totalPurchases }}
                    </p>
                </div>
            </div>

            {{-- Recent Transactions --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                        Recent Transactions
                    </h3>
                    <a href="#"
                        class="text-sm font-semibold text-blue-600 hover:text-blue-500">
                        View All
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-gray-50 dark:bg-gray-900/50">
                            <tr>
                                <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">
                                    Date
                                </th>
                                <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">
                                    Invoice
                                </th>
                                <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">
                                    Amount
                                </th>
                                <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @forelse ($recentTransactions as $transaction)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">
                                        {{ \Carbon\Carbon::parse($transaction->sale_date)->format('M d, Y') }}
                                    </td>

                                    <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">
                                        #INV-{{ str_pad($transaction->id, 4, '0', STR_PAD_LEFT) }}
                                    </td>

                                    <td class="px-6 py-4 text-sm font-bold text-gray-900 dark:text-white">
                                        ₱{{ number_format($transaction->total_amount, 2) }}
                                    </td>

                                    <td class="px-6 py-4">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            {{ strtolower($transaction->status) === 'paid'
                                                ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400'
                                                : 'bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-400' }}">
                                            {{ $transaction->status }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4"
                                        class="px-6 py-10 text-center text-gray-500 dark:text-gray-400">
                                        No transactions found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Help Card --}}
            <div
                class="bg-indigo-50 dark:bg-indigo-900/20 p-6 rounded-2xl border border-indigo-100 dark:border-indigo-800">
                <h4 class="text-indigo-900 dark:text-indigo-300 font-bold">
                    Need help?
                </h4>
                <p class="text-sm text-indigo-700 dark:text-indigo-400 mt-1">
                    Our support team is available 24/7 for any billing inquiries.
                </p>
                <button
                    class="mt-4 text-sm font-bold text-indigo-600 dark:text-indigo-300 underline">
                    Contact Support
                </button>
            </div>

        </div>
    </div>
</x-customer-app-layout>