<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-center text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Editar perfil') }}
        </h2>
    </x-slot>

    <div class="py-12 flex justify-center">
        <div class="w-full max-w-lg bg-white dark:bg-gray-800 shadow-lg rounded-xl overflow-hidden p-8">
            
            <form method="post" action="{{ route('profile.update') }}" class="space-y-6" enctype="multipart/form-data">
                @csrf
                @method('patch')

                <div class="flex justify-center mb-6 relative">
                    <div class="relative group">
                        <div class="w-32 h-32 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center border-4 border-white dark:border-gray-700 shadow-sm overflow-hidden">
                            @if(Auth::user()->profile_photo)
                                <img id="preview-image" src="{{ asset('storage/' . Auth::user()->profile_photo) }}" alt="Foto de perfil" class="w-full h-full object-cover">
                            @else
                                <img id="preview-image" src="" alt="" class="w-full h-full object-cover hidden"> <svg id="default-icon" xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                </svg>
                            @endif
                        </div>
                        
                        <label for="photo_input" class="absolute bottom-0 right-0 bg-white dark:bg-gray-700 p-2 rounded-full shadow-md border border-gray-200 dark:border-gray-600 hover:bg-gray-100 cursor-pointer transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-700 dark:text-gray-300" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                            </svg>
                        </label>
                        
                        <input type="file" id="photo_input" name="profile_photo" class="hidden" accept="image/*" onchange="previewFile()">
                    </div>
                </div>

                <div>
                    <x-input-label for="name" :value="__('Nombre')" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full rounded-lg border-gray-300" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>

                <div>
                    <x-input-label for="email" :value="__('Correo electrónico')" />
                    <x-text-input id="email" name="email" type="email" class="mt-1 block w-full rounded-lg border-gray-300" :value="old('email', $user->email)" required autocomplete="username" />
                    <x-input-error class="mt-2" :messages="$errors->get('email')" />
                </div>

                <div>
                    <x-input-label for="password" :value="__('Nueva contraseña')" />
                    <x-text-input id="password" name="password" type="password" class="mt-1 block w-full rounded-lg border-gray-300" autocomplete="new-password" />
                    <x-input-error class="mt-2" :messages="$errors->get('password')" />
                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Dejar en blanco si no deseas cambiar la contraseña.</p>
                </div>

                <div class="flex items-center justify-between gap-4 mt-8 pt-4">
                    <a href="{{ route('profile.show') }}" class="w-1/2 text-center px-4 py-3 bg-red-700 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-800 focus:bg-red-800 active:bg-red-900 transition ease-in-out duration-150">
                        {{ __('Cancelar') }}
                    </a>

                    <button type="submit" class="w-1/2 px-4 py-3 bg-gray-900 dark:bg-white border border-transparent rounded-lg font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-gray-200 focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 transition ease-in-out duration-150">
                        {{ __('Confirmar') }}
                    </button>
                </div>

                @if (session('status') === 'profile-updated')
                    <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-green-600 text-center">
                        {{ __('Perfil actualizado correctamente.') }}
                    </p>
                @endif
            </form>
        </div>
    </div>

    <script>
        function previewFile() {
            const preview = document.getElementById('preview-image');
            const defaultIcon = document.getElementById('default-icon');
            const file = document.querySelector('input[type=file]').files[0];
            const reader = new FileReader();

            reader.onloadend = function () {
                preview.src = reader.result;
                preview.classList.remove('hidden');
                if(defaultIcon) defaultIcon.classList.add('hidden');
            }

            if (file) {
                reader.readAsDataURL(file);
            }
        }
    </script>
</x-app-layout>