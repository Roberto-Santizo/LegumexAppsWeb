@extends('layouts.agricola')

@section('titulo')
Ingreso de Empleados Diarios
@endsection

@section('contenido')

<x-alertas />

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
                <button type="submit" class="bg-green-moss hover:bg-green-meadow btn">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6 inline-block align-middle">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                </button>

                <x-link route="usuariosFincas" text="Borrar Filtros" class="btn bg-green-moss hover:bg-green-meadow"/>
            </div>
        </div>
    </form>
</div>

<div class="overflow-x-auto mt-10 flex flex-col">


    <table class="tabla">
        <thead class="tabla-head">
            <tr class="text-xs md:text-sm">
                <th scope="col" class="encabezado">
                    Nombre del empleado</th>
                <th scope="col" class="encabezado">
                    Hora y Fecha de Ingreso</th>
                <th scope="col" class="encabezado">
                    Finca de Marcaje</th>
            </tr>
        </thead>
        <tbody class="tabla-body">
            @foreach ($ingresos as $ingreso)
            <tr>
                <td class="campo">{{ $ingreso->empleado->first_name }}</td>
                <td class="campo">{{ $ingreso->punch_time }}</td>
                <td class="campo">{{ $ingreso->lugar->alias }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<x-paginacion :items="$ingresos" />


@endsection