<x-customer-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-gray-900 dark:text-white tracking-tight">
                {{ __('My Bookings') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-2xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        
                        <!-- Table Header -->
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Product
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Price
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Quantity
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Total
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Status
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Booking Date
                                </th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>

                        <!-- Table Body -->
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($bookings as $booking)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">

                                    <!-- Product Name -->
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                        {{ $booking->product_name }}
                                    </td>

                                    <!-- Price -->
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                        ₱{{ number_format($booking->product_price, 2) }}
                                    </td>

                                    <!-- Quantity -->
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                        {{ $booking->quantity }}
                                    </td>

                                    <!-- Total -->
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900 dark:text-white">
                                        ₱{{ number_format($booking->product_price * $booking->quantity, 2) }}
                                    </td>

                                    <!-- Status -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-3 py-1 inline-flex text-xs font-bold rounded-full
                                            @if($booking->status === 'pending')
                                                bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300
                                            @elseif($booking->status === 'approved')
                                                bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300
                                            @elseif($booking->status === 'cancelled')
                                                bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300
                                            @else
                                                bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300
                                            @endif">
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    </td>

                                    <!-- Created At -->
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                        {{ \Carbon\Carbon::parse($booking->created_at)->format('M d, Y h:i A') }}
                                    </td>


                                    <!-- Actions -->
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        @if($booking->status === 'pending')
                                            <form action="{{ route('bookings.cancel', $booking->id) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Are you sure you want to cancel this booking?')">
                                                @csrf
                                                @method('PATCH')

                                                <button type="submit"
                                                    class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-xs font-bold rounded-lg shadow-sm transition">
                                                    Cancel
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-xs text-gray-400 dark:text-gray-500">
                                                No Action
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8"
                                        class="px-6 py-10 text-center text-gray-500 dark:text-gray-400">
                                        No bookings found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-customer-app-layout>