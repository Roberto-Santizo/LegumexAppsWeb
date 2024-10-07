@extends('layouts.agricola')

@section('titulo')
Control de Plantación
@endsection

@section('contenido')

<x-alertas/>

@php
    $clasesEnlaces = 'mt-5 bg-orange-500 cursor-pointer hover:bg-orange-700 text-white font-bold py-2 px-4 rounded
    inline-block';
    $clasesEncabezados = 'p-3 text-sm font-bold uppercase rtl:text-right text-gray-500 dark:text-gray-400';
    $clasesRegistros = 'px-4 py-2 text-md font-medium whitespace-nowrap';
    $clasesIconos = 'text-xl hover:text-gray-400';
@endphp

<a href="{{ route('cdps.create') }}"
    class="mt-5 bg-orange-500 cursor-pointer hover:bg-orange-700 text-white font-bold py-2 px-4 rounded inline-block ">
    <i class="fa-solid fa-plus"></i>
    Crear CDP
</a>

<div class="overflow-x-auto mt-10">
    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-xs md:text-sm">
        <thead class="bg-gray-50 dark:bg-gray-800">
            <tr class="text-xs md:text-sm">
                <th scope="col"
                    class="{{ $clasesEncabezados }} text-left">
                    Nombre CDP</th>
                <th scope="col"
                    class="{{ $clasesEncabezados }} text-left">
                    Cultivo</th>
                <th scope="col"
                    class="{{ $clasesEncabezados }} text-center">
                    Semana Actual</th>
                <th scope="col"
                    class="{{ $clasesEncabezados }} text-left">
                    Fecha de Creación</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200 dark:divide-gray-700 dark:bg-gray-900">
            @foreach ($cdps as $cdp)
            <tr>
                <td class="{{ $clasesRegistros }}">{{ $cdp->nombre }}</td>
                <td class="{{ $clasesRegistros }}">{{ $cdp->cultivo->cultivo }}</td>
                <td class="{{ $clasesRegistros }} text-center">{{ $cdp->semana }}</td>
                <td class="{{ $clasesRegistros }}">{{ $cdp->created_at->Format('d-m-Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="my-10">
    {{ $cdps->links('pagination::tailwind') }}
</div>

@endsection