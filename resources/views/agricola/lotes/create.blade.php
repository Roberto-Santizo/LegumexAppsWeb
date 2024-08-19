@extends('layouts.administracion')

@section('titulo')
Crear Lote
@endsection

@section('contenido')
@if(session('success'))
<p class="bg-green-500 uppercase text-xl text-white my-2 rounded-lg p-2 text-center font-bold">{{ session('success') }}
</p>
@endif

@php
    $clasesAlertas = 'bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center';
    $clasesLabel = 'mb-2 block uppercase text-gray-500 font-bold';
    $clasesInput = 'border p-3 w-full rounded-lg';
    $clasesEnlaces = 'bg-orange-500 cursor-pointer hover:bg-orange-700 text-white font-bold py-2 px-4 rounded inline-block mt-5 mb-5';
@endphp

<div class="bg-white p-6 rounded-lg shadow-lg mt-10 md:mt-0 container xl:w-2/3  mx-auto">
    <form action="{{ route('lotes.create') }}" method="POST" id="formulario8" novalidate>
        @csrf

        <x-alertas />

        <div class="mb-5">
            <label for="nombre" class="{{ $clasesLabel }}">Nombre/Codificación del Lote:
            </label>
            <input type="text" id="nombre" name="nombre"
                class="border p-3 w-full rounded-lg @error('nombre') border-red-500 @enderror" autocomplete="off"
                value="{{ old('nombre') }}" placeholder="Nombre/Codificación del Lote">

            @error('nombre')
            <p class="{{ $clasesAlertas }}">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-5">
            <label for="cdp_id" class="{{ $clasesLabel }} ">Elija el CDP relacionado con el lote: </label>
            <select name="cdp_id" id="cdp_id" class="w-full p-4 rounded bg-gray-50 select">
                <option value="" class="opcion-default" selected disabled>---SELECCIONE UNA OPCIÓN---</option>
                @foreach ($cdps as $cdp)
                    <option value="{{ $cdp->id }}">{{ $cdp->nombre }}</option>
                @endforeach
            </select>
            @error('cdp_id')
                <p class="{{ $clasesAlertas }}">Seleccione un cultivo
                <p>
            @enderror
        </div>

        <div class="mb-5">
            <label for="finca_id" class="{{ $clasesLabel }} ">Elija la finca relacionada al lote: </label>
            <select name="finca_id" id="finca_id" class="w-full p-4 rounded bg-gray-50 select">
                <option value="" class="opcion-default" selected disabled>---SELECCIONE UNA OPCIÓN---</option>
                @foreach ($fincas as $finca)
                    <option value="{{ $finca->id }}">{{ $finca->finca }}</option>
                @endforeach
            </select>
            @error('finca_id')
                <p class="{{ $clasesAlertas }}">Seleccione un cultivo
                <p>
            @enderror
        </div>


        <div class="flex justify-end mt-10">
            <input type="submit" value="Guardar"
                class=" bg-sky-600 hover:bg-sky-700 p-3 transition-colors cursor-pointer uppercase font-bold text-white rounded-lg">
        </div>

    </form>
</div>
@endsection