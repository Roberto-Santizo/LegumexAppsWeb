@extends('layouts.administracion')

@section('titulo')
Formulario para documento Lavado y desinfección
@endsection

@section('contenido')
<a href="{{ route('documentold') }}"
    class=" bg-orange-500 cursor-pointer hover:bg-orange-700 text-white font-bold py-2 px-4 rounded inline-block mt-5 mb-5 ">
    <i class="fa-solid fa-arrow-left"></i>
    Volver
</a>
<div class="bg-white p-6 rounded-lg shadow-lg mt-10 md:mt-0 container xl:w-2/3  mx-auto">
    <form action="{{ route('documentold.store') }}" method="POST" id="formulario1" novalidate>
        @csrf

        <x-alertas />

        <div class="mb-5">
            <label for="tecnico_mantenimiento" class="mb-2 block uppercase text-gray-500 font-bold">Técnico
                mantenimiento: </label>
            <input type="text" id="tecnico_mantenimiento" name="tecnico_mantenimiento"
                class="border p-3 w-full rounded-lg @error('tecnico_mantenimiento') border-red-500 @enderror"
                value="{{ auth()->user()->name }}" disabled>
            <input type="hidden" name="tecnico_mantenimiento" value="{{ auth()->user()->name }}">

            @error('tecnico_mantenimiento')
            <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-5">
            <label for="fecha" class="mb-2 block uppercase text-gray-500 font-bold">Fecha: </label>
            <input type="text" id="fecha" name="fecha"
                class="border p-3 w-full rounded-lg @error('fecha') border-red-500 @enderror"
                value="{{ now()->format('d-m-Y') }}" disabled>

            <input type="hidden" name="fecha" value="{{ now()->format('d-m-Y') }}">

            @error('fecha')
            <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-5">
            <label for="planta_id" class="mb-2 block uppercase text-gray-500 font-bold ">Planta: </label>
            <select name="planta_id" id="planta" class="w-full p-4 rounded bg-gray-50">
                <option value="" class="opcion-default" selected disabled>---SELECCIONE UNA OPCIÓN---</option>
                @foreach ($plantas as $planta)
                <option class="uppercase" value="{{ $planta->id }}">{{ $planta->planta }}</option>
                @endforeach

            </select>
            @error('planta_id')
            <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">Seleccione un planta
            <p>
                @enderror
        </div>

        <div class="mb-5">
            <label for="area_id" class="mb-2 block uppercase text-gray-500 font-bold">Área: </label>
            <select name="area_id" id="area" class="rounded bg-gray-50 w-full p-4">
                <option value="" class="opcion-default" selected disabled>---SELECCIONE UNA OPCIÓN---</option>

            </select>
            @error('area_id')
            <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">Seleccione un área
            <p>
                @enderror
        </div>

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
            <div class="mb-5">
                <label for="entrada" class="mb-2 block uppercase text-gray-500 font-bold">Entrada de herramientas:
                </label>
                <select name="entrada" id="entrada" class="rounded bg-gray-50 w-full p-4 uppercase">
                    <option value="" selected disabled>---SELECCIONE UNA OPCIÓN---</option>
                    <option class="uppercase" value="1">Bueno</option>
                    <option class="uppercase" value="0">Malo</option>
                </select>
                @error('entrada')
                <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">Especifiqué el estado de la
                    entrada de herramientas
                <p>
                    @enderror
            </div>

            <div class="mb-5">
                <label for="observaciones_entrada" class="mb-2 block uppercase text-gray-500 font-bold">Observaciones de
                    entrada: </label>
                <input type="text" id="observaciones_entrada" name="observaciones_entrada"
                    class="border p-3 w-full rounded-lg @error('observaciones_entrada') border-red-500 @enderror"
                    placeholder="Observaciones de entrada de herramientas" autocomplete="off"
                    value="{{ old('observaciones_entrada') }}">

                @error('observaciones_entrada')
                <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }}</p>
                @enderror
            </div>
            <div class="flex flex-col items-center 2xl:flex-row justify-center gap-2 text-center">
                <div>
                    <canvas id="signature-pad-2" class="border border-black w-full lg:w-96"></canvas>
                    <div class="clear_btn">
                        <h4 class="text-xl font-bold">Firma Inspector de calidad</h4>
                        <div id="clear-button-2"
                            class="inline-block mt-5 bg-orange-600 hover:bg-orange-700 p-3 transition-colors cursor-pointer uppercase font-bold text-white rounded-lg">
                            <span>Limpiar</span></div>
                    </div>
                </div>
            </div>

        </fieldset>

        <div class="mb-5">
            <label for="observaciones" class="mb-2 block uppercase text-gray-500 font-bold">Observaciones Generales:
            </label>
            <input type="text" id="observaciones" name="observaciones"
                class="border p-3 w-full rounded-lg @error('observaciones') border-red-500 @enderror"
                placeholder="Observaciones generales" autocomplete="off" value="{{ old('observaciones') }}">

            @error('observaciones')
            <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex flex-col items-center 2xl:flex-row justify-center gap-2 text-center">
            <div>
                <canvas id="signature-pad" class="border border-black w-full lg:w-96"></canvas>
                <div class="clear_btn">
                    <h4 class="text-xl font-bold">Firma Técnico de mantenimiento</h4>
                    <div id="clear-button"
                        class="inline-block mt-5 bg-orange-600 hover:bg-orange-700 p-3 transition-colors cursor-pointer uppercase font-bold text-white rounded-lg">
                        <span>Limpiar</span></div>
                </div>
            </div>

            <div>
                <canvas id="signature-pad-3" class="border border-black w-full lg:w-96"></canvas>

                <div>
                    <h4 class="text-xl font-bold">Firma Asistente de mantenimiento</h4>
                    <div id="clear-button-3"
                        class="inline-block mt-5 bg-orange-600 hover:bg-orange-700 p-3 transition-colors cursor-pointer uppercase font-bold text-white rounded-lg">
                        <span>Limpiar</span></div>
                </div>
            </div>
        </div>

        <input id="firma1" name="tecnico_firma" type="hidden" value="">
        <input id="firma2" name="asistente_firma" type="hidden" value="">
        <input id="firma3" name="firma_entrada" type="hidden" value="">

        <div class="flex justify-end mt-20">
            <input type="submit" value="Guardar Borrador"
                class=" bg-sky-600 hover:bg-sky-700 p-3 transition-colors cursor-pointer uppercase font-bold text-white rounded-lg">
        </div>
    </form>
</div>
@endsection