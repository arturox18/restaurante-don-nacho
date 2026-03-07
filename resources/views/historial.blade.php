<x-app-layout>
    <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
                <div>
                    <h2 class="text-3xl font-extrabold text-gray-800 dark:text-white">
                        Historial de Ventas
                    </h2>
                </div>
            </div>

            <div
                class="bg-gradient-to-r from-indigo-600 to-indigo-800 dark:from-indigo-800 dark:to-gray-800 rounded-3xl p-8 text-white shadow-xl mb-8 flex flex-col md:flex-row justify-between items-center overflow-hidden relative">
                <svg class="absolute opacity-10 right-0 top-0 h-full transform translate-x-1/3" viewBox="0 0 100 100"
                    fill="currentColor">
                    <circle cx="50" cy="50" r="50" />
                </svg>

                <div class="relative z-10">
                    <p class="text-indigo-200 text-lg font-medium mb-1 uppercase tracking-wider text-sm">Ingresos del
                        periodo</p>
                    <h3 class="text-5xl font-extrabold tracking-tight">${{ number_format($totalIngresos, 2) }}</h3>
                </div>
                <div
                    class="mt-4 md:mt-0 bg-white/10 border border-white/20 px-6 py-4 rounded-2xl backdrop-blur-md relative z-10 text-center">
                    <p class="text-3xl font-bold">{{ $ordenes->total() }}</p>
                    <p class="text-indigo-200 text-sm font-medium">Órdenes cobradas</p>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm mb-8 border border-gray-100 dark:border-gray-700"
                x-data="{ tipo: 'dia' }">
                <h3 class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest mb-4">Filtros de
                    Búsqueda</h3>

                <form action="{{ route('historial') }}" method="GET">
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-5 items-end">

                        <div class="md:col-span-3">
                            <label
                                class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Período</label>
                            <div class="flex p-1 bg-gray-100 dark:bg-gray-900/50 rounded-lg">
                                <button type="button" @click="tipo = 'dia'"
                                    :class="tipo === 'dia' ?
                                        'bg-white dark:bg-gray-700 shadow-sm text-indigo-600 dark:text-indigo-400' :
                                        'text-gray-500 hover:text-gray-700 dark:text-gray-400'"
                                    class="flex-1 py-1.5 text-sm font-bold rounded-md transition-all">Día</button>
                                <button type="button" @click="tipo = 'mes'"
                                    :class="tipo === 'mes' ?
                                        'bg-white dark:bg-gray-700 shadow-sm text-indigo-600 dark:text-indigo-400' :
                                        'text-gray-500 hover:text-gray-700 dark:text-gray-400'"
                                    class="flex-1 py-1.5 text-sm font-bold rounded-md transition-all">Mes</button>
                                <button type="button" @click="tipo = 'anio'"
                                    :class="tipo === 'anio' ?
                                        'bg-white dark:bg-gray-700 shadow-sm text-indigo-600 dark:text-indigo-400' :
                                        'text-gray-500 hover:text-gray-700 dark:text-gray-400'"
                                    class="flex-1 py-1.5 text-sm font-bold rounded-md transition-all">Año</button>
                            </div>
                        </div>

                        <div class="md:col-span-3">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Selecciona
                                la fecha</label>
                            <input x-show="tipo === 'dia'" type="date" name="fecha" value="{{ request('fecha') }}"
                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white text-sm focus:ring-indigo-500 focus:border-indigo-500 transition">
                            <input x-show="tipo === 'mes'" style="display: none;" type="month" name="mes"
                                value="{{ request('mes') }}"
                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white text-sm focus:ring-indigo-500 focus:border-indigo-500 transition">
                            <select x-show="tipo === 'anio'" style="display: none;" name="anio"
                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white text-sm focus:ring-indigo-500 focus:border-indigo-500 transition">
                                @for ($i = date('Y'); $i >= 2024; $i--)
                                    <option value="{{ $i }}" {{ request('anio') == $i ? 'selected' : '' }}>
                                        {{ $i }}</option>
                                @endfor
                            </select>
                        </div>

                        <div class="md:col-span-4">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Filtrar por
                                Mesero</label>
                            <select name="mesero_id"
                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white text-sm focus:ring-indigo-500 focus:border-indigo-500 transition">
                                <option value="">Todos los meseros</option>
                                @foreach ($meseros as $mesero)
                                    <option value="{{ $mesero->id }}"
                                        {{ request('mesero_id') == $mesero->id ? 'selected' : '' }}>
                                        {{ $mesero->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="md:col-span-2 flex gap-2">
                            <button type="submit"
                                class="flex-1 bg-gray-900 hover:bg-gray-800 dark:bg-white dark:hover:bg-gray-200 dark:text-gray-900 text-white py-2 rounded-lg font-bold shadow-md transition flex justify-center items-center gap-2">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                Buscar
                            </button>
                            @if (request()->hasAny(['fecha', 'mes', 'anio', 'mesero_id']))
                                <a href="{{ route('historial') }}"
                                    class="px-3 py-2 bg-red-50 hover:bg-red-100 dark:bg-red-900/20 dark:hover:bg-red-900/40 text-red-600 dark:text-red-400 rounded-lg font-bold transition flex items-center justify-center"
                                    title="Limpiar Filtros">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </a>
                            @endif
                        </div>

                    </div>
                </form>
            </div>

            <div
                class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                @if ($ordenes->isEmpty())
                    <div class="p-16 text-center">
                        <svg class="w-16 h-16 mx-auto text-gray-300 dark:text-gray-600 mb-4" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <p class="text-xl font-medium text-gray-500 dark:text-gray-400">No se encontraron ventas.</p>
                        <p class="text-sm text-gray-400 mt-1">Prueba seleccionando otras fechas u otro mesero.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr
                                    class="bg-gray-50 dark:bg-gray-900/50 border-b border-gray-200 dark:border-gray-700">
                                    <th
                                        class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        Folio y Fecha</th>
                                    <th
                                        class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        Mesa</th>
                                    <th
                                        class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        Atendido por</th>
                                    <th
                                        class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider text-center">
                                        Artículos</th>
                                    <th
                                        class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider text-right">
                                        Total</th>
                                    <th class="px-4 py-4"></th>
                                </tr>
                            </thead>

                            @foreach ($ordenes as $orden)
                                <tbody x-data="{ open: false }" class="divide-y divide-gray-50 dark:divide-gray-800">
                                    <tr @click="open = !open"
                                        class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition cursor-pointer group">

                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="font-bold text-gray-900 dark:text-white">#{{ $orden->id }}
                                            </div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                                {{ $orden->created_at->format('d M Y') }}</div>
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-indigo-50 text-indigo-700 border border-indigo-100 dark:bg-indigo-900/30 dark:text-indigo-400 dark:border-indigo-800">
                                                {{ $orden->mesa->nombre }}
                                            </span>
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center gap-3">
                                                <div class="h-8 w-8 flex-shrink-0">
                                                    @if ($orden->usuario->profile_photo)
                                                        <img class="h-8 w-8 rounded-full object-cover shadow-sm"
                                                            src="{{ asset('storage/' . $orden->usuario->profile_photo) }}"
                                                            alt="{{ $orden->usuario->name }}">
                                                    @else
                                                        <div
                                                            class="h-8 w-8 rounded-full bg-gray-200 dark:bg-gray-600 flex items-center justify-center text-gray-500 shadow-sm">
                                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                                                stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                            </svg>
                                                        </div>
                                                    @endif
                                                </div>

                                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                                    {{ $orden->usuario->name }}
                                                </span>
                                            </div>
                                        </td>
                                        <span
                                            class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $orden->usuario->name }}</span>
                    </div>
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <span
                            class="text-sm font-bold text-gray-600 dark:text-gray-400">{{ $orden->detalles->sum('cantidad') }}</span>
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap text-right">
                        <span class="text-lg font-black text-green-600 dark:text-green-400">
                            ${{ number_format($orden->total, 2) }}
                        </span>
                    </td>

                    <td
                        class="px-4 py-4 whitespace-nowrap text-right text-gray-400 group-hover:text-indigo-500 transition">
                        <svg :class="{ 'rotate-180': open }"
                            class="w-5 h-5 transition-transform duration-200 inline-block" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 9l-7 7-7-7" />
                        </svg>
                    </td>
                    </tr>

                    <tr x-show="open" style="display: none;" x-transition>
                        <td colspan="6" class="p-0 border-t border-gray-100 dark:border-gray-700">
                            <div class="bg-gray-50/80 dark:bg-gray-900/50 px-8 py-6 shadow-inner">
                                <h4
                                    class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest mb-4">
                                    Desglose de la orden</h4>

                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                                    @foreach ($orden->detalles as $detalle)
                                        <div
                                            class="bg-white dark:bg-gray-800 p-3 rounded-xl border border-gray-200 dark:border-gray-700 flex justify-between items-center shadow-sm">
                                            <div class="flex items-center gap-3">
                                                <span
                                                    class="bg-indigo-50 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-400 font-black rounded-lg px-2.5 py-1 text-sm border border-indigo-100 dark:border-indigo-800/50">
                                                    {{ $detalle->cantidad }}x
                                                </span>
                                                <span
                                                    class="font-bold text-gray-700 dark:text-gray-200 text-sm">{{ $detalle->producto->nombre }}</span>
                                            </div>
                                            <span class="font-semibold text-gray-600 dark:text-gray-400 text-sm">
                                                ${{ number_format($detalle->precio_unitario * $detalle->cantidad, 2) }}
                                            </span>
                                        </div>
                                    @endforeach
                                </div>

                            </div>
                        </td>
                    </tr>
                    </tbody>
                @endforeach

                </table>
            </div>
            @endif
        </div>

        <div class="mt-6">
            {{ $ordenes->links() }}
        </div>

    </div>
    </div>
</x-app-layout>
