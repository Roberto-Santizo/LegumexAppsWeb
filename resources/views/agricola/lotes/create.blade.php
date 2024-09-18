@extends('layouts.agricola')

@section('titulo')
Crear Lote
@endsection

@section('contenido')

<x-alertas />

<div class="bg-white p-6 rounded-lg shadow-lg mt-10 md:mt-0 container xl:w-2/3  mx-auto">
    <form action="{{ route('lotes.create') }}" method="POST" id="formulario8" novalidate>
        @csrf

        <x-alertas />
       
        <x-input type="text" name="nombre" label="Nombre/Codificación del Lote" value="{{ old('name') }}" placeholder="Nombre/Codificación del Lote" />

        <div class="mb-5">
            <label for="finca_id" class="mb-2 block uppercase text-gray-500 font-bold ">Elija la finca relacionada al lote: </label>
            <select name="finca_id" id="finca_id" class="w-full p-4 rounded bg-gray-50 select">
                <option value="" class="opcion-default" selected disabled>---SELECCIONE UNA OPCIÓN---</option>
                @foreach ($fincas as $finca)
                    <option value="{{ $finca->id }}">{{ $finca->finca }}</option>
                @endforeach
            </select>
            @error('finca_id')
                <p class="border border-red-500 bg-red-100 text-red-700 font-bold uppercase p-2 mt-2 text-sm flex flex-row gap-2 items-center">Seleccione un cultivo<p>
            @enderror
        </div>

        <div class="flex justify-end mt-10">
            <input type="submit" value="Guardar" class="btn bg-green-moss hover:bg-green-meadow">
        </div>

    </form>
</div>
@endsection