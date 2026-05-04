<x-customer-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('My Cart') }}
                </h2>
            <a href="{{ route('order') }}"
            class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">
                ← Back
            </a>    
        </div>

    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(count($cart))

                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">

                    <table class="w-full">
                        <thead>
                            <tr>
                                <th class="text-left">Product</th>
                                <th>Price</th>
                                <th>Qty</th>
                                <th>Total</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($cart as $item)
                                <tr class="border-t">
                                    <td class="py-2">{{ $item['name'] }}</td>
                                    <td>₱{{ number_format($item['price'], 2) }}</td>
                                    <td>{{ $item['quantity'] }}</td>
                                    <td>
                                        ₱{{ number_format($item['price'] * $item['quantity'], 2) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-6 text-right">
                        <h3 class="text-lg font-bold">
                            Total: ₱{{ number_format($total, 2) }}
                        </h3>

                        <button class="mt-4 bg-green-600 text-white px-6 py-2 rounded">
                            Checkout
                        </button>
                    </div>

                </div>

            @else
                <div class="bg-white dark:bg-gray-800 p-6 text-center">
                    <p class="text-gray-500">Your cart is empty.</p>
                </div>
            @endif

        </div>
    </div>
</x-customer-app-layout>