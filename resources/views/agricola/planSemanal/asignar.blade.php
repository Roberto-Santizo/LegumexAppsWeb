@extends('layouts.agricola')

@section('titulo')
    Asignación de Empleados {{ $tarea->tarea }} - Semana {{ $plansemanalfinca->semana }} - {{ $plansemanalfinca->finca->finca }}
@endsection

@section('contenido')

<x-link-volver ruta="planSemanal.tareasLote" class="bg-green-moss hover:bg-green-meadow" :parametros="[$tarealote->lote, $plansemanalfinca]"/>

<livewire:asignar-empleados-tarea :plansemanalfinca="$plansemanalfinca" :lote="$lote" :tarea="$tarea" :tarealote="$tarealote"/>

@endsection