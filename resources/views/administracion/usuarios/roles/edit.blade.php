@extends('layouts.administracion')

@section('titulo')
    Editar Rol
@endsection

@section('contenido')
   <x-alertas />

   <x-link route="usuarios" text="Volver" icon="fa-solid fa-arrow-left" />
   

    <form action="{{ route('usuarios.roles-update',$role) }}" method="POST">
        @csrf
        @method('PATCH')

        <x-input type="text" name="name" label="Nombre" value="{{ $role->name }}" placeholder="Nombre del Rol" />

        <input type="submit" value="Guardar" class=" btn">
    </form>

@endsection