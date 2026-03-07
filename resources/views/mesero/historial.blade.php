<x-app-layout>
    <div class="py-6 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-md mx-auto px-4">

            <div class="flex items-center justify-between mb-6">
                <a href="{{ route('mesero.dashboard') }}" class="p-2 rounded-full hover:bg-gray-200 dark:hover:bg-gray-700">
                    <svg class="w-6 h-6 text-gray-600 dark:text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200">Historial</h2>
                <div class="w-10"></div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl p-4 shadow-sm mb-6 border border-gray-100 dark:border-gray-700" x-data="{ tipo: 'dia' }">
                <div class="flex gap-2 mb-3 overflow-x-auto pb-1">
                    <button @click="tipo = 'dia'" :class="tipo === 'dia' ? 'bg-black text-white' : 'bg-gray-100 text-gray-600'" class="px-4 py-1.5 rounded-full text-xs font-bold whitespace-nowrap transition">Por día</button>
                    <button @click="tipo = 'mes'" :class="tipo === 'mes' ? 'bg-black text-white' : 'bg-gray-100 text-gray-600'" class="px-4 py-1.5 rounded-full text-xs font-bold whitespace-nowrap transition">Por mes</button>
                    <button @click="tipo = 'anio'" :class="tipo === 'anio' ? 'bg-black text-white' : 'bg-gray-100 text-gray-600'" class="px-4 py-1.5 rounded-full text-xs font-bold whitespace-nowrap transition">Por año</button>
                </div>

                <form action="{{ route('mesero.historial') }}" method="GET" class="flex gap-2">
                    <input x-show="tipo === 'dia'" type="date" name="fecha" value="{{ request('fecha') }}" class="w-full rounded-lg border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white text-sm">
                    <input x-show="tipo === 'mes'" type="month" name="mes" value="{{ request('mes') }}" class="w-full rounded-lg border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white text-sm">
                    <select x-show="tipo === 'anio'" name="anio" class="w-full rounded-lg border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white text-sm">
                        @for($i = date('Y'); $i >= 2026; $i--)
                            <option value="{{ $i }}" {{ request('anio') == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>

                    <button type="submit" class="bg-indigo-600 text-white p-2 rounded-lg shadow-md">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                    </button>
                    
                    @if(request()->hasAny(['fecha', 'mes', 'anio']))
                        <a href="{{ route('mesero.historial') }}" class="bg-red-100 text-red-600 p-2 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                        </a>
                    @endif
                </form>
            </div>

            <div class="space-y-4">
                @forelse($ordenes as $orden)
                    <div x-data="{ open: false }" class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden transition-all duration-200">
                        
                        <div @click="open = ! open" class="p-4 flex justify-between items-center cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700/50">
                            <div>
                                <div class="flex items-center gap-2">
                                    <h3 class="font-bold text-gray-800 dark:text-white text-lg">Mesa: {{ $orden->mesa->nombre }}</h3>
                                    <span class="text-xs bg-gray-100 text-gray-500 px-2 py-0.5 rounded border border-gray-200">#{{ $orden->id }}</span>
                                </div>
                                <p class="text-xs text-gray-400 mt-1">
                                    {{ $orden->created_at->format('d M') }}
                                </p>
                            </div>
                            
                            <div class="text-right flex items-center gap-3">
                                <div>
                                    <span class="block font-extrabold text-lg text-gray-900 dark:text-white">
                                        ${{ number_format($orden->total, 2) }}
                                    </span>
                                    <span class="text-xs text-green-600 font-bold">Pagado</span>
                                </div>
                                <svg :class="{'rotate-180': open}" class="w-5 h-5 text-gray-400 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>

                        <div x-show="open" 
                             style="display: none;"
                             x-transition.opacity.duration.300ms
                             class="bg-gray-50 dark:bg-gray-900/50 border-t border-gray-100 dark:border-gray-700 p-4">
                            
                            <h4 class="text-xs font-bold text-gray-500 uppercase mb-2 tracking-wide">Detalle del consumo</h4>
                            
                            <ul class="space-y-3 text-sm">
                                @foreach($orden->detalles as $detalle)
                                <li class="flex justify-between items-start">
                                    <div class="flex gap-3">
                                        <span class="font-bold text-gray-900 dark:text-white min-w-[1.5rem]">{{ $detalle->cantidad }}x</span>
                                        <div>
                                            <p class="text-gray-700 dark:text-gray-300 leading-tight">{{ $detalle->producto->nombre }}</p>
                                            @if($detalle->notas)
                                                <p class="text-xs text-gray-400 italic mt-0.5">{{ Str::limit($detalle->notas, 30) }}</p>
                                            @endif
                                        </div>
                                    </div>
                                    <span class="font-medium text-gray-600 dark:text-gray-400">
                                        ${{ number_format($detalle->precio_unitario * $detalle->cantidad, 2) }}
                                    </span>
                                </li>
                                @endforeach
                            </ul>
                            
                            <div class="mt-4 pt-3 border-t border-gray-200 dark:border-gray-700 flex justify-between items-center">
                                <span class="text-xs text-gray-500">Total final</span>
                                <span class="font-bold text-gray-900 dark:text-white border-b-2 border-indigo-500">
                                    ${{ number_format($orden->total, 2) }}
                                </span>
                            </div>
                        </div>

                    </div>
                @empty
                    <div class="flex flex-col items-center justify-center py-12 opacity-60">
                        <svg class="w-16 h-16 text-gray-300 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <p class="text-gray-500">No hay ventas registradas con estos filtros.</p>
                    </div>
                @endforelse

                <div class="mt-6">
                    {{ $ordenes->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>