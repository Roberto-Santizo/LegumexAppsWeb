@extends('layouts.agricola')

@section('titulo')
Plan Semanal Lote - {{ $lote->nombre }} Semana {{ $plansemanalfinca->semana }}
@endsection

@section('contenido')

<x-alertas />
<x-link-volver ruta="planSemanal.show" class="bg-green-moss hover:bg-green-meadow" :parametros="[$plansemanalfinca]"/>

<div class="bg-white p-6 rounded-lg shadow-lg mt-10 container mx-auto">
    <livewire:mostrar-tareas-lote :tareas="$tareas" :plansemanalfinca="$plansemanalfinca" :lote="$lote"/>
</div>

@endsection