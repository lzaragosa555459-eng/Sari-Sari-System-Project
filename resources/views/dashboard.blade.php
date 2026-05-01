<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <div>
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Today's Overview</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-blue-500">
                        <div class="p-6">
                            <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Total Transactions</p>
                            <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">
                                {{ $totalsalesTransactionToday }}
                            </p>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-green-500">
                        <div class="p-6">
                            <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Total Sales Today</p>
                            <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">
                                ₱{{ number_format($totalSalesToday, 2) }}
                            </p>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-indigo-500">
                        <div class="p-6">
                            <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Net Cash Kept</p>
                            <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">
                                ₱{{ number_format($netCashKeptToday, 2) }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Monthly & Financials</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <p class="text-sm font-semibold text-gray-400">Sales This Month</p>
                            <p class="mt-1 text-2xl font-bold text-gray-900 dark:text-white">
                                ₱{{ number_format($totalSalesThisMonth, 2) }}
                            </p>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <p class="text-sm font-semibold text-red-500">Outstanding Credits</p>
                            <p class="mt-1 text-2xl font-bold text-gray-900 dark:text-white">
                                ₱{{ number_format($totalOutstandingCredit, 2) }}
                            </p>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <p class="text-sm font-semibold text-gray-400">Total Sales Amount (All-time)</p>
                            <p class="mt-1 text-2xl font-bold text-gray-900 dark:text-white">
                                ₱{{ number_format($totalAmount->total, 2) }}
                            </p>
                        </div>
                    </div>
                </div>

                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

                <canvas id="salesChart"></canvas>

                <script>
                const labels = @json($labels);
                const data = @json($data);

                new Chart(document.getElementById('salesChart'), {
                    type: 'bar', // or 'line', 'pie'
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
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
                </script>
            </div>

        </div>
    </div>
</x-app-layout>
