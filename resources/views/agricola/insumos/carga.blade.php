@extends('layouts.agricola')

@section('titulo')
Carga Masiva de Insumos
@endsection

@section('contenido')

<x-alertas />

<x-link-volver ruta="insumos" class="bg-green-moss hover:bg-green-meadow" />
<div class="bg-white p-6 rounded-lg shadow-lg mt-5 container xl:w-2/3  mx-auto">
    <form action="{{ route('insumos.import') }}" method="POST" enctype="multipart/form-data" novalidate>
        @csrf

        <x-alertas />

        <x-input type="file" name="file" label="Archivo de Carga" accept=".xls,.xlsx" />

        <div class="flex justify-end mt-10">
            <input type="submit" value="CREAR"
                class=" bg-sky-600 hover:bg-sky-700 p-3 transition-colors cursor-pointer uppercase font-bold text-white rounded-lg">
        </div>

    </form>
</div>
@endsection