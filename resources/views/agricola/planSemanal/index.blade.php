@extends('layouts.administracion')

@section('titulo')
Tareas Finca Semanal
@endsection

@section('contenido')

<x-alertas />

<a href="{{ route('planSemanal.create') }}" class="btn mt-5">
    <i class="fa-solid fa-plus"></i>
    Crear Plan Semanal
</a>

<div class="overflow-x-auto mt-10">
    <table class="tabla">
        <thead class="tabla-head">
            <tr class="text-xs md:text-sm">
                <th scope="col" class="encabezado">
                    Finca</th>
                <th scope="col" class="encabezado">
                    Semana</th>
                <th scope="col" class="encabezado">
                    Fecha de Creación</th>
                <th scope="col" class="encabezado">
                    Presupuesto Total</th>
                <th scope="col" class="encabezado">
                    Número máximo de personas para una tarea</th>
                <th scope="col" class="encabezado">
                    Total Tareas Semanales</th>
                <th scope="col" class="encabezado text-center">
                    Tareas</th>
                <th scope="col" class="encabezado text-center">
                    Tareas Atrasadas</th>
                <th scope="col" class="encabezado text-center">
                    Reporte General</th>

            </tr>
        </thead>
        <tbody class="tabla-body">
            @foreach ($planes as $plansemanalfinca)
            <tr>
                <td class="campo">{{ $plansemanalfinca->finca->finca }}</td>
                <td class="campo">{{ $plansemanalfinca->semana }}</td>
                <td class="campo">{{ $plansemanalfinca->created_at->format('d-m-Y') }}</td>
                <td class="campo">Q {{ $plansemanalfinca->presupuesto }}</td>
                <td class="campo text-center">{{ $plansemanalfinca->totalPersonasNecesarias->personas }}
                </td>
                <td class="campo text-center">{{ $plansemanalfinca->tareas_totales }}</td>
                <td class="campo">
                    <a class="btn" href="{{ route('planSemanal.show',$plansemanalfinca) }}">
                        Ver Tareas Semanales
                    </a>
                </td>

                <td class="campo">
                    <a class="btn-red" href="{{ route('planSemanal.atrasadas',$plansemanalfinca) }}">
                        Ver Tareas Atrasadas
                    </a>
                </td>

                <td class="campo text-center">
                    <a href="{{ route('reporte.PlanSemanalDiario',$plansemanalfinca->id) }}">
                        <i title="Reporte Tareas Generales"
                            class="fa-solid fa-file-excel text-3xl hover:text-gray-500 cursor-pointer"></i>
                    </a>
                </td>


            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection