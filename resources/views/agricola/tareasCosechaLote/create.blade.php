@extends('layouts.agricola')

@section('titulo')
    Crear Tarea Cosecha Extraordinaria 
@endsection

@section('contenido')

<x-alertas />
<x-link-volver ruta="planSemanal" class="bg-green-moss hover:bg-green-meadow"/>

<livewire:crear-tarea-cosecha-lote :planes="$planes" :lotes="$lotes" :tareas="$tareas"/>

@endsection