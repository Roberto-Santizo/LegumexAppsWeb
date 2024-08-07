@extends('layouts.administracion')


@section('titulo')
Editar documento
@endsection

@section('contenido')
<a href="{{ route('documentold') }}"
    class=" bg-orange-500 cursor-pointer hover:bg-orange-700 text-white font-bold py-2 px-4 rounded inline-block mt-5 mb-5 ">
    <i class="fa-solid fa-arrow-left"></i>
    Volver
</a>
<div class="bg-white p-6 rounded-lg shadow-lg mt-10 md:mt-0 container xl:w-2/3  mx-auto">
    <form action="{{ route('documentold.update',$documento) }}" method="POST" id="formulario2" novalidate>
        @csrf
        @method('PATCH')

        @if(session('mensaje'))
        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ session('mensaje') }}</p>
        @endif

        <div class="flex flex-col p-5 bg-gray-100 rounded-lg mb-10">
            <h1 class="text-2xl mb-5 font-bold text-center uppercase">Información del encabezado</h1>

            <div class="mb-5 bg-gray-200 p-5 rounded-lg">
                <p class="uppercase text-gray-500 font-bold">Técnico de Mantenimiento: <span class="text-black">{{
                        $documento->tecnico_mantenimiento }}</span></p>
            </div>
            <div class="mb-5 bg-gray-200 p-5 rounded-lg">
                <p class="uppercase text-gray-500 font-bold">Fecha de creación: <span class="text-black">{{
                        $documento->fecha }}</span></p>
            </div>

            <div class="mb-5 bg-gray-200 p-5 rounded-lg">
                <p class="uppercase text-gray-500 font-bold">Planta: <span class="text-black">{{
                        $documento->planta->planta }}</span></p>
            </div>

            <div class="mb-5 bg-gray-200 p-5 rounded-lg">
                <p class="uppercase text-gray-500 font-bold">Área: <span class="text-black">{{ $documento->area->area
                        }}</span></p>
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
            <div class="mb-5">
                <label for="salida" class="mb-2 block uppercase text-gray-500 font-bold">Salida de herramientas: </label>
                <select name="salida" id="salida" class="rounded bg-gray-50 w-full p-4 uppercase">
                    <option value="" selected disabled>---SELECCIONE UNA OPCIÓN---</option>
                    <option class="uppercase" value="1">Bueno</option>
                    <option class="uppercase" value="0">Malo</option>
                </select>
                @error('salida')
                    <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">Especifiqué el estado de la salida
                        de herramientas
                    <p>
                @enderror
            </div>
    
            <div class="mb-5">
                <label for="observaciones_salida" class="mb-2 block uppercase text-gray-500 font-bold">Observaciones de
                    salida: </label>
                <input type="text" id="observaciones_salida" name="observaciones_salida"
                    class="border p-3 w-full rounded-lg @error('observaciones_salida') border-red-500 @enderror"
                    placeholder="Observaciones de salida de herramientas" autocomplete="off"
                    value="{{ old('observaciones_salida') }}">
    
                @error('observaciones_salida')
                <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }}</p>
                @enderror
            </div>
            <div class="flex flex-col items-center 2xl:flex-row justify-center gap-2 text-center">
                <div>
                    <canvas id="signature-pad" class="border border-black w-full lg:w-96"></canvas>
                    <div class="clear_btn">
                        <h4 class="text-xl font-bold">Firma Inspector de calidad</h4>
                        <div id="clear-button"
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
                placeholder="Observaciones generales" autocomplete="off" value="{{ $documento->observaciones }}">

            @error('observaciones')
            <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }}</p>
            @enderror
        </div>
        <div class="flex flex-col items-center 2xl:flex-row justify-center gap-2 text-center">
            <div class="">
                <canvas id="signature-pad-2" class="border border-black w-full lg:w-96"></canvas>
                <div class="clear_btn">
                    <h4 class="text-xl font-bold">Firma Inspector de Calidad</h4>
                    <div id="clear-button-2"
                        class="inline-block mt-5 bg-orange-600 hover:bg-orange-700 p-3 transition-colors cursor-pointer uppercase font-bold text-white rounded-lg">
                        <span>Limpiar</span>
                    </div>
                </div>
            </div>
        </div>

        <input id="firma2" name="inspector_firma" type="hidden" value="">
        <input id="firma" name="firma_salida" type="hidden" value="">

        <div class="flex justify-end mt-20">
            <input type="submit" value="Guardar"
                class=" bg-sky-600 hover:bg-sky-700 p-3 transition-colors cursor-pointer uppercase font-bold text-white rounded-lg">
        </div>
    </form>
</div>
@endsection