@extends('layouts.administracion')

@section('titulo')
Dashboard Admin
@endsection

@section('contenido')
@php
    $color = '#999999';
@endphp
<x-alertas />

<div class="flex flex-col gap-5 xl:grid xl:grid-cols-8 mt-10" data-aos="zoom-in">
    <div class="col-start-1 col-span-5 bg-gray-200 rounded-2xl shadow-xl">
        <div class="bg-gray-300 w-full p-5 flex flex-row gap-2 items-center text-gray-600 rounded-t-2xl">
            <i class="fa-solid fa-user text-2xl"></i>
            <h1 class="text-2xl font-bold">Manejo de Usuarios</h1>
        </div>

        <div class="grid grid-cols-3 lg:flex lg:flex-row lg:items-center lg:flex-wrap gap-5 p-5">
            <a href="{{ route('usuarios.create') }}"
                class="flex flex-col justify-between items-center hover:bg-gray-300 rounded-xl lg:p-5 grow-animation-sm">
                <x-circle-plus :color="$color"/>
                <p class="text-sm text-center font-bold uppercase">Crear un Usuario</p>
            </a>

            <a href="{{ route('usuarios.roles-create') }}"
                class="flex flex-col justify-between items-center hover:bg-gray-300 rounded-xl lg:p-5 grow-animation-sm">
                <x-circle-plus :color="$color"/>
                <p class="text-sm text-center font-bold uppercase">Crear Rol</p>
            </a>

            <a href="{{ route('usuarios.permissions-create') }}"
                class="flex flex-col justify-between items-center hover:bg-gray-300 rounded-xl lg:p-5 grow-animation-sm">
                <x-circle-plus :color="$color"/>
                <p class="text-sm text-center font-bold uppercase">Crear Permiso</p>
            </a>

            <a href="{{ route('usuarios.supervisores-create') }}"
                class="flex flex-col justify-between items-center hover:bg-gray-300 rounded-xl lg:p-5 grow-animation-sm">
               <x-circle-plus :color="$color"/>
                <p class="text-sm text-center font-bold uppercase">Crear Supervisor</p>
            </a>
        </div>
    </div>

    <div class=" col-start-1 col-span-8 bg-gray-200 rounded-2xl shadow-xl mt-5">
        <div class="bg-gray-300 w-full p-5 flex flex-row gap-2 items-center text-gray-600 rounded-t-2xl">
            <i class="fa-solid fa-user text-2xl"></i>
            <h1 class="text-2xl font-bold">Ultimos logeos</h1>
        </div>

        <div class="p-2 h-96 overflow-y-auto">
            <table class="tabla">
                <thead class="bg-gray-400">
                    <tr class="text-xs md:text-sm rounded">
                        <th scope="col" class="text-white">Nombre</th>
                        <th scope="col" class="text-white">Ultima versión vista</th>
                        <th scope="col" class="text-white">Fecha de logueo</th>
                    </tr>
                </thead>
                <tbody class="tabla-body">
                    @foreach ($sessions as $session)
                        <tr>
                            <td class="campo text-center">{{ $session->user->name  ?? 'No se encontró nombre'}}</td>
                            <td class="campo text-center">{{ $session->user->last_seen_version  ?? 'No se encontró version'}}</td>
                            <td class="campo text-center">{{ $session->ultima_coneccion }} </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection