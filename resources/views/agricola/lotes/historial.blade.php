@extends('layouts.agricola')

@section('titulo')
Historial de Lotes
@endsection

@section('contenido')
<a href="{{ route('lotes') }}"
    class=" bg-orange-500 cursor-pointer hover:bg-orange-700 text-white font-bold py-2 px-4 rounded inline-block mt-5 mb-5 ">
    <i class="fa-solid fa-arrow-left"></i>
    Volver
</a>

@php
    $clasesEncabezado = 'p-3 text-sm font-bold uppercase rtl:text-right text-gray-500 dark:text-gray-400';
@endphp

<div class="overflow-x-auto mt-10">
    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-xs md:text-sm">
        <thead class="bg-gray-50 dark:bg-gray-800">
            <tr class="text-xs md:text-sm">
                <th scope="col"
                    class="{{ $clasesEncabezado }} text-left">
                    Lote Actualizado</th>
                <th scope="col"
                    class="{{ $clasesEncabezado }} text-left">
                    CDP Anterior</th>
                <th scope="col"
                    class="{{ $clasesEncabezado }} text-left">
                    CDP Nuevo</th>
                <th scope="col"
                    class="{{ $clasesEncabezado }} text-left">
                    Estado Anterior</th>
                <th scope="col"
                    class="{{ $clasesEncabezado }} text-left">
                    Estado Nuevo</th>
                <th scope="col" class="{{ $clasesEncabezado }} text-center">
                    Semana de Actualización</th>
                <th scope="col" class="{{ $clasesEncabezado }} text-left">
                    Fecha de actualización</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200 dark:divide-gray-700 dark:bg-gray-900">
            @foreach ($cambios as $cambio)
            <tr>
                <td class="px-4 py-2 text-md font-medium whitespace-nowrap">{{ $cambio->lote->nombre }}</td>
                <td class="px-4 py-2 text-md font-medium whitespace-nowrap">{{ $cambio->cdp_anterior }}</td>
                <td class="px-4 py-2 text-md font-medium whitespace-nowrap">{{ $cambio->cdp_nuevo }}</td>
                <td class="px-4 py-2 text-md whitespace-nowrap text-white font-bold "><span
                        class="{{ ($cambio->estado_anterior== 1) ? 'bg-green-500' : 'bg-red-500' }} p-2 rounded">{{
                        ($cambio->estado_anterior == 1) ? 'ACTIVO' : 'INACTIVO' }}</span></td>
                <td class="px-4 py-2 text-md whitespace-nowrap text-white font-bold "><span
                        class="{{ ($cambio->estado_nuevo == 1) ? 'bg-green-500' : 'bg-red-500' }} p-2 rounded">{{
                        ($cambio->estado_nuevo == 1) ? 'ACTIVO' : 'INACTIVO' }}</span></td>
                <td class="px-4 py-2 text-md font-medium whitespace-nowrap text-center">{{ $cambio->semana_cambio }}
                </td>
                <td class="px-4 py-2 text-md font-medium whitespace-nowrap">{{ $cambio->created_at->format('d-m-Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="my-10">
    {{ $cambios->links('pagination::tailwind') }}
</div>

@endsection