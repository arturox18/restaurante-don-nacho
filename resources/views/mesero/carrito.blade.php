<x-app-layout>
    <div class="py-6 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-md mx-auto px-4">

            <h2 class="text-2xl font-bold text-center text-gray-800 dark:text-gray-200 mb-6">
                Orden para {{ $mesa->nombre }}
            </h2>

            @if (!$orden || $orden->detalles->isEmpty())
                <div class="bg-white dark:bg-gray-800 rounded-xl p-8 text-center shadow-sm">
                    <p class="text-gray-500 mb-4">No has agregado nada a la orden aún.</p>
                    <a href="{{ route('mesero.catalogo', $mesa) }}" class="text-indigo-600 font-bold hover:underline">Ir
                        al Menú</a>
                </div>
            @else
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden mb-8">
                    <div
                        class="bg-gray-200 dark:bg-gray-700 px-4 py-2 flex justify-between font-bold text-gray-700 dark:text-gray-300 text-sm">
                        <span>Platillo</span>
                        <span>Cant.</span>
                    </div>

                    <div class="divide-y divide-gray-100 dark:divide-gray-700">
                        @foreach ($orden->detalles as $detalle)
                            <div class="p-4 flex justify-between items-start">
                                <div>
                                    <h3 class="font-bold text-gray-900 dark:text-white">{{ $detalle->producto->nombre }}
                                    </h3>

                                    @if ($detalle->notas)
                                        <p class="text-xs text-gray-500 mt-1">{{ $detalle->notas }}</p>
                                    @endif

                                    <p class="text-xs font-semibold text-indigo-600 mt-1">
                                        ${{ number_format($detalle->precio_unitario, 2) }}
                                    </p>
                                </div>
                        @endforeach
                    </div>

                    <div
                        class="bg-gray-50 dark:bg-gray-700 px-4 py-3 flex justify-between items-center border-t border-gray-200 dark:border-gray-600">
                        <span class="font-bold text-gray-600 dark:text-gray-300">Total Estimado</span>
                        <span class="font-bold text-xl text-gray-900 dark:text-white">
                            ${{ number_format($orden->detalles->sum(fn($d) => $d->precio * $d->cantidad), 2) }}
                        </span>
                    </div>
                </div>

                <div class="flex flex-col gap-3">
                    <form action="{{ route('mesero.confirmar', $mesa) }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="w-full bg-gray-900 hover:bg-gray-800 dark:bg-white dark:text-gray-900 font-bold py-4 rounded-xl text-center shadow-lg transition transform active:scale-95">
                            Mandar a cocinero
                        </button>
                    </form>

                    <a href="{{ route('mesero.catalogo', $mesa) }}"
                        class="w-full bg-indigo-100 hover:bg-indigo-200 text-indigo-700 font-bold py-3 rounded-xl text-center transition">
                        + Agregar más cosas
                    </a>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
