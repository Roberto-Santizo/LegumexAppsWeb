@extends('layouts.agricola')

@section('titulo')
Creación Plan Semanal Finca
@endsection

@section('contenido')
<x-link route="planSemanal" text="Volver" icon="fa-solid fa-arrow-left" class="bg-green-moss hover:bg-green-meadow"/>
<div class="bg-white p-6 rounded-lg shadow-lg mt-5 container xl:w-2/3  mx-auto">
    <form action="{{ route('planSemanal.store') }}" method="POST" id="formulario6" enctype="multipart/form-data" novalidate>
        @csrf

        <x-alertas />

        
        <x-input type="file" name="file" label="Archivo de Carga" accept=".xls,.xlsx"/>
        
        <div class="flex justify-end mt-10">
            <input type="submit" value="CREAR"
                class=" bg-sky-600 hover:bg-sky-700 p-3 transition-colors cursor-pointer uppercase font-bold text-white rounded-lg">
        </div>

    </form>
</div>
@endsection