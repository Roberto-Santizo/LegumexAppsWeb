@extends('layouts.administracion')

@section('titulo')
Ingreso de Empleados Diarios
@endsection

@section('contenido')

<x-alertas />

@php
$clasesCampo = 'px-4 py-2 text-md font-medium whitespace-nowrap';
$clasesEncabezados = 'p-3 text-sm font-bold uppercase text-left rtl:text-right text-gray-500 dark:text-gray-400';
$clasesEnlaces = 'mt-5 bg-orange-500 cursor-pointer hover:bg-orange-700 text-white font-bold py-2 px-4 rounded
inline-block ';
@endphp


<div class="flex-col items-center gap-5 p-4 md:flex-row hidden md:flex" id="filtros">
    <form action="{{ route('usuariosFincas') }}" method="GET" class="w-full">
        <div class="bg-gray-100 p-4 rounded-lg flex flex-col md:flex-row gap-4">
            <div class="flex flex-col gap-2">
                <label for="punch_time" class="text-sm font-medium">Fecha de Marcaje:</label>
                <input autocomplete="off" class="border border-black p-2 rounded w-full" type="date"
                    name="punch_time" id="punch_time" placeholder="Fecha de entrega..."
                    value="{{ old('punch_time', request()->input('punch_time')) }}">
            </div>


            <div class="flex flex-col gap-2 md:flex-row md:justify-between">
                <button type="submit" class="bg-orange-500 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6 inline-block align-middle">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                </button>

                <a href="{{ route('usuariosFincas') }}"
                    class="mt-2 md:mt-0 text-white font-bold bg-orange-500 hover:bg-orange-600 p-2 text-center rounded flex items-center justify-center">
                    Borrar Filtros
                </a>
            </div>
        </div>
    </form>
</div>

<div class="overflow-x-auto mt-10 flex flex-col">


    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-xs md:text-sm">
        <thead class="bg-gray-50 dark:bg-gray-800">
            <tr class="text-xs md:text-sm">
                <th scope="col" class="{{ $clasesEncabezados }}">
                    Nombre del empleado</th>
                <th scope="col" class="{{ $clasesEncabezados }}">
                    Hora y Fecha de Ingreso</th>
                <th scope="col" class="{{ $clasesEncabezados }}">
                    Finca de Marcaje</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200 dark:divide-gray-700 dark:bg-gray-900">
            @foreach ($ingresos as $ingreso)
            <tr>
                <td class="{{ $clasesCampo }}">{{ $ingreso->empleado->first_name }}</td>
                <td class="{{ $clasesCampo }}">{{ $ingreso->punch_time }}</td>
                <td class="{{ $clasesCampo }}">{{ $ingreso->lugar->alias }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="my-10">
    {{ $ingresos->links('pagination::tailwind') }}
</div>

@endsection