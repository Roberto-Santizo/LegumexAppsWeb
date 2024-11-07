<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @stack('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css"
        integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <title>LegumexApps - @yield('titulo')</title>
    <style>
        .scroll-container {
            overflow-y: scroll;
            scrollbar-width: none;
        }

        .scroll-container::-webkit-scrollbar {
            width: 2px;
        }

        .scroll-container::-webkit-scrollbar-thumb {
            background-color: #4a4a4a;
            border-radius: 4px;
        }

        .scroll-container::-webkit-scrollbar-track {
            background-color: #f1f1f1;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    @livewireStyles
    @stack('styles')
</head>

<body class="flex flex-col h-screen hide-scrollbar scrollable">
    <header
        class="header flex flex-row h-24 justify-between bg-blue-500 p-5 text-white w-full fixed top-0 left-0 z-10 items-center">
        <div class="w-28 flex flex-row">
            <img src="{{ asset('img/LOGO_LX.png'); }}" alt="Imagen Login de Usuarios" class="hidden md:block">
            <div class="flex flex-row gap-5 justify-center items-center">
                <p class="text-4xl font-bold">LegumexApps</p>
            </div>
            <img src="{{ asset('img/noviembre_icon.gif'); }}" alt="Imagen Barrilete" class="hidden md:block w-14">
        </div>

        <div class="hidden md:flex justify-center items-center gap-2 bg-orange-600 p-3 rounded shadow-xl">
            <p class="text-2xl font-bold">Mantenimiento</p>
            <i class="fa-solid fa-screwdriver-wrench"></i>
        </div>

        <div class="flex-row gap-2 hidden md:flex">
            <div id="btnProfile">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor"
                    class="h-16 w-16 cursor-pointer hover:bg-blue-600 rounded-lg transition-colors">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                </svg>
            </div>

        </div>
        <i class="fa-solid fa-bars text-5xl md:hidden" id="btnMenuMobile"></i>
    </header>

    <div class="md:flex md:flex-row flex-1 pt-24">
        <aside
            class="pb-32 hidden h-full w-32 bg-blue-500 text-white md:flex flex-col items-center fixed top-24 scroll-container z-20"
            id="menu-nav">

            <x-navegacion />

        </aside>

        <div id="contenido" class="flex-1 md:ml-32 p-10  w-full  md:w-full hide-scrollbar scrollable">
            <div id="profileModal"
                class="p-5 shadow-2xl hidden fixed z-20 right-2 top-28 bg-white hide-scrollbar scrollable">
                <div class="flex w-full mb-5 justify-between">
                    <img src="{{ asset('img/LOGO_LX.png') }}" alt="Imagen Logo" class="h-10 w-20">
                    <span id="close-btn" class="cursor-pointer"><i class="fa-solid fa-arrow-left mb-5"
                            id="close-btn"></i></span>
                </div>
                <div class="flex flex-col gap-5">
                    <p class="font-bold">{{ auth()->user()->name }}</p>
                    <p><span class="font-bold">Nombre de usuario:</span> {{ auth()->user()->username }}</p>
                    <p><span class="font-bold">Correo:</span> {{ auth()->user()->email }}</p>
                    <p>Agroindustria Legumex S.A</p>
                </div>
                <div class="mt-10 flex flex-row gap-2">
                    <form action="{{ route('logout.microsoft') }}" method="POST">
                        @csrf
                        <input type="submit" value="Cerrar Sesión"
                            class="mt-5 bg-orange-500 cursor-pointer hover:bg-orange-700 text-white font-bold py-2 px-4 rounded inline-block ">
                    </form>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <input type="submit" value="Utilizar otro Usuario"
                            class="mt-5 bg-orange-500 cursor-pointer hover:bg-orange-700 text-white font-bold py-2 px-4 rounded inline-block ">
                    </form>

                    <div class="btn" id="permiso_camara">
                        <i class="fa-solid fa-camera"></i>
                    </div>
                </div>
            </div>

            <h1 id="titulo" class="text-2xl font-bold md:text-4xl">@yield('titulo')</h1>
            @yield('contenido')
        </div>
    </div>
    @livewireScripts
    @stack('scripts')

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>

</html>