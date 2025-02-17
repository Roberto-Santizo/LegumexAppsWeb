@extends('layouts.mantenimiento')

@section('titulo')
    Editar Ficha de Equipo {{ $equipo->name }}
@endsection

@section('contenido')

<x-alertas />

<x-link-volver ruta="equipos" class="bg-orange-600 hover:bg-orange-800"/>

<livewire:edit-equipo :equipo='$equipo'/>
@endsection