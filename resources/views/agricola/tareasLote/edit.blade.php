@extends('layouts.administracion')

@section('titulo')
    {{ $tarea->tarea->tarea }} - {{ $tarea->lote->nombre }} - Semana {{ $tarea->plansemanal->semana }}
@endsection

@section('contenido')

<x-alertas />

<livewire:editar-tarea-lote :tareaslote="$tarea"/>

@endsection