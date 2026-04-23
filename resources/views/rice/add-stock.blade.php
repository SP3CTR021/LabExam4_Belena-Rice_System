<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Stock: ' . $riceType->name) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded">
                        <h3 class="font-semibold text-blue-900">{{ $riceType->name }}</h3>
                        <div class="mt-2 grid grid-cols-2 gap-4 text-sm text-blue-800">
                            <div>Current Stock: <span class="font-bold">{{ $riceType->stock_kg }} kg</span></div>
                            <div>Price: <span class="font-bold">₱{{ number_format($riceType->price_per_kilo, 2) }}/kg</span></div>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('rice.store-stock', $riceType) }}">
                        @csrf

                        <div>
                            <x-input-label for="quantity_kg" :value="__('Quantity to Add (kg)')" />
                            <x-text-input id="quantity_kg" name="quantity_kg" type="number" step="0.01" min="0.01" class="mt-1 block w-full" placeholder="Enter amount in kilograms" :value="old('quantity_kg')" required autofocus />
                            <x-input-error :messages="$errors->get('quantity_kg')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="notes" :value="__('Notes (Optional)')" />
                            <textarea id="notes" name="notes" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500" rows="3" placeholder="e.g., Supplier name, delivery date, etc...">{{ old('notes') }}</textarea>
                            <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                        </div>

                        <div class="mt-6 p-4 bg-gray-50 rounded">
                            <h4 class="font-semibold text-gray-900 mb-2">Stock After Addition</h4>
                            <div id="newStockPreview" class="text-lg font-bold text-green-600">
                                {{ $riceType->stock_kg }} kg
                            </div>
                        </div>

                        <div class="flex items-center justify-end gap-4 mt-6">
                            <a href="{{ route('menus.index') }}" class="text-gray-700 hover:text-gray-900">Cancel</a>
                            <x-primary-button>
                                {{ __('Add Stock') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('quantity_kg').addEventListener('input', function() {
            const currentStock = {{ $riceType->stock_kg }};
            const quantity = parseFloat(this.value) || 0;
            const newStock = currentStock + quantity;
            document.getElementById('newStockPreview').textContent = newStock.toFixed(2) + ' kg';
        });
    </script>
</x-app-layout> 
