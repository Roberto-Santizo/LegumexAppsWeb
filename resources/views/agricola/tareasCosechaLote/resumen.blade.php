@extends('layouts.agricola')

@section('titulo')
    Resumen de cosecha {{ $tarealotecosecha->tarea->tarea }} - S{{ $tarealotecosecha->plansemanal->semana }} - {{ $tarealotecosecha->lote->nombre  }}
@endsection

@section('contenido')

<x-alertas />
<x-link-volver ruta="planSemanal.tareasCosechaLote" class="bg-green-moss hover:bg-green-meadow" :parametros="[$tarealotecosecha->lote, $tarealotecosecha->plansemanal]"/>

<livewire:resumen-cosecha :tarealotecosecha="$tarealotecosecha"/>
 

@endsection