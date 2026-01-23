<x-app-layout>
    <div class="py-12">
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

                <div class="relative w-full md:w-96">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 20 20" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                    </div>
                    <input type="text" id="search-menu"
                        class="block w-full p-2.5 pl-10 text-sm border border-gray-300 rounded-full bg-gray-50 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                        placeholder="Buscar platillo..." autocomplete="off">
                </div>
                <a href="{{ route('menu.create') }}"
                        class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-full font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 transition ease-in-out duration-150 shadow-md">
                        Agregar un nuevo platillo
                    </a>
            </div>

            <div id="menu-container">
                @include('menu.partials.menu-list')
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
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
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