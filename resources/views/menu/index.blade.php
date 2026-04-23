<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Rice Inventory Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
            @endif

            <!-- Rice Inventory Section -->
            <div class="mb-8">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-4">
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 font-medium">
                            ← Back to Dashboard
                        </a>
                        <h3 class="text-2xl font-bold text-gray-900">Rice Inventory</h3>
                    </div>
                    <div class="flex gap-3">
                        <x-primary-button as="a" href="{{ route('rice.create') }}">
                            {{ __('Add New Rice Type') }}
                        </x-primary-button>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        @if($riceTypes->count() > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                                @foreach($riceTypes as $rice)
                                    <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition">
                                        <div class="flex items-start justify-between mb-2">
                                            <div>
                                                <h4 class="font-semibold text-gray-900">{{ $rice->name }}</h4>
                                                <p class="text-xs text-gray-600">{{ $rice->description }}</p>
                                            </div>
                                        </div>
                                        
                                        <div class="space-y-2 mb-4 pt-2 border-t">
                                            <div class="flex justify-between text-sm">
                                                <span class="text-gray-600">Stock:</span>
                                                <span class="font-bold {{ $rice->stock_kg == 0 ? 'text-red-600' : ($rice->stock_kg < 20 ? 'text-yellow-600' : 'text-green-600') }}">
                                                    {{ $rice->stock_kg }} kg
                                                </span>
                                            </div>
                                            <div class="flex justify-between text-sm">
                                                <span class="text-gray-600">Price:</span>
                                                <span class="font-semibold">₱{{ number_format($rice->price_per_kilo, 2) }}/kg</span>
                                            </div>
                                        </div>

                                        <div class="flex gap-2 text-xs">
                                            <a href="{{ route('rice.add-stock', $rice) }}"
                                               class="flex-1 text-center px-2 py-1 text-white rounded font-bold"
                                               style="background-color: #16a34a;"
                                               onmouseover="this.style.backgroundColor='#15803d'"
                                               onmouseout="this.style.backgroundColor='#16a34a'">
                                                Add Stock
                                            </a>
                                            <a href="{{ route('rice.edit', $rice) }}"
                                               class="flex-1 text-center px-2 py-1 text-white rounded font-bold"
                                               style="background-color: #eab308;"
                                               onmouseover="this.style.backgroundColor='#ca8a04'"
                                               onmouseout="this.style.backgroundColor='#eab308'">
                                                Update
                                            </a>
                                            <form action="{{ route('rice.destroy', $rice) }}" method="POST" class="flex-1">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="w-full px-2 py-1 text-white rounded font-bold"
                                                        style="background-color: #dc2626;"
                                                        onmouseover="this.style.backgroundColor='#b91c1c'"
                                                        onmouseout="this.style.backgroundColor='#dc2626'"
                                                        onclick="return confirm('Delete this rice type?')">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Inventory Summary Table -->
                            <div class="mt-6">
                                <h4 class="font-semibold text-gray-900 mb-3">Inventory Summary</h4>
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="px-4 py-2 text-left font-medium text-gray-700">Rice Type</th>
                                                <th class="px-4 py-2 text-right font-medium text-gray-700">Stock (kg)</th>
                                                <th class="px-4 py-2 text-right font-medium text-gray-700">Price/kg</th>
                                                <th class="px-4 py-2 text-right font-medium text-gray-700">Total Value</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-200">
                                            @foreach($riceTypes as $rice)
                                                <tr>
                                                    <td class="px-4 py-2 text-gray-900">{{ $rice->name }}</td>
                                                    <td class="px-4 py-2 text-right text-gray-900">{{ $rice->stock_kg }} kg</td>
                                                    <td class="px-4 py-2 text-right text-gray-900">₱{{ number_format($rice->price_per_kilo, 2) }}</td>
                                                    <td class="px-4 py-2 text-right font-semibold text-gray-900">₱{{ number_format($rice->stock_kg * $rice->price_per_kilo, 2) }}</td>
                                                </tr>
                                            @endforeach
                                            <tr class="bg-gray-50 font-semibold">
                                                <td class="px-4 py-2 text-gray-900">Total Inventory</td>
                                                <td class="px-4 py-2 text-right text-gray-900">{{ $riceTypes->sum('stock_kg') }} kg</td>
                                                <td class="px-4 py-2 text-right text-gray-900">-</td>
                                                <td class="px-4 py-2 text-right text-gray-900">₱{{ number_format($riceTypes->sum(function($r) { return $r->stock_kg * $r->price_per_kilo; }), 2) }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @else
                            <div class="text-center py-8">
                                <p class="text-gray-500 mb-4">No rice types found.</p>
                                <x-primary-button as="a" href="{{ route('rice.create') }}">
                                    {{ __('Create First Rice Type') }}
                                </x-primary-button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>


        </div>
    </div>
</x-app-layout>