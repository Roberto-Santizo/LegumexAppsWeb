@extends('layouts.agricola')

@section('titulo')
Plan Semanal Lote - {{ $lote->nombre }} Semana {{ $plansemanalfinca->semana }}
@endsection

@section('contenido')

<x-alertas />


<div class="bg-white p-6 rounded-lg shadow-lg mt-10 container mx-auto">

    <livewire:mostrar-tareas-cosecha-lote :tarea="$tarea" :plansemanalfinca="$plansemanalfinca" :lote="$lote" :semanaActual="$semanaActual"/>
</div>

@endsection