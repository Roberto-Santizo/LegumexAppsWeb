@extends('layouts.auth')

@section('titulo')
    Documento Checklist Preoperacional - {{ $planta->name }}
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
@endpush


@section('contenido')
    <x-alertas />

    <x-link route="documentocp.select" text="Volver" icon="fa-solid fa-arrow-left"
        class=" btn bg-orange-600 hover:bg-orange-800" />

    <form id="formularioCP" class="mt-5 w-full" action="{{ route('documentocp.store', $planta) }}" method="POST">
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
                        data-target="#step{{ $area->id }}-content">
                        <button type="button" class="step-trigger" role="tab"
                            aria-controls="step{{ $area->id }}-content">
                            <span class="bs-stepper-label text-sm font-medium ">{{ $area->area }}</span>
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
                            <p class="text-2xl">Planta: <span class="font-bold">{{ $planta->name }}</span></p>
                        </div>
                        <div class="formulario__campo">
                            <p class="text-2xl">Fecha: <span class="font-bold">{{ now()->format('d-m-Y') }}</span></p>
                        </div>
                    </fieldset>
                </div>
                @php
                    $count = 1;
                @endphp
                @foreach ($planta->areas as $area)
                    <div id="step{{ $area->id }}-content" class="content w-full" role="tabpanel"
                        aria-labelledby="step{{ $area->area }}-content">
                        <table class="w-full divide-y divide-gray-200 shadow-xl  overflow-y-scroll">
                            <thead class="bg-blue-300">
                                <tr class="text-white">
                                    <th scope="col" class="p-5 text-sm font-bold uppercase text-left rtl:text-right">
                                        UBICACIÓN</th>
                                    <th scope="col" class="p-5 text-sm font-bold uppercase text-left rtl:text-right">OK
                                    </th>
                                    <th scope="col" class="p-5 text-sm font-bold uppercase text-left rtl:text-right">
                                        PROBLEMA</th>
                                    <th scope="col" class="p-5 text-sm font-bold uppercase text-left rtl:text-right">
                                        ACCIÓN TOMADA</th>
                                    <th scope="col" class="p-5 text-sm font-bold uppercase text-left rtl:text-right">
                                        RESPONSABLE</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-200 font-bold">
                                @foreach ($area->elementos as $elemento)
                                    <tr class="odd:bg-sky-200">
                                        <td class=" p-2 table__td">
                                            {{ $elemento->elemento }}
                                        </td>
                                        <td class="p-2">
                                            <input data-id="{{ $elemento->id }}"
                                                name="areas[{{ $area->id }}][ok][{{ $elemento->id }}]"
                                                class="w-7 h-7 checkbox-{{ $area->id }} table__check" checked
                                                type="checkbox">
                                        </td>

                                        <td class="p-2">
                                            <input data-id="{{ $elemento->id }}"
                                                name="areas[{{ $area->id }}][problema][{{ $elemento->id }}]"
                                                class="problem-{{ $elemento->id }} border border-sky-400 input-text"
                                                disabled type="text">
                                        </td>
                                        <td class="p-2">
                                            <input data-id="{{ $elemento->id }}"
                                                name="areas[{{ $area->id }}][accion][{{ $elemento->id }}]"
                                                class="action-{{ $elemento->id }}  border border-sky-400 input-text"
                                                disabled type="text">
                                        </td>
                                        <td class="p-2">
                                            <div data-area="{{ $area->id }}" data-elemento="{{ $elemento->id }}"
                                                data-planta="{{ $planta->id }}"
                                                class="text-center hidden cursor-pointer bg-blue-500 hover:bg-blue-600 p-2 text-white font-black rounded responsable-{{ $elemento->id }} create-ot">
                                                Crear OT
                                                <input id="responsable-{{ $elemento->id }}" type="hidden"
                                                    name="areas[{{ $area->id }}][orden_trabajos_id][{{ $elemento->id }}]"
                                                    data-id="{{ $elemento->id }}">
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="formulario__firma flex justify-center items-center flex-col">
                            <canvas id="signature-pad{{ $count }}"
                                class="formulario__firma-canva formulario__firma-canva--checklist bg-gray-50 mt-10 rounded-xl border border-black"
                                width="450" height="250"></canvas>
                            <div class="clear_btn flex flex-col justify-center items-center">
                                <h4 class="formulario__texto text-xl">Firma Inspector de Calidad</h4>
                                <div id="clear-button{{ $count }}"
                                    class="formulario__firma--clear inline-block mt-5 btn bg-orange-600 hover:bg-orange-800">
                                    <span>Limpiar</span>
                                </div>
                            </div>
                            <input type="hidden" id="signature-pad{{ $count }}-input"
                                name="areas[{{ $area->id }}][firma]">
                        </div>
                    </div>
                    @php
                        $count += 1;
                    @endphp
                @endforeach

                <div id="stepPiePagina-content" class="content" role="tabpanel" aria-labelledby="stepPiePagina-content">
                    <fieldset class="formulario__fieldset flex flex-col">
                        <div class="formulario__firmas flex justify-center items-center gap-2">
                            <div class="formulario__firma flex justify-center items-center flex-col">
                                <canvas id="signature-pad{{ $count }}"
                                    class="formulario__firma-canva  bg-gray-50 mt-10 rounded-xl border border-black"
                                    width="325" height="175"></canvas>
                                <div class="clear_btn flex justify-center items-center flex-col">
                                    <h4 class="formulario__texto">Verificado Por</h4>
                                    <div id="clear-button{{ $count }}"
                                        class=" btn formulario__firma--clear bg-orange-600 hover:bg-orange-800">
                                        <span>Limpiar</span>
                                    </div>

                                </div>
                                <input type="hidden" id="signature-pad{{ $count }}-input"
                                    name="verificado_firma">
                            </div>

                            <div class="formulario__firma flex justify-center items-center flex-col">
                                <canvas id="signature-pad{{ $count + 1 }}"
                                    class="formulario__firma-canva  bg-gray-50 mt-10 rounded-xl border border-black"
                                    width="325" height="175"></canvas>

                                <div class="clear_btn flex justify-center items-center flex-col">
                                    <h4 class="formulario__texto">Jefe de Mantenimiento</h4>
                                    <div id="clear-button{{ $count + 1 }}"
                                        class=" btn formulario__firma--clear bg-orange-600 hover:bg-orange-800">
                                        <span>Limpiar</span>
                                    </div>
                                </div>
                                <input type="hidden" id="signature-pad{{ $count + 1 }}-input"
                                    name="jefemanto_firma">
                            </div>

                            <div class="formulario__firma flex justify-center items-center flex-col">
                                <canvas id="signature-pad{{ $count + 2 }}" width="325" height="175"
                                    class=" bg-gray-50 mt-10 rounded-xl border border-black"></canvas>

                                <div class="clear_btn flex justify-center items-center flex-col">
                                    <h4 class="formulario__texto">Supervisor de calidad</h4>
                                    <div id="clear-button{{ $count + 2 }}"
                                        class="btn formulario__firma--clear bg-orange-600 hover:bg-orange-800">
                                        <span>Limpiar</span>
                                    </div>
                                </div>
                                <input type="hidden" id="signature-pad{{ $count + 2 }}-input"
                                    name="supervisor_firma">
                            </div>
                        </div>

                        <x-input type="text" name="observaciones" label="Observaciones Generales"
                            placeholder="Observación Generales" />

                        <input type="submit" value="Guardar"
                            class="btn formulario__firma--clear bg-orange-600 hover:bg-orange-800">

                    </fieldset>


                </div>

            </div>

        </div>

        <input type="hidden" value="{{ auth()->user()->name }}" id="user">
        <input type="hidden" value="{{ $planta->areas->count() + 4 }}" id="total_firmas">

    </form>
@endsection
