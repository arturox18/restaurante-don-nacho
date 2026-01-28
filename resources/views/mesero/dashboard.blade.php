<x-app-layout>
    <div class="py-6">
        <div class="max-w-md mx-auto sm:px-6 lg:px-8">
            
            <h2 class="text-2xl font-bold text-center text-gray-800 dark:text-gray-200 mb-6">
                Bienvenido, {{ Auth::user()->name }}
            </h2>

            <div class="grid grid-cols-2 gap-4 px-4">
                @foreach($mesas as $mesa)
                <a href="{{ route('mesero.catalogo', $mesa) }}" class="group">
                    <div class="bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 rounded-xl p-6 flex flex-col items-center justify-center shadow-sm hover:border-indigo-500 hover:shadow-md transition duration-200 h-40">
                        <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center mb-3 group-hover:bg-indigo-50 dark:group-hover:bg-indigo-900">
                            <svg class="w-8 h-8 text-gray-500 group-hover:text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                            </svg>
                        </div>
                        <span class="font-bold text-gray-800 dark:text-gray-200 text-lg">{{ $mesa->nombre }}</span>
                        
                        <span class="text-xs mt-1 {{ $mesa->estado == 'ocupada' ? 'text-red-500' : 'text-green-500' }}">
                            {{ ucfirst($mesa->estado) }}
                        </span>
                    </div>
                </a>
                @endforeach
            </div>

        </div>
    </div>
</x-app-layout>