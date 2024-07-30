@extends('layouts.administracion')

@section('titulo')
Documentos Checklists Preoperacionales
@endsection

@section('contenido')

<x-alertas />

<div>
    @can('create documentocp')
    <div class="mt-10 md:hidden">
        <a href="{{ route('documentocp.select') }}"
            class="mt-5 bg-orange-500 cursor-pointer hover:bg-orange-700 text-white font-bold py-2 px-4 rounded">
            <i class="fa-solid fa-plus"></i>
            Crear
        </a>
    </div>
    @endcan

    <div id="FiltrosBtn"
        class="mt-10 md:hidden bg-orange-500 cursor-pointer hover:bg-orange-700 text-white font-bold py-2 px-4 rounded flex justify-center items-center gap-2">
        <p>Filtros</p>
        <i class="fa-solid fa-plus"></i>
    </div>
</div>

<div class="flex-col items-center gap-5 p-4 md:flex-row hidden md:flex" id="filtros">
    <form action="{{ route('documentocp') }}" method="GET" class="w-full ">
        <div class="bg-gray-100 p-4 rounded-lg flex flex-col md:flex-row gap-4">
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

                <a href="{{ route('documentocp') }}"
                    class="mt-2 md:mt-0 text-white font-bold bg-orange-500 hover:bg-orange-600 p-2 text-center rounded flex items-center justify-center">
                    Borrar Filtros
                </a>
            </div>
        </div>
    </form>
    @can('create documentocp')
    <a href="{{ route('documentocp.select') }}"
        class="mt-5 bg-orange-500 cursor-pointer hover:bg-orange-700 text-white font-bold py-2 px-4 rounded justify-center items-center gap-3 hidden md:flex">
        <i class="fa-solid fa-plus"></i>
        Crear
    </a>
    @endcan
</div>

<div class="overflow-x-auto mt-10  overflow-y-hidden">
    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-xs md:text-sm">
        <thead class="bg-gray-50 dark:bg-gray-800">
            <tr class="text-xs md:text-sm">
                <th scope="col"
                    class="p-3 text-sm font-bold uppercase text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    Planta</th>
                <th scope="col"
                    class="p-3 text-sm font-bold uppercase text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    Fecha</th>
                <th scope="col"
                    class="p-3 text-sm font-bold uppercase text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    Acción</th>
                <th scope="col"
                    class="p-3 text-sm font-bold uppercase rtl:text-right text-gray-500 dark:text-gray-400 text-center">
                    Ordenes de Trabajo relacionadas</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200 dark:divide-gray-700 dark:bg-gray-900">
            @foreach ($documentos as $documento)
            <tr>
                <td class="px-4 py-2 text-md font-medium whitespace-nowrap">{{ $documento->planta->planta }}</td>
                <td class="px-4 py-2 text-md font-medium whitespace-nowrap">{{ $documento->fecha }}</td>
                @if ($documento->estado === 1)
                <td class="px-4 py-2 whitespace-nowrap">
                    <a href="{{ route('documentocp.document', $documento) }}">
                        <i class="fa-solid fa-print text-2xl hover:text-gray-500"></i>
                    </a>
                </td>
                @elseif ($documento->estado === 2)
                <td class="px-4 py-2 whitespace-nowrap">
                    <a href="{{ $documento->weburl }}" target="_blank">
                        <i class="fa-solid fa-file text-2xl hover:text-gray-500"></i>
                    </a>
                </td>
                @endif
                <td class="text-center">
                    <a href="{{ route('documentocp.showordeneschecklist', $documento) }}"
                        class="bg-orange-500 cursor-pointer hover:bg-orange-700 text-white font-bold py-2 px-4 rounded inline-block">Ver
                        Ordenes de trabajo</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@if ($documentos->hasPages())
<div class="mt-5 px-2">
    {{ $documentos->links() }}
</div>
@endif

@endsection