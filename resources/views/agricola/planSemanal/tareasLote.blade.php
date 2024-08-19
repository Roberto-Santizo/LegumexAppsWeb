@extends('layouts.administracion')

@section('titulo')
    Plan Semanal Lote - {{ $lote->nombre }} {{ $lote->finca->finca }}
@endsection

@section('contenido')
@if(session('success'))
<p class="bg-green-500 uppercase text-xl text-white my-2 rounded-lg p-2 text-center font-bold">{{ session('success') }}
</p>
@endif

@php
    $clasesEncabezados = 'p-3 text-sm font-bold uppercase text-left rtl:text-right text-gray-500 dark:text-gray-400';
    $clasesEnlaces = 'bg-orange-500 cursor-pointer hover:bg-orange-700 text-white font-bold py-2 px-4 rounded
    inline-block ';
    $clasesCampo = 'px-4 py-2 text-md font-medium whitespace-nowrap';
    $clasesAlertas = 'bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center';
    $clasesLegend = 'text-2xl font-bold mb-5 text-center uppercase';
@endphp


<div class="bg-white p-6 rounded-lg shadow-lg mt-10 container xl:w-2/3  mx-auto">
    <form action="" method="POST" id="formulario6" novalidate>
        @csrf

        <x-alertas />

        <fieldset>
            <legend class="{{ $clasesLegend }}">Archivo de Carga</legend>
            <div class="mb-5">
                <label for="tareas_file" class="mb-2 block uppercase text-gray-500 font-bold">Archivo de Carga de Tareas (MASIVA): </label>
                <input type="file" id="tareas_file" name="tareas_file"
                class="border p-3 w-full rounded-lg @error('tareas_file') border-red-500 @enderror" 
                accept=".xlsx,.xls" 
                autocomplete="off">
    
                @error('tareas_file')
                <p class="{{ $clasesAlertas }}">{{ $message }}</p>
                @enderror
            </div>
        </fieldset>
       
        <div class="flex justify-end mt-10">
            <input type="submit" value="Guardar"
                class=" bg-sky-600 hover:bg-sky-700 p-3 transition-colors cursor-pointer uppercase font-bold text-white rounded-lg">
        </div>

    </form>
</div>

@endsection