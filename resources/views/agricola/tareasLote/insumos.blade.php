@extends('layouts.agricola')

@section('titulo')
Insumos {{ $tarea->tarea->tarea }} - {{ $tarea->lote->nombre }} - Semana {{ $tarea->plansemanal->semana }}
@endsection

@section('contenido')

<x-alertas />

<x-link-volver ruta="planSemanal.tareasLote" class="bg-green-moss hover:bg-green-meadow" :parametros="[$tarea->lote, $tarea->plansemanal]" />

<x-insumos-table :insumos="$tarea->insumos" />
@endsection