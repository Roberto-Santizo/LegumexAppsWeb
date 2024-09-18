@extends('layouts.mantenimiento')

@section('titulo')
Formulario para documento Lavado y desinfección
@endsection

@section('contenido')

<x-link route="documentold" text="Volver" icon="fa-solid fa-arrow-left" />

<div class="bg-white p-6 rounded-lg shadow-lg mt-10 md:mt-0 container xl:w-2/3  mx-auto">
    <x-alertas />
    <form action="{{ route('documentold.store') }}" method="POST" id="formulario1" novalidate>
        @csrf

        <x-alertas />

        <x-input disabled type="text" name="tecnico_mantenimiento" label="Técnico mantenimiento"
            value="{{ auth()->user()->name }}" placeholder="Nombre Completo del Usuario" />
        <x-input type="hidden" name="tecnico_mantenimiento" value="{{ auth()->user()->name }}" />

        <x-input disabled type="text" name="fecha" label="Fecha" value="{{ now()->format('d-m-Y') }}" />
        <x-input type="hidden" name="fecha" value="{{ now()->format('d-m-Y') }}" />

        <x-select name="planta_id" label="Seleccione una Planta" :options="$plantas" id="planta" />

        <x-select name="area_id" label="Seleccione un Área" id="area" />


        <fieldset>
            <legend class="text-sm md:text-2xl font-bold py-5 md:text-center">Herramientas que se estan ingresando
            </legend>

            <table class="md:w-1/2 lg:w-full mb-5">
                <thead class="bg-sky-600">
                    <tr>
                        <th scope="col" class="text-white text-sm md:text-xl p-2">Herramienta</th>
                        <th scope="col" class="text-white text-sm md:text-xl p-2">Lavada(SI/NO)</th>
                        <th scope="col" class="text-white text-sm md:text-xl p-2">Desinfectada(SI/NO)</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($herramientas as $herramienta)
                    <tr class="odd:bg-orange-200 odd:text-white">
                        <td class="text-sm md:text-xl font-bold p-2">
                            {{ $herramienta->herramienta }}
                        </td>
                        <td class="text-center">
                            <input class="h-6 w-6 mt-2 lavadas" type="checkbox" name="herramientas[lavadas][si][]"
                                value="{{ $herramienta->id }}">
                            <input class="h-6 w-6 mt-2 lavadas" type="checkbox" name="herramientas[lavadas][no][]"
                                value="{{ $herramienta->id }}">
                        </td>

                        <td class="text-center">
                            <input class="h-6 w-6 mt-2 desinfectadas" type="checkbox"
                                name="herramientas[desinfectadas][si][]" value="{{ $herramienta->id }}">
                            <input class="h-6 w-6 mt-2 desinfectadas" type="checkbox"
                                name="herramientas[desinfectadas][no][]" value="{{ $herramienta->id }}">
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </fieldset>

        <fieldset class="mt-5">
            <legend class="font-bold text-2xl text-center">Inspección de calidad</legend>

            @php
                $options = ['1' => "BUENO", '2' => "MALO"]
            @endphp

            <x-select name="entrada" label="Entrada de Herramientas" :options="$options" id="entrada" />

            <x-input type="text" name="observaciones_entrada" label="Observaciones de Entrada" placeholder="Observación de entrada de Herramientas" />


            <div class="flex flex-col items-center 2xl:flex-row justify-center gap-2 text-center">
                <div>
                    <canvas id="signature-pad-2" class="border border-black w-full lg:w-96"></canvas>
                    <div class="clear_btn">
                        <h4 class="text-xl font-bold">Firma Inspector de calidad</h4>
                        <div id="clear-button-2"
                            class="btn">
                            <span>Limpiar</span>
                        </div>
                    </div>
                </div>
            </div>

        </fieldset>

        <x-input type="text" name="observaciones" label="Observaciones Generales" placeholder="Observación Generales" />

        <div class="flex flex-col items-center 2xl:flex-row justify-center gap-2 text-center">
            <div>
                <canvas id="signature-pad" class="border border-black w-full lg:w-96"></canvas>
                <div class="clear_btn">
                    <h4 class="text-xl font-bold">Firma Técnico de mantenimiento</h4>
                    <div id="clear-button"
                        class="btn">
                        <span>Limpiar</span>
                    </div>
                </div>
            </div>

            <div>
                <canvas id="signature-pad-3" class="border border-black w-full lg:w-96"></canvas>

                <div>
                    <h4 class="text-xl font-bold">Firma Asistente de mantenimiento</h4>
                    <div id="clear-button-3"
                        class="btn">
                        <span>Limpiar</span>
                    </div>
                </div>
            </div>
        </div>

        <input id="firma1" name="tecnico_firma" type="hidden" value="">
        <input id="firma2" name="asistente_firma" type="hidden" value="">
        <input id="firma3" name="firma_entrada" type="hidden" value="">

        <div class="flex justify-end mt-20">
            <input type="submit" value="Guardar Borrador"
                class=" btn">
        </div>
    </form>
</div>
@endsection