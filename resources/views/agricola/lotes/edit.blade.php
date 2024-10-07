@extends('layouts.agricola')

@section('titulo')
Editar Lote - {{ $lote->nombre }}
@endsection

@section('contenido')

<x-alertas />

@php
    $clasesAlertas = 'bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center';
    $clasesLabel = 'mb-2 block uppercase text-gray-500 font-bold';
    $clasesInput = 'border p-3 w-full rounded-lg';
    $clasesEnlaces = 'bg-orange-500 cursor-pointer hover:bg-orange-700 text-white font-bold py-2 px-4 rounded inline-block mt-5 mb-5';
@endphp

<a href="{{ route('lotes') }}"
    class=" bg-orange-500 cursor-pointer hover:bg-orange-700 text-white font-bold py-2 px-4 rounded inline-block mt-5 mb-5 ">
    <i class="fa-solid fa-arrow-left"></i>
    Volver
</a>

<div class="bg-white p-6 rounded-lg shadow-lg mt-5 container xl:w-2/3  mx-auto">
    <form action="{{ route('lotes.update',$lote) }}" method="POST" id="formulario8" novalidate>
        @csrf
        @method('PATCH')
        <x-alertas />

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

        <div class="flex justify-end mt-10">
            <input type="submit" value="Guardar"
                class=" bg-sky-600 hover:bg-sky-700 p-3 transition-colors cursor-pointer uppercase font-bold text-white rounded-lg">
        </div>

    </form>
</div>
@endsection