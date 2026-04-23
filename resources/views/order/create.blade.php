<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Order') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    @if(session('success'))
                        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
                    @endif

                    <form method="POST" action="{{ route('orders.store') }}">
                        @csrf

                        <div>
                            <x-input-label for="customer_name" :value="__('Customer Name')" />
                            <x-text-input id="customer_name" name="customer_name" type="text" class="mt-1 block w-full" :value="old('customer_name')" required autofocus />
                            <x-input-error :messages="$errors->get('customer_name')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="rice_type_id" :value="__('Rice Type')" />
                            <select id="rice_type_id" name="rice_type_id" class="block w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" required onchange="updateStock(this)">
                                <option value="">Select a rice type</option>
                                @foreach($riceTypes as $rice)
                                    <option value="{{ $rice->id }}"
                                            data-stock="{{ $rice->stock_kg }}"
                                            data-price="{{ $rice->price_per_kilo }}"
                                            @selected(old('rice_type_id') == $rice->id)>
                                        {{ $rice->name }} (₱{{ number_format($rice->price_per_kilo, 2) }} / kilo) — Stock: {{ $rice->stock_kg }} kg
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('rice_type_id')" class="mt-2" />

                            <div id="stock-info" class="mt-2 text-sm text-gray-500 hidden">
                                Available stock: <span id="stock-value" class="font-bold text-green-600"></span> kg
                            </div>
                        </div>

                        <div class="mt-4">
                            <x-input-label for="quantity" :value="__('Quantity (Kilos)')" />
                            <x-text-input id="quantity" name="quantity" type="number" step="0.01" min="0.01" class="mt-1 block w-full" :value="old('quantity', 1)" required />
                            <x-input-error :messages="$errors->get('quantity')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-between mt-6">
                            <a href="{{ route('orders.index') }}" class="text-gray-700 hover:text-gray-900">← Back to Orders</a>
                            <x-primary-button>
                                {{ __('Create Order') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function updateStock(select) {
            const selected = select.options[select.selectedIndex];
            const stock = selected.dataset.stock;
            const stockInfo = document.getElementById('stock-info');
            const stockValue = document.getElementById('stock-value');
            const quantityInput = document.getElementById('quantity');

            if (stock !== undefined && select.value !== '') {
                stockInfo.classList.remove('hidden');
                stockValue.textContent = stock;
                stockValue.className = stock > 0 ? 'font-bold text-green-600' : 'font-bold text-red-600';
                quantityInput.max = stock;
            } else {
                stockInfo.classList.add('hidden');
                quantityInput.removeAttribute('max');
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            const select = document.getElementById('rice_type_id');
            if (select.value) updateStock(select);
        });
    </script>
</x-app-layout>