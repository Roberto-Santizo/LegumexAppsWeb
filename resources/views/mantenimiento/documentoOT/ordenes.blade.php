@extends('layouts.mantenimiento')


@section('titulo')
Ordenes de Trabajo {{ $titulo }}
@endsection


@section('contenido')

<x-alertas />
<div id="FiltrosBtn" class="mt-10 md:hidden btn">
    <p>Filtros</p>
</div>

<div class="flex-col items-center gap-5 p-4 md:flex-row hidden md:flex justify-between" id="filtros">
    <form action="{{ route('documentoOT.showordenes',$estado) }}" method="GET" class="w-full md:w-5/6">
        <div class="shadow-xl p-4 rounded-lg flex flex-col md:flex-row gap-4">
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
                        ? 'selected' : '' }}>{{ $planta->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex flex-col gap-2">
                <label for="urgencia" class="text-sm font-medium">Urgencia:</label>
                <select name="urgencia" id="urgencia" class="border border-black p-2 rounded w-full">
                    <option value="">--SIN FILTRO--</option>
                    <option value="1">URGENTE</option>
                    <option value="2">MEDIA</option>
                    <option value="3">BAJA</option>
                </select>
            </div>

            <div class="flex flex-col gap-2 md:flex-row md:justify-between">
                <button type="submit" class="btn">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6 inline-block align-middle">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                </button>

                <a class="btn" href="{{ route('documentoOT.showordenes',$estado) }}">
                    Borrar Filtros
                </a>
            </div>
        </div>
    </form>
    <x-link route="documentoOT" text="Volver" icon="fa-solid fa-arrow-left" />

</div>

@if($ordenes->count() > 0)
    <x-ordenesde-trabajo :ots="$ordenes" />
@else
    <p class="text-center uppercase text-2xl mt-10">No hay ordenes {{ $titulo }}</p>
@endif

<x-paginacion :items="$ordenes" />
@endsection