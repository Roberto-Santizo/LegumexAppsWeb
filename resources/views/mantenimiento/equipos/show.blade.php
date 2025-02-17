@extends('layouts.mantenimiento')

@section('titulo')
    Ficha Técnica {{ $equipo->name }}
@endsection

@section('contenido')

<x-link-volver ruta="equipos" class="bg-orange-600 hover:bg-orange-800"/>

<livewire:show-equipo :equipo='$equipo'/>
@endsection