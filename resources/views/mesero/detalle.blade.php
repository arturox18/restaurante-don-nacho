<x-app-layout>
    <div class="py-6 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-md mx-auto px-4">
            
            <div class="text-center mb-6">
                <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200">{{ $mesa->nombre }}</h2>
                <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white mt-2">{{ $producto->nombre }}</h1>
                <p class="text-2xl font-bold text-indigo-600 mt-1">${{ number_format($producto->precio, 0) }}</p>
            </div>

            <form action="{{ route('mesero.agregar', [$mesa, $producto]) }}" method="POST">
                @csrf
                
                <div class="bg-white dark:bg-gray-800 p-4 rounded-xl shadow-sm mb-6 flex justify-between items-center">
                    <span class="font-bold text-gray-700 dark:text-gray-200">Cantidad</span>
                    <div class="flex items-center gap-4">
                        <button type="button" onclick="restar()" class="w-10 h-10 rounded-full bg-gray-200 text-xl font-bold text-gray-600">-</button>
                        <input type="number" id="cantidad" name="cantidad" value="1" min="1" class="w-16 text-center border-none bg-transparent font-bold text-2xl dark:text-white focus:ring-0">
                        <button type="button" onclick="sumar()" class="w-10 h-10 rounded-full bg-indigo-600 text-xl font-bold text-white">+</button>
                    </div>
                </div>

                @foreach($producto->gruposOpciones as $grupo)
                <div class="bg-white dark:bg-gray-800 p-5 rounded-xl shadow-sm mb-4 border border-gray-100 dark:border-gray-700">
                    <div class="flex justify-between mb-3">
                        <h3 class="font-bold text-lg text-gray-800 dark:text-white">{{ $grupo->nombre }}</h3>
                        @if($grupo->es_obligatorio)
                            <span class="text-xs bg-red-100 text-red-600 px-2 py-1 rounded-full font-bold">Requerido</span>
                        @endif
                    </div>
                    <div class="space-y-3">
                        @foreach($grupo->opciones as $opcion)
                        <label class="flex items-center justify-between cursor-pointer p-2 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                            <div class="flex items-center">
                                @if($grupo->es_multiple)
                                    <input type="checkbox" name="opciones[{{ $grupo->id }}][]" value="{{ $opcion->id }}" class="w-5 h-5 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                @else
                                    <input type="radio" name="opciones[{{ $grupo->id }}]" value="{{ $opcion->id }}" class="w-5 h-5 text-indigo-600 border-gray-300 focus:ring-indigo-500" {{ $grupo->es_obligatorio && $loop->first ? 'checked' : '' }}>
                                @endif
                                <span class="ml-3 text-gray-700 dark:text-gray-200 font-medium">{{ $opcion->nombre }}</span>
                            </div>
                            @if($opcion->precio_extra > 0)
                                <span class="text-indigo-600 font-bold text-sm">+${{ number_format($opcion->precio_extra, 0) }}</span>
                            @endif
                        </label>
                        @endforeach
                    </div>
                </div>
                @endforeach

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Notas de cocina</label>
                    <textarea name="notas" rows="2" class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white rounded-lg shadow-sm focus:ring-indigo-500" placeholder="Ej: Sin cebolla..."></textarea>
                </div>

                <div class="mb-8">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Costo Extra Manual ($)</label>
                    <input type="number" name="costo_manual" step="0.50" min="0" placeholder="0.00" class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white rounded-lg shadow-sm focus:ring-indigo-500 text-lg font-bold">
                    <p class="text-xs text-gray-500 mt-1">Úsalo para cobrar extras no listados (ej. envases, ingredientes especiales)</p>
                </div>

                <div class="flex gap-4 pb-8">
                    <a href="{{ url()->previous() }}" class="w-1/3 bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-4 rounded-xl text-center transition">Volver</a>
                    <button type="submit" class="w-2/3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-4 rounded-xl text-center shadow-lg transition transform active:scale-95">Agregar Orden</button>
                </div>
            </form>
        </div>
    </div>
    
    <script>
        function sumar() {
            let input = document.getElementById('cantidad');
            input.value = parseInt(input.value) + 1;
        }
        function restar() {
            let input = document.getElementById('cantidad');
            if (parseInt(input.value) > 1) input.value = parseInt(input.value) - 1;
        }
    </script>
</x-app-layout>