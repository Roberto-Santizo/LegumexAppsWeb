@extends('layouts.mantenimiento')

@section('titulo')
Documento Lavado y Desinfección de Herramientas
@endsection

@section('contenido')
<x-alertas />

<div>
    @can('create documentold')
    <div class="mt-10 md:hidden">
        <x-link route="documentold.create" text="Crear Documento" icon="fa-solid fa-plus" />
    </div>
    @endcan

    <div id="FiltrosBtn" class="mt-10 md:hidden btn bg-orange-600 hover:bg-orange-800">
        <i class="fa-solid fa-plus"></i>
        Filtros
    </div>
</div>



<div class="flex-col items-center gap-5 p-4 md:flex-row hidden md:flex" id="filtros">

    {{-- Formulario de buscador --}}
    <form action="{{ route('documentold') }}" method="GET" class="w-full ">
        <div class="shadow-xl p-4 rounded-lg flex flex-col md:flex-row gap-4 w-full md:w-5/6">
            <div class="flex flex-col gap-2">
                <label for="tecnico_mantenimiento" class="text-sm font-medium">Técnico:</label>
                <input autocomplete="off" class="border border-black p-2 rounded w-full" type="text"
                    name="tecnico_mantenimiento" id="tecnico_mantenimiento" placeholder="Técnico..."
                    value="{{ old('tecnico_mantenimiento', request()->input('tecnico_mantenimiento')) }}">
            </div>

            <div class="flex flex-col gap-2">
                <label for="fecha" class="text-sm font-medium">Fecha:</label>
                <input autocomplete="off" class="border border-black p-2 rounded w-full" type="text" name="fecha"
                    id="fecha" placeholder="Fecha..." value="{{ old('fecha', request()->input('fecha')) }}">
            </div>

            <div class="flex flex-col gap-2">
                <label for="planta_id" class="text-sm font-medium">Planta:</label>
                <select name="planta_id" id="planta_id" class="border border-black p-2 rounded w-full">
                    <option value="">--SIN FILTRO--</option>
                    @foreach ($plantas as $planta)
                    <option  class="text-xs" value="{{ $planta->id }}" {{ $planta->id == old('planta_id', request()->input('planta_id'))
                        ? 'selected' : '' }}>{{ $planta->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex flex-col gap-2">
                <label for="area_id" class="text-sm font-medium">Área:</label>
                <select name="area_id" id="area_id" class="border border-black p-2 rounded w-full">
                    <option value="">--SIN FILTRO--</option>
                    @foreach ($areas as $area)
                    <option class="text-xs" value="{{ $area->id }}" {{ $area->id == old('area_id', request()->input('area_id')) ?
                        'selected' : '' }}>{{ ($area->area) }} - {{ $area->planta->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex flex-col gap-2 md:flex-row md:justify-between">
                <button type="submit" class="btn bg-orange-600 hover:bg-orange-800">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6 inline-block align-middle">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                </button>

                
            </div>
            <x-link route="documentold" text="Borrar Filtros" class="bg-orange-600 hover:bg-orange-800 "/>
        </div>
    </form>
    
    @can('create documentold')
        <div class="hidden md:block">
            <x-link route="documentold.create" text="Crear Documento" class=" btn bg-orange-600 hover:bg-orange-800"/>
        </div>
    @endcan 

</div>



<div class="overflow-x-auto mt-10">
    <table class="tabla">
        <thead class="tabla-head">
            <tr class="text-xs md:text-sm">
                <th scope="col" class="encabezado">Técnico de mantenimiento</th>
                <th scope="col" class="encabezado">Planta</th>
                <th scope="col" class="encabezado">Área</th>
                <th scope="col" class="encabezado">Fecha</th>
                <th scope="col" class="encabezado">Acción</th>
            </tr>
        </thead>
        <tbody class="tabla-body">
            @foreach ($documentos as $documento)
            <tr>
                <td class="campo">{{ $documento->tecnico_mantenimiento }}</td>
                <td class="campo">{{ $documento->planta->name }}</td>
                <td class="campo">{{ $documento->area->area }}</td>
                <td class="campo">{{ $documento->fecha }}</td>

                @if ($documento->estado === 0)
                    <td class="px-4 py-2 whitespace-nowrap ">
                        @can('create documentold')
                        <a href="{{ route('documentold.edit', $documento) }}">
                            <i class="fa-solid fa-pen-to-square icon-link"></i>
                        </a>
                        @endcan
                    </td>
                @elseif ($documento->estado === 1)
                    <td class="px-4 py-2 whitespace-nowrap">
                        @can('create documentold')
                        <a href="{{ route('documentold.document', $documento) }}">
                            <i class="fa-solid fa-print icon-link"></i>
                        </a>
                        @endcan
                    </td>
                @elseif ($documento->estado === 2)
                <td class="px-4 py-2 whitespace-nowrap">
                    <a href="{{ $documento->weburl }}" target="_blank">
                        <i class="fa-solid fa-file icon-link"></i>
                    </a>
                </td>
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<x-paginacion :items="$documentos" />

@endsection