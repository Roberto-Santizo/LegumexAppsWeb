@extends('layouts.administracion')

@section('titulo')
Crear Supervisor
@endsection

@section('contenido')
<x-alertas />

<x-link route="usuarios.supervisores" text="Volver" icon="fa-solid fa-arrow-left" />

<form action="{{ route('usuarios.supervisores-update',$supervisor) }}" method="POST">
    @csrf
    @method('PATCH')

    <x-input type="text" name="name" label="Nombre del Supervisor" value="{{ $supervisor->name }}" placeholder="Nombre del nuevo supervisor" />

    <x-select name="role_id" label="Seleccione un Rol" :options="$roles"  :selected="$supervisor->role->name"/>

    <input type="submit" value="Guardar"
        class=" bg-orange-600 hover:bg-orange-700 p-3 transition-colors cursor-pointer uppercase font-bold text-white rounded-lg">
</form>

@endsection