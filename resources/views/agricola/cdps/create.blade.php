@extends('layouts.administracion')

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

<a href="{{ route('cdps') }}"
    class="{{ $clasesEnlaces }}">
    <i class="fa-solid fa-arrow-left"></i>
    Volver
</a>


<div class="bg-white p-6 rounded-lg shadow-lg mt-10 md:mt-0 container xl:w-2/3  mx-auto">
    <form action="{{ route('cdps.store') }}" method="POST" id="formulario7" novalidate>
        @csrf

        <x-alertas />

        <div class="mb-5">
            <label for="nombre" class="{{ $clasesLabel }}">Nombre del CDP: </label>
            <input type="text" id="nombre" name="nombre"
                class="{{ $clasesInput }} @error('nombre') border-red-500 @enderror" autocomplete="off"
                value="{{ old('nombre') }}" placeholder="Nombre/Codificación del CDP">

            @error('nombre')
            <p class="{{ $clasesAlertas }}">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-5">
            <label for="cultivo_id" class="{{ $clasesLabel }}">Cultivo: </label>
            <select name="cultivo_id" id="cultivo_id" class="w-full p-4 rounded bg-gray-50">
                <option  value class="opcion-default" selected disabled>---SELECCIONE UNA OPCIÓN---</option>
                @foreach ($cultivos as $cultivo)
                    <option value="{{ $cultivo->id }}">{{ $cultivo->cultivo }}</option>
                @endforeach
    
            </select>                                
            @error('cultivo_id')
                <p class="{{ $clasesAlertas }}">{{ $message }}<p>
            @enderror
        </div>

        <div class="flex justify-end mt-10">
            <input type="submit" value="Guardar"
                class=" bg-sky-600 hover:bg-sky-700 p-3 transition-colors cursor-pointer uppercase font-bold text-white rounded-lg">
        </div>

    </form>
</div>
@endsection