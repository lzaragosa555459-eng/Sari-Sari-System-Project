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
                            @elseif($booking->status == 'cancelled')
                                <span class="px-2 py-1 rounded bg-red-500 text-white">
                                    Cancelled
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

                                <button type="button"
                                    onclick="openCheckoutModal({{ $booking->customer_id }}, {{ $booking->total }})"
                                    class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded">
                                    Checkout
                                </button>
                            @elseif($booking->status == 'cancelled')
                                <span class="text-gray-400">None</span>
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
<div id="checkoutModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" onclick="closeModal()"></div>

    <div class="bg-white dark:bg-gray-800 w-full max-w-md rounded-3xl shadow-2xl relative z-10 overflow-hidden transform transition-all">
        
        <div class="px-8 pt-8 pb-4">
            <div class="flex items-center gap-3 mb-1">
                <div class="p-2 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg">
                    <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <h2 class="text-2xl font-black text-gray-800 dark:text-white tracking-tight">Checkout</h2>
            </div>
            <p class="text-sm text-gray-500 dark:text-gray-400">Complete the transaction by entering the payment details below.</p>
        </div>

        <form id="checkoutForm" method="POST" class="p-8 pt-4">
            @csrf
            <input type="hidden" name="customer_id" id="customer_id">

            <div class="space-y-5">
                <div>
                    <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2 ml-1">Total Amount</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 font-bold">₱</span>
                        <input type="text" id="total_amount" 
                            class="w-full bg-gray-50 dark:bg-gray-700/50 border-none ring-1 ring-gray-200 dark:ring-gray-600 rounded-2xl p-4 pl-8 text-xl font-black text-gray-900 dark:text-white" 
                            readonly>
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2 ml-1">Amount Paid</label>
                    <div class="relative group">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-indigo-500 font-bold group-focus-within:scale-110 transition-transform">₱</span>
                        <input type="number" name="amount_paid" id="amount_paid"
                            class="w-full bg-white dark:bg-gray-900 border-none ring-2 ring-indigo-100 dark:ring-indigo-900/30 focus:ring-4 focus:ring-indigo-500 transition-all rounded-2xl p-4 pl-8 text-xl font-black text-gray-900 dark:text-white placeholder-gray-300" 
                            placeholder="0.00"
                            oninput="computeChange()" required>
                    </div>
                </div>

                <div class="bg-emerald-50 dark:bg-emerald-900/20 rounded-2xl p-4 flex justify-between items-center border border-emerald-100 dark:border-emerald-800">
                    <span class="text-xs font-bold text-emerald-700 dark:text-emerald-400 uppercase tracking-widest">Change Due</span>
                    <input type="text" id="change" 
                        class="bg-transparent border-none p-0 text-right text-xl font-black text-emerald-600 dark:text-emerald-400 w-1/2 focus:ring-0" 
                        value="₱0.00" readonly>
                </div>
            </div>
            <div class="mt-4">
                <label for="payment_method" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    Payment Method
                </label>

                <select
                    name="payment_method"
                    id="payment_method"
                    class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white
                        focus:border-indigo-500 focus:ring-indigo-500 shadow-sm"
                    required
                >
                    <option value="" disabled selected>Select method</option>
                    <option value="cash">Cash</option>
                    <option value="credit">Credit</option>
                </select>
            </div>
            <div class="flex gap-3 mt-8">
                <button type="button" onclick="closeModal()"
                    class="flex-1 px-6 py-4 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-600 dark:text-gray-300 rounded-2xl font-bold text-sm transition-all active:scale-95 uppercase tracking-widest">
                    Cancel
                </button>

                <button type="submit"
                    class="flex-[2] px-6 py-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl font-black text-sm transition-all active:scale-95 shadow-lg shadow-indigo-200 dark:shadow-none uppercase tracking-widest">
                    Confirm Payment
                </button>
            </div>
        </form>
    </div>
</div>
<script>
let total = 0;

function openCheckoutModal(customerId, bookingTotal) {
    document.getElementById('checkoutModal').classList.remove('hidden');

    document.getElementById('customer_id').value = customerId;
    document.getElementById('total_amount').value = bookingTotal;

    total = bookingTotal;

    document.getElementById('checkoutForm').action =
        `/employee/bookings/checkout/${customerId}`;
}

function closeModal() {
    document.getElementById('checkoutModal').classList.add('hidden');
}

function computeChange() {
    let paid = document.getElementById('amount_paid').value;
    let change = paid - total;

    document.getElementById('change').value = change >= 0 ? change : 0;
}
</script>
</x-employee-app-layout>