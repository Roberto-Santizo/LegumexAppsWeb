@extends('layouts.administracion')

@section('titulo')
Plan Semanal {{ $planSemanal->finca->finca }} Semana - {{ $planSemanal->semana }}
@endsection

@section('contenido')

<x-alertas />

<x-link route="planSemanal" text="Volver" icon="fa-solid fa-arrow-left" />


<div class="overflow-x-auto mt-10">

    <table class="tabla">
        <thead class="tabla-head">
            <tr class="text-xs md:text-sm">
                <th scope="col" class="encabezado">
                    Lotes Disponibles</th>
                <th scope="col" class="encabezado">
                    Personas</th>
                <th scope="col" class="encabezado">
                    Presupuesto</th>
                <th scope="col" class="encabezado">
                    Horas</th>
                <th scope="col" class="encabezado">
                    Ver tareas asignadas</th>
            </tr>
        </thead>
        <tbody class="tabla-body">
            @foreach ($lotes as $lote)
            <tr>
                <td class="campo">{{ $lote->lote->nombre }}</td>
                <td class="campo">{{ $lote->total_personas }}</td>
                <td class="campo">Q {{ $lote->total_presupuesto }}</td>
                <td class="campo">{{ $lote->total_horas }}</td>
                <td class="campo">
                    <a class="btn" href="{{ route('planSemanal.tareasLote',[$lote->lote,$planSemanal]) }}">
                        Tareas de lote
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection