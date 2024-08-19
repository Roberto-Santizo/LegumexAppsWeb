@extends('layouts.administracion')

@section('titulo')
Creación Plan Semanal Finca
@endsection

@section('contenido')
@if(session('success'))
<p class="bg-green-500 uppercase text-xl text-white my-2 rounded-lg p-2 text-center font-bold">{{ session('success') }}
</p>
@endif

@php
    $clasesAlerta = 'bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center';
    $clasesLabel = 'mb-2 block uppercase text-gray-500 font-bold';
@endphp

<div class="bg-white p-6 rounded-lg shadow-lg mt-5 container xl:w-2/3  mx-auto">
    <form action="{{ route('planSemanal.store') }}" method="POST" id="formulario6" enctype="multipart/form-data" novalidate>
        @csrf

        <x-alertas />

        <div class="mb-5">
            <label for="finca_id" class="{{ $clasesLabel }}">Elija la finca: </label>
            <select name="finca_id" id="finca_id" class="w-full p-4 rounded bg-gray-50 select">
                <option value="" class="opcion-default" selected disabled>---SELECCIONE UNA OPCIÓN---</option>
                @foreach ($fincas as $finca)
                    <option value="{{ $finca->id }}">{{ $finca->finca }}</option>
                @endforeach
            </select>
            @error('finca_id')
                <p class="{{ $clasesAlerta }}">{{ $message }}<p>
            @enderror
        </div>

        <div class="mb-5">
            <label for="file" class="{{ $clasesLabel }}">Archivo masivo de cargas</label>
            <input type="file" name="file" class="border w-full" accept=".xls,.xlsx">
            @error('file')
                <p class="{{ $clasesAlerta }}">{{ $message }}<p>
            @enderror
        </div>

        <div class="flex justify-end mt-10">
            <input type="submit" value="CREAR"
                class=" bg-sky-600 hover:bg-sky-700 p-3 transition-colors cursor-pointer uppercase font-bold text-white rounded-lg">
        </div>

    </form>
</div>
@endsection