<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Customer Directory') }}
            </h2>
            <button class="px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white transition ease-in-out duration-150">
                Add Customer
            </button>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th class="px-6 py-4">ID</th>
                                    <th class="px-6 py-4">Customer Name</th>
                                    <th class="px-6 py-4">Email Address</th>
                                    <th class="px-6 py-4">Contact Number</th>
                                    <th class="px-6 py-4">Address</th>
                                    <th class="px-6 py-4 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach ($customers as $customer)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                    <td class="px-6 py-4 font-mono text-xs text-gray-400">
                                        #{{ $customer->customer_id }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="h-8 w-8 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center mr-3">
                                                <span class="text-indigo-700 dark:text-indigo-200 font-bold text-xs">
                                                    {{ strtoupper(substr($customer->name, 0, 1)) }}
                                                </span>
                                            </div>
                                            <div class="font-medium text-gray-900 dark:text-white">
                                                {{ $customer->name }}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $customer->email }}
                                    </td>
                                    <td class="px-6 py-4 tabular-nums">
                                        {{ $customer->contact_number }}
                                    </td>
                                    <td class="px-6 py-4 truncate max-w-xs">
                                        {{ $customer->address }}
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="#" class="text-indigo-600 dark:text-indigo-400 hover:underline font-medium">Edit</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>