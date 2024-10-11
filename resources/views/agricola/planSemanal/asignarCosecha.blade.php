@extends('layouts.agricola')

@section('titulo')
Asignación de Empleados {{ $tarea->tarea }}, Semana {{ $plansemanalfinca->semana }}
@endsection

@section('contenido')

<x-alertas />

<livewire:asignar-empleados-cosecha :plansemanalfinca="$plansemanalfinca" :tarea="$tarea" :lote="$lote" :tarealotecosecha="$tarealotecosecha"/>

@endsection