@extends('layouts.administracion')

@section('titulo')
Plan Semanal {{ $plansemanalfinca->finca->finca }} {{ $plansemanalfinca->semana }}, Tareas Atrasadas
@endsection

@section('contenido')

<x-alertas />


<div class="bg-white p-6 rounded-lg shadow-lg mt-10 container mx-auto">
    <livewire:mostrar-tareas-lote :tareas="$tareas" :plansemanalfinca="$plansemanalfinca" :atrasadas="$atrasadas" />
</div>

@endsection