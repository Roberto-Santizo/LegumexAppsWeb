@extends('layouts.agricola')

@section('titulo')
    Toma de Rendimiento {{ $plansemanalfinca->finca->finca }} - {{ $lote->nombre }} - {{ $tarealotecosecha->tarea->tarea  }} - S{{ $plansemanalfinca->semana }}
@endsection

@section('contenido')

<x-alertas />

<livewire:toma-rendimiento-cosecha-personal :lote="$lote" :plansemanalfinca="$plansemanalfinca" :tarealotecosecha="$tarealotecosecha"/>

@endsection