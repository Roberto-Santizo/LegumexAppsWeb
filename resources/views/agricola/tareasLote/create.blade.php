@extends('layouts.agricola')

@section('titulo')
    Crear Tarea Extraordinaria 
@endsection

@section('contenido')

<x-alertas />

<livewire:crear-tarea-lote :planes="$planes" :lotes="$lotes" :tareas="$tareas"/>

@endsection