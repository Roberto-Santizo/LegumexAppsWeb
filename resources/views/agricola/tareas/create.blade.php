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
    <form action="{{ route('tareas.store') }}" method="POST" id="formulario6" novalidate>
        @csrf

        <x-alertas />


        <x-input type="text" name="tarea" label="Nombre de la tarea:" value="{{ old('tarea') }}" placeholder="Nombre de la tarea" />
        <x-input type="text" name="descripcion" label="Descripción de la tarea:" value="{{ old('descripcion') }}" placeholder="Describa la tarea" />
        <x-input type="text" name="code" label="Codigo de la tarea:" value="{{ old('code') }}" placeholder="Codigo de la tarea" />

        
        <div class="flex justify-end mt-10">
            <input type="submit" value="Guardar"
                class=" bg-sky-600 hover:bg-sky-700 p-3 transition-colors cursor-pointer uppercase font-bold text-white rounded-lg">
        </div>

    </form>
</div>
@endsection