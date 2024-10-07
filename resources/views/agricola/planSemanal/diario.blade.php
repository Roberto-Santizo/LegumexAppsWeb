@extends('layouts.agricola')

@section('titulo')
    Toma Diaria de Rendimiento {{ $usuario->first_name }}
@endsection

@section('contenido')
<p class="text-2xl font-bold mt-5">{{ $tarealote->tarea->tarea }}</p>
<x-alertas />

@php
    $clasesAlerta = 'bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center';
    $clasesLabel = 'mb-2 block uppercase text-gray-500 font-bold';

    $primerMarcajeFormateado = \Illuminate\Support\Carbon::createFromFormat('Y-m-d H:i:s.u', $primerMarcaje->punch_time)->format('d-m-Y h:i:s A');
    $ultimoMarcajeFormateado = \Illuminate\Support\Carbon::createFromFormat('Y-m-d H:i:s.u', $ultimoMarcaje->punch_time)->format('d-m-Y h:i:s A');
@endphp

<div class="bg-white p-6 rounded-lg shadow-lg mt-5 container xl:w-2/3  mx-auto">
    <form action="{{ route('planSemanal.storediario') }}" method="POST" id="formulario6" enctype="multipart/form-data" novalidate>
        @csrf
        <fieldset>
            <table class="md:w-1/2 lg:w-full mb-5">
                <thead class="bg-sky-600">
                    <tr>
                        <th scope="col" class="text-white text-sm md:text-xl p-2">¿Completo su tarea diaria?(SI/NO)</th>
                    </tr>
                </thead>
                    <tr>
                        <th class="flex justify-center items-center gap-2">
                            <p>Selecciona si aplica</p>
                            <input class="h-6 w-6 mt-2" type="checkbox" name="terminado">
                        </th>
                    </tr>
                <tbody>
                    
                </tbody>
            </table>
        </fieldset>

        <fieldset>
            <legend class="text-xl font-bold uppercase mb-5">Datos del Biometrico</legend>
            <div class="mb-5">
                <label for="name" class="mb-2 block uppercase text-gray-500 font-bold">Primer Marcaje: </label>
                <input type="text" id="name" name="name"
                    class="border p-3 w-full rounded-lg @error('name') border-red-500 @enderror"
                    placeholder="Nombre del nuevo usuario" autocomplete="off" value="{{ $primerMarcajeFormateado }}" disabled>

                @error('name')
                <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-5">
                <label for="name" class="mb-2 block uppercase text-gray-500 font-bold">Ultimo Marcaje: </label>
                <input type="text" id="name" name="name"
                    class="border p-3 w-full rounded-lg @error('name') border-red-500 @enderror"
                    placeholder="Nombre del nuevo usuario" autocomplete="off" value="{{ $ultimoMarcajeFormateado }}" disabled>

                @error('name')
                <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }}</p>
                @enderror
            </div>
        </fieldset>

        <input type="hidden" value="{{ $tarealote->asignacion->id }}" name="asignacion_diaria_id">
        <input type="hidden" value="{{ $usuario->asignacion_usuario_id->id }}" name="usuario_asignacion_id">

        <div class="flex justify-end mt-10">
            <input type="submit" value="Guardar"
                class=" bg-sky-600 hover:bg-sky-700 p-3 transition-colors cursor-pointer uppercase font-bold text-white rounded-lg">
        </div>
    </form>
</div>
@endsection