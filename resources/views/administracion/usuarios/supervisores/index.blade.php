@extends('layouts.administracion')

@section('titulo')
Supervisores
@endsection

@section('contenido')
<x-alertas />
<div class="flex flex-row justify-end ">
    <form action="{{ route('usuarios.supervisores') }}" method="GET" class="mt-5 inline-block mr-5">
        <div>
            <input class="border border-black p-1 rounded" type="text" name="query" placeholder="Buscar...."
                value="{{ old('query', request()->input('query')) }}" autocomplete="off">
            <button type="submit" class="p-2 rounded">
                <i class="fa-solid fa-magnifying-glass icon-link"></i>
            </button>
        </div>
    </form>
    <x-link route="usuarios.supervisores" text="Borrar Filtros" class=" btn bg-sky-600 hover:bg-sky-800"/>
</div>

<div class="flex flex-col md:flex-row w-full justify-between items-center mt-5">
    <x-link route="usuarios" text="Volver" icon="fa-solid fa-arrow-left" class=" btn bg-sky-600 hover:bg-sky-800"/>
    <x-link route="usuarios.supervisores-create" text="Crear Supervisor" icon="fa-solid fa-plus" class=" btn bg-sky-600 hover:bg-sky-800"/>
</div>

<div class="overflow-x-auto mt-10">
    <table class="tabla">
        <thead class="tabla-head">
            <tr class="md:text-sm text-sm font-bold uppercase text-left rtl:text-right text-gray-500">
                <th scope="col" class="encabezado">No.</th>
                <th scope="col" class="encabezado">Nombre</th>
                <th scope="col" class="encabezado">Rol</th>
                <th scope="col" class="encabezado">Estado</th>
                <th scope="col" class="encabezado">Acciones</th>
            </tr>
        </thead>
        <tbody class="tabla-body">
            @foreach ($supervisores as $supervisor)
            <tr>
                <td class="campo">{{ $supervisor->id }}</td>
                <td class="campo">{{ $supervisor->name }}</td>
                <td class="campo">{{ $supervisor->role->name }}</td>
                <td class="campo">
                    <form action="{{ route('usuarios.supervisores-destroy',$supervisor) }}" class="estado"
                        method="POST">
                        @csrf
                        @method('DELETE')
                        <input data-status="{{ $supervisor->status }}" id="supervisor_destroy-button" type="submit"
                            value="{{ ($supervisor->status == 1) ? 'ACTIVO' : 'INACTIVO' }}"
                            class="status-btn {{ ($supervisor->status == 1) ? 'bg-green-500 hover:bg-green-600' : 'bg-red-500 hover:bg-red-600' }}">
                    </form>
                </td>

                <td>
                    <a href="{{ route('usuarios.supervisores-edit', $supervisor) }}">
                        <i class="fa-solid fa-pen text-xl icon-link"></i>
                    </a>
                </td>
            </tr>

            @endforeach
        </tbody>
    </table>
</div>


<x-paginacion :items="$supervisores" />

@endsection