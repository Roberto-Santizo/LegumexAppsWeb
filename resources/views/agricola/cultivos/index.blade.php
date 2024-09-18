@extends('layouts.agricola')

@section('titulo')
Cultivos
@endsection

@section('contenido')

<x-alertas />

<a href="{{ route('cultivos.create') }}"
    class="mt-5 bg-orange-500 cursor-pointer hover:bg-orange-700 text-white font-bold py-2 px-4 rounded inline-block ">
    <i class="fa-solid fa-plus"></i>
    Crear Cultivo
</a>

<div class="overflow-x-auto mt-10">
    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-xs md:text-sm">
        <thead class="bg-gray-50 dark:bg-gray-800">
            <tr class="text-xs md:text-sm">
                <th scope="col"
                    class="p-3 text-sm font-bold uppercase text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    Nombre/Codificación del cultivo</th>
                <th scope="col"
                    class="p-3 text-sm font-bold uppercase text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    Semanas totales del Cultivo</th>
                <th scope="col"
                    class="p-3 text-sm font-bold uppercase text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    Fecha de Creación</th>
                <th scope="col"
                    class="p-3 text-sm font-bold uppercase text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    Ultima fecha de actualización</th>
                <th scope="col"
                    class="p-3 text-sm font-bold uppercase text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    Acción</th>

            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200 dark:divide-gray-700 dark:bg-gray-900">
            @foreach ($cultivos as $cultivo)
            <tr>
                <td class="px-4 py-2 text-md font-medium whitespace-nowrap">{{ $cultivo->cultivo }}</td>
                <td class="px-4 py-2 text-md font-medium whitespace-nowrap">{{ $cultivo->semanas }}</td>
                <td class="px-4 py-2 text-md font-medium whitespace-nowrap">{{ $cultivo->created_at }}</td>
                <td class="px-4 py-2 text-md font-medium whitespace-nowrap">{{ $cultivo->updated_at }}</td>
                <td class="px-4 py-2 text-md font-medium whitespace-nowrap flex gap-5 justify-center items-center">
                    <a href="{{ route('cultivos.edit',$cultivo) }}">
                        <i class="fa-solid fa-pen text-xl hover:text-gray-400"></i>
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection