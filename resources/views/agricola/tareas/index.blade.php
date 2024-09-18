@extends('layouts.agricola')

@section('titulo')
Tareas Generales Fincas
@endsection

@section('contenido')

<x-alertas />

<x-link class="bg-green-moss hover:bg-green-meadow" route="tareas.create" text="Crear Tarea" />


<div class="overflow-x-auto mt-10">
    <table class="tabla">
        <thead class="tabla-head">
            <tr class="text-xs md:text-sm">
                <th scope="col" class="encabezado text-left">
                    Nombre de la Tarea</th>
                <th scope="col" class="encabezado text-center">
                    Acciones</th>
            </tr>

        </thead>
        <tbody class="tabla-body">
            @foreach ($tareas as $tarea)
            <tr>
                <td class="campo">{{ $tarea->tarea }}</td>
                <td class="campo flex flex-row gap-5">

                <a href="{{ route('tareas.edit',$tarea) }}">
                    <i class="fa-solid fa-pen icon-link"></i>
                </a>
                
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="my-10">
    {{ $tareas->links('pagination::tailwind') }}
</div>
@endsection