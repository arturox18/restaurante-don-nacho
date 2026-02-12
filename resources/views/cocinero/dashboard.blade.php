<x-app-layout>
    <meta http-equiv="refresh" content="30">

    <div class="py-6 bg-gray-100 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-3xl font-extrabold text-gray-800 dark:text-white">
                    Pedidos en Cocina
                </h2>
                <div class="text-sm text-gray-500 dark:text-gray-400">
                    Actualizando automáticamente...
                </div>
            </div>

            @if($ordenes->isEmpty())
                <div class="flex flex-col items-center justify-center py-20 text-gray-500 dark:text-gray-400">
                    <svg class="w-20 h-20 mb-4 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <p class="text-xl font-medium">Todo tranquilo. No hay pedidos pendientes.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    
                    @foreach($ordenes as $orden)
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border-l-8 border-indigo-500 overflow-hidden flex flex-col order-card" data-timestamp="{{ $orden->updated_at->timestamp }}">
                        
                        <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 flex justify-between items-center border-b border-gray-100 dark:border-gray-600">
                            <div>
                                <h3 class="text-xl font-bold text-gray-800 dark:text-white">
                                    Mesa: {{ $orden->mesa->nombre }}
                                </h3>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    Mesero: {{ $orden->usuario->name }}
                                </p>
                            </div>
                            <div class="flex items-center text-gray-700 dark:text-gray-200 font-mono text-lg font-bold bg-gray-200 dark:bg-gray-600 px-2 py-1 rounded">
                                ⏱️ <span class="timer ml-1">00:00</span>
                            </div>
                        </div>

                        <div class="p-4 flex-1">
                            <ul class="divide-y divide-gray-100 dark:divide-gray-700">
                                @foreach($orden->detalles as $detalle)
                                <li class="py-2 flex justify-between">
                                    <div class="pr-2">
                                        <div class="font-bold text-gray-800 dark:text-gray-200 text-lg leading-tight">
                                            {{ $detalle->producto->nombre }}
                                        </div>
                                        @if($detalle->notas)
                                            <div class="text-sm text-red-500 font-semibold mt-1 bg-red-50 dark:bg-red-900/20 p-1 rounded inline-block">
                                                {{ $detalle->notas }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="text-2xl font-extrabold text-indigo-600 dark:text-indigo-400 pl-3">
                                        x{{ $detalle->cantidad }}
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="p-4 bg-gray-50 dark:bg-gray-700/50 mt-auto">
                            <form action="{{ route('cocinero.terminar', $orden) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="w-full bg-gray-800 hover:bg-gray-900 dark:bg-white dark:text-gray-900 text-white font-bold py-3 rounded-lg shadow transition transform active:scale-95 text-lg">
                                    Finalizar Orden
                                </button>
                            </form>
                        </div>

                    </div>
                    @endforeach

                </div>
            @endif
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function updateTimers() {
                const now = Math.floor(Date.now() / 1000);
                
                document.querySelectorAll('.order-card').forEach(card => {
                    const timestamp = parseInt(card.getAttribute('data-timestamp'));
                    const diff = now - timestamp;
                    
                    // Formato MM:SS
                    const minutes = Math.floor(diff / 60).toString().padStart(2, '0');
                    const seconds = (diff % 60).toString().padStart(2, '0');
                    
                    // Actualizar texto
                    card.querySelector('.timer').textContent = `${minutes}:${seconds}`;

                    // Cambiar color por urgencia
                    // Si lleva más de 15 minutos (900 seg), pon el borde ROJO
                    if (diff > 900) {
                        card.classList.remove('border-indigo-500', 'border-yellow-400');
                        card.classList.add('border-red-600');
                    } 
                    // Si lleva más de 8 minutos (480 seg), pon el borde AMARILLO
                    else if (diff > 480) {
                        card.classList.remove('border-indigo-500');
                        card.classList.add('border-yellow-400');
                    }
                });
            }

            // Actualizar cada segundo
            setInterval(updateTimers, 1000);
            updateTimers(); // Ejecutar inmediatamente al cargar
            
            // Recargar la página completa cada 15 segundos para buscar nuevos pedidos
            setTimeout(() => {
                window.location.reload();
            }, 15000);
        });
    </script>
</x-app-layout>