@extends('layouts.agricola')

@section('titulo')
Plan Semanal {{ $plansemanalfinca->finca->finca }} {{ $plansemanalfinca->semana }}, Tareas Atrasadas
@endsection

@section('contenido')

<x-alertas />


<div class="bg-white p-6 rounded-lg shadow-lg mt-10 container mx-auto">
    <livewire:mostrar-tareas-lote :tareas="$tareasFiltradas" :plansemanalfinca="$plansemanalfinca" :atrasadas="$atrasadas" />
</div>

@endsection