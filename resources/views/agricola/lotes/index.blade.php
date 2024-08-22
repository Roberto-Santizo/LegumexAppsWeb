@extends('layouts.administracion')

@section('titulo')
Lotes por Finca
@endsection

@section('contenido')

<x-alertas />

@php
    $clasesCampo = 'px-4 py-2 text-md font-medium whitespace-nowrap';    
    $clasesEncabezados = 'p-3 text-sm font-bold uppercase text-left rtl:text-right text-gray-500 dark:text-gray-400';
    $clasesEnlaces = 'mt-5 bg-orange-500 cursor-pointer hover:bg-orange-700 text-white font-bold py-2 px-4 rounded inline-block ';
@endphp

<div class="flex flex-col md:flex-row justify-between">
    <a href="{{ route('lotes.create') }}"
        class="{{ $clasesEnlaces }}">
        <i class="fa-solid fa-plus"></i>
        Crear Lote
    </a>

    <a href="{{ route('lotes.historial') }}"
        class="{{ $clasesEnlaces }}">
        Ver historial de Lotes
    </a>

</div>
<div class="overflow-x-auto mt-10">
    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-xs md:text-sm">
        <thead class="bg-gray-50 dark:bg-gray-800">
            <tr class="text-xs md:text-sm">
                <th scope="col"
                    class="{{ $clasesEncabezados }}">
                    Nombre/Codificación del cultivo</th>
                <th scope="col"
                    class="{{ $clasesEncabezados }}">
                    CDP</th>
                <th scope="col"
                    class="{{ $clasesEncabezados }}">
                    Finca</th>
                <th scope="col"
                    class="{{ $clasesEncabezados }}">
                    Fecha de Creación</th>
                <th scope="col"
                    class="{{ $clasesEncabezados }}">
                    Ultima fecha de actualización</th>
                <th scope="col"
                    class="{{ $clasesEncabezados }}">
                    Estado</th>
                <th scope="col"
                    class="{{ $clasesEncabezados }}">
                    Acción</th>

            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200 dark:divide-gray-700 dark:bg-gray-900">
            @foreach ($lotes as $lote)
            <tr>
                <td class="{{ $clasesCampo }}">{{ $lote->nombre }}</td>
                <td class="{{ $clasesCampo }}">{{ $lote->cdp->nombre }}</td>
                <td class="{{ $clasesCampo }}">{{ $lote->finca->finca }}</td>
                <td class="{{ $clasesCampo }}">{{ $lote->created_at->format('d-m-Y') }}</td>
                <td class="{{ $clasesCampo }}">{{ $lote->updated_at->format('d-m-Y') }}</td>
                <td class="{{ $clasesCampo }}">
                    <form action="{{ route('lotes.destroy',$lote) }}" class="estado"
                        method="POST">
                        @csrf
                        @method('DELETE')
                        <input data-status="{{ $lote->estado }}" id="destroy-button" type="submit"
                            value="{{ ($lote->estado == 1) ? 'ACTIVO' : 'INACTIVO' }}"
                            class="cursor-pointer text-white font-bold rounded p-2 {{ ($lote->estado) ? 'bg-green-500 hover:bg-green-600' : 'bg-red-500 hover:bg-red-600' }}">
                    </form>
                </td>
                <td class="{{ $clasesCampo }}">
                    <a href="{{ route('lotes.edit',$lote) }}">
                        <i class="fa-solid fa-pen text-xl"></i>
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>


@endsection