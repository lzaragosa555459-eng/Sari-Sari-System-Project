<x-employee-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Customer Books') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">

                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">

                    <thead class="text-xs uppercase bg-gray-100 dark:bg-gray-700">
                        <tr>
                            <th class="px-4 py-2">Customer Name</th>
                            <th class="px-4 py-2">Contact</th>
                            <th class="px-4 py-2">Date & Time</th>
                            <th class="px-4 py-2">Products & Quantity</th>
                            <th class="px-4 py-2">Total Amount</th>
                            <th class="px-4 py-2">Status</th>
                            <th class="px-4 py-2 text-center">Action</th>
                        </tr>
                    </thead>

                    <tbody>

                    @forelse($bookings as $booking)
                    <tr class="border-b dark:border-gray-700">

                        <td class="px-4 py-2">
                            {{ $booking->customer_name }}
                        </td>

                        <td class="px-4 py-2">
                            {{ $booking->contact_number }}
                        </td>
                        <td class="px-4 py-2">
                           {{ \Carbon\Carbon::parse($booking->created_at)->format('M d, Y h:i A') }}
                        </td>
                        <td class="px-4 py-2">
                            @php
                                $products = explode(',', $booking->products);
                                $quantities = explode(',', $booking->quantities);
                            @endphp

                            @foreach($products as $index => $product)
                                <div>
                                    {{ trim($product) }} {{ $quantities[$index] ?? '' }}x
                                </div>
                            @endforeach
                        </td>
                        <td class="px-4 py-2">
                            ₱{{ $booking->total}}
                        </td>
                        {{-- STATUS --}}
                        <td class="px-4 py-2">
                            @if($booking->status == 'pending')
                                <span class="px-2 py-1 rounded bg-yellow-500 text-white">
                                    Pending
                                </span>
                            @else
                                <span class="px-2 py-1 rounded bg-green-600 text-white">
                                    Completed
                                </span>
                            @endif
                        </td>

                        {{-- ACTION --}}
                        <td class="px-4 py-2 text-center">

                            @if($booking->status == 'pending')

                               <form action="{{ route('employee.bookings.checkout', $booking->customer_id) }}" method="POST">
                                    @csrf

                                    <button type="submit"
                                        class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded">
                                        Checkout
                                    </button>
                                </form>

                            @else
                                <span class="text-gray-400">Done</span>
                            @endif

                        </td>

                    </tr>
                    @empty

                    <tr>
                        <td colspan="7" class="text-center py-6 text-gray-500">
                            No bookings found.
                        </td>
                    </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

        </div>
    </div>
</x-employee-app-layout>