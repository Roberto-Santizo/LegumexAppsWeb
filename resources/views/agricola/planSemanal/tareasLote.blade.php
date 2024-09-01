@extends('layouts.administracion')

@section('titulo')
Plan Semanal Lote - {{ $lote->nombre }} Semana {{ $plansemanalfinca->semana }}
@endsection

@section('contenido')

<x-alertas />

<div class="bg-white p-6 rounded-lg shadow-lg mt-10 container mx-auto">
    <div>
        @foreach ($tareas as $tarea)

        <div class="mt-5 flex flex-col md:flex-row justify-between p-5 rounded-xl shadow-xl border-l-8 ">
            <div class="text-xs md:text-xl">
                <p><span class="uppercase font-bold">Nombre del Lote:</span> {{ $tarea->lote->nombre }}</p>
                <p><span class="uppercase font-bold">Semana:</span> {{ $plansemanalfinca->semana }}</p>
                <p><span class="uppercase font-bold">Semana:</span> {{ $tarea->tarea->tarea }}</p>
                <p><span class="uppercase font-bold">Cupos disponibles:</span> {{ ($tarea->personas -
                    $tarea->cupos_utilizados) }}</p>
                <p><span class="uppercase font-bold">Presupuesto:</span> Q{{ $tarea->presupuesto }}</p>
                <p><span class="uppercase font-bold">Horas Necesarias:</span> {{ $tarea->horas }} horas</p>
                @if($tarea->cierre)
                    <p><span class="uppercase font-bold">Fecha de cierre:</span> {{ \Illuminate\Support\Carbon::parse($tarea->cierre->created_at)->format('d-m-Y'); }}</p>
                @endif
            </div>

            <div>
                @if (($tarea->asignacion_diaria))
                @if(!$tarea->cierre)
                <form action="{{ route('planSemanal.storediario') }}" method="POST">
                    @csrf
                    <input type="hidden" value="{{ $tarea->id }}" name="tarea_lote_id">
                    <button type="submit"><i class="fa-solid fa-circle-check text-3xl hover:text-gray-600"></i></button>
                </form>
                @else
                <i title="La tarea fue realizada" class="fa-solid fa-circle-check text-3xl text-green-500"></i>
                @endif

                @else
                <a href="{{ route('planSemanal.Asignar',[$lote,$plansemanalfinca,$tarea->tarea, $tarea]) }}">
                    <i title="Asignar Empleados"
                        class="fa-solid fa-square-plus text-3xl cursor-pointer hover:text-gray-500"></i>
                </a>
                @endif
            </div>
        </div>
        @endforeach
    </div>
</div>

@endsection