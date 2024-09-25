@extends('layouts.mantenimiento')

@section('titulo')
    Editar herramienta
@endsection

@section('contenido')
    <x-alertas />

    <x-link route="herramientas" text="Volver" icon="fa-solid fa-arrow-left" class="btn bg-orange-600 hover:bg-orange-800"/>

    <form action="{{ route('herramientas.update',$herramienta) }}" class="mt-10" method="POST">
        @csrf
        @method('PATCH')
        <x-input type="text" name="herramienta" label="Nombre de la herramienta" value="{{ $herramienta->herramienta }}" placeholder="Nombre de la Herramienta" />

        <input type="submit" value="Guardar" class="btn bg-orange-600 hover:bg-orange-800">
    </form>

@endsection