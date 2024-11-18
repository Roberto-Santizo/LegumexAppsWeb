@extends('layouts.agricola')

@section('titulo')
    Empleados Asignados Cosecha: {{ $asignacion->created_at->format('d-m-Y') }}
@endsection

@section('contenido')

<x-alertas />

<x-link-volver ruta="dashboard.agricola" class="bg-green-moss hover:bg-green-meadow"/>

<div>
    <div class="flex flex-col gap-5">
        <div class="flex flex-row justify-between items-center gap-2 bg-green-moss font-bold p-3 rounded-xl">
            <table class="tabla">
                <thead class="tabla-head">
                    <tr class="text-xs md:text-sm">
                        <th scope="col" class="encabezado">Codigo</th>
                        <th scope="col" class="encabezado">Nombre del Empleado</th>
                        <th scope="col" class="encabezado">Fecha de Asignación</th>
                    </tr>
                </thead>
                <tbody class="tabla-body">
                    @foreach ($empleadosAsignados as $empleado)
                    <tr>
                        <td class="campo">{{ $empleado->codigo }}</td>
                        <td class="campo">{{ $empleado->nombre }}</td>
                        <td class="campo">{{ $empleado->created_at->format('d-m-Y h:i:s A') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
       
    </div>
</div>
@endsection