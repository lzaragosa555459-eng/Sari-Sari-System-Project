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
                            <th class="px-4 py-2">Sale ID</th>
                            <th class="px-4 py-2">Customer Name</th>
                            <th class="px-4 py-2">Contact</th>
                            <th class="px-4 py-2">Total Amount</th>
                            <th class="px-4 py-2">Payment</th>
                            <th class="px-4 py-2">Status</th>
                            <th class="px-4 py-2 text-center">Action</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($sales as $sale)
                            <tr class="border-b dark:border-gray-700">

                                <td class="px-4 py-2">
                                    {{ $sale->sale_id }}
                                </td>

                                <td class="px-4 py-2">
                                    {{ $sale->name }}
                                </td>

                                <td class="px-4 py-2">
                                    {{ $sale->contact_number }}
                                </td>

                                <td class="px-4 py-2">
                                    ₱{{ number_format($sale->total_amount, 2) }}
                                </td>

                                <td class="px-4 py-2">
                                    {{ ucfirst($sale->payment_method) }}
                                </td>

                                {{-- STATUS --}}
                                <td class="px-4 py-2">
                                    <span class="px-2 py-1 rounded text-white 
                                        {{ $sale->status ?? 'pending' == 'pending' ? 'bg-yellow-500' : 'bg-green-600' }}">
                                        {{ ucfirst($sale->status ?? 'pending') }}
                                    </span>
                                </td>

                                {{-- ACTION --}}
                                <td class="px-4 py-2 text-center">

                                    @if(($sale->status ?? 'pending') == 'pending')

                                        <form action="{{ route('employee.sales.checkout', $sale->sale_id) }}" method="POST">
                                            @csrf

                                            <button type="submit"
                                                class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded">
                                                Checkout
                                            </button>
                                        </form>

                                    @else
                                        <span class="text-gray-400">Completed</span>
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