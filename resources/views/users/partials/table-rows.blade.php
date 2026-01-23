@foreach ($users as $user)
<tr>
    <td class="px-6 py-4 whitespace-nowrap">
        <div class="h-10 w-10 flex-shrink-0">
            @if($user->profile_photo)
                <img class="h-10 w-10 rounded-full object-cover" src="{{ asset('storage/' . $user->profile_photo) }}">
            @else
                <div class="h-10 w-10 rounded-full bg-gray-200 dark:bg-gray-600 flex items-center justify-center text-gray-500">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                </div>
            @endif
        </div>
    </td>
    
    <td class="px-6 py-4 whitespace-nowrap">
        <div class="text-sm font-medium text-gray-500 dark:text-white">{{ $user->name }}</div>
    </td>

    <td class="px-6 py-4 whitespace-nowrap">
        <div class="text-sm text-gray-500 dark:text-gray-100">{{ $user->email }}</div>
    </td>

    <td class="px-6 py-4 whitespace-nowrap">
        <form action="{{ route('users.updateRole', $user) }}" method="POST">
            @csrf
            @method('PATCH')
            <select name="rol_id" onchange="this.form.submit()" class="text-sm rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white cursor-pointer">
                @foreach($roles as $rol)
                    <option value="{{ $rol->id }}" {{ $user->rol_id == $rol->id ? 'selected' : '' }}>
                        {{ $rol->nombre }}
                    </option>
                @endforeach
            </select>
        </form>
    </td>

    <td class="px-6 py-4 whitespace-nowrap">
        <form action="{{ route('users.toggleStatus', $user) }}" method="POST">
            @csrf
            @method('PATCH')
            <button type="submit" class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $user->is_active ? 'bg-green-100 text-green-800 hover:bg-green-200' : 'bg-red-100 text-red-800 hover:bg-red-200' }} transition-colors cursor-pointer">
                {{ $user->is_active ? 'Activo' : 'Desactivado' }}
            </button>
        </form>
    </td>
</tr>
@endforeach

@if($users->isEmpty())
<tr>
    <td colspan="4" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
        No se encontraron usuarios.
    </td>
</tr>
@endif