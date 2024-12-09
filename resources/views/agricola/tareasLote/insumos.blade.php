@extends('layouts.agricola')

@section('titulo')
Insumos {{ $tarea->tarea->tarea }} - {{ $tarea->lote->nombre }} - Semana {{ $tarea->plansemanal->semana }}
@endsection

@section('contenido')

<x-alertas />

<x-link-volver ruta="planSemanal.tareasLote" class="bg-green-moss hover:bg-green-meadow" :parametros="[$tarea->lote, $tarea->plansemanal]" />

<div class="mt-10">
    <table class="tabla">
        <thead class="bg-green-meadow">
            <tr class="text-xs md:text-sm rounded">
                <th scope="col" class="text-white uppercase">Insumo</th>
                <th scope="col" class="text-white uppercase">Cantidad Asignada</th>
                <th scope="col" class="text-white uppercase">Cantidad Usada</th>
            </tr>
        </thead>
        <tbody class="tabla-body">
            @foreach ($tarea->insumos as $insumo)
            <tr>
                <td class="campo">{{ $insumo->insumo->insumo }}</td>
                <td class="campo text-center">{{ $insumo->cantidad_asignada }}</td>
                <td class="campo text-center">{{ $insumo->cantidad_usada ?? 'Sin registro' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection