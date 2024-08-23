@extends('layouts.administracion')

@section('titulo')
Asignación de Empleados {{ $tarea->tarea }}, Semana {{ $plansemanalfinca->semana }}
@endsection

@section('contenido')

<x-alertas />

@php
$clasesAlertas = 'bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center';
$clasesLabel = 'mb-2 block uppercase text-gray-500 font-bold';
$clasesInput = 'border p-3 w-full rounded-lg';
$clasesEnlaces = 'bg-orange-500 cursor-pointer hover:bg-orange-700 text-white font-bold py-2 px-4 rounded inline-block
mt-5 mb-5';
@endphp

<div class="grid grid-cols-3 mt-10">
    <div class="col-span-2">
        <h1 class="text-2xl font-bold">Información de la tarea: </h1>

        <p><span class="text-xl font-bold">Descripción: </span>{{ $tarea->descripcion }}</p>

        <div class="flex gap-2">
            <p class="text-xl font-bold">Cupos Disponibles: </p>
            <p class="text-xl font-bold" id="cupos" data-cupos="{{ $tarealote->personas }}">{{ $tarealote->cupos }}</p>
        </div>

        <div class="mt-5 w-1/2">
            <h1 class="text-2xl font-bold">Usuarios Asignados a esta tarea: </h1>

            <div id="usuariosAsignadosContainer" class="flex flex-col gap-2 mt-5">
                @foreach ($ingresos as $ingreso)
                    @if(in_array($ingreso->emp_id,$asignados))
                    <div class="border p-3 selected text-white rounded cursor-pointer empleados"
                        data-user="{{ $ingreso->emp_id }}">
                        <div class="flex flex-row items-center gap-3">
                            <i class="fa-solid fa-user text-2xl"></i>
                            <div>
                                <p class="font-bold">{{ $ingreso->empleado->first_name }}</p>
                                <p class="font-bold">Número de Tareas Asignadas: {{ $ingreso->total_asignaciones }}</p>
                                <input type="hidden" value="{{ $ingreso->emp_id }}" id="usuario_id">
                            </div>
                        </div>
                    </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>

    <div>
        <h1 class="text-2xl font-bold">Usuarios Disponibles: </h1>
        <input type="text" id="buscarUsuario" placeholder="Buscar usuario..."
            class="border p-2 rounded mt-4 mb-4 w-full">

        <div class="mt-2 flex flex-col gap-2 overflow-y-auto h-96" id="disponiblesContainer">


            @foreach ($ingresos as $ingreso)
                @if(!in_array($ingreso->emp_id,$asignados))
                <div class="border p-3 not-selected text-white rounded cursor-pointer empleados"
                    data-user="{{ $ingreso->emp_id }}">
                    <div class="flex flex-row items-center gap-3">
                        <i class="fa-solid fa-user text-2xl"></i>
                        <div>
                            <p class="font-bold">{{ $ingreso->empleado->first_name }}</p>
                            <p class="font-bold">Número de Tareas Asignadas: {{ $ingreso->total_asignaciones }}</p>
                            <input type="hidden" value="{{ $ingreso->emp_id }}" id="usuario_id">
                        </div>
                    </div>
                </div>
                @endif
            @endforeach
        </div>
    </div>

    <form method="POST" action="{{ route('asignacionDiaria.store',[$lote,$plansemanalfinca])  }}">
        @csrf
        <input type="hidden" value="{{ $tarealote->id }}" id="tarealote_id" name="tarealote_id">
        <input type="submit" value="Cerrar Asignación Diaria" class="cursor-pointer bg-orange-500 text-white p-2 font-bold rounded hover:bg-orange-600">
    </form>
    

</div>
@endsection