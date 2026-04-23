<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Rice Inventory Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-4 flex gap-4">
                <x-primary-button as="a" href="{{ route('rice.create') }}">
                    {{ __('Add New Rice Type') }}
                </x-primary-button>
            </div>

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @forelse($riceTypes as $rice)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <h3 class="text-lg font-semibold text-gray-900">{{ $rice->name }}</h3>
                                    <p class="text-sm text-gray-600 mt-1">{{ $rice->description }}</p>
                                    
                                    <div class="mt-4 space-y-2">
                                        <div class="flex justify-between items-center">
                                            <span class="text-gray-700">Stock:</span>
                                            <span class="text-lg font-bold {{ $rice->stock_kg == 0 ? 'text-red-600' : ($rice->stock_kg < 20 ? 'text-yellow-600' : 'text-green-600') }}">
                                                {{ $rice->stock_kg }} kg
                                            </span>
                                        </div>
                                        <div class="flex justify-between items-center">
                                            <span class="text-gray-700">Price:</span>
                                            <span class="font-semibold">₱{{ number_format($rice->price_per_kilo, 2) }}/kg</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-6 flex gap-2">
                                <a href="{{ route('rice.add-stock', $rice) }}" class="flex-1 text-center px-3 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm font-medium">
                                    Add Stock
                                </a>
                                <a href="{{ route('rice.edit', $rice) }}" class="flex-1 text-center px-3 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 text-sm font-medium">
                                    Edit
                                </a>
                                <form action="{{ route('rice.destroy', $rice) }}" method="POST" class="flex-1">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full px-3 py-2 bg-red-600 text-white rounded hover:bg-red-700 text-sm font-medium" onclick="return confirm('Delete this rice type?')">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200 text-center text-gray-500">
                            No rice types found. <a href="{{ route('rice.create') }}" class="text-indigo-600 hover:text-indigo-900">Add one now</a>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Summary Table -->
            <div class="mt-8 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Inventory Summary</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rice Type</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Stock (kg)</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Price/kg</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Total Value</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($riceTypes as $rice)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $rice->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">{{ $rice->stock_kg }} kg</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">₱{{ number_format($rice->price_per_kilo, 2) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right font-semibold">₱{{ number_format($rice->stock_kg * $rice->price_per_kilo, 2) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">No rice types found.</td>
                                    </tr>
                                @endforelse
                                @if($riceTypes->count() > 0)
                                    <tr class="bg-gray-50 font-semibold">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Total Inventory</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">{{ $riceTypes->sum('stock_kg') }} kg</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">-</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">₱{{ number_format($riceTypes->sum(function($r) { return $r->stock_kg * $r->price_per_kilo; }), 2) }}</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
