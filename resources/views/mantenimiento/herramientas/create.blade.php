@extends('layouts.mantenimiento')

@section('titulo')
    Crear herramienta
@endsection

@section('contenido')
    <x-alertas />
    <x-link route="herramientas" text="Volver" icon="fa-solid fa-arrow-left" />

    <form action="{{ route('herramientas.store') }}" class="mt-10" method="POST">
        @csrf

        <x-input type="text" name="herramienta" label="Nombre de la herramienta" placeholder="Ingrese el nombre de la herramienta" />
      

        <input type="submit" value="Crear" class="btn">
    </form>

@endsection