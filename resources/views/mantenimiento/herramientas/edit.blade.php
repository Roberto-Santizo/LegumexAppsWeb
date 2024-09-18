@extends('layouts.mantenimiento')

@section('titulo')
    Editar herramienta
@endsection

@section('contenido')
    <x-alertas />

    <x-link route="herramientas" text="Volver" icon="fa-solid fa-arrow-left" />

    <form action="{{ route('herramientas.update',$herramienta) }}" class="mt-10" method="POST">
        @csrf
        @method('PATCH')
        <x-input type="text" name="herramienta" label="Nombre de la herramienta" value="{{ $herramienta->herramienta }}" placeholder="Nombre de la Herramienta" />

        <input type="submit" value="Guardar" class="bg-orange-500 text-white p-3 rounded-lg cursor-pointer hover:bg-orange-600 font-bold uppercase">
    </form>

@endsection