@forelse($categorias as $categoria)
    <div class="mb-8">
        <h3 class="text-xl font-bold text-gray-800 dark:text-gray-200 mb-4 px-2 border-l-4 border-indigo-500">
            {{ $categoria->nombre }}
        </h3>

        <div
            class="overflow-x-auto bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg border border-gray-200 dark:border-gray-700">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-black-500 dark:text-black-300 uppercase w-1/3">
                            Platillo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-black-500 dark:text-black-300 uppercase">
                            Foto</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-black-500 dark:text-black-300 uppercase">
                            Precio</th>
                        <th
                            class="px-6 py-3 text-center text-xs font-medium text-black-500 dark:text-black-300 uppercase">
                            Acción</th>
                        <th
                            class="px-6 py-3 text-center text-xs font-medium text-black-500 dark:text-black-300 uppercase">
                            Estado</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach ($categoria->productos as $producto)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-750">
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-700 dark:text-white">{{ $producto->nombre }}
                                </div>
                                <div class="text-xs text-gray-500">{{ Str::limit($producto->descripcion, 40) }}</div>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="h-16 w-16 flex-shrink-0">
                                    @if ($producto->imagen)
                                        <img class="h-16 w-16 rounded-lg object-cover border border-gray-200"
                                            src="{{ asset('storage/' . $producto->imagen) }}"
                                            alt="{{ $producto->nombre }}">
                                    @else
                                        <div
                                            class="h-16 w-16 rounded-lg bg-gray-100 dark:bg-gray-700 flex items-center justify-center text-gray-400">
                                            <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                            </td>

                            <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-200 font-bold">
                                ${{ number_format($producto->precio, 2) }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex item-center justify-center gap-2">
                                    <a href="{{ route('menu.edit', $producto) }}"
                                        class="p-2 bg-blue-100 hover:bg-gray-200 text-gray-800 rounded-full transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                    </a>

                                    <button
                                        @click="open = true; action = '{{ route('menu.destroy', $producto) }}'; itemName = '{{ $producto->nombre }}'"
                                        class="p-2 bg-red-100 hover:bg-red-50 text-red-800 rounded-full transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <form action="{{ route('menu.toggleStatus', $producto) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button type="submit"
                                        class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $producto->is_active ? 'bg-green-100 text-green-800 hover:bg-green-200' : 'bg-gray-100 text-gray-800 hover:bg-gray-200' }} cursor-pointer">
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
