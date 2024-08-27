@extends('layouts.administracion')

@section('titulo')
Plan Semanal Lote - {{ $lote->nombre }} Semana {{ $plansemanalfinca->semana }}
@endsection

@section('contenido')

<x-alertas />

<div class="bg-white p-6 rounded-lg shadow-lg mt-10 container mx-auto">
    <div>
        @foreach ($tareas as $tarea)

        <div class="mt-5 flex flex-col md:flex-row justify-between p-5 rounded-xl shadow-xl border-l-8 ">
            <div class="text-xs md:text-xl">
                <p><span class="uppercase font-bold">Nombre del Lote:</span> {{ $tarea->lote->nombre }}</p>
                <p><span class="uppercase font-bold">Semana:</span> {{ $plansemanalfinca->semana }}</p>
                <p><span class="uppercase font-bold">Semana:</span> {{ $tarea->tarea->tarea }}</p>
                <p><span class="uppercase font-bold">Cupos disponibles:</span> {{ ($tarea->personas - $tarea->cupos_utilizados) }}</p>
                <p><span class="uppercase font-bold">Presupuesto:</span> Q{{ $tarea->presupuesto }}</p>
                <p><span class="uppercase font-bold">Horas Necesarias:</span> {{ $tarea->horas }} horas</p>
            </div>

            <div>
                @if (($tarea->asignacion_diaria))
                    <a href="{{ route('planSemanal.rendimiento',$tarea)}}">
                        <i title="Registrar Día" class="fa-solid fa-chart-simple text-3xl  cursor-pointer hover:text-gray-500"></i>
                    </a>
                @else
                    <a href="{{ route('planSemanal.Asignar',[$lote,$plansemanalfinca,$tarea->tarea, $tarea]) }}">
                        <i title="Asignar Empleados"
                            class="fa-solid fa-square-plus text-3xl cursor-pointer hover:text-gray-500"></i>
                    </a>
                @endif
            </div>
        </div>
        @endforeach
    </div>
</div>

@endsection