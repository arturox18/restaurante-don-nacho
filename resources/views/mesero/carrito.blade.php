<x-app-layout>
    <div class="py-6 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-md mx-auto px-4">

            <h2 class="text-2xl font-bold text-center text-gray-800 dark:text-gray-200 mb-6">
                Orden para {{ $mesa->nombre }}
            </h2>

            <div class="text-center mb-4">
                <span class="px-3 py-1 rounded-full text-sm font-bold bg-indigo-100 text-indigo-800">
                    Estatus: {{ ucfirst($orden ? $orden->estatus : 'Vacío') }}
                </span>
            </div>

            @if (!$orden || $orden->detalles->isEmpty())
                <div class="bg-white dark:bg-gray-800 rounded-xl p-8 text-center shadow-sm">
                    <p class="text-gray-500 dark:text-gray-400 mb-4">No has agregado nada a la orden aún.</p>
                    <a href="{{ route('mesero.catalogo', $mesa) }}"
                        class="text-indigo-600 dark:text-indigo-400 font-bold hover:underline">
                        Ir al Menú
                    </a>
                </div>
            @else
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden mb-8">
                    <div class="bg-gray-200 dark:bg-gray-700 px-4 py-2 flex justify-between font-bold text-gray-700 dark:text-gray-300 text-sm border-b border-gray-900 dark:border-gray-700">
                        <span>Platillo</span>
                        <span>Cant.</span>
                    </div>

                    <div class="divide-y divide-gray-100 dark:divide-gray-700">
                        @foreach ($orden->detalles as $detalle)
                            <div class="p-4 flex justify-between items-start">
                                <div>
                                    <h3 class="font-bold text-gray-900 dark:text-white">{{ $detalle->producto->nombre }}</h3>
                                    @if ($detalle->notas)
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $detalle->notas }}</p>
                                    @endif
                                    <p class="text-xs font-semibold text-blue-600 dark:text-blue-400 mt-1">
                                        ${{ number_format ($detalle->precio_unitario, 2) }}
                                    </p>
                                </div>
                                <div class="text-lg font-bold text-gray-800 dark:text-gray-200">
                                    {{ $detalle->cantidad }}
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="bg-gray-200 dark:bg-gray-700 px-4 py-3 flex justify-between font-bold text-gray-700 dark:text-gray-300 text-sm border-t border-gray-900 dark:border-gray-700 items-center">
                        <span class="font-bold text-gray-600 dark:text-gray-300">Total a Pagar</span>
                        <span class="font-bold text-2xl text-gray-900 dark:text-white">
                            ${{ number_format($orden->detalles->sum(fn($d) => $d->precio_unitario * $d->cantidad), 2) }}
                        </span>
                    </div>
                </div>

                <div class="flex flex-col gap-3">

                    @if ($orden->estatus == 'pendiente' || $orden->estatus == 'vacio' || $orden->estatus == null)
                        
                        <form action="{{ route('mesero.confirmar', $mesa) }}" method="POST" class="flex flex-col gap-3">
                            @csrf
                            <button type="submit" name="accion" value="cocina"
                                class="w-full bg-gray-900 text-white hover:bg-gray-800 dark:bg-white dark:text-gray-900 font-bold py-4 rounded-xl text-center shadow-lg transition transform active:scale-95 flex items-center justify-center gap-2">
                                Mandar a cocinero
                            </button>
                        </form>

                        <a href="{{ route('mesero.catalogo', $mesa) }}"
                            class="w-full bg-indigo-100 hover:bg-indigo-200 text-indigo-700 font-bold py-3 rounded-xl text-center transition">
                            Agregar más cosas
                        </a>

                    @else
                        
                        <div class="flex flex-col gap-3 mt-4">
                            
                            <form action="{{ route('mesero.confirmar', $mesa) }}" method="POST" class="grid grid-cols-2 gap-2 mb-2">
                                @csrf
                                <button type="submit" name="accion" value="cocina" class="bg-gray-800 hover:bg-gray-900 text-white text-sm font-bold py-3 rounded-xl shadow transition transform active:scale-95 flex items-center justify-center gap-1">
                                    Extra a cocina
                                </button>
                                <button type="submit" name="accion" value="cuenta" class="bg-blue-50 hover:bg-blue-100 text-blue-700 border border-blue-200 text-sm font-bold py-3 rounded-xl shadow transition transform active:scale-95 flex items-center justify-center gap-1">
                                    Extra a cuenta
                                </button>
                            </form>

                            <a href="{{ route('mesero.ticket', $mesa) }}" target="_blank"
                                class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-4 rounded-xl text-center shadow-lg transition transform active:scale-95 flex items-center justify-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                </svg>
                                Imprimir ticket y liberar mesa
                            </a>

                            <a href="{{ route('mesero.catalogo', $mesa) }}"
                                class="w-full bg-indigo-50 hover:bg-indigo-100 dark:bg-gray-800 dark:hover:bg-gray-700 text-indigo-700 dark:text-indigo-400 font-bold py-3 rounded-xl text-center transition transform active:scale-95 flex items-center justify-center gap-2 border border-indigo-200 dark:border-gray-600 shadow-sm">
                                ¿Olvidaron algo? Agregar extra
                            </a>
                        </div>

                    @endif

                </div>
            @endif
        </div>
    </div>
</x-app-layout>