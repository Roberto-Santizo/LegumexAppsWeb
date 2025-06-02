@extends('layouts.auth')

@section('titulo')
    Crear Ficha de Equipo
@endsection

@section('contenido')

<x-alertas />

<x-link-volver ruta="equipos" class="bg-orange-600 hover:bg-orange-800"/>

<livewire:crear-ficha-equipo />
@endsection