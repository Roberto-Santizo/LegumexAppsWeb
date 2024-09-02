@extends('layouts.administracion')

@section('titulo')
Permisos
@endsection

@section('contenido')
<x-alertas />


<div class="flex w-full justify-between items-center">
    <x-link route="usuarios" text="Volver" icon="fa-solid fa-arrow-left" />
    <x-link route="usuarios.permissions-create" text="Crear Permiso" icon="fa-solid fa-plus" />
</div>

<div class="overflow-x-auto mt-10">
    <table class="tabla">
        <thead class="tabla-head">
            <tr class="md:text-sm text-sm font-bold uppercase text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <th scope="col" class="encabezado">No.</th>
                <th scope="col" class="encabezado">Permiso</th>
                <th scope="col" class="encabezado">Fecha de creación</th>
                <th scope="col" class="encabezado">Última fecha de actualización</th>
                <th scope="col" class="encabezado">Acciones</th>
            </tr>
        </thead>
        <tbody class="tabla-body">
            @foreach ($permissions as $permission)
            <tr>
                <td class="campo">{{ $permission->id }}</td>
                <td class="campo">{{ $permission->name }}</td>
                <td class="campo">{{ $permission->created_at }}</td>
                <td class="campo">{{ $permission->updated_at }}</td>
                <td class="campo">
                    <a href="{{ route('usuarios.permissions-edit', $permission) }}">
                        <i class="fa-solid fa-pen text-xl icon-link"></i>
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<x-paginacion :items="$permissions" />

@endsection