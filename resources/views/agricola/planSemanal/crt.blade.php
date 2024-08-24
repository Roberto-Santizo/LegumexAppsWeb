@extends('layouts.administracion')

@section('titulo')
Control de Tareas Lote - {{ $lote->nombre }} Semana {{ $plansemanalfinca->semana }}
@endsection

@section('contenido')

<x-alertas />

@php
$clasesEncabezados = 'p-3 text-sm font-bold uppercase text-left rtl:text-right text-gray-500 dark:text-gray-400';
$clasesEnlaces = 'bg-orange-500 cursor-pointer hover:bg-orange-700 text-white font-bold py-2 px-4 rounded
inline-block ';
$clasesCampo = 'px-4 py-2 text-md font-medium whitespace-nowrap';
@endphp

<div class="overflow-x-auto mt-10">
    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-xs md:text-sm">
        <thead class="bg-gray-50 dark:bg-gray-800">
            <tr class="text-xs md:text-sm">
                <th scope="col" class="{{ $clasesEncabezados }}">
                    Tarea</th>
                @foreach ($fechasSemana as $fecha)
                <th scope="col" class="{{ $clasesEncabezados }}">
                    {{ $fecha }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody class="bg-w hite divide-y divide-gray-200 dark:divide-gray-700 dark:bg-gray-900">
            @foreach ($tareas as $tarea)
            <tr>
                <th class="{{ $clasesCampo }} text-left">{{ $tarea->tarea->tarea }}</th>
            </tr>
                @endforeach
        </tbody>
    </table>
</div>

@endsection