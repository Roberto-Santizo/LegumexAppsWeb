@extends('layouts.auth')

@section('titulo')
Equipos y Fichas Técnicas
@endsection

@section('contenido')
<x-alertas />

<div class="flex justify-end gap-5">
    <div class="flex flex-col md:flex-row gap-5 justify-center md:justify-end items-center mt-5">
        <x-link route="equipos.create" text="Crear Equipo" class="btn bg-orange-600 hover:bg-orange-800"/>
    </div>

    <div class="flex flex-col md:flex-row gap-5 justify-center md:justify-end items-center mt-5">
        <x-link route="accesorios.create" text="Crear Accesorio" class="btn bg-orange-600 hover:bg-orange-800"/>
    </div>
</div>

<livewire:equipos-controller-index />

@endsection