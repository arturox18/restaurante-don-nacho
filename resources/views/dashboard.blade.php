<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="text-center mb-12">
                <h1 class="text-4xl font-extrabold text-gray-900 dark:text-white tracking-tight">
                    Bienvenido {{ Auth::user()->name }}
                </h1>
            </div>

            <div class="flex flex-wrap justify-center gap-8">

                <a href="{{ route('users.index') }}" class="group flex flex-col items-center justify-center w-64 h-64 bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 rounded-3xl shadow-sm hover:shadow-xl hover:border-black dark:hover:border-white transition-all duration-300 transform hover:-translate-y-1 cursor-pointer">
                    <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-full mb-4 group-hover:bg-gray-100 dark:group-hover:bg-gray-600 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 text-gray-800 dark:text-white">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                        </svg>                          
                    </div>
                    <span class="text-xl font-bold text-gray-800 dark:text-white">Usuarios</span>
                </a>

                <a href="{{ route('users.create') }}" class="group flex flex-col items-center justify-center w-64 h-64 bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 rounded-3xl shadow-sm hover:shadow-xl hover:border-black dark:hover:border-white transition-all duration-300 transform hover:-translate-y-1 cursor-pointer">
                    <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-full mb-4 group-hover:bg-gray-100 dark:group-hover:bg-gray-600 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 text-gray-800 dark:text-white">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
                        </svg>
                    </div>
                    <span class="text-xl font-bold text-gray-800 dark:text-white">Registrar usuarios</span>
                </a>
                
                <a href="{{ route('mesas.index') }}" class="group flex flex-col items-center justify-center w-64 h-64 bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 rounded-3xl shadow-sm hover:shadow-xl hover:border-black dark:hover:border-white transition-all duration-300 transform hover:-translate-y-1 cursor-pointer">
                    <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-full mb-4 group-hover:bg-gray-100 dark:group-hover:bg-gray-600 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 text-gray-800 dark:text-white">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" />
                        </svg>
                    </div>
                    <span class="text-xl font-bold text-gray-800 dark:text-white">Administrar mesas</span>
                </a>

                <a href="{{ route('menu.index') }}" class="group flex flex-col items-center justify-center w-64 h-64 bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 rounded-3xl shadow-sm hover:shadow-xl hover:border-black dark:hover:border-white transition-all duration-300 transform hover:-translate-y-1 cursor-pointer">
                    <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-full mb-4 group-hover:bg-gray-100 dark:group-hover:bg-gray-600 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 text-gray-800 dark:text-white">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                        </svg>
                    </div>
                    <span class="text-xl font-bold text-gray-800 dark:text-white">Administrar menú</span>
                </a>

                <a href="#" class="group flex flex-col items-center justify-center w-64 h-64 bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 rounded-3xl shadow-sm hover:shadow-xl hover:border-black dark:hover:border-white transition-all duration-300 transform hover:-translate-y-1 cursor-pointer">
                    <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-full mb-4 group-hover:bg-gray-100 dark:group-hover:bg-gray-600 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 text-gray-800 dark:text-white">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                        </svg>
                    </div>
                    <span class="text-xl font-bold text-gray-800 dark:text-white">Historial de ordenes</span>
                </a>

            </div>
        </div>
    </div>
</x-app-layout>