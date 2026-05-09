<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- OVERALL NET --}}
            <div>
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                    Overall Store Balance
                </h3>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-blue-500">
                    <div class="p-6">
                        <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider">
                            Current Store Cash
                        </p>

                        <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">
                            ₱{{ number_format($totalNet->current_balance ?? 0, 2) }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- TODAY --}}
            <div>
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                    Today's Overview
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

                    {{-- TRANSACTIONS --}}
                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg border-l-4 border-blue-500 p-6">
                        <p class="text-sm font-semibold text-gray-500 uppercase">Transactions</p>
                        <p class="mt-2 text-3xl font-bold text-white">
                            {{ $totalTransactionsToday ?? 0 }}
                        </p>
                    </div>

                    {{-- SALES --}}
                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg border-l-4 border-green-500 p-6">
                        <p class="text-sm font-semibold text-gray-500 uppercase">Sales Today</p>
                        <p class="mt-2 text-3xl font-bold text-white">
                            ₱{{ number_format($totalSalesToday ?? 0, 2) }}
                        </p>
                    </div>

                    {{-- CASH --}}
                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg border-l-4 border-indigo-500 p-6">
                        <p class="text-sm font-semibold text-gray-500 uppercase">Cash Collected</p>
                        <p class="mt-2 text-3xl font-bold text-white">
                            ₱{{ number_format($cashCollectedToday ?? 0, 2) }}
                        </p>
                    </div>

                    {{-- CREDIT PAYMENTS TODAY --}}
                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg border-l-4 border-yellow-500 p-6">
                        <p class="text-sm font-semibold text-gray-500 uppercase">Credit Payments</p>
                        <p class="mt-2 text-3xl font-bold text-white">
                            ₱{{ number_format($creditPaymentsToday ?? 0, 2) }}
                        </p>
                    </div>

                </div>
            </div>

            {{-- FINANCIAL SUMMARY --}}
            <div>
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                    Financial Overview
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                    {{-- MONTHLY SALES --}}
                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                        <p class="text-sm font-semibold text-gray-400">Sales This Month</p>
                        <p class="mt-1 text-2xl font-bold text-white">
                            ₱{{ number_format($totalSalesThisMonth ?? 0, 2) }}
                        </p>
                    </div>

                    {{-- OUTSTANDING CREDIT --}}
                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                        <p class="text-sm font-semibold text-red-500">Outstanding Credits</p>
                        <p class="mt-1 text-2xl font-bold text-white">
                            ₱{{ number_format($totalOutstandingCredit ?? 0, 2) }}
                        </p>
                    </div>

                    {{-- TOTAL REVENUE (REAL BUSINESS VALUE) --}}
                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 border-l-4 border-green-600">
                        <p class="text-sm font-semibold text-gray-400">Total Revenue Today</p>
                        <p class="mt-1 text-2xl font-bold text-white">
                            ₱{{ number_format(($totalSalesToday ?? 0) + ($creditPaymentsToday ?? 0), 2) }}
                        </p>
                    </div>

                </div>
            </div>

            {{-- CHART --}}
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                    Sales Chart
                </h3>

                <canvas id="salesChart"></canvas>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const labels = @json($labels);
        const data = @json($data);

        new Chart(document.getElementById('salesChart'), {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Sales',
                    data: data,
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    </script>
</x-app-layout>