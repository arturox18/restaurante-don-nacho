<x-app-layout>
    <div class="py-6">
        <div class="max-w-md mx-auto sm:px-6 lg:px-8">
            
            <div class="flex items-center justify-between px-4 mb-6">
                <a href="{{ route('mesero.dashboard') }}" class="p-2 rounded-full hover:bg-gray-200 dark:hover:bg-gray-700">
                    <svg class="w-6 h-6 text-gray-600 dark:text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <div class="text-center">
                    <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200">{{ $mesa->nombre }}</h2>
                    <p class="text-sm text-gray-500">Selecciona la categoría</p>
                </div>
                <div class="w-10"></div> </div>

            <div class="grid grid-cols-2 gap-4 px-4">
                @foreach($categorias as $categoria)
                <a href="{{ route('mesero.platillos', [$mesa, $categoria]) }}" class="group">
                    <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-4 flex flex-col items-center justify-center shadow-sm hover:border-indigo-500 transition duration-200 h-36">
                        <div class="w-12 h-12 bg-gray-50 dark:bg-gray-700 rounded-lg flex items-center justify-center mb-2">
                             <svg class="w-6 h-6 text-gray-400 group-hover:text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                        </div>
                        <span class="font-semibold text-gray-800 dark:text-gray-200 text-center text-sm">
                            {{ $categoria->nombre }}
                        </span>
                    </div>
                </a>
                @endforeach
            </div>

        </div>
    </div>
</x-app-layout>