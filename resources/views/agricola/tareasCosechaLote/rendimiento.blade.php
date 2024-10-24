@extends('layouts.agricola')

@section('titulo')
    Toma de Rendimiento {{ $plansemanalfinca->finca->finca }} - {{ $lote->nombre }} - {{ $tarealotecosecha->tarea->tarea  }} - S{{ $plansemanalfinca->semana }}
@endsection

@section('contenido')

<x-alertas />
<x-link-volver ruta="planSemanal.tareasCosechaLote" class="bg-green-moss hover:bg-green-meadow" :parametros="[$tarealotecosecha->lote, $plansemanalfinca]"/>

<livewire:toma-rendimiento-cosecha-personal :lote="$lote" :plansemanalfinca="$plansemanalfinca" :tarealotecosecha="$tarealotecosecha"/>

@endsection