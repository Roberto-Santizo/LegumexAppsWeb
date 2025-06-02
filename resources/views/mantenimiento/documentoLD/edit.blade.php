@extends('layouts.auth')


@section('titulo')
Editar documento
@endsection

@section('contenido')



<x-link route="documentold" text="Volver" icon="fa-solid fa-arrow-left" class=" btn bg-orange-600 hover:bg-orange-800"/>

<div class="bg-white p-6 rounded-lg shadow-lg mt-10 md:mt-0 container xl:w-2/3  mx-auto">
    <form action="{{ route('documentold.update',$documento) }}" method="POST" id="formulario2" novalidate>
        @csrf
        @method('PATCH')
        
        <x-alertas />

        <div class="flex flex-col p-5 bg-gray-100 rounded-lg mb-10">
            <h1 class="text-2xl mb-5 font-bold text-center uppercase">Información del encabezado</h1>

            <div class="mb-5 bg-gray-200 p-5 rounded-lg">
                <p class="uppercase text-gray-500 font-bold">Técnico de Mantenimiento: <span class="text-black">{{ $documento->tecnico_mantenimiento }}</span></p>
            </div>
            <div class="mb-5 bg-gray-200 p-5 rounded-lg">
                <p class="uppercase text-gray-500 font-bold">Fecha de creación: <span class="text-black">{{ $documento->fecha }}</span></p>
            </div>

            <div class="mb-5 bg-gray-200 p-5 rounded-lg">
                <p class="uppercase text-gray-500 font-bold">Planta: <span class="text-black">{{ $documento->planta->name }}</span></p>
            </div>

            <div class="mb-5 bg-gray-200 p-5 rounded-lg">
                <p class="uppercase text-gray-500 font-bold">Área: <span class="text-black">{{ $documento->area->area}}</span></p>
            </div>
        </div>

        <fieldset>
            <legend class="text-sm md:text-2xl font-bold py-5 md:text-center">Herramientas que se estan egresando
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
                    @foreach ($documento->herramientas->sortBy('herramienta_id') as $herramienta)
                    <tr class="odd:bg-orange-200 odd:text-white">
                        <td class="text-sm md:text-xl font-bold p-2">
                            {{ $herramienta->herramienta->herramienta }}
                        </td>
                        <td class="text-center">
                            <input class="h-6 w-6 mt-2 lavadas" type="checkbox" name="herramientas[lavadas][si][]"
                                value="{{ $herramienta->herramienta->id }}">
                            <input class="h-6 w-6 mt-2 lavadas" type="checkbox" name="herramientas[lavadas][no][]"
                                value="{{ $herramienta->herramienta->id }}">
                        </td>

                        <td class="text-center">
                            <input class="h-6 w-6 mt-2 desinfectadas" type="checkbox"
                                name="herramientas[desinfectadas][si][]" value="{{ $herramienta->herramienta->id }}">
                            <input class="h-6 w-6 mt-2 desinfectadas" type="checkbox"
                                name="herramientas[desinfectadas][no][]" value="{{ $herramienta->herramienta->id }}">
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </fieldset>

        <fieldset class="mt-5">
            <legend class="font-bold text-center text-2xl">Inspección de calidad</legend>
            @php
                $options = ['1' => "BUENO", '2' => "MALO"]
            @endphp

        <x-select name="salida" label="Salida de Herramientas" :options="$options" id="salida" />

        <x-input type="text" name="observaciones_salida" label="Observaciones de Salida" placeholder="Observación de Salida de Herramientas" />
        
        <div class="flex flex-col items-center 2xl:flex-row justify-center gap-2 text-center">
                <div>
                    <canvas id="signature-pad" class="border border-black w-full lg:w-96"></canvas>
                    <div class="clear_btn">
                        <h4 class="text-xl font-bold">Firma Inspector de calidad</h4>
                        <div id="clear-button"
                        class=" btn bg-orange-600 hover:bg-orange-800">
                            <span>Limpiar</span></div>
                    </div>
                </div>
            </div>
        </fieldset>

        <x-input type="text" name="observaciones" label="Observaciones Generales" placeholder="Observación Generales" value="{{ $documento->observaciones }}" />

        <div class="flex flex-col items-center 2xl:flex-row justify-center gap-2 text-center">
            <div class="">
                <canvas id="signature-pad-2" class="border border-black w-full lg:w-96"></canvas>
                <div class="clear_btn">
                    <h4 class="text-xl font-bold">Firma Inspector de Calidad</h4>
                    <div id="clear-button-2"
                    class=" btn bg-orange-600 hover:bg-orange-800">
                        <span>Limpiar</span>
                    </div>
                </div>
            </div>
        </div>

        <input id="firma2" name="inspector_firma" type="hidden" value="">
        <input id="firma" name="firma_salida" type="hidden" value="">

        <div class="flex justify-end mt-20">
            <input type="submit" value="Guardar"
            class=" btn bg-orange-600 hover:bg-orange-800">
        </div>
    </form>
</div>
@endsection