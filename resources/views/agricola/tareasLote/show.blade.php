@extends('layouts.agricola')

@section('titulo')
    {{ $tarea->tarea->tarea }} - {{ $tarea->plansemanal->finca->finca }} SEMANA - {{ $tarea->plansemanal->semana }}
@endsection

@section('contenido')

<x-alertas />
<x-link-volver ruta="planSemanal.tareasLote" class="bg-green-moss hover:bg-green-meadow" :parametros="[$tarea->lote, $tarea->plansemanal]"/>

<div class="mt-10">
    <h2 class="font-bold text-2xl">Información de la tarea: </h2>

    <div class="mt-5 flex gap-5 flex-col shadow-2xl p-5 rounded-xl">
       
        <h2 class="font-bold text-xl">Información de la Asignación: </h2>
        <div>
            <p class="text-xl"><span class="font-bold">Fecha de asignación:</span> {{ $tarea->asignacion->created_at->format('d-m-Y h:i:s A') }}</p>
            <p class="text-xl"><span class="font-bold">Horas Teoricas:</span> 
                {{ $tarea->horas }}
                @choice('hora|horas', $tarea->horas)</td>
            </p>
            <p class="text-xl"><span class="font-bold">Horas Rendimiento:</span> 
                @php
                    $difhoras = round($tarea->asignacion->created_at->diffinhours($tarea->cierre->created_at),2);
                @endphp
                {{ $difhoras }}
                @choice('hora|horas', $difhoras)
            </p>
            <p class="text-xl"><span class="font-bold">Cupos Totales:</span> {{ $tarea->personas  }}</p>
            <p class="text-xl"><span class="font-bold">Cupos Asignados:</span> {{ $tarea->users()->count() }}</p>
            
        </div>
    </div>

    <div class="mt-5 flex gap-5 flex-col shadow-2xl p-5 rounded-xl">
        <h2 class="font-bold text-xl">Empleados Asignados: </h2>
        <livewire:mostrar-usuarios-asignados :asignaciones="$tarea->users"/>
        
    </div>
</div>
@endsection