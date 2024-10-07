@extends('layouts.agricola')

@section('titulo')
Crear Nuevo semanas
@endsection

@section('contenido')

@php
    $clasesAlertas = 'bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center';
    $clasesLabel = 'mb-2 block uppercase text-gray-500 font-bold';
    $clasesInput = 'border p-3 w-full rounded-lg';
    $clasesEnlaces = 'bg-orange-500 cursor-pointer hover:bg-orange-700 text-white font-bold py-2 px-4 rounded inline-block mt-5 mb-5';
@endphp

<a href="{{ route('cultivos') }}"
    class="{{ $clasesEnlaces }}">
    <i class="fa-solid fa-arrow-left"></i>
    Volver
</a>


<div class="bg-white p-6 rounded-lg shadow-lg mt-10 md:mt-0 container xl:w-2/3  mx-auto">
    <form action="{{ route('cultivos.store') }}" method="POST" id="formulario7" novalidate>
        @csrf

        <x-alertas />

        <div class="mb-5">
            <label for="cultivo" class="{{ $clasesLabel }}">Nombre/Codificación del Cultivo: </label>
            <input type="text" id="cultivo" name="cultivo"
                class="{{ $clasesInput }} @error('cultivo') border-red-500 @enderror" autocomplete="off"
                value="{{ old('cultivo') }}" placeholder="Nombre/Codificación del Cultivo">

            @error('cultivo')
            <p class="{{ $clasesAlertas }}">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-5">
            <label for="semanas" class="{{ $clasesLabel }}">Semanas totales del cultivo: </label>
            <input type="number" id="semanas" name="semanas"
                class="{{ $clasesInput }} @error('semanas') border-red-500 @enderror" autocomplete="off"
                value="{{ old('semanas') }}" placeholder="Semanas totales del Cultivo">

            @error('semanas')
            <p class="{{ $clasesAlertas }}">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end mt-10">
            <input type="submit" value="Guardar"
                class=" bg-sky-600 hover:bg-sky-700 p-3 transition-colors cursor-pointer uppercase font-bold text-white rounded-lg">
        </div>

    </form>
</div>
@endsection