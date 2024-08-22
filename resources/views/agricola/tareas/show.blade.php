@extends('layouts.administracion')

@section('titulo')
{{$tarea->tarea}}
@endsection

@section('contenido')

<x-alertas />

<a href="{{ route('tareas') }}"
    class=" bg-orange-500 cursor-pointer hover:bg-orange-700 text-white font-bold py-2 px-4 rounded inline-block mt-5 mb-5 ">
    <i class="fa-solid fa-arrow-left"></i>
    Volver
</a>

<div>
    <p class="text-xl"><span class="font-bold">Descripción de la tarea:</span> {{  $tarea->descripcion }}</p>
</div>
@endsection