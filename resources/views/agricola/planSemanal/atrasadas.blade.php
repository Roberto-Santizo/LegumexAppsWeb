@extends('layouts.administracion')

@section('titulo')
Plan Semanal {{ $plansemanalfinca->finca->finca }} {{ $plansemanalfinca->semana }}, Tareas Atrasadas
@endsection

@section('contenido')

<x-alertas />


<div class="bg-white p-6 rounded-lg shadow-lg mt-10 container mx-auto">

    <div>
        @forelse ($tareas as $tarea)
        <div class="mt-5 flex flex-col md:flex-row justify-between p-5 rounded-xl shadow-xl border-l-8 ">
            <div class="text-xs md:text-xl">
                <p><span class="uppercase font-bold">Nombre del Lote:</span> {{ $tarea->lote->nombre }}</p>
                <p><span class="uppercase font-bold">Semana:</span> {{ $plansemanalfinca->semana }}</p>
                <p><span class="uppercase font-bold">Tarea:</span> {{ $tarea->tarea->tarea }}</p>
                <p><span class="uppercase font-bold">Cupos disponibles:</span> {{ ($tarea->personas -
                    $tarea->cupos_utilizados) }}</p>
                <p><span class="uppercase font-bold">Presupuesto:</span> Q{{ $tarea->presupuesto }}</p>
                <p><span class="uppercase font-bold">Horas Necesarias:</span> {{ $tarea->horas }} horas</p>
                @if($tarea->cierre)
                <p><span class="uppercase font-bold">Fecha de cierre:</span> {{
                    \Illuminate\Support\Carbon::parse($tarea->cierre->created_at)->format('d-m-Y h:m:s'); }}</p>
                @endif

                @if ($tarea->extraordinaria)
                    <p class="text-white p-2 rounded-lg bg-blue-500 uppercase font-bold inline-block mt-5">Extraordinaria</p>
                @endif

                <p class="btn-red mt-5">ATRASADA</p>
            </div>

            <div class="flex flex-col items-center justify-between">

                <div>
                    <div class="flex flex-col gap-2">
                        @hasanyrole('admin|adminagricola|auxalameda')
                        <a href="{{ route('planSemanal.tareaLote.edit',$tarea) }}">
                            <i title="Editar Tarea"
                                class="fa-solid fa-arrow-right-arrow-left text-2xl cursor-pointer hover:text-gray-500"></i>
                        </a>

                        @endhasanyrole

                    </div>
                </div>

                @if ($tarea->extendido)
                <div class="bg-green-500 text-white font-bold p-2 rounded-xl">
                    <p>{{ $tarea->ingresados }} / {{ ($tarea->personas - $tarea->cupos) }}</p>
                </div>
                @endif

            </div>
        </div>
        @empty
            <p class="text-center font-bold uppercase">No existen tareas atrasadas</p>
        @endforelse 

        
    </div>
</div>

@endsection