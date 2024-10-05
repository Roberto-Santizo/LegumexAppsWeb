@extends('layouts.agricola')

@section('titulo')
Asignación de Empleados {{ $tarea->tarea }}, Semana {{ $plansemanalfinca->semana }}
@endsection

@section('contenido')

<x-alertas />

<div class="md:grid md:grid-cols-3 mt-10 flex flex-col">
    <div class="col-span-2">
        <h1 class="text-2xl font-bold">Información de la tarea: </h1>

        <p><span class="text-xl font-bold">Descripción: </span>{{ $tarea->descripcion }}</p>

        <div class="flex gap-2">
            <p class="text-xl font-bold">Cupos Disponibles: </p>
            <p class="text-xl font-bold" id="cupos" data-cupos="{{ $tarealote->personas }}">{{ ($tarealote->personas - $tarealote->cupos_utilizados) }}</p>
        </div>

        <div class="flex gap-2">
            <p class="text-xl font-bold">Fecha de la asignación: </p>
            <p class="text-xl font-bold">{{ $hoy }}</p>
        </div>

        <div class="mt-5 md:w-1/2 w-full">
            <h1 class="text-2xl font-bold">Empleados Asignados a esta tarea: </h1>

            <div id="usuariosAsignadosContainer" class="flex flex-col gap-2 mt-5 overflow-y-auto h-96 mb-5">
                @foreach ($ingresos as $ingreso)
                    @if(in_array($ingreso->emp_id,$asignados))
                        <div class="border p-3 selected text-white rounded cursor-pointer empleados"
                            data-user="{{ $ingreso->emp_id }}">
                            <div class="flex flex-row items-center gap-3">
                                <i class="fa-solid fa-user text-2xl"></i>
                                <div>
                                    <p class="font-bold">{{ $ingreso->empleado->first_name }}</p>
                                    <p class="font-bold">Horas del día de hoy: {{ round($ingreso->horas_totales,2) }}</p>
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
        <h1 class="text-2xl font-bold">Empleados Disponibles: </h1>
        <input type="text" id="buscarUsuario" placeholder="Buscar usuario..."
            class="border p-2 rounded mt-4 mb-4 w-full">

        <div class="mt-2 flex flex-col gap-2 overflow-y-auto h-96" id="disponiblesContainer">


            @foreach ($ingresos as $ingreso)
                @if(!in_array($ingreso->emp_id,$asignados))
                    <div class="bg-green-moss hover:bg-green-meadow btn empleados empleadosBuscar"
                        data-user="{{ $ingreso->emp_id }}">
                        <div class="flex flex-row items-center gap-3">
                            <i class="fa-solid fa-user text-2xl"></i>
                            <div>
                                <p class="font-bold">{{ $ingreso->empleado->first_name }}</p>
                                <p class="font-bold">Horas del día de hoy: {{ round($ingreso->horas_totales,2) }}</p>
                                <input type="hidden" value="{{ $ingreso->emp_id }}" id="usuario_id">
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>

    <form method="POST" action="{{ route('asignacionDiaria.store',[$lote,$plansemanalfinca])  }}" class="mt-10 md:mt-0">
        @csrf
        <input type="hidden" value="{{ $tarealote->id }}" id="tarealote_id" name="tarealote_id">
        <input type="submit" value="Cerrar Asignación Diaria" class="btn bg-green-moss hover:bg-green-meadow">
    </form>
    

</div>
@endsection