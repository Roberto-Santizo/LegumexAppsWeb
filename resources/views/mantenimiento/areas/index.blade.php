@extends('layouts.mantenimiento')

@section('titulo')
Áreas y Ubicaciones
@endsection

@section('contenido')

<x-alertas />

<x-link class="bg-orange-600 hover:bg-orange-800" route="areas.create" text="Crear Área" />

<livewire:areas-controller-index />

@endsection