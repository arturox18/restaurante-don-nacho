@forelse($categorias as $categoria)
    <div class="mb-8">
        <h3 class="text-xl font-bold text-gray-800 dark:text-gray-200 mb-4 px-2 border-l-4 border-indigo-500">
            {{ $categoria->nombre }}
        </h3>

        <div class="overflow-x-auto bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg border border-gray-200 dark:border-gray-700">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-black-500 dark:text-black-300 uppercase w-1/3">Platillo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-black-500 dark:text-black-300 uppercase">Foto</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-black-500 dark:text-black-300 uppercase">Precio</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-black-500 dark:text-black-300 uppercase">Acción</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-black-500 dark:text-black-300 uppercase">Estado</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($categoria->productos as $producto)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-750">
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-700 dark:text-white">{{ $producto->nombre }}</div>
                            <div class="text-xs text-gray-500">{{ Str::limit($producto->descripcion, 40) }}</div>
                        </td>
                        
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="h-16 w-16 flex-shrink-0">
                                @if($producto->imagen)
                                    <img class="h-16 w-16 rounded-lg object-cover border border-gray-200" src="{{ asset('storage/' . $producto->imagen) }}" alt="{{ $producto->nombre }}">
                                @else
                                    <div class="h-16 w-16 rounded-lg bg-gray-100 dark:bg-gray-700 flex items-center justify-center text-gray-400">
                                        <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                    </div>
                                @endif
                            </div>
                        </td>

                        <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-200 font-bold">
                            ${{ number_format($producto->precio, 2) }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            <a href="{{ route('menu.edit', $producto) }}" class="text-indigo-600 hover:text-indigo-900 font-medium text-sm">Editar</a>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <form action="{{ route('menu.toggleStatus', $producto) }}" method="POST">
                                @csrf @method('PATCH')
                                <button type="submit" class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $producto->is_active ? 'bg-green-100 text-green-800 hover:bg-green-200' : 'bg-gray-100 text-gray-800 hover:bg-gray-200' }} cursor-pointer">
                                    {{ $producto->is_active ? 'Activo' : 'Inactivo' }}
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@empty
    <div class="text-center py-10 text-gray-500">
        No se encontraron platillos.
    </div>
@endforelse