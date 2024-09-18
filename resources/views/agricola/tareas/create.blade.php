@extends('layouts.agricola')

@section('titulo')
Crear Tarea Finca
@endsection

@section('contenido')


<x-link class="bg-green-moss hover:bg-green-meadow" route="tareas" text="Volver" />

<div class="bg-white p-6 rounded-lg shadow-lg mt-10 md:mt-0 container xl:w-2/3  mx-auto">
    <form action="{{ route('tareas.store') }}" method="POST" id="formulario6" novalidate>
        @csrf

        <x-alertas />


        <x-input type="text" name="tarea" label="Nombre de la tarea:" value="{{ old('tarea') }}" placeholder="Nombre de la tarea" />
        <x-input type="text" name="descripcion" label="Descripción de la tarea:" value="{{ old('descripcion') }}" placeholder="Describa la tarea" />
        <x-input type="text" name="code" label="Codigo de la tarea:" value="{{ old('code') }}" placeholder="Codigo de la tarea" />

        
        <div class="flex justify-end mt-10">
            <input type="submit" value="Guardar"
                class=" btn bg-green-moss hover:bg-green-meadow">
        </div>

    </form>
</div>
@endsection