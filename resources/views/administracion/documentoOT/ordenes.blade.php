@extends('layouts.administracion')


@section('titulo')
Ordenes de Trabajo {{ $titulo }}
@endsection


@section('contenido')

<x-alertas />
<div>
    <a href="{{ route('documentoOT') }}"
        class=" bg-orange-500 cursor-pointer hover:bg-orange-700 text-white font-bold py-2 px-4 rounded inline-block mt-5 mb-5 ">
        <i class="fa-solid fa-arrow-left"></i>
        Volver
    </a>

    <div id="FiltrosBtn"
        class="mt-10 md:hidden bg-orange-500 cursor-pointer hover:bg-orange-700 text-white font-bold py-2 px-4 rounded flex justify-center items-center gap-2">
        <p>Filtros</p>
        <i class="fa-solid fa-plus"></i>
    </div>
</div>

<div class="flex-col items-center gap-5 p-4 md:flex-row hidden md:flex" id="filtros">
    <form action="{{ route('documentoOT.showordenes',$estado) }}" method="GET" class="w-full">
        <div class="bg-gray-100 p-4 rounded-lg flex flex-col md:flex-row gap-4">
            <div class="flex flex-col gap-2">
                <label for="nombre_solicitante" class="text-sm font-medium">Solicitante:</label>
                <input autocomplete="off" class="border border-black p-2 rounded w-full" type="text"
                    name="nombre_solicitante" id="nombre_solicitante" placeholder="Solicitante..."
                    value="{{ old('nombre_solicitante', request()->input('nombre_solicitante')) }}">
            </div>

            <div class="flex flex-col gap-2">
                <label for="fecha_propuesta" class="text-sm font-medium">Fecha entrega:</label>
                <input autocomplete="off" class="border border-black p-2 rounded w-full" type="date"
                    name="fecha_propuesta" id="fecha_propuesta" placeholder="Fecha de entrega..."
                    value="{{ old('fecha_propuesta', request()->input('fecha_propuesta')) }}">
            </div>

            <div class="flex flex-col gap-2">
                <label for="planta_id" class="text-sm font-medium">Planta:</label>
                <select name="planta_id" id="planta_id" class="border border-black p-2 rounded w-full">
                    <option value="">--SIN FILTRO--</option>
                    @foreach ($plantas as $planta)
                    <option value="{{ $planta->id }}" {{ $planta->id == old('planta_id', request()->input('planta_id'))
                        ? 'selected' : '' }}>{{ $planta->planta }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex flex-col gap-2 md:flex-row md:justify-between">
                <button type="submit" class="bg-orange-500 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6 inline-block align-middle">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                </button>

                <a href="{{ route('documentoOT.showordenes',$estado) }}"
                    class="mt-2 md:mt-0 text-white font-bold bg-orange-500 hover:bg-orange-600 p-2 text-center rounded flex items-center justify-center">
                    Borrar Filtros
                </a>
            </div>
        </div>
    </form>
</div>




@if($ordenes->count() > 0)
<x-ordenesde-trabajo :ots="$ordenes" />
@else
<p class="text-center uppercase text-2xl mt-10">No hay ordenes {{ $titulo }}</p>
@endif
{{ $ordenes->links('pagination::tailwind') }}
</div>
@endsection