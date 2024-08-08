@extends('layouts.administracion')

@section('titulo')
Usuarios
@endsection

@section('contenido')
@if(session('success'))
<p class="bg-green-500 uppercase text-xl text-white my-2 rounded-lg p-2 text-center font-bold">{{ session('success') }}
</p>
@endif
<div>
    <div class="md:inline-block  flex justify-center items-center flex-col">
        <form action="{{ route('usuarios') }}" method="GET" class="mt-5 inline-block mr-5">
            <div class="items-center bg-gray-100 p-2 rounded-lg flex gap-1">
                <input class="border border-black p-1 rounded" type="text" name="query" placeholder="Buscar...."
                    value="{{ old('query') }}" autocomplete="off">
                <button type="submit" class="hover:bg-orange-200 p-2 rounded">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                </button>
            </div>
        </form>

        <a href="{{ route('usuarios.create') }}"
            class="mt-5 bg-orange-500 cursor-pointer hover:bg-orange-700 text-white font-bold py-2 px-4 rounded inline-block ">
            <i class="fa-solid fa-plus"></i>
            Crear Usuario
        </a>

    </div>
    <div class="flex gap-5 justify-center md:justify-end items-center">

        <a href="{{ route('usuarios.roles') }}"
            class="mt-5 bg-orange-500 cursor-pointer hover:bg-orange-700 text-white font-bold py-2 px-4 rounded inline-block ">
            Roles
        </a>

        <a href="{{ route('usuarios.permissions') }}"
            class="mt-5 bg-orange-500 cursor-pointer hover:bg-orange-700 text-white font-bold py-2 px-4 rounded inline-block ">
            Permisos
        </a>

        <a href="{{ route('usuarios.supervisores') }}"
            class="mt-5 bg-orange-500 cursor-pointer hover:bg-orange-700 text-white font-bold py-2 px-4 rounded inline-block ">
            Supervisores - Calidad
        </a>
    </div>
</div>

<div class="overflow-x-auto mt-10">
    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-xs md:text-sm">
        <thead class="bg-gray-50 dark:bg-gray-800">
            <tr class="text-xs md:text-sm">
                <th scope="col"
                    class="p-3 text-sm font-bold uppercase text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    Nombre</th>
                <th scope="col"
                    class="p-3 text-sm font-bold uppercase text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    Nombre de usuario</th>
                <th scope="col"
                    class="p-3 text-sm font-bold uppercase text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    Correo</th>
                <th scope="col"
                    class="p-3 text-sm font-bold uppercase text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    Rol</th>
                <th scope="col"
                    class="p-3 text-sm font-bold uppercase text-center rtl:text-right text-gray-500 dark:text-gray-400">
                    Acciones</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200 dark:divide-gray-700 dark:bg-gray-900">
            @foreach ($usuarios as $usuario)
            <tr>
                <td class="px-4 py-2 text-md font-medium whitespace-nowrap">{{ $usuario->name }}</td>
                <td class="px-4 py-2 text-md font-medium whitespace-nowrap">{{ $usuario->username }}</td>
                <td class="px-4 py-2 text-md font-medium whitespace-nowrap">{{ $usuario->email }}</td>
                <td class="px-4 py-2 text-md font-medium whitespace-nowrap">{{ $usuario->getRoleNames()->first(); }}
                </td>
                <td class="px-4 py-2 text-md font-medium whitespace-nowrap flex gap-5 justify-center items-center">
                    <a href="{{ route('usuarios.edit',$usuario) }}">
                        <i class="fa-solid fa-pen text-xl"></i>
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="my-10">
    {{ $usuarios->links('pagination::tailwind') }}
</div>
@endsection