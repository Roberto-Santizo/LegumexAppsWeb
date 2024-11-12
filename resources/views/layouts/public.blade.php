<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css"
        integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://code.iconify.design/iconify-icon/2.1.0/iconify-icon.min.js"></script>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}" />
    <title>AgroIndustria Legumex</title>
    @vite('resources/css/app.css')
</head>

<body class="flex flex-col h-screen justify-between">
    <header class="p-5 border-b bg-white shadow">
        <div class="container mx-auto flex justify-between">
            <a href="{{ route('home') }}" class="w-28 flex flex-row items-center">
                <img src="{{ asset('img/LOGO_LX.png'); }}" alt="Imagen Login de Usuarios">
                <p class="text-3xl items-center text-gray-500 font-bold hidden md:block">LegumexApps</p>
            </a>

            <div class="flex flex-row gap-5 items-center justify-center">
                @guest
                <a href="{{ route('login') }}">
                    <div
                        class="flex gap-1 justify-center items-center mt-5 p-2 rounded-lg">
                        <iconify-icon icon="material-symbols:login" class="text-4xl block md:hidden"></iconify-icon>
                        <p class="hidden sm:block text-xl hover:text-gray-400">Iniciar sesión</p>
                    </div>
                </a>
                @endguest

                @auth
                    <a class="text-xs font-bold uppercase bg-sky-500 p-3 text-white hover:bg-sky-600" href="{{ route('dashboard') }}">Administración</a>
                    <form action="{{ route('logout') }}" method="POST"
                        class="flex justify-center items-center">
                        @csrf
                        <input type="submit" value="Cerrar Sesión"
                            class="text-xs font-bold uppercase cursor-pointer bg-orange-500 p-3 text-white hover:bg-orange-600">
                    </form>
                @endauth
            </div>
        </div>
    </header>

    <main >
        <h2 class="text-center text-4xl mb-10 font-bold p-5 md:p-0">
            @yield('titulo')
        </h2>
        @yield('contenido')
    </main>

    <footer class="text-center p-8 text-gray-500 font-bold uppercase mt-10 border">
        AgroIndustria Legumex - Todos los derechos reservados {{ now()->year }}
    </footer>
</body>

</html>