<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Credit Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6"
                    x-data="{
                        open: false,
                        creditId: '',
                        customerName: '',
                        balance: 0
                    }">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th class="px-6 py-4">Credit ID</th>
                                    <th class="px-6 py-4">Customer</th>
                                    <th class="px-6 py-4">Address</th>
                                    <th class="px-6 py-4">Contact number</th>
                                    <th class="px-6 py-4">Total Amount</th>
                                    <th class="px-6 py-4">Balance</th>
                                    <th class="px-6 py-4">Due Date</th>
                                    <th class="px-6 py-4 text-center">Status</th>
                                    <th class="px-6 py-4 text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($credits as $credit)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                    <td class="px-6 py-4 font-mono text-xs text-gray-400">#{{ $credit->id }}</td>
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                        {{ $credit->customer_name ?? null }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-600 dark:text-gray-300">
                                        {{ $credit->address }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-600 dark:text-gray-300">
                                        {{ $credit->contact_number }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-600 dark:text-gray-300">
                                        ₱{{ number_format($credit->total_amount, 2) }}
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

                                    <!-- ACTION BUTTON -->
                                    <td class="px-6 py-4 text-center">
                                        @if ($credit->balance > 0)
                                            <button
                                                type="button"
                                                @click="
                                                    open = true;
                                                    creditId = {{ $credit->id }};
                                                    customerName = '{{ addslashes($credit->customer_name) }}';
                                                    balance = {{ $credit->balance }};
                                                "
                                                class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-lg shadow"
                                            >
                                                Pay Debt
                                            </button>
                                        @else
                                            <span class="text-gray-400 text-xs italic">Completed</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-10 text-center text-gray-500 italic">
                                        No credit records found.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- PAYMENT MODAL -->
                        <div
                            x-show="open"
                            x-cloak
                            class="fixed inset-0 bg-black/60 flex items-center justify-center z-50"
                        >
                        <div
                            @click.away="open = false"
                            class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-4xl p-6"
                        >
                            <!-- HEADER -->
                            <div class="flex justify-between items-center mb-6">
                                <div>
                                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">
                                        Credit Payment
                                    </h2>
                                    <p class="text-sm text-gray-500">
                                        <span x-text="customerName"></span>
                                    </p>
                                </div>
                                <button
                                    @click="open = false"
                                    class="text-gray-400 hover:text-red-500 text-2xl font-bold"
                                >
                                    &times;
                                </button>
                            </div>

                            <!-- BALANCE -->
                            <div class="mb-6 p-4 bg-indigo-50 dark:bg-indigo-900/20 rounded-xl">
                                <p class="text-sm text-gray-500">Remaining Balance</p>
                                <p class="text-3xl font-black text-indigo-600">
                                    ₱<span x-text="parseFloat(balance).toFixed(2)"></span>
                                </p>
                            </div>

                            <!-- PAYMENT FORM -->
                            <form method="POST" action="{{ route('credit.pay') }}" class="space-y-4 mb-8">
                                @csrf

                                <input type="hidden" name="credit_id" :value="creditId">

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <label class="block text-xs font-bold uppercase text-gray-500 mb-1">
                                            Amount Paid
                                        </label>
                                        <input
                                            type="number"
                                            step="0.01"
                                            name="amount_tendered"
                                            required
                                            class="w-full border rounded-lg p-2"
                                        />
                                    </div>

                                    <div>
                                        <label class="block text-xs font-bold uppercase text-gray-500 mb-1">
                                            Payment Date
                                        </label>
                                        <input
                                            type="date"
                                            name="payment_date"
                                            value="{{ date('Y-m-d') }}"
                                            required
                                            class="w-full border rounded-lg p-2"
                                        >
                                    </div>

                                    <div>
                                        <label class="block text-xs font-bold uppercase text-gray-500 mb-1">
                                            Method
                                        </label>
                                        <select
                                            name="method"
                                            class="w-full border rounded-lg p-2"
                                        >
                                            <option value="Cash">Cash</option>
                                            <option value="GCash">GCash</option>
                                            <option value="Bank Transfer">Bank Transfer</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="flex justify-end gap-3">
                                    <button
                                        type="button"
                                        @click="open = false"
                                        class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg font-semibold"
                                    >
                                        Cancel
                                    </button>

                                    <button
                                        type="submit"
                                        class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-bold shadow"
                                    >
                                        Record Payment
                                    </button>
                                </div>
                            </form>

                            <!-- PAYMENT HISTORY TABLE -->
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-3">
                                Payment History
                            </h3>

                            <div class="overflow-x-auto max-h-64 overflow-y-auto border rounded-lg">
                                <table class="w-full text-sm">
                                    <thead>
                                    <tr>
                                        <th class="px-4 py-3 text-left">Date</th>
                                        <th class="px-4 py-3 text-left">Amount</th>
                                        <th class="px-4 py-3 text-left">Change</th>
                                        <th class="px-4 py-3 text-left">Method</th>
                                    </tr>
                                </thead>

                                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                    @forelse ($creditPayments as $payment)
                                    <tr>
                                        <td class="px-4 py-3">
                                            {{ \Carbon\Carbon::parse($payment->payment_date)->format('M d, Y') }}
                                        </td>

                                        <td class="px-4 py-3 font-semibold">
                                            ₱{{ number_format($payment->amount_paid, 2) }}
                                        </td>

                                        <td class="px-4 py-3 font-semibold">
                                            ₱{{ number_format($payment->change, 2) }}
                                        </td>

                                        <td class="px-4 py-3">
                                            {{ $payment->method }}
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="px-4 py-6 text-center text-gray-500 italic">
                                            No payments recorded yet.
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
        </div>
    </div>
<style>
    [x-cloak] {
        display: none !important;
    }
</style>
</x-app-layout>