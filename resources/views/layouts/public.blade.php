<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}" />
    <title>Legumex - @yield('titulo')</title>
    @vite('resources/css/app.css')
</head>
<body class="flex flex-col h-screen">
    <header class="p-5 border-b bg-white shadow">
        <div class="container mx-auto flex justify-between">
            <div class="w-28 flex flex-row items-center">
                <img src="{{ asset('img/LOGO_LX.png'); }}" alt="Imagen Login de Usuarios">
                <p class="text-3xl items-center text-gray-500 font-bold hidden md:block">LegumexApps</p>
            </div>

         <div class="flex flex-row gap-5 items-center justify-center">
                @if(!$autenticado)
                    <a href="{{ route('redirectToMicrosoft') }}" title="Iniciar sesión con micrososft">
                        <div class="flex gap-1 justify-center items-center mt-5 bg-gray-100 p-2 rounded-lg hover:bg-gray-200">
                            <div>
                                <?xml version="1.0" encoding="utf-8"?>
                                <svg width="800px" height="800px" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg" class="h-7 w-7">
                                    <rect x="17" y="17" width="10" height="10" fill="#FEBA08"/>
                                    <rect x="5" y="17" width="10" height="10" fill="#05A6F0"/>
                                    <rect x="17" y="5" width="10" height="10" fill="#80BC06"/>
                                    <rect x="5" y="5" width="10" height="10" fill="#F25325"/>
                                </svg>
                            </div>
                            <p class="hidden sm:block">Iniciar sesión con Microsoft</p>
                        </div>
                    </a>
                @else
                    <div class="flex gap-2 flex-col sm:flex-row">
                        @auth
                            <a class="text-xs font-bold uppercase bg-sky-500 p-3 text-white hover:bg-sky-600" href="{{ route('dashboard') }}">Administración</a>
                        @endauth

                        <form action="{{ route('logout.microsoft') }}" method="POST" class="flex justify-center items-center">
                            @csrf
                            <input type="submit" value="Cerrar Sesión" class="text-xs font-bold uppercase cursor-pointer bg-orange-500 p-3 text-white hover:bg-orange-600">
                        </form>
                        
                    </div>
                @endif
         </div>
        </div>
    </header>

    <main class="container mx-auto mt-10">
        <h2 class="text-center text-4xl mb-10 font-bold p-5 md:p-0">
            @yield('titulo')
        </h2>
        @yield('contenido')
    </main>

    <footer class="text-center p-8 text-gray-500 font-bold uppercase mt-10">
        AgroIndustria Legumex - Todos los derechos reservados {{ now()->year }}
    </footer>
</body>
</html>
