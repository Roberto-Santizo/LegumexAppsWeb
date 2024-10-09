@extends('layouts.agricola')

@section('titulo')
    Crear Tarea Cosecha Extraordinaria 
@endsection

@section('contenido')

<x-alertas />

<livewire:crear-tarea-cosecha-lote :planes="$planes" :lotes="$lotes" :tareas="$tareas"/>

@endsection