@extends('layouts.administracion')

@section('titulo')
Plan Semanal Lote - {{ $lote->nombre }} {{ $lote->finca->finca }} Semana {{ $plansemanalfinca->semana }}
@endsection

@section('contenido')
    @if(session('success'))
    <p class="bg-green-500 uppercase text-xl text-white my-2 rounded-lg p-2 text-center font-bold">{{ session('success') }}</p>
    @endif

@php
$clasesEncabezados = 'p-3 text-sm font-bold uppercase text-left rtl:text-right text-gray-500 dark:text-gray-400';
$clasesEnlaces = 'bg-orange-500 cursor-pointer hover:bg-orange-700 text-white font-bold py-2 px-4 rounded
inline-block ';
$clasesCampo = 'px-4 py-2 text-md font-medium whitespace-nowrap';
$clasesAlertas = 'bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center';
$clasesLegend = 'text-2xl font-bold mb-5 text-center uppercase';
@endphp


<div class="bg-white p-6 rounded-lg shadow-lg mt-10 container mx-auto">
    <div>
        @foreach ($tareas as $tarea)
        <div class="mt-5 flex flex-col md:flex-row justify-between p-5 rounded-xl shadow-xl border-l-8 ">
            <div class="text-xs md:text-xl">
                <p><span class="uppercase font-bold">Nombre del Lote:</span> {{ $tarea->lote->nombre }}</p>
                <p><span class="uppercase font-bold">Semana:</span> {{ $plansemanalfinca->semana }}</p>
                <p><span class="uppercase font-bold">Semana:</span> {{ $tarea->tarea->tarea }}</p>
                <p><span class="uppercase font-bold">Cupos disponibles:</span> {{ $tarea->personas }}</p>
                <p><span class="uppercase font-bold">Presupuesto:</span> Q{{ $tarea->presupuesto }}</p>
                <p><span class="uppercase font-bold">Horas Necesarias:</span> {{ $tarea->horas }} horas</p>
            </div>
        </div>
        @endforeach
    </div>
</div>

@endsection