@extends('layouts.administracion')

@section('titulo')
Asignación de Empleados {{ $tarea->tarea }}, Semana {{ $plansemanalfinca->semana }}
@endsection

@section('contenido')

<x-alertas />

@php
    $clasesAlertas = 'bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center';
    $clasesLabel = 'mb-2 block uppercase text-gray-500 font-bold';
    $clasesInput = 'border p-3 w-full rounded-lg';
    $clasesEnlaces = 'bg-orange-500 cursor-pointer hover:bg-orange-700 text-white font-bold py-2 px-4 rounded inline-block mt-5 mb-5';
@endphp

<div class="grid grid-cols-3 mt-10">
    <div class="col-span-2">
        <h1 class="text-2xl font-bold">Información de la tarea: </h1>

        <p><span class="text-xl font-bold">Descripción: </span>{{ $tarea->descripcion }}</p>

        <div class="flex gap-2">
            <p class="text-xl font-bold">Cupos Disponibles: </p>
            <p class="text-xl font-bold" id="cupos" data-cupos="{{ $tarealote->personas }}">{{ $tarealote->personas }}
            </p>

        </div>

        <form action="" class="mt-10 w-2/3">
            <div class="mb-5">
                <label for="fecha_ejecucion" class="{{ $clasesLabel }}">Fecha de realización de la tarea: </label>
                <input type="date" id="fecha_ejecucion" name="fecha_ejecucion"
                    class="{{ $clasesInput }} @error('fecha_ejecucion') border-red-500 @enderror" autocomplete="off"
                    value="{{ old('fecha_ejecucion') }}" min="{{ now()->format('Y-m-d')}}">

                @error('fecha_ejecucion')
                <p class="{{ $clasesAlertas }}">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end mt-10">
                <input type="submit" value="Guardar"
                    class=" bg-sky-600 hover:bg-sky-700 p-3 transition-colors cursor-pointer uppercase font-bold text-white rounded-lg">
            </div>

        </form>
    </div>

    <div>
        <h1 class="text-2xl font-bold">Usuarios Disponibles: </h1>
        <input type="text" id="buscarUsuario" placeholder="Buscar usuario..."
            class="border p-2 rounded mt-4 mb-4 w-full">

        <div class="mt-2 flex flex-col gap-2 overflow-y-auto h-96">
            @foreach ($ingresos as $ingreso)
            <div class="border p-5 bg-orange-400 hover:bg-orange-600 rounded cursor-pointer empleados">
                <p class="text-white font-bold">{{ $ingreso->empleado->first_name }}</p>
            </div>
            @endforeach
        </div>
    </div>


</div>
@endsection