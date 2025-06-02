@extends('layouts.auth')

@section('titulo')
    Editar Rol
@endsection

@section('contenido')
   <x-alertas />

   <x-link route="usuarios.roles" text="Volver" icon="fa-solid fa-arrow-left" class=" btn bg-sky-600 hover:bg-sky-800"/>
   

    <form action="{{ route('usuarios.roles-update',$role) }}" method="POST">
        @csrf
        @method('PATCH')

        <x-input type="text" name="name" label="Nombre" value="{{ $role->name }}" placeholder="Nombre del Rol" />

        <input type="submit" value="Guardar" class=" btn bg-sky-600 hover:bg-sky-800">
    </form>

@endsection