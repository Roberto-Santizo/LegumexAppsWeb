@extends('layouts.agricola')

@section('titulo')
Tareas Finca Semanal
@endsection

@section('contenido')

<x-alertas />
<x-link class="bg-green-moss hover:bg-green-meadow" route="planSemanal.create" text="Crear Plan Semanal" />


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
                    Control Presupueto</th>
                <th scope="col" class="encabezado">
                    Presupuesto Extraordinario</th>
                <th scope="col" class="encabezado">
                    Control Tareas</th>
                <th scope="col" class="encabezado text-center">
                    Tareas</th>
                <th scope="col" class="encabezado text-center">
                    Tareas Atrasadas</th>
                <th scope="col" class="encabezado text-center">
                    Reporte General</th>
                <th scope="col" class="encabezado text-center">
                    Planilla Semanal</th>

            </tr>
        </thead>
        <tbody class="tabla-body">
            @foreach ($planes as $plansemanalfinca)
            <tr>
                <td class="campo">{{ $plansemanalfinca->finca->finca }}</td>
                <td class="campo">{{ $plansemanalfinca->semana }}</td>
                <td class="campo">{{ $plansemanalfinca->created_at->format('d-m-Y') }}</td>
                <td class="campo">Q {{ $plansemanalfinca->presupuesto_general_gastado }} / Q {{ $plansemanalfinca->presupuesto_general}}</td>
                <td class="campo">Q {{ $plansemanalfinca->presupuesto_extraordinario_gastado }} / Q {{ $plansemanalfinca->presupuesto_extraordinario}}</td>
                <td class="campo"> <span class="bg-sky-500 p-2 text-white rounded-xl">{{
                        $plansemanalfinca->tareasRealizadas->count() }} / {{ $plansemanalfinca->tareasTotales->count()
                        }}</span></td>
                <td class="campo">
                    <a class="btn bg-green-moss hover:bg-green-meadow"
                        href="{{ route('planSemanal.show',$plansemanalfinca) }}">
                        Ver Tareas Semanales
                    </a>
                </td>

                <td class="campo">
                    @if ($plansemanalfinca->tareasRealizadas->count() == 0 && $plansemanalfinca->semana < now()->weekOfYear)
                        <a class="btn-red" href="{{ route('planSemanal.atrasadas',$plansemanalfinca) }}">
                            Ver Tareas Atrasadas
                        </a>
                        @endif

                </td>

                <td class="campo text-center">
                    <a href="{{ route('reporte.PlanSemanal',$plansemanalfinca->id) }}">
                        <i title="Reporte Tareas Generales"
                            class="fa-solid fa-file-arrow-down text-3xl hover:text-gray-500 cursor-pointer"></i>
                    </a>
                </td>

                <td class="campo text-center">
                    <a href="{{ route('reporte.PlanillaSemanal',$plansemanalfinca->id) }}">
                        <i title="Planilla General Semanal"
                            class="fa-solid fa-file-arrow-down text-3xl hover:text-gray-500 cursor-pointer"></i>
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<x-paginacion :items="$planes" />

@endsection