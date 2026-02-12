<x-app-layout>
    <div class="py-6 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-md mx-auto px-4">

            <div class="flex items-center justify-between mb-6">
                <a href="{{ route('mesero.dashboard') }}" class="p-2 rounded-full hover:bg-gray-200 dark:hover:bg-gray-700">
                    <svg class="w-6 h-6 text-gray-600 dark:text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200">Mis órdenes activas</h2>
                <div class="w-10"></div>
            </div>

            @if($ordenes->isEmpty())
                <div class="text-center py-10">
                    <p class="text-gray-500 dark:text-gray-400">No tienes órdenes activas.</p>
                </div>
            @else
                <div class="space-y-4">
                    @foreach($ordenes as $orden)
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                            
                            <div class="px-4 py-3 flex justify-between items-center bg-gray-50 dark:bg-gray-700/50 border-b border-gray-100 dark:border-gray-700">
                                <h3 class="font-bold text-lg text-gray-800 dark:text-white">
                                    {{ $orden->mesa->nombre }}
                                </h3>
                                
                                @php
                                    $estilos = match($orden->estatus) {
                                        'pendiente' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                        'cocinando' => 'bg-orange-100 text-orange-800 border-orange-200',
                                        'listo' => 'bg-green-100 text-green-800 border-green-200',
                                        default => 'bg-gray-100 text-gray-800'
                                    };
                                    $icono = match($orden->estatus) {
                                        'pendiente' => '⏳',
                                        'cocinando' => '🔥',
                                        'listo' => '✅',
                                        default => ''
                                    };
                                @endphp
                                <span class="px-3 py-1 rounded-full text-xs font-bold border {{ $estilos }}">
                                    {{ $icono }} {{ ucfirst($orden->estatus) }}
                                </span>
                            </div>

                            <div class="p-4">
                                <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">
                                    {{ $orden->created_at->format('h:i A') }} &bull; {{ $orden->detalles->count() }} artículos
                                </p>
                                
                                <div class="flex justify-between items-end mt-2">
                                    <a href="{{ route('mesero.carrito', $orden->mesa) }}" class="text-indigo-600 dark:text-indigo-400 text-sm font-semibold hover:underline">
                                        Ver detalles &rarr;
                                    </a>
                                    <span class="text-xl font-bold text-gray-900 dark:text-white">
                                        ${{ number_format($orden->total, 2) }}
                                    </span>
                                </div>
                            </div>

                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </div>
</x-app-layout>