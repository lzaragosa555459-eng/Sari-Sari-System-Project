<x-customer-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-gray-800 dark:text-white tracking-tight">
                {{ __('Dashboard') }}
            </h2>
            <span class="text-sm font-medium px-3 py-1 bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300 rounded-full">
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
                        You have <span class="font-semibold text-white">2 pending tasks</span> and your rewards are growing.
                    </p>
                    <div class="mt-6 flex gap-3">
                        <a href="#" class="inline-flex items-center px-4 py-2 bg-white text-blue-700 text-sm font-bold rounded-xl hover:bg-blue-50 transition-colors shadow-sm">
                            View Statements
                        </a>
                    </div>
                </div>
                {{-- Decorative Background Elements --}}
                <div class="absolute top-0 right-0 -mt-4 -mr-4 h-64 w-64 rounded-full bg-white/10 blur-3xl"></div>
                <div class="absolute bottom-0 right-10 -mb-8 h-40 w-40 rounded-full bg-indigo-400/20 blur-2xl"></div>
            </div>

            {{-- Modern Metric Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-2xl p-6 shadow-sm transition-hover hover:shadow-md">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-2 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                        </div>
                        <span class="text-xs font-bold text-green-500 bg-green-50 px-2 py-1 rounded-md">+2.5%</span>
                    </div>
                    <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Credit Balance</h4>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white mt-1">₱1,250.00</p>
                </div>

                <div class="bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-2xl p-6 shadow-sm">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-2 bg-emerald-50 dark:bg-emerald-900/20 rounded-lg">
                            <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        </div>
                    </div>
                    <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Purchases</h4>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white mt-1">24</p>
                </div>

                <div class="bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-2xl p-6 shadow-sm">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-2 bg-purple-50 dark:bg-purple-900/20 rounded-lg">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                        </div>
                    </div>
                    <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Reward Points</h4>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white mt-1">340</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                {{-- Table Section --}}
                <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">Recent Transactions</h3>
                        <a href="#" class="text-sm font-semibold text-blue-600 hover:text-blue-500">View All</a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead class="bg-gray-50 dark:bg-gray-900/50">
                                <tr>
                                    <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Date</th>
                                    <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Invoice</th>
                                    <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Amount</th>
                                    <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">May 4, 2026</td>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">#INV-1001</td>
                                    <td class="px-6 py-4 text-sm font-bold text-gray-900 dark:text-white">₱350.00</td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                            Paid
                                        </span>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">May 2, 2026</td>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">#INV-0998</td>
                                    <td class="px-6 py-4 text-sm font-bold text-gray-900 dark:text-white">₱500.00</td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-400">
                                            Credit
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Side Actions --}}
                <div class="space-y-6">
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Quick Actions</h3>
                        <div class="grid grid-cols-1 gap-3">
                            <a href="#" class="flex items-center p-3 text-sm font-semibold text-gray-700 dark:text-gray-200 bg-gray-50 dark:bg-gray-900/50 rounded-xl hover:bg-blue-600 hover:text-white transition-all group">
                                <span class="mr-3 p-2 bg-white dark:bg-gray-800 rounded-lg group-hover:bg-blue-500 shadow-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                </span>
                                Pay Balance
                            </a>
                            <a href="#" class="flex items-center p-3 text-sm font-semibold text-gray-700 dark:text-gray-200 bg-gray-50 dark:bg-gray-900/50 rounded-xl hover:bg-blue-600 hover:text-white transition-all group">
                                <span class="mr-3 p-2 bg-white dark:bg-gray-800 rounded-lg group-hover:bg-blue-500 shadow-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                </span>
                                Edit Profile
                            </a>
                        </div>
                    </div>

                    {{-- Help Card --}}
                    <div class="bg-indigo-50 dark:bg-indigo-900/20 p-6 rounded-2xl border border-indigo-100 dark:border-indigo-800">
                        <h4 class="text-indigo-900 dark:text-indigo-300 font-bold">Need help?</h4>
                        <p class="text-sm text-indigo-700 dark:text-indigo-400 mt-1">Our support team is available 24/7 for any billing inquiries.</p>
                        <button class="mt-4 text-sm font-bold text-indigo-600 dark:text-indigo-300 underline">Contact Support</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-customer-app-layout>