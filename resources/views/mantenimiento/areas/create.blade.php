@extends('layouts.mantenimiento')

@section('titulo')
    Crear Nueva Área
@endsection

@section('contenido')

<x-alertas />

<x-link-volver ruta="areas" class="bg-orange-600 hover:bg-orange-800"/>

<livewire:crear-area />
@endsection