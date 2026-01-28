<x-app-layout>
    <div class="py-6 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-md mx-auto px-4">
            
            <div class="text-center mb-6">
                <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200">{{ $mesa->nombre }}</h2>
                <p class="text-indigo-600 font-bold text-lg">{{ $producto->categoria->nombre }}</p>
                <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white mt-1">{{ $producto->nombre }}</h1>
            </div>

            <form action="{{ route('mesero.agregar', [$mesa, $producto]) }}" method="POST">
                @csrf
                
                <div class="flex justify-center mb-6">
                    <div class="w-40 h-40 bg-white p-2 rounded-2xl shadow-sm">
                         @if($producto->imagen)
                            <img src="{{ asset('storage/' . $producto->imagen) }}" class="w-full h-full object-cover rounded-xl">
                        @else
                            <div class="w-full h-full bg-gray-200 rounded-xl flex items-center justify-center">
                                <svg class="w-12 h-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Piezas</label>
                    <input type="number" name="cantidad" value="1" min="1" class="block w-full text-center text-2xl font-bold border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 py-3">
                </div>

                <div class="space-y-4 mb-6">
                    @foreach(['Miel', 'Chispas', 'Chocolate', 'Fruta'] as $extra)
                    <div class="flex items-center justify-between bg-white dark:bg-gray-800 p-3 rounded-lg border border-gray-200 dark:border-gray-700">
                        <span class="font-medium text-gray-700 dark:text-gray-300">{{ $extra }}</span>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="extras[]" value="{{ $extra }}" class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 dark:peer-focus:ring-indigo-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-green-500"></div>
                        </label>
                    </div>
                    @endforeach
                </div>

                <div class="mb-8">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Comentarios</label>
                    <textarea name="comentarios" rows="3" class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="Ej: Sin cebolla, muy cocido..."></textarea>
                </div>

                <div class="flex gap-4">
                    <a href="{{ route('mesero.platillos', [$mesa, $producto->categoria_id]) }}" class="w-1/2 bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-4 rounded-xl text-center transition">
                        Cancelar
                    </a>
                    <button type="submit" class="w-1/2 bg-gray-900 hover:bg-gray-800 dark:bg-white dark:text-gray-900 font-bold py-3 px-4 rounded-xl text-center transition">
                        Confirmar
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>