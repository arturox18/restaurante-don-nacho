<x-app-layout>
    <div class="py-12">
        <div class="max-w-lg mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-6 justify-center flex">
                    Nueva categoría
                </h2>

                <form method="POST" action="{{ route('categorias.store') }}">
                    @csrf

                    <div class="mb-4">
                        <x-input-label for="nombre" :value="__('Nombre de la categoría')" />
                        <x-text-input id="nombre" class="block mt-1 w-full" type="text" name="nombre" :value="old('nombre')" required autofocus placeholder="Ej: Postres, Bebidas..." />
                        <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end mt-4 gap-4">
                        <a href="{{ route('menu.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 font-medium text-sm">
                            Cancelar
                        </a>
                        
                        <x-primary-button>  
                            {{ __('Guardar categoría') }}
                        </x-primary-button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>