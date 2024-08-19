@extends('layouts.administracion')

@section('titulo')
Tareas Generales Fincas
@endsection

@section('contenido')
    @if(session('success'))
    <p class="bg-green-500 uppercase text-xl text-white my-2 rounded-lg p-2 text-center font-bold">{{ session('success') }}
    </p>
    @endif

@php
    $clasesEnlaces = 'mt-5 bg-orange-500 cursor-pointer hover:bg-orange-700 text-white font-bold py-2 px-4 rounded inline-block';
    $clasesEncabezados = 'p-3 text-sm font-bold uppercase rtl:text-right text-gray-500 dark:text-gray-400';
    $clasesRegistros = 'px-4 py-2 text-md font-medium whitespace-nowrap';
    $clasesIconos = 'text-xl hover:text-gray-400';
@endphp

<div class="flex flex-col md:flex-row justify-between">
    <a href="{{ route('tareas.create') }}"
        class="{{ $clasesEnlaces }}">
        <i class="fa-solid fa-plus"></i>
        Crear Tarea
    </a>

    <a href="{{ route('tareas.historial') }}"
    class="{{ $clasesEnlaces }}">
        Ver historial de Tareas
    </a>
</div>

<div class="overflow-x-auto mt-10">
    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-xs md:text-sm">
        <thead class="bg-gray-50 dark:bg-gray-800">
            <tr class="text-xs md:text-sm">
                <th scope="col" class="{{ $clasesEncabezados }} text-left">
                    Nombre de la Tarea</th>
                <th scope="col" class="{{ $clasesEncabezados }} text-center">
                    Acciones</th>
            </tr>

        </thead>
        <tbody class="bg-white divide-y divide-gray-200 dark:divide-gray-700 dark:bg-gray-900">
            @foreach ($tareas as $tarea)
            <tr>
                <td class="{{ $clasesRegistros }}">{{ $tarea->tarea }}</td>
                <td class="flex gap-5 justify-center items-center {{ $clasesRegistros }}">

                    <a href="{{ route('tareas.edit',$tarea) }}">
                        <i class="fa-solid fa-pen {{ $clasesIconos }}"></i>
                    </a>

                    <a href="{{ route('tareas.show',$tarea) }}">
                        <i class="fa-solid fa-eye {{ $clasesIconos }}"></i>
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="my-10">
    {{ $tareas->links('pagination::tailwind') }}
</div>
@endsection