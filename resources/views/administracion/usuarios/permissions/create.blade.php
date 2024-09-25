@extends('layouts.administracion')

@section('titulo')
    Crear Permiso
@endsection

@section('contenido')
   <x-alertas />

   <x-link route="usuarios.roles" text="Volver" icon="fa-solid fa-arrow-left" class="btn bg-sky-600 hover:bg-sky-800"/>

    <form action="{{ route('usuarios.permissions-store') }}" method="POST">
        @csrf

        <x-input type="text" name="name" label="Nombre del Permiso" value="{{ old('name') }}" placeholder="Nombre del Permiso" />

        <input type="submit" value="Crear" class=" btn bg-sky-600 hover:bg-sky-800">
    </form>

@endsection