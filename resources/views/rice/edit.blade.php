<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Rice Type: ' . $riceType->name) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('rice.update', $riceType) }}">
                        @csrf
                        @method('PUT')

                        <div>
                            <x-input-label for="name" :value="__('Rice Type Name')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $riceType->name)" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="description" :value="__('Description (Optional)')" />
                            <textarea id="description" name="description" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500" rows="3">{{ old('description', $riceType->description) }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <div class="mt-4 grid grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="stock_kg" :value="__('Current Stock (kg)')" />
                                <x-text-input id="stock_kg" name="stock_kg" type="number" step="0.01" min="0" class="mt-1 block w-full" :value="old('stock_kg', $riceType->stock_kg)" required />
                                <x-input-error :messages="$errors->get('stock_kg')" class="mt-2" />
                                <p class="text-xs text-gray-500 mt-1">Use "Add Stock" feature to increase stock instead</p>
                            </div>

                            <div>
                                <x-input-label for="price_per_kilo" :value="__('Price per Kilo (₱)')" />
                                <x-text-input id="price_per_kilo" name="price_per_kilo" type="number" step="0.01" min="0" class="mt-1 block w-full" :value="old('price_per_kilo', $riceType->price_per_kilo)" required />
                                <x-input-error :messages="$errors->get('price_per_kilo')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end gap-4 mt-6">
                            <a href="{{ route('menus.index') }}" class="text-gray-700 hover:text-gray-900">Cancel</a>
                            <x-primary-button>
                                {{ __('Update Rice Type') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
