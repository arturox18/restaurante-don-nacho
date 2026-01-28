<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if (session('success'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            @endif

            <div class="flex flex-col md:flex-row justify-between items-start gap-6">
                
                <div class="w-full md:w-2/3">
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-6">Mesas actuales</h2>
                    
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        @foreach($mesas as $mesa)
                            <div class="relative group bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 rounded-2xl p-6 flex flex-col items-center justify-center hover:border-indigo-500 transition duration-200">
                                
                                <div class="w-12 h-12 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mb-2 text-gray-500 dark:text-gray-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 0 0 6 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0 1 18 16.5h-2.25m-7.5 0h7.5m-7.5 0-1 3m8.5-3 1 3m0 0 .5 1.5m-.5-1.5h-9.5m0 0-.5 1.5M9 11.25v1.5M12 9v3.75m3-6v6" />
                                    </svg>
                                </div>
                                
                                <span class="font-bold text-gray-800 dark:text-white">{{ $mesa->nombre }}</span>
                                <span class="text-xs text-gray-400">{{ ucfirst($mesa->estado) }}</span>

                                <form action="{{ route('mesas.destroy', $mesa) }}" method="POST" class="absolute top-2 right-2 opacity-100 md:opacity-0 group-hover:opacity-100 transition-opacity" onsubmit="return confirm('¿Estás seguro de eliminar la {{ $mesa->nombre }}?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1 bg-red-100 text-red-600 rounded-full hover:bg-red-200 focus:outline-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                                            <path fill-rule="evenodd" d="M8.75 1A2.75 2.75 0 0 0 6 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 1 0 .23 1.482l.149-.022.841 10.518A2.75 2.75 0 0 0 7.596 19h4.807a2.75 2.75 0 0 0 2.742-2.53l.841-10.52.149.023a.75.75 0 0 0 .23-1.482A41.03 41.03 0 0 0 14 4.193V3.75A2.75 2.75 0 0 0 11.25 1h-2.5ZM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4ZM8.58 7.72a.75.75 0 0 0-1.5.06l.3 7.5a.75.75 0 1 0 1.5-.06l-.3-7.5Zm4.34.06a.75.75 0 1 0-1.5-.06l-.3 7.5a.75.75 0 1 0 1.5.06l.3-7.5Z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="w-full md:w-1/3 bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 sticky top-24">
                    <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-4">Agregar nueva mesa</h3>
                    
                    <form action="{{ route('mesas.store') }}" method="POST">
                        @csrf
                        <div>
                            <x-input-label for="nombre" :value="__('Nombre de la mesa')" />
                            <x-text-input id="nombre" class="block mt-1 w-full" type="text" name="nombre" placeholder="Ej: Mesa 9 o Terraza 1" required autofocus />
                            <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
                        </div>

                        <div class="mt-6">
                            <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                                Crear mesa
                            </button>
                        </div>
                    </form>

                    <div class="mt-6 pt-6 border-t border-gray-100 dark:border-gray-700">
                        <a href="{{ route('dashboard') }}" class="text-sm text-gray-500 hover:text-gray-900 dark:hover:text-gray-300 flex items-center justify-center">
                            Volver al inicio
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>