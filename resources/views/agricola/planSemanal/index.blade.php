@extends('layouts.administracion')

@section('titulo')
Tareas Finca Semanal
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
                    Finca</th>
                <th scope="col" class="{{ $clasesEncabezados }}">
                    Semana</th>
                <th scope="col" class="{{ $clasesEncabezados }}">
                    Fecha de Creación</th>
                <th scope="col" class="{{ $clasesEncabezados }}">
                    Presupuesto Total</th>
                <th scope="col" class="{{ $clasesEncabezados }}">
                    Total de Personas</th>
                <th scope="col" class="{{ $clasesEncabezados }}">
                    Tareas Semanales</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200 dark:divide-gray-700 dark:bg-gray-900">
            @foreach ($planes as $plan)
            <tr>
                <td class="{{ $clasesCampo }}">{{ $plan->finca->finca }}</td>
                <td class="{{ $clasesCampo }}">{{ $plan->semana }}</td>
                <td class="{{ $clasesCampo }}">{{ $plan->created_at->format('d-m-Y') }}</td>
                <td class="{{ $clasesCampo }}"></td>
                <td class="{{ $clasesCampo }}"></td>
                <td class="{{ $clasesCampo }}">
                    <a class="{{ $clasesEnlaces }}" href="{{ route('planSemanal.show',$plan) }}">
                        Tareas Semanales
                    </a>
                </td>

            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection