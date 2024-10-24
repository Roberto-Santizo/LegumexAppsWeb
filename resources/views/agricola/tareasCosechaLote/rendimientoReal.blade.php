@extends('layouts.agricola')

@section('titulo')
    Registro de Rendimiento Real (Ingresado en Planta)
@endsection

@section('contenido')

<x-alertas />
<x-link-volver ruta="planSemanal.tareasCosechaLote" class="bg-green-moss hover:bg-green-meadow" :parametros="[$lote,$plansemanalfinca]"/>


@if ($tarealotecosecha->tarea->cultivo->id === 1)
    <livewire:toma-rendimiento-diario-real-brocoli :lote="$lote" :plansemanalfinca="$plansemanalfinca" :tarealotecosecha="$tarealotecosecha"/>
@elseif ($tarealotecosecha->tarea->cultivo->id === 2)
    <livewire:toma-rendimiento-diario-real-ejote />
@endif
 

@endsection