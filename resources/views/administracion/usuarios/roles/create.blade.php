@extends('layouts.administracion')

@section('titulo')
Crear Rol
@endsection

@section('contenido')
<x-alertas />

<x-link route="usuarios.roles" text="Volver" icon="fa-solid fa-arrow-left" />

<form action="{{ route('usuarios.roles-store') }}" method="POST">
    @csrf

    <x-input type="text" name="name" label="Nombre del Rol" value="{{ old('name') }}" placeholder="Nombre del Nuevo Rol" />

    <input type="submit" value="Crear"class="btn">
</form>

@endsection