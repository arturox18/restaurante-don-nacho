<x-app-layout>
    <div class="py-6">
        <div class="max-w-md mx-auto sm:px-6 lg:px-8">
            
            <div class="flex items-center justify-between px-4 mb-6">
                <a href="{{ route('mesero.catalogo', $mesa) }}" class="p-2 rounded-full hover:bg-gray-200 dark:hover:bg-gray-700">
                    <svg class="w-6 h-6 text-gray-600 dark:text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <div class="text-center">
                    <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200">{{ $mesa->nombre }}</h2>
                    <p class="text-sm font-semibold text-indigo-600">{{ $categoria->nombre }}</p>
                </div>
                <div class="w-10"></div>
            </div>

            <div class="grid grid-cols-2 gap-4 px-4">
                @forelse($productos as $producto)
                <a href="{{ route('mesero.detalle', [$mesa, $producto]) }}" class="group text-left w-full">
                    <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-3 shadow-sm hover:border-indigo-500 transition duration-200 h-full relative overflow-hidden">
                        
                        <div class="w-full h-24 bg-gray-100 dark:bg-gray-700 rounded-lg mb-3 overflow-hidden flex items-center justify-center">
                            @if($producto->imagen)
                                <img src="{{ asset('storage/' . $producto->imagen) }}" class="w-full h-full object-cover">
                            @else
                                <svg class="w-8 h-8 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                            @endif
                        </div>

                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="font-bold text-gray-800 dark:text-gray-200 text-sm leading-tight mb-1">
                                    {{ $producto->nombre }}
                                </h3>
                                <p class="text-indigo-600 font-bold text-sm">
                                    ${{ number_format($producto->precio, 2) }}
                                </p>
                            </div>
                            <div class="bg-indigo-100 text-indigo-600 rounded-full p-1">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                            </div>
                        </div>
                    </div>
                </a>
                @empty
                <div class="col-span-2 text-center text-gray-500 py-10">
                    No hay platillos disponibles en esta categoría.
                </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>