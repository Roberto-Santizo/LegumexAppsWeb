@extends('layouts.agricola')

@section('titulo')
Crear Tarea Finca
@endsection

@section('contenido')

<x-link class="bg-green-moss hover:bg-green-meadow" route="tareas" text="Volver" />


<div class="bg-white p-6 rounded-lg shadow-lg mt-10 md:mt-0 container xl:w-2/3  mx-auto">
    <form action="{{ route('tareas.update',$tarea) }}" method="POST" id="formulario6" novalidate>
        @csrf
        @method('PATCH')
        <x-alertas />

        <div class="mb-5">
            <label for="tarea" class="mb-2 block uppercase text-gray-500 font-bold">Nombre de la tarea: </label>
            <input type="text" id="tarea" name="tarea"
                class="border p-3 w-full rounded-lg @error('tarea') border-red-500 @enderror" autocomplete="off"
                value="{{ $tarea->tarea }}" placeholder="Nombre de la tarea">

            @error('tarea')
            <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-5">
            <label for="descripcion" class="mb-2 block uppercase text-gray-500 font-bold">Descripción de la tarea:
            </label>

            <input type="text" id="descripcion" name="descripcion"
                class="border p-3 w-full rounded-lg @error('descripcion') border-red-500 @enderror" autocomplete="off"
                value="{{ $tarea->descripcion }}" placeholder="Descripcion de la tarea">

            @error('descripcion')
            <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }}</p>
            @enderror
        </div>

        <x-input type="text" name="code" label="Codigo de la tarea:" value="{{ $tarea->code }}" placeholder="Codigo de la tarea" />


        <div class="flex justify-end mt-10">
            <input type="submit" value="Guardar"
                class=" btn bg-green-moss hover:bg-green-meadow">
        </div>

    </form>
</div>
@endsection