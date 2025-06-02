@extends('layouts.auth')

@section('titulo')
    Crear herramienta
@endsection

@section('contenido')
    <x-alertas />
    <x-link route="herramientas" text="Volver" icon="fa-solid fa-arrow-left" class="btn bg-orange-600 hover:bg-orange-800"/>

    <form action="{{ route('herramientas.store') }}" class="mt-10" method="POST">
        @csrf

        <x-input type="text" name="herramienta" label="Nombre de la herramienta" placeholder="Ingrese el nombre de la herramienta" />
      

        <input type="submit" value="Crear" class="btn bg-orange-600 hover:bg-orange-800">
    </form>

@endsection