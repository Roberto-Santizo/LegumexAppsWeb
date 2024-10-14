@extends('layouts.agricola')

@section('titulo')
    {{ $tarea->tarea->tarea }} - {{ $tarea->plansemanal->finca->finca }} SEMANA - {{ $tarea->plansemanal->semana }}
@endsection

@section('contenido')

<x-alertas />

<div class="mt-10">
    <h2 class="font-bold text-2xl">Información de la tarea: </h2>

    <div class="mt-5 flex gap-5 flex-col shadow-2xl p-5 rounded-xl">
        @php
            $fecha_actual = now(); // Supongo que aquí tienes la fecha actual
            $totalHoras = round($tarea->asignacion->created_at->diffInHours($fecha_actual),1);
            $totalMinutosRestantes = $tarea->asignacion->created_at->diffInMinutes($fecha_actual) % 60;
        @endphp
        <h2 class="font-bold text-xl">Información de la Asignación: </h2>
        <div>
            <p class="text-xl"><span class="font-bold">Fecha de asignación:</span> {{ $tarea->asignacion->created_at->format('d-m-Y h:i:s A') }}</p>
            @if ($tarea->cierre)
                <p class="text-xl"><span class="font-bold">Fecha de Cierre:</span> {{ $tarea->cierre->created_at->format('d-m-Y h:i:s A') }}</p>
            @endif
            <p class="text-xl"><span class="font-bold">Cupos Totales:</span> {{ $tarea->personas }}</p>
            <p class="text-xl"><span class="font-bold">Cupos Asignados:</span> {{ $tarea->users->count() }}</p>

            @if (!$tarea->cierre)
                <p class="text-xl"><span class="font-bold">Horas Empleadas:</span> {{ $totalHoras }} horas {{ $totalMinutosRestantes }} minutos</p>
                
            @endif
        </div>
    </div>

    <div class="mt-5 flex gap-5 flex-col shadow-2xl p-5 rounded-xl">
        <h2 class="font-bold text-xl uppercase">{{ $tarea->cierre ? 'Empleados Que Realizaron la Tarea' : 'Empleados Asignados' }}: </h2>
        <livewire:mostrar-usuarios-asignados :asignaciones="$tarea->users"/>
        
    </div>
</div>
@endsection