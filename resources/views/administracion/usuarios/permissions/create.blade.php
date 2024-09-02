@extends('layouts.administracion')

@section('titulo')
    Crear Permiso
@endsection

@section('contenido')
   <x-alertas />

   <x-link route="usuarios.roles" text="Volver" icon="fa-solid fa-arrow-left" />

    <form action="{{ route('usuarios.permissions-store') }}" method="POST">
        @csrf

        <x-input type="text" name="name" label="Nombre del Permiso" value="{{ old('name') }}" placeholder="Nombre del Permiso" />

        <input type="submit" value="Crear" class=" btn">
    </form>

@endsection