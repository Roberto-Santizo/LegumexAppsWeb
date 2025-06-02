@extends('layouts.auth')

@section('titulo')
Crear Supervisor
@endsection

@section('contenido')
<x-alertas />

<x-link route="usuarios.supervisores" text="Volver" icon="fa-solid fa-arrow-left" class=" btn bg-sky-600 hover:bg-sky-800"/>


<form action="{{ route('usuarios.supervisores-store') }}" method="POST">
    @csrf

    <x-input type="text" name="name" label="Nombre del Supervisor" value="{{ old('name') }}" placeholder="Nombre del nuevo supervisor" />


    <x-select name="role_id" label="Seleccione un Rol" :options="$roles"  />

    <input type="submit" value="Crear" class=" btn bg-sky-600 hover:bg-sky-800">
</form>

@endsection