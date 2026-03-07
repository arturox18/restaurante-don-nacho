<x-app-layout>
    <div class="py-6 bg-gray-100 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex items-center gap-4 mb-6 border-b border-gray-200 dark:border-gray-700 pb-4">
                <a href="{{ route('cocinero.dashboard') }}" class="p-2 bg-white dark:bg-gray-800 rounded-full shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                    <svg class="w-6 h-6 text-gray-600 dark:text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <div>
                    <h2 class="text-2xl font-extrabold text-gray-800 dark:text-white">
                        Historial de Cocina
                    </h2>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl p-4 shadow-sm mb-8 border border-gray-200 dark:border-gray-700" x-data="{ tipo: 'dia' }">
                <div class="flex gap-2 mb-3 overflow-x-auto pb-1">
                    <button @click="tipo = 'dia'" :class="tipo === 'dia' ? 'bg-gray-900 dark:bg-white text-white dark:text-gray-900' : 'bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300'" class="px-4 py-1.5 rounded-full text-xs font-bold whitespace-nowrap transition">Por Día</button>
                    <button @click="tipo = 'mes'" :class="tipo === 'mes' ? 'bg-gray-900 dark:bg-white text-white dark:text-gray-900' : 'bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300'" class="px-4 py-1.5 rounded-full text-xs font-bold whitespace-nowrap transition">Por Mes</button>
                    <button @click="tipo = 'anio'" :class="tipo === 'anio' ? 'bg-gray-900 dark:bg-white text-white dark:text-gray-900' : 'bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300'" class="px-4 py-1.5 rounded-full text-xs font-bold whitespace-nowrap transition">Por Año</button>
                </div>

                <form action="{{ route('cocinero.historial') }}" method="GET" class="flex gap-2">
                    <input x-show="tipo === 'dia'" type="date" name="fecha" value="{{ request('fecha') }}" class="w-full rounded-lg border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white text-sm">
                    <input x-show="tipo === 'mes'" type="month" name="mes" value="{{ request('mes') }}" class="w-full rounded-lg border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white text-sm">
                    <select x-show="tipo === 'anio'" name="anio" class="w-full rounded-lg border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white text-sm">
                        @for($i = date('Y'); $i >= 2024; $i--)
                            <option value="{{ $i }}" {{ request('anio') == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>

                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white p-2 rounded-lg shadow-md transition">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                    </button>
                    
                    @if(request()->hasAny(['fecha', 'mes', 'anio']))
                        <a href="{{ route('cocinero.historial') }}" class="bg-red-100 hover:bg-red-200 text-red-600 p-2 rounded-lg flex items-center justify-center transition" title="Limpiar filtros">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                        </a>
                    @endif
                </form>
            </div>

            @if($ordenes->isEmpty())
                <div class="flex flex-col items-center justify-center py-20 text-gray-500 dark:text-gray-400">
                    <svg class="w-16 h-16 mb-4 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="text-lg">No se encontraron pedidos con estos filtros.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($ordenes as $orden)
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                            
                            <div class="px-4 py-3 bg-green-50 dark:bg-green-900/20 border-b border-green-100 dark:border-green-800/30 flex justify-between items-center">
                                <div>
                                    <span class="font-bold text-green-800 dark:text-green-400 text-lg">
                                        Mesa: {{ $orden->mesa->nombre }}
                                    </span>
                                    <span class="text-xs text-green-600 dark:text-green-500 ml-2">#{{ $orden->id }}</span>
                                </div>
                                <div class="text-right">
                                    <span class="block text-xs font-bold text-gray-500 dark:text-gray-400">Fecha de orden:</span>
                                    <span class="text-sm text-gray-700 dark:text-gray-300">
                                        {{ $orden->updated_at->format('d M Y') }}
                                </div>
                            </div>

                            <div class="p-4">
                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-3 border-b border-gray-100 dark:border-gray-700 pb-2">
                                    <span class="font-semibold">Mesero:</span> {{ $orden->usuario->name }}
                                </p>
                                
                                <ul class="space-y-3">
                                    @foreach($orden->detalles as $detalle)
                                    <li class="flex items-start gap-3">
                                        <div class="bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 font-black rounded px-2 py-1 text-xs mt-0.5">
                                            {{ $detalle->cantidad }}x
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-gray-800 dark:text-gray-200 leading-tight">
                                                {{ $detalle->producto->nombre }}
                                            </p>
                                            @if($detalle->notas)
                                                <p class="text-xs text-gray-500 dark:text-gray-400 italic mt-0.5">
                                                    {{ $detalle->notas }}
                                                </p>
                                            @endif
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $ordenes->links() }}
                </div>
            @endif

        </div>
    </div>
</x-app-layout>