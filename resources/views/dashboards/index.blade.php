@extends('layouts.administracion')

@section('titulo')
Dashboard Admin
@endsection

@section('contenido')
<div class="flex flex-col gap-5 xl:grid xl:grid-cols-8 mt-10" data-aos="zoom-in">

    <div
        class="flex flex-col justify-between items-center col-start-1 col-span-2 bg-gray-300 rounded-lg p-4 shadow-2xl text-gray-600">
        <div>
            <svg width="400" height="200" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                <g id="SVGRepo_iconCarrier">
                    <circle cx="12" cy="9" r="3" stroke="#a1a1a1" stroke-width="1.5"></circle>
                    <circle cx="12" cy="12" r="10" stroke="#a1a1a1" stroke-width="1.5"></circle>
                    <path d="M17.9691 20C17.81 17.1085 16.9247 15 11.9999 15C7.07521 15 6.18991 17.1085 6.03076 20"
                        stroke="#a1a1a1" stroke-width="1.5" stroke-linecap="round"></path>
                </g>
            </svg>
        </div>
        <p class="font-bold">{{ auth()->user()->name }}</p>
        <p class="font-bold">{{ auth()->user()->getRoleNames()->first() }}</p>
        <p class="font-bold">{{ auth()->user()->email }}</p>
    </div>

    <div class=" col-start-4 col-span-5 bg-gray-200 rounded-2xl shadow-xl">
        <div class="bg-gray-300 w-full p-5 flex flex-row gap-2 items-center text-gray-600 rounded-t-2xl">
            <i class="fa-solid fa-user text-2xl"></i>
            <h1 class="text-2xl font-bold">Manejo de Usuarios</h1>
        </div>

        <div class="grid grid-cols-3 lg:flex lg:flex-row lg:items-center lg:flex-wrap gap-5 p-5">
            <a href="{{ route('usuarios.create') }}"
                class="flex flex-col justify-between items-center hover:bg-gray-300 rounded-xl lg:p-5 grow-animation-sm">
                <div>
                    <svg width="100" height="50" viewBox="0 -0.5 17 17" version="1.1" xmlns="http://www.w3.org/2000/svg"
                        xmlns:xlink="http://www.w3.org/1999/xlink" class="si-glyph si-glyph-circle-plus" fill="#000000">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <title>933</title>
                            <defs> </defs>
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <path
                                    d="M9.021,0.097 C4.625,0.097 1.063,3.655 1.063,8.04 C1.063,12.428 4.625,15.985 9.021,15.985 C13.416,15.985 16.979,12.427 16.979,8.04 C16.979,3.654 13.415,0.097 9.021,0.097 L9.021,0.097 Z M11.325,9.082 L10.088,9.082 L10.088,10.319 C10.088,11.298 10.147,12.088 9,12.088 C7.856,12.088 7.912,11.298 7.912,10.319 L7.912,9.082 L6.675,9.082 C5.696,9.082 4.906,9.138 4.906,7.994 C4.906,6.848 5.696,6.906 6.675,6.906 L7.912,6.906 L7.912,5.669 C7.912,4.69 7.856,3.9 9,3.9 C10.146,3.9 10.088,4.69 10.088,5.669 L10.088,6.906 L11.325,6.906 C12.304,6.906 13.094,6.847 13.094,7.994 C13.094,9.138 12.304,9.082 11.325,9.082 L11.325,9.082 Z"
                                    fill="#9e9e9e" class="si-glyph-fill"> </path>
                            </g>
                        </g>
                    </svg>

                </div>
                <p class="text-sm text-center font-bold uppercase">Crear un Usuario</p>
            </a>

            <a href="{{ route('usuarios.roles-create') }}"
                class="flex flex-col justify-between items-center hover:bg-gray-300 rounded-xl lg:p-5 grow-animation-sm">
                <div>
                    <svg width="100" height="50" viewBox="0 -0.5 17 17" version="1.1" xmlns="http://www.w3.org/2000/svg"
                        xmlns:xlink="http://www.w3.org/1999/xlink" class="si-glyph si-glyph-circle-plus" fill="#000000">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <title>933</title>
                            <defs> </defs>
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <path
                                    d="M9.021,0.097 C4.625,0.097 1.063,3.655 1.063,8.04 C1.063,12.428 4.625,15.985 9.021,15.985 C13.416,15.985 16.979,12.427 16.979,8.04 C16.979,3.654 13.415,0.097 9.021,0.097 L9.021,0.097 Z M11.325,9.082 L10.088,9.082 L10.088,10.319 C10.088,11.298 10.147,12.088 9,12.088 C7.856,12.088 7.912,11.298 7.912,10.319 L7.912,9.082 L6.675,9.082 C5.696,9.082 4.906,9.138 4.906,7.994 C4.906,6.848 5.696,6.906 6.675,6.906 L7.912,6.906 L7.912,5.669 C7.912,4.69 7.856,3.9 9,3.9 C10.146,3.9 10.088,4.69 10.088,5.669 L10.088,6.906 L11.325,6.906 C12.304,6.906 13.094,6.847 13.094,7.994 C13.094,9.138 12.304,9.082 11.325,9.082 L11.325,9.082 Z"
                                    fill="#9e9e9e" class="si-glyph-fill"> </path>
                            </g>
                        </g>
                    </svg>

                </div>
                <p class="text-sm text-center font-bold uppercase">Crear Rol</p>
            </a>

            <a href="{{ route('usuarios.permissions-create') }}"
                class="flex flex-col justify-between items-center hover:bg-gray-300 rounded-xl lg:p-5 grow-animation-sm">
                <div>
                    <svg width="100" height="50" viewBox="0 -0.5 17 17" version="1.1" xmlns="http://www.w3.org/2000/svg"
                        xmlns:xlink="http://www.w3.org/1999/xlink" class="si-glyph si-glyph-circle-plus" fill="#000000">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <title>933</title>
                            <defs> </defs>
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <path
                                    d="M9.021,0.097 C4.625,0.097 1.063,3.655 1.063,8.04 C1.063,12.428 4.625,15.985 9.021,15.985 C13.416,15.985 16.979,12.427 16.979,8.04 C16.979,3.654 13.415,0.097 9.021,0.097 L9.021,0.097 Z M11.325,9.082 L10.088,9.082 L10.088,10.319 C10.088,11.298 10.147,12.088 9,12.088 C7.856,12.088 7.912,11.298 7.912,10.319 L7.912,9.082 L6.675,9.082 C5.696,9.082 4.906,9.138 4.906,7.994 C4.906,6.848 5.696,6.906 6.675,6.906 L7.912,6.906 L7.912,5.669 C7.912,4.69 7.856,3.9 9,3.9 C10.146,3.9 10.088,4.69 10.088,5.669 L10.088,6.906 L11.325,6.906 C12.304,6.906 13.094,6.847 13.094,7.994 C13.094,9.138 12.304,9.082 11.325,9.082 L11.325,9.082 Z"
                                    fill="#9e9e9e" class="si-glyph-fill"> </path>
                            </g>
                        </g>
                    </svg>

                </div>
                <p class="text-sm text-center font-bold uppercase">Crear Permiso</p>
            </a>

            <a href="{{ route('usuarios.supervisores-create') }}"
                class="flex flex-col justify-between items-center hover:bg-gray-300 rounded-xl lg:p-5 grow-animation-sm">
                <div>
                    <svg width="100" height="50" viewBox="0 -0.5 17 17" version="1.1" xmlns="http://www.w3.org/2000/svg"
                        xmlns:xlink="http://www.w3.org/1999/xlink" class="si-glyph si-glyph-circle-plus" fill="#000000">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <title>933</title>
                            <defs> </defs>
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <path
                                    d="M9.021,0.097 C4.625,0.097 1.063,3.655 1.063,8.04 C1.063,12.428 4.625,15.985 9.021,15.985 C13.416,15.985 16.979,12.427 16.979,8.04 C16.979,3.654 13.415,0.097 9.021,0.097 L9.021,0.097 Z M11.325,9.082 L10.088,9.082 L10.088,10.319 C10.088,11.298 10.147,12.088 9,12.088 C7.856,12.088 7.912,11.298 7.912,10.319 L7.912,9.082 L6.675,9.082 C5.696,9.082 4.906,9.138 4.906,7.994 C4.906,6.848 5.696,6.906 6.675,6.906 L7.912,6.906 L7.912,5.669 C7.912,4.69 7.856,3.9 9,3.9 C10.146,3.9 10.088,4.69 10.088,5.669 L10.088,6.906 L11.325,6.906 C12.304,6.906 13.094,6.847 13.094,7.994 C13.094,9.138 12.304,9.082 11.325,9.082 L11.325,9.082 Z"
                                    fill="#9e9e9e" class="si-glyph-fill"> </path>
                            </g>
                        </g>
                    </svg>

                </div>
                <p class="text-sm text-center font-bold uppercase">Crear Supervisor</p>
            </a>
        </div>
    </div>

    <div class=" col-start-1 col-span-8 bg-gray-200 rounded-2xl shadow-xl mt-5">
        <div class="bg-gray-300 w-full p-5 flex flex-row gap-2 items-center text-gray-600 rounded-t-2xl">
            <i class="fa-solid fa-user text-2xl"></i>
            <h1 class="text-2xl font-bold">Ultimos logeos</h1>
        </div>

        <div class="p-3 flex flex-col gap-5">
            @foreach ($sessions as $session)
            <div class="flex flex-row gap-5 p-2 text-gray-600 font-bold rounded-xl shadow-xl">
                <p>{{ $session->user->name  ?? 'No se encontró nombre'}}</p>
                <p>{{ $session->ultima_coneccion }} </p>
            </div>
            @endforeach
        </div>

    </div>

</div>
@endsection