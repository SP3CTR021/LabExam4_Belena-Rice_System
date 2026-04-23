<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid gap-6 md:grid-cols-3">
                <a href="{{ route('menus.index') }}" class="block rounded-xl border border-gray-200 bg-white p-6 shadow-sm hover:border-indigo-500">
                    <h3 class="text-lg font-semibold text-gray-900">Rice Inventory</h3>
                    <p class="mt-2 text-sm text-gray-600">Manage rice types and stock levels.</p>
                </a>
                <a href="{{ route('orders.index') }}" class="block rounded-xl border border-gray-200 bg-white p-6 shadow-sm hover:border-indigo-500">
                    <h3 class="text-lg font-semibold text-gray-900">Orders</h3>
                    <p class="mt-2 text-sm text-gray-600">Create new orders and view order summaries.</p>
                </a>
                <a href="{{ route('payments.index') }}" class="block rounded-xl border border-gray-200 bg-white p-6 shadow-sm hover:border-indigo-500">
                    <h3 class="text-lg font-semibold text-gray-900">Payments</h3>
                    <p class="mt-2 text-sm text-gray-600">Process payments and view transaction history.</p>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
