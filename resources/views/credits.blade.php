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
                        historyOpen: false,
                        creditId: '',
                        customerName: '',
                        balance: 0,
                        specificHistory: []
                    }">
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th class="px-6 py-4">Credit ID</th>
                                    <th class="px-6 py-4">Customer</th>
                                    <th class="px-6 py-4">Address</th>
                                    <th class="px-6 py-4">Contact</th>
                                    <th class="px-6 py-4">Total</th>
                                    <th class="px-6 py-4">Balance</th>
                                    <th class="px-6 py-4">Due Date</th>
                                    <th class="px-6 py-4 text-center">Status</th>
                                    <th class="px-6 py-4 text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($credits as $credit)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                    <td class="px-6 py-4 font-mono text-xs text-gray-400">#{{ $credit->id }}</td>
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ $credit->customer_name }}</td>
                                    <td class="px-6 py-4 text-gray-600 dark:text-gray-300">{{ $credit->address }}</td>
                                    <td class="px-6 py-4 text-gray-600 dark:text-gray-300">{{ $credit->contact_number }}</td>
                                    <td class="px-6 py-4">₱{{ number_format($credit->total_amount, 2) }}</td>
                                    <td class="px-6 py-4 font-bold text-gray-900 dark:text-white">₱{{ number_format($credit->balance, 2) }}</td>
                                    <td class="px-6 py-4">
                                        <span class="{{ strtotime($credit->due_date) < time() && $credit->balance > 0 ? 'text-red-500 font-semibold' : '' }}">
                                            {{ \Carbon\Carbon::parse($credit->due_date)->format('M d, Y') }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if ($credit->balance <= 0)
                                            <span class="px-3 py-1 text-xs font-bold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">Paid</span>
                                        @elseif (strtotime($credit->due_date) < time())
                                            <span class="px-3 py-1 text-xs font-bold rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200 animate-pulse">Overdue</span>
                                        @else
                                            <span class="px-3 py-1 text-xs font-bold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">Active</span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4 text-center flex items-center justify-center gap-2">
                                        @if ($credit->balance > 0)
                                            <button type="button" 
                                                @click="open = true; creditId = {{ $credit->id }}; customerName = '{{ addslashes($credit->customer_name) }}'; balance = {{ $credit->balance }};"
                                                class="px-3 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-lg shadow transition">
                                                Pay Debt
                                            </button>
                                        @endif

                                        <button type="button"
                                            @click="
                                                historyOpen = true; 
                                                customerName = '{{ addslashes($credit->customer_name) }}'; 
                                                specificHistory = {{ $credit->payments->toJson() }};
                                            "
                                            class="px-3 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 text-xs font-bold rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition">
                                            History
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="px-6 py-10 text-center text-gray-500 italic">No credit records found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div x-show="open" x-cloak class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm flex items-center justify-center z-50 p-4">
                        <div @click.away="open = false" class="bg-white dark:bg-gray-800 rounded-3xl shadow-2xl w-full max-w-md overflow-hidden border border-gray-100 dark:border-gray-700">
                            <div class="px-6 py-4 flex justify-between items-center border-b dark:border-gray-700">
                                <h3 class="text-xl font-bold dark:text-white">New Payment</h3>
                                <button @click="open = false" class="text-gray-400 hover:text-red-500">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                            </div>
                            <div class="p-6">
                                <div class="mb-6 p-4 bg-indigo-50 dark:bg-indigo-900/30 rounded-2xl">
                                    <p class="text-xs font-bold text-indigo-600 dark:text-indigo-400 uppercase">Customer</p>
                                    <p class="text-lg font-black dark:text-white" x-text="customerName"></p>
                                    <p class="text-sm mt-2 text-gray-600 dark:text-gray-400">Balance: <span class="font-bold">₱<span x-text="parseFloat(balance).toLocaleString()"></span></span></p>
                                </div>
                                <form method="POST" action="{{ route('credit.pay') }}" class="space-y-4">
                                    @csrf
                                    <input type="hidden" name="credit_id" :value="creditId">
                                    <div>
                                        <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Amount to Pay</label>
                                        <input type="number" step="0.01" name="amount_tendered" required class="w-full bg-gray-50 dark:bg-gray-700 border-none rounded-xl p-3 focus:ring-2 focus:ring-indigo-500 dark:text-white" />
                                    </div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <input type="date" name="payment_date" value="{{ date('Y-m-d') }}" class="bg-gray-50 dark:bg-gray-700 border-none rounded-xl p-3 text-sm dark:text-white" />
                                        <select name="method" class="bg-gray-50 dark:bg-gray-700 border-none rounded-xl p-3 text-sm dark:text-white">
                                            <option>Cash</option>
                                            <option>GCash</option>
                                            <option>Bank Transfer</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="w-full py-4 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 shadow-lg transition">Confirm Payment</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div x-show="historyOpen" x-cloak class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm flex items-center justify-center z-50 p-4">
                        <div @click.away="historyOpen = false" class="bg-white dark:bg-gray-800 rounded-3xl shadow-2xl w-full max-w-2xl overflow-hidden border border-gray-100 dark:border-gray-700">
                            <div class="px-8 py-6 border-b dark:border-gray-700 flex justify-between items-center">
                                <h2 class="text-xl font-black dark:text-white">Payment History for <span class="text-indigo-500" x-text="customerName"></span></h2>
                                <button @click="historyOpen = false" class="text-gray-400 hover:text-red-500">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12" stroke-width="2"/></svg>
                                </button>
                            </div>
                            <div class="p-8">
                                <div class="overflow-hidden border dark:border-gray-700 rounded-2xl bg-gray-50/50 dark:bg-gray-900/20">
                                    <table class="w-full text-left">
                                        <thead class="bg-white dark:bg-gray-800 border-b dark:border-gray-700">
                                            <tr>
                                                <th class="px-6 py-3 text-[10px] font-black uppercase text-gray-400">Date</th>
                                                <th class="px-6 py-3 text-[10px] font-black uppercase text-gray-400">Amount Paid</th>
                                                <th class="px-6 py-3 text-[10px] font-black uppercase text-gray-400">Method</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <template x-for="payment in specificHistory" :key="payment.id">
                                                <tr class="border-b dark:border-gray-700/50 hover:bg-white dark:hover:bg-gray-800 transition">
                                                    <td class="px-6 py-4 text-sm dark:text-gray-400" x-text="new Date(payment.payment_date).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })"></td>
                                                    <td class="px-6 py-4">
                                                        <span class="text-sm font-bold dark:text-white" x-text="'₱' + parseFloat(payment.amount_paid).toLocaleString(undefined, {minimumFractionDigits: 2})"></span>
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 dark:bg-gray-700 dark:text-gray-300" x-text="payment.method"></span>
                                                    </td>
                                                </tr>
                                            </template>
                                            <template x-if="specificHistory.length === 0">
                                                <tr>
                                                    <td colspan="3" class="px-6 py-12 text-center text-gray-400 italic">No payments recorded.</td>
                                                </tr>
                                            </template>
                                        </tbody>
                                    </table>
                                </tr>
                            </div>
                        </div>
                    </div>

                </div> </div>
        </div>
    </div>

    <style>
        [x-cloak] { display: none !important; }
    </style>
</x-app-layout>