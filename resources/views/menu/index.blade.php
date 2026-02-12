<x-app-layout>
    <div x-data="{ open: false, action: '', itemName: '' }" class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            @endif

            <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
                <div class="flex items-center gap-4 w-full md:w-auto">
                    <h2 class="text-3xl font-bold text-gray-800 dark:text-gray-200">
                        Administrar menú
                    </h2>
                </div>
            </div>

            <div class="flex flex-col md:flex-row items-center gap-4 justify-between mb-6 w-full">
                <div class="relative w-full md:w-96">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 20 20" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                    </div>
                    <input type="text" id="search-menu"
                        class="block w-full p-2.5 pl-10 text-sm border border-gray-300 rounded-full bg-gray-50 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                        placeholder="Buscar platillo..." autocomplete="off">
                </div>

                <div class="flex gap-2 w-full md:w-auto justify-end">
                    <a href="{{ route('categorias.create') }}"
                        class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-full font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 transition ease-in-out duration-150 shadow-md whitespace-nowrap">
                        Crear categoría
                    </a>

                    <a href="{{ route('menu.create') }}"
                        class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 dark:text-gray-800 border border-transparent rounded-full font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white transition ease-in-out duration-150 shadow-md whitespace-nowrap">
                        Crear platillo
                    </a>
                </div>
            </div>

            <div id="menu-container">
                @include('menu.partials.menu-list')
            </div>

        </div>

        <div x-show="open" 
            style="display: none;"
            class="fixed inset-0 z-50 overflow-y-auto" 
            aria-labelledby="modal-title" role="dialog" aria-modal="true">
            
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="open" 
                    x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" 
                    @click="open = false" aria-hidden="true"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div x-show="open" 
                    x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    
                    <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white" id="modal-title">
                                    Eliminar Platillo
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500 dark:text-gray-300">
                                        ¿Estás seguro de que deseas eliminar <span x-text="itemName" class="font-bold"></span>? Esta acción no se puede deshacer.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <form :action="action" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                                Sí, eliminar
                            </button>
                        </form>
                        <button type="button" @click="open = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2 bg-white dark:bg-gray-800 text-base font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancelar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('search-menu');
            const menuContainer = document.getElementById('menu-container');
            let timeout = null;

            searchInput.addEventListener('input', function() {
                const query = this.value;
                clearTimeout(timeout);
                timeout = setTimeout(() => {
                    fetch(`{{ route('menu.index') }}?search=${query}`, {
                            headers: { 'X-Requested-With': 'XMLHttpRequest' }
                        })
                        .then(response => response.text())
                        .then(html => {
                            menuContainer.innerHTML = html;
                        });
                }, 300);
            });
        });
    </script>
</x-app-layout>