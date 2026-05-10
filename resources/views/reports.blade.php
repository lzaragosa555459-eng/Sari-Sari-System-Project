<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Reports') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            {{-- 📊 Trending Products --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                
                <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-700">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                        🔥 Trending Products
                    </h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Based on total quantity sold
                    </p>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-gray-50 dark:bg-gray-900/30">
                            <tr>
                                <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase">Product</th>
                                <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase">Total Sold</th>
                                <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase">Revenue</th>
                                <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase">Status</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @foreach($trendingProducts as $product)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition">
                                    
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                        {{ $product->product_name }}
                                    </td>

                                    <td class="px-6 py-4 text-gray-700 dark:text-gray-300">
                                        {{ $product->total_sold }}
                                    </td>

                                    <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                                        ₱{{ number_format($product->total_revenue, 2) }}
                                    </td>

                                    <td class="px-6 py-4">
                                        @if($product->total_sold >= 10)
                                            <span class="px-2 py-1 text-xs font-bold bg-green-100 text-green-700 rounded-lg">
                                                Hot 🔥
                                            </span>
                                        @elseif($product->total_sold >= 5)
                                            <span class="px-2 py-1 text-xs font-bold bg-blue-100 text-blue-700 rounded-lg">
                                                Popular
                                            </span>
                                        @else
                                            <span class="px-2 py-1 text-xs font-bold bg-gray-100 text-gray-600 rounded-lg">
                                                Normal
                                            </span>
                                        @endif
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">

                <div class="mb-4">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                        📈 Monthly Net Sales
                    </h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Overview of total sales per month
                    </p>
                </div>

                <canvas id="monthlySalesChart" height="100"></canvas>
            </div>
        </div>
    </div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const monthlyLabels = {!! json_encode(array_column($monthlySales, 'label')) !!};
    const monthlyData = {!! json_encode(array_column($monthlySales, 'total')) !!};

    new Chart(document.getElementById('monthlySalesChart'), {
        type: 'line',
        data: {
            labels: monthlyLabels,
            datasets: [{
                label: 'Net Sales (₱)',
                data: monthlyData,
                borderWidth: 3,
                fill: true,
                tension: 0.3,
                pointRadius: 4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return '₱' + context.raw.toLocaleString();
                        }
                    }
                }
            },
            scales: {
                y: {
                    ticks: {
                        callback: function(value) {
                            return '₱' + value;
                        }
                    }
                }
            }
        }
    });
</script>
</x-app-layout>