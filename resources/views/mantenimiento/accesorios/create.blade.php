@extends('layouts.auth')

@section('titulo')
    Crear Accesorio
@endsection

@section('contenido')

<x-alertas />

<x-link-volver ruta="equipos" class="bg-orange-600 hover:bg-orange-800"/>

<livewire:create-accesorio-form />


@endsection