@extends('layouts.agricola')

@section('titulo')
    {{ $tarea->tarea->tarea }} - {{ $tarea->lote->nombre }} - Semana {{ $tarea->plansemanal->semana }}
@endsection

@section('contenido')

<x-alertas />

<x-link-volver ruta="planSemanal.tareasLote" class="bg-green-moss hover:bg-green-meadow" :parametros="[$tarea->lote, $tarea->plansemanal]"/>

<livewire:editar-tarea-lote :tareaslote="$tarea"/>

@endsection