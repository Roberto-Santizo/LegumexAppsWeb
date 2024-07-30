@extends('layouts.administracion')


@section('titulo')
Crear orden de trabajo
@endsection


@section('contenido')
<a href="{{ route('documentoOT') }}"
    class=" bg-orange-500 cursor-pointer hover:bg-orange-700 text-white font-bold py-2 px-4 rounded inline-block mt-5 mb-5 ">
    <i class="fa-solid fa-arrow-left"></i>
    Volver
</a>

<div class="w-full flex md:justify-center items-center">
    <form method="POST" action="{{ route('documentoOT.store') }}" id="formulario5" class="w-2/3">
        @csrf
        <fieldset class="p-5 mb-10 shadow-2xl">
            <legend class="text-xl font-bold uppercase">Datos generales de la Orden</legend>

            <div class="mb-5">
                <label for="planta_id" class="mb-2 block uppercase text-gray-500 font-bold">Elija una planta</label>
                <select name="planta_id" id="planta_id" class="w-full p-4 rounded bg-gray-50">
                    <option value class="opcion-default" selected disabled>---SELECCIONE UNA OPCIÓN---</option>
                    @foreach ($plantas as $planta)
                    <option value="{{ $planta->id }}">{{ $planta->planta }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-5">
                <label for="area_id" class="mb-2 block uppercase text-gray-500 font-bold">Elija una area</label>
                <select name="area_id" id="area_id" class="w-full p-4 rounded bg-gray-50">
                    <option value class="opcion-default" selected disabled>---SELECCIONE UNA OPCIÓN---</option>

                </select>
            </div>

            <div class="mb-5 hidden especifique">
                <label for="especifique" class="mb-2 block uppercase text-gray-500 font-bold">Especifique</label>
                <input type="text" id="especifique" name="especifique"
                    class="border p-3 w-full rounded-lg @error('especifique') border-red-500 @enderror"
                    placeholder="Especifique el área" autocomplete="off" value="{{ old('especifique') }}">
            </div>

            <div class="mb-5 hidden equipo_problema">
                <label for="equipo_problema" class="mb-2 block uppercase text-gray-500 font-bold">Equipo con
                    problema</label>
                <input type="text" id="equipo_problema" name="equipo_problema"
                    class="border p-3 w-full rounded-lg @error('equipo_problema') border-red-500 @enderror"
                    placeholder="Ingrese el equipo con problema" autocomplete="off"
                    value="{{ old('equipo_problema') }}">
            </div>

            <div class="mb-5 elemento_id">
                <label for="elemento_id" class="mb-2 block uppercase text-gray-500 font-bold">Elija una
                    ubicación</label>
                <select name="elemento_id" id="elemento_id" class="w-full p-4 rounded bg-gray-50">
                    <option value class="opcion-default" selected disabled>---SELECCIONE UNA OPCIÓN---</option>

                </select>
            </div>


            <div class="mb-5">
                <label for="retiro_equipo" class="mb-2 block uppercase text-gray-500 font-bold">¿Es necesario retirar el
                    equipo?</label>
                <select name="retiro_equipo" id="retiro_equipo" class="w-full p-4 rounded bg-gray-50">
                    <option value="" class="opcion-default" selected disabled>---SELECCIONE UNA OPCIÓN---</option>
                    <option value="1">SI</option>
                    <option value="2">NO</option>
                </select>
            </div>

            <div class="mb-5 flex flex-col gap-2">
                <label for="problema_detectado"
                    class="inline-block uppercase text-gray-500 font-bold">Antecedentes/Problema detectado:</label>
                <textarea id="problema_detectado" name="problema_detectado" rows="4" cols="50"
                    class="border"></textarea>
            </div>

            <div class="mb-5">
                <label for="urgencia" class="mb-2 block uppercase text-gray-500 font-bold">Urgencia del Trabajo:</label>
                <select name="urgencia" id="urgencia" class="w-full p-4 rounded bg-red-50">
                    <option value="" class="opcion-defaul" selected disabled>---SELECCIONE UNA OPCIÓN---</option>
                    <option value="1" class="bg-red-500 text-white">URGENTE</option>
                    <option value="2" class="bg-yellow-500 text-white">MEDIA</option>
                    <option value="3" class="bg-green-500 text-white">BAJA</option>
                </select>
            </div>

            <div class="mb-5 flex gap-2 items-center">
                <label for="fecha_propuesta" class="inline-block uppercase text-gray-500 font-bold">Fecha propuesta de
                    entrega:</label>
                <input type="date" name="fecha_propuesta" id="fecha_propuesta" min="{{ now()->format('Y-m-d') }}">
            </div>


        </fieldset>
        
        <fieldset class="p-5 mb-10 shadow-2xl">
            <legend class="text-xl font-bold uppercase">Datos del jefe de área</legend>
            <div class="mt-5">
                <label for="nombre_jefearea" class="mb-2 block uppercase text-gray-500 font-bold">Nombre del jefe de
                    Área:</label>
                <input autocomplete="off" type="text" id="nombre_jefearea" name="nombre_jefearea"
                    placeholder="Nombre del jefe de área" class="border p-3 w-full rounded-lg">
            </div>
            <div class="flex justify-center items-center flex-col">
                <canvas id="signature-pad-2" width="375" height="200"
                    class="bg-gray-50 mt-10 rounded-xl border border-black"></canvas>
                <div class="clear_btn flex justify-center items-center flex-col mt-3">
                    <h4 class="font-bold uppercase">Firma del jefe de área</h4>
                    <div id="clear-button-2"
                        class="inline-block mt-2 bg-orange-600 hover:bg-orange-700 p-3 transition-colors cursor-pointer uppercase font-bold text-white rounded-lg formulario__firma--clear">
                        <span>Limpiar</span></div>
                </div>
            </div>
        </fieldset>
        <fieldset class="p-5 mb-2 shadow-2xl">
            <legend class="text-xl font-bold uppercase">Datos del solicitante</legend>
            <div class="flex justify-center items-center flex-col">
                <canvas id="signature-pad" width="375" height="200"
                    class="bg-gray-50 mt-10 rounded-xl border border-black"></canvas>
                <div class="clear_btn flex justify-center items-center flex-col mt-3">
                    <h4 class="font-bold uppercase">Firma del solicitante</h4>
                    <div id="clear-button"
                        class="inline-block mt-5 bg-orange-600 hover:bg-orange-700 p-3 transition-colors cursor-pointer uppercase font-bold text-white rounded-lg formulario__firma--clear">
                        <span>Limpiar</span></div>
                </div>
            </div>
        </fieldset>
        <input type="hidden" value="" id="firma" name="firma_solicitante">
        <input type="hidden" value="" id="firma2" name="firma_jefearea">
        <input id="btnSaveOT" type="submit" value="Guardar"
            class="inline-block mt-5 bg-blue-600 hover:bg-blue-700 p-3 transition-colors cursor-pointer uppercase font-bold text-white rounded-lg">
    </form>
</div>
@endsection