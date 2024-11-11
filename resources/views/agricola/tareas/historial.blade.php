@extends('layouts.agricola')

@section('titulo')
Historial de Tareas
@endsection

@section('contenido')
<a href="{{ route('tareas') }}"
    class=" bg-orange-500 cursor-pointer hover:bg-orange-700 text-white font-bold py-2 px-4 rounded inline-block mt-5 mb-5 ">
    <i class="fa-solid fa-arrow-left"></i>
    Volver
</a>

<div class="overflow-x-auto mt-10">
    <table class="min-w-full divide-y divide-gray-200 text-xs md:text-sm">
        <thead class="bg-gray-50">
            <tr class="text-xs md:text-sm">
                <th scope="col"
                    class="p-3 text-sm font-bold uppercase text-left rtl:text-right text-gray-500">
                    Tarea</th>
                <th scope="col"
                    class="p-3 text-sm font-bold uppercase text-left rtl:text-right text-gray-500">
                    Presupuesto Anterior</th>
                <th scope="col"
                    class="p-3 text-sm font-bold uppercase text-left rtl:text-right text-gray-500">
                    Presupuesto Nuevo</th>
                <th scope="col" class="p-3 text-sm font-bold uppercase text-center  text-gray-500">
                    Tarifa Anterior</th>
                <th scope="col" class="p-3 text-sm font-bold uppercase text-center  text-gray-500">
                    Tarifa Nueva</th>
                <th scope="col" class="p-3 text-sm font-bold uppercase text-center  text-gray-500">
                    Horas Anterior</th>
                <th scope="col" class="p-3 text-sm font-bold uppercase text-center  text-gray-500">
                    Horas Nuevas</th>
                <th scope="col" class="p-3 text-sm font-bold uppercase text-center  text-gray-500">
                    Personas Anterior</th>
                <th scope="col" class="p-3 text-sm font-bold uppercase text-center  text-gray-500">
                    Personas Nuevo</th>
                <th scope="col" class="p-3 text-sm font-bold uppercase text-center  text-gray-500">
                    Semana de Actualización</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @php
                $clases = 'px-4 py-2 text-md font-medium whitespace-nowrap text-center';
            @endphp
            @foreach ($cambios as $cambio)
                <tr>
                    <td class="px-4 py-2 text-md font-medium whitespace-nowrap">{{ $cambio->tarea->tarea }}</td>
                    <td class="{{ $clases }}">Q {{ $cambio->presupuesto_anterior }}</td>
                    <td class="{{ $clases }}">Q {{ $cambio->presupuesto_nuevo }}</td>
                    <td class="{{ $clases }}">Q {{ $cambio->tarifa_anterior }}</td>
                    <td class="{{ $clases }}">Q {{ $cambio->tarifa_nueva }}</td>
                    <td class="{{ $clases }}">{{ $cambio->horas_anterior }}</td>
                    <td class="{{ $clases }}">{{ $cambio->horas_nueva }}</td>
                    <td class="{{ $clases }}">{{ $cambio->personas_anterior }}</td>
                    <td class="{{ $clases }}">{{ $cambio->personas_nuevo }}</td>
                    <td class="{{ $clases }}">{{ $cambio->semana }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="my-10">
    {{ $cambios->links('pagination::tailwind') }}
</div>

@endsection