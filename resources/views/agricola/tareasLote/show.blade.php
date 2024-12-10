@extends('layouts.agricola')

@section('titulo')
    {{ $tarea->tarea->tarea }} - {{ $tarea->plansemanal->finca->finca }} - SEMANA {{ $tarea->plansemanal->semana }}
@endsection

@section('contenido')

    <x-alertas />
    <x-link-volver ruta="planSemanal.tareasLote" class="bg-green-moss hover:bg-green-meadow" :parametros="[$tarea->lote, $tarea->plansemanal]" />

    <div class="mt-10">
        <h2 class="font-bold text-2xl">Información de la tarea: </h2>
        @if (!$tarea->cierreParcialActivo->isEmpty())
            <div class="flex flex-row gap-1 justify-end">
                <i class="fa-solid fa-circle-play text-orange-500 text-2xl"></i>
                <p class="font-bold text-2xl">La tarea se encuentra actualmente en pausa</p>
            </div>
        @endif

        <div class="mt-5 flex gap-5 flex-col md:flex-row shadow-2xl p-5 rounded-xl justify-between">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <div class="p-5 bg-gray-200 shadow-xl rounded-xl">
                    <p class="font-bold text-xl">Fecha de Inicio:</p>
                    <p>{{ $tarea->asignacion->created_at->format('d-m-Y h:i:s A') }}</p>
                </div>

                <div class="p-5 bg-gray-200 shadow-xl rounded-xl">
                    <p class="text-xl font-bold">Horas Teoricas:</p>
                    <p>{{ $tarea->horas }} @choice('hora|horas', $tarea->horas)</p>
                </div>

                @if ($tarea->cierre)
                    <div class="p-5 bg-gray-200 shadow-xl rounded-xl">
                        @php
                            $difhoras =
                                (round($tarea->asignacion->created_at->diffinhours($tarea->cierre->created_at), 2) -
                                    $tarea->horas_diferencia) *
                                $tarea->users->count();
                        @endphp
                        <p class="text-xl font-bold">Horas Rendimiento Real:</p>
                        <p>{{ round($difhoras, 2) }} @choice('hora|horas', $difhoras)</p>
                    </div>

                    <div class="p-5 bg-gray-200 shadow-xl rounded-xl">
                        <p class="font-bold text-xl">Fecha de Cierre</p>
                        <p>{{ $tarea->cierre->created_at->format('d-m-Y h:i:s A') }}</p>
                    </div>
                @endif

                <div class="p-5 bg-gray-200 shadow-xl rounded-xl">
                    <p class="text-xl font-bold">Cupos Totales:</p>
                    <p>{{ $tarea->personas }} @choice('persona|personas', $tarea->personas)</p>
                </div>

                <div class="p-5 bg-gray-200 shadow-xl rounded-xl">
                    <p class="text-xl font-bold">Cupos Asignados:</p>
                    <p>{{ $tarea->users()->count() }} @choice('persona|personas', $tarea->users()->count())</p>
                </div>

                @if (!$tarea->cierre)
                    <div class="p-5 bg-gray-200 shadow-xl rounded-xl">
                        @php
                            $horas_transcurridas =
                                $tarea->asignacion->created_at->diffInHours(now()) - $tarea->horas_diferencia;
                        @endphp
                        <p class="text-xl font-bold">Horas Transcurridas Reales:</p>
                        <p>{{ $tarea->asignacion->use_dron
                            ? round($horas_transcurridas, 2)
                            : round($horas_transcurridas * $tarea->users->count(), 2) }}
                            @choice('hora|horas', $horas_transcurridas)
                        </p>
                    </div>
                @endif
            </div>

            <div class="bg-green-100 p-5 flex-1 rounded shadow-xl">
                <h2 class="text-2xl font-bold">Cierre Parciales</h2>
                <div class="text-xl flex gap-2 flex-col mt-2">
                    @if ($tarea->cierresParciales->count() > 0)
                        <table class="tabla">
                            <thead class="tabla-head">
                                <tr class="text-xs md:text-sm">
                                    <th scope="col" class="encabezado">Fecha de Cierre Parcial</th>
                                    <th scope="col" class="encabezado">Fecha de Reapertura</th>
                                </tr>
                            </thead>
                            <tbody class="tabla-body">
                                @foreach ($tarea->cierresParciales as $cierre)
                                    <tr>
                                        <td class="campo">{{ $cierre->fecha_inicio->format('d-m-Y h:i:s A') }}</td>
                                        <td class="campo">
                                            {{ $cierre->fecha_final ? $cierre->fecha_final->format('d-m-Y h:i:s A') : 'Aún no tiene cierre' }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>Esta tarea no cuenta con cierres parciales</p>
                    @endif
                </div>
            </div>

        </div>
        @if ($tarea->asignacion->use_dron)
            <div
                class=" {{ $tarea->cierre ? 'bg-green-500' : 'bg-orange-500' }} w-full text-white mt-2 font-bold py-2 px-1 flex justify-center items-center rounded gap-2">
                <iconify-icon icon="hugeicons:drone" class="text-3xl"></iconify-icon>
                @if ($tarea->cierre)
                    <p class="uppercase">Tarea Realizada con Dron</p>
                @else
                    <p class="uppercase">Tarea Asignada para Realizar con Dron</p>
                @endif
            </div>
        @else
            @if ($tarea->insumos->count() > 0)
                <div class="space-y-5">
                    <h2 class="text-xl uppercase font-bold mt-5">Insumos:</h2>
                    <x-insumos-table :insumos="$tarea->insumos" />
                </div>
            @endif
            <div class="mt-5 flex gap-5 flex-col shadow-2xl p-5 rounded-xl">
                <h2 class="font-bold text-xl">Empleados Asignados: </h2>
                <livewire:mostrar-usuarios-asignados :asignaciones="$tarea->users" />
            </div>

            @if ($tarea->cierre && !$tarea->cierresParciales->isEmpty())
                <div class="mt-5 flex gap-5 flex-col shadow-2xl p-5 rounded-xl">
                    <h2 class="font-bold text-xl">Distribución de datos: </h2>
                    <livewire:distribucion-asignaciones :tarea="$tarea" />
                </div>
            @endif
        @endif
    </div>
@endsection
