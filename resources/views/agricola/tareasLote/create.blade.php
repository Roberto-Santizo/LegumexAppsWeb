@extends('layouts.agricola')

@section('titulo')
    Crear Tarea Extraordinaria - Lote {{ $lote->nombre }} - Semana {{ $plansemanalfinca->semana }}
@endsection

@section('contenido')

<x-alertas />

<livewire:crear-tarea-lote :lote="$lote" :plansemanalfinca="$plansemanalfinca" :tareas="$tareas"/>

@endsection