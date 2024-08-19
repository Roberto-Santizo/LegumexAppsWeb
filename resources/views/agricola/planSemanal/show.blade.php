@extends('layouts.administracion')

@section('titulo')
Plan Semanal {{ $planSemanal->finca->finca }} Semana - {{ $planSemanal->semana }}
@endsection

@section('contenido')
@if(session('success'))
<p class="bg-green-500 uppercase text-xl text-white my-2 rounded-lg p-2 text-center font-bold">{{ session('success') }}
</p>
@endif

@php
$clasesEncabezados = 'p-3 text-sm font-bold uppercase text-left rtl:text-right text-gray-500 dark:text-gray-400';
$clasesEnlaces = 'bg-orange-500 cursor-pointer hover:bg-orange-700 text-white font-bold py-2 px-4 rounded
inline-block ';
$clasesCampo = 'px-4 py-2 text-md font-medium whitespace-nowrap';
@endphp

<a href="{{ route('planSemanal.create') }}" class="{{ $clasesEnlaces }} mt-5">
    <i class="fa-solid fa-plus"></i>
    Crear Plan Semanal
</a>

<div class="overflow-x-auto mt-10">
    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-xs md:text-sm">
        <thead class="bg-gray-50 dark:bg-gray-800">
            <tr class="text-xs md:text-sm">
                <th scope="col" class="{{ $clasesEncabezados }}">
                    Lotes Disponibles</th>
                <th scope="col" class="{{ $clasesEncabezados }}">
                    Total de Tareas Asignadas</th>
                <th scope="col" class="{{ $clasesEncabezados }}">
                    Presupuesto por Lote</th>
                <th scope="col" class="{{ $clasesEncabezados }}">
                    Acciones</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200 dark:divide-gray-700 dark:bg-gray-900">
            @foreach ($lotes as $lote)
            <tr>
                <td class="{{ $clasesCampo }}">{{ $lote->nombre }}</td>
                <td class="{{ $clasesCampo }}">10</td>
                <td class="{{ $clasesCampo }}">Q10,000</td>
                <td class="{{ $clasesCampo }}">
                    <a class="{{ $clasesEnlaces }}" href="{{ route('planSemanal.tareasLote',$lote) }}">
                        Agregar Tareas
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection