@extends('layouts.agricola')

@section('titulo')
    Asignación de Empleados {{ $tarea->tarea }} - Semana {{ $plansemanalfinca->semana }} - {{ $plansemanalfinca->finca->finca }}
@endsection

@section('contenido')

<livewire:asignar-empleados-tarea :plansemanalfinca="$plansemanalfinca" :lote="$lote" :tarea="$tarea" :tarealote="$tarealote"/>

@endsection