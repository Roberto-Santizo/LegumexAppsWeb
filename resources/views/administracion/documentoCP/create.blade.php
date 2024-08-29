@extends('layouts.administracion')

@section('titulo')
Documento Checklist Preoperacional - {{ $planta->planta }}
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
@endpush


@section('contenido')
<x-alertas />

<a href="{{ route('documentocp.select') }}"
    class=" bg-orange-500 cursor-pointer hover:bg-orange-700 text-white font-bold py-2 px-4 rounded inline-block mt-5 mb-5 ">
    <i class="fa-solid fa-arrow-left"></i>
    Volver
</a>

<form id="{{ ($planta->id == 1) ? 'formularioP1' : (($planta->id == 2) ? 'formularioP2' : 'formularioP3') }}"
    class="mt-5" action="{{ route('documentocp.store',$planta) }}" method="POST">
    @csrf
    <div class="bs-stepper">
        <div class="bs-stepper-header flex flex-wrap gap-2 " role="tablist">

            <div class="step bg-blue-100 shadow flex justify-center items-center rounded-lg p-2"
                data-target="#stepEncabezado-content">
                <button type="button" class="step-trigger" role="tab" aria-controls="stepEncabezado-content">
                    <span class="bs-stepper-label text-sm font-medium text-black">INFORMACIÓN GENERAL</span>
                </button>
            </div>

            @foreach ($planta->areas as $area)
            <div class="step shadow flex justify-center items-center rounded-lg p-2 text-black"
                data-target="#step{{$area->id}}-content">
                <button type="button" class="step-trigger" role="tab" aria-controls="step{{$area->id}}-content">
                    <span class="bs-stepper-label text-sm font-medium ">{{$area->area}}</span>
                </button>
            </div>
            @endforeach

            <div class="step bg-blue-100 shadow flex justify-center items-center rounded-lg p-2"
                data-target="#stepPiePagina-content">
                <button type="button" class="step-trigger" role="tab" aria-controls="stepPiePagina-content">
                    <span class="bs-stepper-label text-sm font-medium text-black">FIRMAS Y OBSERVACIONES</span>
                </button>
            </div>
        </div>

        <div class="bs-stepper-content p-10 flex justify-center items-center">
            <div id="stepEncabezado-content" class="content" role="tabpanel" aria-labelledby="stepEncabezado-content">
                <fieldset class="formulario__fieldset">
                    <legend class="formulario__legend text-4xl">Información General</legend>
                    <div class="formulario__campo">
                        <p class="text-2xl">Planta: <span class="font-bold">{{ $planta->planta }}</span></p>
                    </div>
                    <div class="formulario__campo">
                        <p class="text-2xl">Fecha: <span class="font-bold">{{ now()->format('d-m-Y') }}</span></p>
                    </div>
                </fieldset>
            </div>

            @foreach ($planta->areas as $area)
            <div id="step{{$area->id}}-content" class="content w-full" role="tabpanel"
                aria-labelledby="step{{$area->area}}-content">
                <table class="w-full divide-y divide-gray-200 shadow-xl dark:divide-gray-700  overflow-y-scroll">
                    <thead class="bg-blue-300">
                        <tr class="text-white">
                            <th scope="col"
                                class="p-5 text-sm font-bold uppercase text-left rtl:text-right dark:text-gray-400">
                                UBICACIÓN</th>
                            <th scope="col"
                                class="p-5 text-sm font-bold uppercase text-left rtl:text-right dark:text-gray-400">OK
                            </th>
                            <th scope="col"
                                class="p-5 text-sm font-bold uppercase text-left rtl:text-right dark:text-gray-400">
                                PROBLEMA</th>
                            <th scope="col"
                                class="p-5 text-sm font-bold uppercase text-left rtl:text-right dark:text-gray-400">
                                ACCIÓN TOMADA</th>
                            <th scope="col"
                                class="p-5 text-sm font-bold uppercase text-left rtl:text-right dark:text-gray-400">
                                RESPONSABLE</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700 font-bold">
                        @foreach ($area->elementos as $elemento)
                        <tr class="odd:bg-sky-200">
                            <td class=" p-2 table__td">
                                {{ $elemento->elemento }}
                            </td>
                            <td class="p-2">
                                <input data-id="{{$elemento->id}}" name="areas[{{$area->id}}][ok][{{ $elemento->id }}]"
                                    class="w-7 h-7 checkbox-{{$area->id}} table__check" checked type="checkbox">
                            </td>

                            <td class="p-2">
                                <input data-id="{{$elemento->id}}"
                                    name="areas[{{$area->id}}][problema][{{$elemento->id}}]"
                                    class="problem-{{$elemento->id}} border border-sky-400 input-text" disabled
                                    type="text">
                            </td>
                            <td class="p-2">
                                <input data-id="{{$elemento->id}}"
                                    name="areas[{{$area->id}}][accion][{{$elemento->id}}]"
                                    class="action-{{$elemento->id}}  border border-sky-400 input-text" disabled
                                    type="text">
                            </td>
                            <td class="p-2">
                                <div data-area="{{ $area->id }}" data-elemento="{{ $elemento->id }}"
                                    data-planta="{{ $planta->id }}"
                                    class="text-center hidden cursor-pointer bg-blue-500 hover:bg-blue-600 p-2 text-white font-black rounded responsable-{{$elemento->id}} create-ot">
                                    Crear OT
                                    <input id="responsable-{{$elemento->id}}" type="hidden"
                                        name="areas[{{$area->id}}][orden_trabajos_id][{{$elemento->id}}]"
                                        data-id="{{$elemento->id}}">
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="formulario__firma flex justify-center items-center flex-col">
                    <canvas id="signature-pad{{$area->id}}"
                        class="formulario__firma-canva formulario__firma-canva--checklist bg-gray-50 mt-10 rounded-xl border border-black"
                        width="450" height="250"></canvas>
                    <div class="clear_btn flex flex-col justify-center items-center">
                        <h4 class="formulario__texto text-xl">Firma Inspector de Calidad</h4>
                        <div id="clear-button{{$area->id}}"
                            class="formulario__firma--clear inline-block mt-5 bg-orange-600 hover:bg-orange-700 p-3 transition-colors cursor-pointer uppercase font-bold text-white rounded-lg">
                            <span>Limpiar</span>
                        </div>
                    </div>
                    <input type="hidden" id="signature-pad{{$area->id}}-input" name="areas[{{$area->id}}][firma]">
                </div>
            </div>
            @endforeach

            <div id="stepPiePagina-content" class="content" role="tabpanel" aria-labelledby="stepPiePagina-content">
                <fieldset class="formulario__fieldset flex flex-col">
                    <div class="formulario__firmas flex justify-center items-center gap-2">
                        <div class="formulario__firma flex justify-center items-center flex-col">
                            <canvas
                                id="signature-pad{{($planta->id == 1) ? '11' : (($planta->id == 2) ? '19' : '38') }}"
                                class="formulario__firma-canva  bg-gray-50 mt-10 rounded-xl border border-black"
                                width="350" height="175"></canvas>
                            <div class="clear_btn flex justify-center items-center flex-col">
                                <h4 class="formulario__texto">Verificado Por</h4>
                                <div id="clear-button{{($planta->id == 1) ? '11' : (($planta->id == 2) ? '19' : '38') }}"
                                    class=" inline-block mt-5 bg-orange-600 hover:bg-orange-700 p-3 transition-colors cursor-pointer uppercase font-bold text-white rounded-lg formulario__firma--clear">
                                    <span>Limpiar</span>
                                </div>

                            </div>
                            <input type="hidden"
                                id="signature-pad{{($planta->id == 1) ? '11' : (($planta->id == 2) ? '19' : '38') }}-input"
                                name="verificado_firma">
                        </div>

                        <div class="formulario__firma flex justify-center items-center flex-col">
                            <canvas
                                id="signature-pad{{($planta->id == 1) ? '12' : (($planta->id == 2) ? '20' : '39') }}"
                                class="formulario__firma-canva  bg-gray-50 mt-10 rounded-xl border border-black"
                                width="350" height="175"></canvas>

                            <div class="clear_btn flex justify-center items-center flex-col">
                                <h4 class="formulario__texto">Jefe de Mantenimiento</h4>
                                <div id="clear-button{{($planta->id == 1) ? '12' : (($planta->id == 2) ? '20' : '39') }}"
                                    class=" inline-block mt-5 bg-orange-600 hover:bg-orange-700 p-3 transition-colors cursor-pointer uppercase font-bold text-white rounded-lg formulario__firma--clear">
                                    <span>Limpiar</span>
                                </div>
                            </div>
                            <input type="hidden"
                                id="signature-pad{{($planta->id == 1) ? '12' : (($planta->id == 2) ? '20' : '39') }}-input"
                                name="jefemanto_firma">
                        </div>

                        <div class="formulario__firma flex justify-center items-center flex-col">
                            <canvas
                                id="signature-pad{{($planta->id == 1) ? '13' : (($planta->id == 2) ? '21' : '40') }}"
                                width="350" height="175"
                                class=" bg-gray-50 mt-10 rounded-xl border border-black"></canvas>

                            <div class="clear_btn flex justify-center items-center flex-col">
                                <h4 class="formulario__texto">Supervisor de calidad</h4>
                                <div id="clear-button{{($planta->id == 1) ? '13' : (($planta->id == 2) ? '21' : '40') }}"
                                    class="inline-block mt-5 bg-orange-600 hover:bg-orange-700 p-3 transition-colors cursor-pointer uppercase font-bold text-white rounded-lg formulario__firma--clear">
                                    <span>Limpiar</span>
                                </div>
                            </div>
                            <input type="hidden"
                                id="signature-pad{{($planta->id == 1) ? '13' : (($planta->id == 2) ? '21' : '40') }}-input"
                                name="supervisor_firma">
                        </div>
                    </div>
                    <div class="w-full mt-10">
                        <label for="observaciones">Observaciones Generales: </label>
                        <input autocomplete="off" type="text" class="p-2 border border-black mt-5 w-full"
                            name="observaciones" id="observaciones">
                    </div>
                    <input type="submit" value="Guardar"
                        class="inline-block mt-5 bg-orange-600 hover:bg-orange-700 p-3 transition-colors cursor-pointer uppercase font-bold text-white rounded-lg formulario__firma--clear">

                </fieldset>


            </div>

        </div>

    </div>


    <input type="hidden" value="{{ auth()->user()->name }}" id="user">

</form>

@endsection