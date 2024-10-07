@extends('layouts.agricola')

@section('titulo')
Plan Semanal Lote - {{ $lote->nombre }} Semana {{ $plansemanalfinca->semana }}
@endsection

@section('contenido')

<x-alertas />


<div class="bg-white p-6 rounded-lg shadow-lg mt-10 container mx-auto">

    <livewire:mostrar-tareas-lote :tareas="$tareas" :plansemanalfinca="$plansemanalfinca" :lote="$lote"/>
    
</div>

@endsection