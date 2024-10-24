@extends('layouts.agricola')

@section('titulo')
Asignación de Empleados {{ $tarea->tarea }}, Semana {{ $plansemanalfinca->semana }}
@endsection

@section('contenido')

<x-alertas />
<x-link-volver ruta="planSemanal.tareasCosechaLote" class="bg-green-moss hover:bg-green-meadow" :parametros="[$lote, $plansemanalfinca]"/>

<livewire:asignar-empleados-cosecha :plansemanalfinca="$plansemanalfinca" :tarea="$tarea" :lote="$lote" :tarealotecosecha="$tarealotecosecha"/>

@endsection