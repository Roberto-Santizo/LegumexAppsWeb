@extends('layouts.administracion')

@section('titulo')
    Editar Permiso
@endsection

@section('contenido')
  <x-alertas />
    <x-link route="usuarios.permissions" text="Volver" icon="fa-solid fa-arrow-left" />

    <form action="{{ route('usuarios.permissions-update',$permission) }}" method="POST">
        @csrf
        @method('PATCH')

        <x-input type="text" name="name" label="Nombre" value="{{ $permission->name }}" placeholder="Nombre del Permiso" />

        <input type="submit" value="Guardar" class="btn">
    </form>

@endsection