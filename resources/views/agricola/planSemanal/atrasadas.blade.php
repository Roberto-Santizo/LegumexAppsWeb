@extends('layouts.agricola')

@section('titulo')
Plan Semanal {{ $plansemanalfinca->finca->finca }} {{ $plansemanalfinca->semana }}, Tareas Atrasadas
@endsection

@section('contenido')

<x-alertas />
<x-link-volver ruta="planSemanal" class="bg-green-moss hover:bg-green-meadow"/>


<div class="bg-white p-6 rounded-lg shadow-lg mt-10 container mx-auto">
    <livewire:mostrar-tareas-atrasadas :plansemanalfinca="$plansemanalfinca"/>
</div>

@endsection