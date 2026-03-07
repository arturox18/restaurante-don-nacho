<x-app-layout>
    <div class="py-6 min-h-screen bg-gray-50 dark:bg-gray-900">
        <div class="max-w-md mx-auto sm:px-6 lg:px-8 relative">
            
            <div class="flex items-center justify-between px-4 mb-6">
                <a href="{{ route('mesero.dashboard') }}" class="p-2 bg-white dark:bg-gray-800 rounded-full shadow-sm hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                    <svg class="w-6 h-6 text-gray-600 dark:text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <div class="text-center">
                    <h2 class="text-xl font-extrabold text-gray-800 dark:text-white">{{ $mesa->nombre }}</h2>
                    <p class="text-xs text-gray-500 font-medium tracking-wide uppercase mt-0.5">Selecciona la categoría</p>
                </div>
                <div class="w-10"></div> 
            </div>

            <div class="px-4 mb-6 relative z-50">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" id="buscador-global" 
                           placeholder="Buscar un platillo rápido..." 
                           autocomplete="off"
                           class="w-full pl-12 pr-4 py-3.5 rounded-2xl border-gray-200 dark:border-gray-700 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm dark:bg-gray-800 dark:text-white text-base font-medium transition-all">
                    
                    <button id="btn-limpiar" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-gray-600 hidden">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>

                <div id="resultados-busqueda" class="absolute left-4 right-4 mt-2 bg-white dark:bg-gray-800 rounded-xl shadow-xl border border-gray-100 dark:border-gray-700 overflow-hidden hidden max-h-80 overflow-y-auto z-50">
                    <ul id="lista-resultados" class="divide-y divide-gray-100 dark:divide-gray-700">
                        </ul>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 px-4 pb-10" id="grid-categorias">
                @foreach($categorias as $categoria)
                <a href="{{ route('mesero.platillos', [$mesa, $categoria]) }}" class="group">
                    <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-4 flex flex-col items-center justify-center shadow-sm hover:border-indigo-500 transition duration-200 h-36">
                        <div class="w-12 h-12 bg-gray-50 dark:bg-gray-700 rounded-lg flex items-center justify-center mb-2 group-hover:bg-indigo-50 transition">
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const buscador = document.getElementById('buscador-global');
            const contenedorResultados = document.getElementById('resultados-busqueda');
            const listaResultados = document.getElementById('lista-resultados');
            const btnLimpiar = document.getElementById('btn-limpiar');
            const gridCategorias = document.getElementById('grid-categorias');

            // Recibimos los platillos con sus categorías desde Laravel
            const productos = @json($productos);
            const mesaId = {{ $mesa->id }};

            buscador.addEventListener('input', function(e) {
                const query = e.target.value.toLowerCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "").trim();
                
                if (query.length > 0) {
                    btnLimpiar.classList.remove('hidden');
                    gridCategorias.style.opacity = '0.3'; 
                    
                    const resultados = productos.filter(producto => {
                        const nombre = producto.nombre.toLowerCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "");
                        return nombre.includes(query);
                    });

                    mostrarResultados(resultados);
                } else {
                    limpiarBuscador();
                }
            });

            function mostrarResultados(resultados) {
                listaResultados.innerHTML = ''; 
                
                if (resultados.length === 0) {
                    listaResultados.innerHTML = `<li class="p-4 text-center text-gray-500 text-sm">No se encontraron platillos.</li>`;
                } else {
                    resultados.forEach(producto => {
                        // Construimos la URL directo al detalle del platillo
                        const url = `/mesas/${mesaId}/platillo/${producto.id}`;
                        
                        // Obtenemos el nombre de la categoría (si no tiene, ponemos 'General')
                        const nombreCategoria = producto.categoria ? producto.categoria.nombre : 'General';
                        
                        const li = document.createElement('li');
                        li.innerHTML = `
                            <a href="${url}" class="flex items-center justify-between p-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                <div>
                                    <span class="block font-bold text-gray-800 dark:text-gray-200 leading-tight">${producto.nombre}</span>
                                    <span class="inline-flex items-center gap-1 text-xs text-gray-500 dark:text-gray-400 mt-1">
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" /></svg>
                                        En: <b>${nombreCategoria}</b>
                                    </span>
                                </div>
                                <div class="text-right pl-3">
                                    <span class="text-sm font-black text-indigo-600 dark:text-indigo-400">$${Number(producto.precio).toFixed(2)}</span>
                                    <span class="block text-[10px] text-gray-400 font-bold uppercase mt-0.5 tracking-wider">Pedir &rarr;</span>
                                </div>
                            </a>
                        `;
                        listaResultados.appendChild(li);
                    });
                }
                
                contenedorResultados.classList.remove('hidden');
            }

            function limpiarBuscador() {
                buscador.value = '';
                btnLimpiar.classList.add('hidden');
                contenedorResultados.classList.add('hidden');
                gridCategorias.style.opacity = '1';
            }

            btnLimpiar.addEventListener('click', limpiarBuscador);

            document.addEventListener('click', function(e) {
                if (!buscador.contains(e.target) && !contenedorResultados.contains(e.target)) {
                    contenedorResultados.classList.add('hidden');
                    gridCategorias.style.opacity = '1';
                }
            });
        });
    </script>
</x-app-layout>