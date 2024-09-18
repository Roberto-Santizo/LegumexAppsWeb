@extends('layouts.agricola')

@section('titulo')
Plan Semanal Lote - {{ $lote->nombre }} Semana {{ $plansemanalfinca->semana }}
@endsection

@section('contenido')

<div class="flex flex-row justify-end">
    <a href="{{ route('planSemanal.tareaLote.create',[$lote,$plansemanalfinca]) }}" class="btn uppercase">
        <i class="fa-solid fa-plus"></i>
        CREAR TAREA
    </a>
</div>

<x-alertas />


<div class="bg-white p-6 rounded-lg shadow-lg mt-10 container mx-auto">

    <livewire:mostrar-tareas-lote :tareas="$tareas" :plansemanalfinca="$plansemanalfinca" :lote="$lote"/>
    
</div>

@endsection