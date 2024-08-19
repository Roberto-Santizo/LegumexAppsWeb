@extends('layouts.administracion')

@section('titulo')
Crear Tarea Finca
@endsection

@section('contenido')
<a href="{{ route('tareas') }}"
    class=" bg-orange-500 cursor-pointer hover:bg-orange-700 text-white font-bold py-2 px-4 rounded inline-block mt-5 mb-5 ">
    <i class="fa-solid fa-arrow-left"></i>
    Volver
</a>

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

        <div class="flex justify-end mt-10">
            <input type="submit" value="Guardar"
                class=" bg-sky-600 hover:bg-sky-700 p-3 transition-colors cursor-pointer uppercase font-bold text-white rounded-lg">
        </div>

    </form>
</div>
@endsection