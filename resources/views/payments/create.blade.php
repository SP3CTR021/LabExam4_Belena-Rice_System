<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Process Payment') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                        <p><strong class="text-blue-900">Customer:</strong> <span class="text-gray-900">{{ $order->customer_name }}</span></p>
                        <p class="mt-2"><strong class="text-blue-900">Rice Type:</strong> <span class="text-gray-900">{{ $order->riceType->name ?? 'N/A' }}</span></p>
                        <p class="mt-2"><strong class="text-blue-900">Quantity:</strong> <span class="text-gray-900">{{ $order->quantity }} kg</span></p>
                        <p class="mt-3 text-lg border-t pt-3"><strong class="text-blue-900">Total Cost:</strong> <span class="text-gray-900 font-bold text-lg">₱{{ number_format($order->total_cost, 2) }}</span></p>
                        <p class="mt-2"><strong class="text-blue-900">Amount Paid:</strong> <span class="text-gray-900 font-semibold">₱{{ number_format($order->amount_paid, 2) }}</span></p>
                        <p class="mt-2"><strong class="text-blue-900">Balance:</strong> <span class="text-red-600 font-bold">₱{{ number_format($order->balance, 2) }}</span></p>
                    </div>

                    <form method="POST" action="{{ route('orders.payment.store', $order) }}">
                        @csrf

                        <div>
                            <x-input-label for="amount" :value="__('Payment Amount')" />
                            <x-text-input id="amount" name="amount" type="number" step="0.01" min="0.01" class="mt-1 block w-full" :value="old('amount')" required autofocus />
                            <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-between mt-6">
                            <a href="{{ route('orders.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 font-medium">
                                ← Back to Orders
                            </a>
                            <x-primary-button>
                                {{ __('Process Payment') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
