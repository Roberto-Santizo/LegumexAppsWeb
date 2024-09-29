@extends('layouts.agricola')

@section('titulo')
Plan Semanal Lote - {{ $lote->nombre }} Semana {{ $plansemanalfinca->semana }}
@endsection

@section('contenido')

@if ($semanaActual <= $plansemanalfinca->semana)
    <div class="flex flex-row justify-end">
        <a href="{{ route('planSemanal.tareaLote.create',[$lote,$plansemanalfinca]) }}" class="btn bg-green-moss hover:bg-green-meadow uppercase">
            <i class="fa-solid fa-plus"></i>
            CREAR TAREA
        </a>
    </div>
@endif


<x-alertas />


<div class="bg-white p-6 rounded-lg shadow-lg mt-10 container mx-auto">

    <livewire:mostrar-tareas-lote :tareas="$tareas" :plansemanalfinca="$plansemanalfinca" :lote="$lote"/>
    
</div>

@endsection