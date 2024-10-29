@extends('layouts.agricola')

@section('titulo')
Plan Semanal {{ $plansemanalfinca->finca->finca }} Semana - {{ $plansemanalfinca->semana }}
@endsection

@section('contenido')

<x-alertas />

<x-link-volver ruta="planSemanal" class="bg-green-moss hover:bg-green-meadow"/>


<div class="overflow-x-auto mt-10">
    <h2 class="text-xl font-bold uppercase mb-5">Tareas Generales</h2>
    <table class="tabla">
        <thead class="tabla-head">
            <tr class="text-xs md:text-sm">
                <th scope="col" class="encabezado">
                    Lote</th>
                <th scope="col" class="encabezado">
                    Personas</th>
                @can('create plan semanal')
                <th scope="col" class="encabezado">
                    Presupuesto</th>
                @endcan
                <th scope="col" class="encabezado">
                    Horas</th>

                <th scope="col" class="encabezado">
                    Ver tareas asignadas</th>
                <th scope="col" class="encabezado">
                    Control de Tareas</th>
            </tr>
        </thead>
        <tbody class="tabla-body">
            @foreach ($lotes as $lote)
            <tr>
                <td class="campo">{{ $lote->lote->nombre }}</td>
                <td class="campo">{{ $lote->total_personas }}</td>
                @can('create plan semanal')
                <td class="campo">Q {{ $lote->total_presupuesto }}</td>
                @endcan
                <td class="campo">{{ $lote->total_horas }}</td>
                <td class="campo">
                    <a class="btn bg-green-moss hover:bg-green-meadow"
                        href="{{ route('planSemanal.tareasLote',[$lote->lote,$plansemanalfinca]) }}">
                        Tareas de lote
                    </a>
                </td>

                <td class="campo">
                    <p class="bg-sky-500 rounded-xl inline-block p-2 text-white font-bold">{{ $lote->total_terminadas }} / {{  $lote->total_asignadas }}</p>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@if ($lotesCosecha->count() > 0)
<div class="overflow-x-auto mt-10">
    <h2 class="text-xl font-bold uppercase mb-5">Cosechas</h2>
    <table class="tabla">
        <thead class="tabla-head">
            <tr class="text-xs md:text-sm">
                <th scope="col" class="encabezado">
                    Lote</th>
                <th scope="col" class="encabezado">
                    Cosecha Asignada</th>
            </tr>
        </thead>
        <tbody class="tabla-body">
            @foreach ($lotesCosecha as $loteCosecha)
            <tr>
                <td class="campo">{{ $loteCosecha->lote->nombre }}</td>
   
                <td class="campo">
                    <a class="btn bg-green-moss hover:bg-green-meadow" href="{{ route('planSemanal.tareasCosechaLote',[$loteCosecha->lote,$planSemanal]) }}">
                        VER COSECHA
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>  
@endif

@endsection