<x-app-layout>

    <div class="py-12 flex justify-center">
        <div class="w-full max-w-md bg-white dark:bg-gray-800 shadow-lg rounded-xl overflow-hidden">
            <h2 class="font-semibold text-3xl text-center text-gray-800 dark:text-gray-200 leading-tight p-4">
            {{ __('Mi perfil') }}
            </h2>
            <div class="p-8 flex flex-col items-center">
                <div class="w-32 h-32 rounded-full bg-gray-200 dark:bg-gray-600 flex items-center justify-center border-4 border-white dark:border-gray-500 shadow-md overflow-hidden mb-4">
                    @if(Auth::user()->profile_photo)
                        <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" alt="Foto de perfil" class="w-full h-full object-cover">
                    @else
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                        </svg>
                    @endif
                </div>

                <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ Auth::user()->name }}</h3>
                <span class="px-3 py-1 mt-2 text-xs font-semibold text-blue-800 bg-blue-100 rounded-full dark:bg-blue-900 dark:text-blue-200">
                    {{ Auth::user()->rol ? Auth::user()->rol->nombre : 'Sin Rol' }}
                </span>
            </div>

            <div class="p-8 space-y-6">
                
                <div class="flex items-center space-x-4">
                    <div class="p-2 bg-gray-100 dark:bg-gray-700 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500 dark:text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Correo electrónico</p>
                        <p class="text-lg font-medium text-gray-800 dark:text-gray-200">{{ Auth::user()->email }}</p>
                    </div>
                </div>

                <div class="flex items-center space-x-4">
                    <div class="p-2 bg-gray-100 dark:bg-gray-700 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500 dark:text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Estado de cuenta</p>
                        <p class="text-lg font-medium text-green-600 dark:text-green-400">Activo</p>
                    </div>
                </div>

                <div class="pt-4">
                    <a href="{{ route('profile.edit') }}" class="block text-center px-4 py-3 bg-gray-900 dark:bg-white border border-transparent rounded-lg font-semibold text-sm text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-gray-200 transition ease-in-out duration-150 shadow-lg">
                        Editar Información
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>