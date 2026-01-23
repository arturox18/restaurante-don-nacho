<x-app-layout>
    <div class="py-12">
        <div class="max-w-lg mx-auto sm:px-6 lg:px-8">

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg p-6">
                <h2 class="text-3xl font-semibold text-gray-800 dark:text-gray-200 p-6 text-center">
                    Agregar platillo
                </h2>
                <form method="POST" action="{{ route('menu.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="flex justify-center mb-6">
                        <div class="relative group">
                            <div
                                class="w-40 h-40 rounded-xl bg-gray-100 dark:bg-gray-700 flex items-center justify-center border-2 border-dashed border-gray-300 dark:border-gray-600 overflow-hidden">
                                <img id="preview-img" class="w-full h-full object-cover hidden">
                                <span id="default-text" class="text-gray-400 text-sm text-center px-2">Subir foto</span>
                            </div>
                            <label for="imagen"
                                class="absolute bottom-2 right-2 bg-white p-2 rounded-full shadow cursor-pointer hover:bg-gray-50">
                                <svg class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                            </label>
                            <input type="file" id="imagen" name="imagen" class="hidden" accept="image/*"
                                onchange="previewFile()">
                        </div>
                    </div>

                    <div>
                        <x-input-label for="nombre" :value="__('Nombre del platillo')" />
                        <x-text-input id="nombre" class="block mt-1 w-full" type="text" name="nombre"
                            :value="old('nombre')" required autofocus />
                    </div>

                    <div class="grid grid-cols-2 gap-4 mt-4">
                        <div>
                            <x-input-label for="precio" :value="__('Precio ($)')" />
                            <x-text-input id="precio" class="block mt-1 w-full" type="number" step="0.50"
                                name="precio" :value="old('precio')" required />
                        </div>
                        <div>
                            <x-input-label for="categoria_id" :value="__('Categoría')" />
                            <select name="categoria_id"
                                class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 rounded-md shadow-sm">
                                @foreach ($categorias as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mt-4">
                        <x-input-label for="descripcion" :value="__('Descripción')" />
                        <textarea name="descripcion"
                            class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 rounded-md shadow-sm"
                            rows="3">{{ old('descripcion') }}</textarea>
                    </div>

                    <div class="flex items-center justify-center mt-6">
                        <button type="button" onclick="window.location='{{ route('menu.index') }}'" class="mr-4 px-4 py-2 bg-red-800 dark:bg-red-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-red-800 uppercase tracking-widest hover:bg-red-700 dark:hover:bg-white transition ease-in-out duration-150">
                                Cancelar
                            </button>
                        <x-primary-button class="justify-center">
                            {{ __('Crear Platillo') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function previewFile() {
            const preview = document.getElementById('preview-img');
            const defaultText = document.getElementById('default-text');
            const file = document.getElementById('imagen').files[0];
            const reader = new FileReader();

            reader.onloadend = function() {
                preview.src = reader.result;
                preview.classList.remove('hidden');
                if (defaultText) defaultText.classList.add('hidden');
            }
            if (file) reader.readAsDataURL(file);
        }
    </script>
</x-app-layout>
