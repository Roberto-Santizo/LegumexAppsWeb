@extends('layouts.administracion')


@section('titulo')
Crear orden de trabajo
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
@endpush

@section('contenido')

<x-link route="documentoOT" text="Volver" icon="fa-solid fa-arrow-left" />

<div class=" w-1/3 md:w-full flex md:justify-center items-center">
    <form method="POST" action="{{ route('documentoOT.store') }}" id="formulario5" class="w-2/3">
        @csrf
        <fieldset class="p-5 mb-10 shadow-2xl">
            <legend class="text-xl font-bold uppercase">Datos generales de la Orden</legend>

            <x-select name="planta_id" label="Seleccione una Planta" :options="$plantas"  id="planta_id"/>
            
            <x-select name="area_id" label="Seleccione un Área" id="area_id"/>

            <div class="mb-5 hidden especifique">
                <x-input type="text" name="especifique" label="Especifique" placeholder="Especifique el Área" />
            </div>

            <div class="mb-5 hidden equipo_problema">
                <x-input type="text" name="equipo_problema" label="Equipo con Problema" placeholder="Especifique el Equipo con Problema" />
            </div>

           <div class="elemento_id">
                <x-select name="elemento_id" label="Seleccione una Ubicación" id="elemento_id"/>
           </div>
        
           @php
               $options = ['1' => 'SI', '2' => 'NO'];
               $urgenciasOptions = ['1' => 'URGENTE', '2' => 'MEDIA', '3' => 'BAJA'];
           @endphp
           
           <x-select name="retiro_equipo" label="¿Es necesario Retirar el Equipo?" :options="$options" id="retiro_equipo"/>

            <div class="mb-5 flex flex-col gap-2">
                <label for="problema_detectado"
                    class="inline-block uppercase text-gray-500 font-bold">Antecedentes/Problema detectado:</label>
                <textarea id="problema_detectado" name="problema_detectado" rows="4" cols="50" class="border"></textarea>
            </div>


            <x-select name="urgencia" label="Urgencia del Trabajo" :options="$urgenciasOptions" id="urgencia"/>

            <x-input type="date" name="fecha_propuesta" label="Fecha propuesta de entrega" min="{{ now()->format('Y-m-d') }}"/>

        </fieldset>

        <fieldset class="p-5 mb-10 shadow-2xl w-96 md:w-full">
            <legend class="text-xl font-bold uppercase">Captura de Imágenes</legend>

            <div class="w-full">
                <h1 class="font-bold text-2xl mb-5 text-center">Imagenes Capturadas: </h1>
                <div class="flex justify-center items-center flex-wrap gap-2" id="results">
                </div>
            </div>

            <div id="camera">
                <div class="my-5" id="camera_fieldset">
                    <div class="flex flex-col justify-center items-center">
                        <div id="my_camera"></div>
                        <div id="takesnapshot"
                            class="btn">
                            <i class="fa-solid fa-camera"></i>
                            Tomar Foto
                        </div>

                        <div class="mt-5" id="cameraOptionsContainer">
                            <label for="cameraOptions" class="label-input">Seleccione una camara: </label>
                            <select name="cameraOptions" id="cameraOptions" class="w-full p-4 rounded bg-gray-50">
                            </select>
                        </div>
                        
                        <p class="text-xs mt-5">(Tome el menor número de fotos posibles)</p>
                    </div>

                    <div class="btn"
                        id="upload_button">
                        <p>Guardar Fotos</p>
                        <x-loading-icon />
                    </div>
                </div>
                <input type="hidden" id="folder_url" name="folder_url">
                <input type="hidden" id="folder_id" name="folder_id">
        </fieldset>

        <fieldset class="p-5 mb-10 shadow-2xl">
            <legend class="text-xl font-bold uppercase">Datos del Supervisor de área</legend>

            <x-select name="supervisor_id" :options="$supervisores" id="supervisor_id" label="Nombre del Supervisor de Área" buscador="true"/>

            <div class="flex justify-center items-center flex-col">
                <canvas id="signature-pad-2" width="350" height="200"
                    class="bg-gray-50 mt-10 rounded-xl border border-black"></canvas>
                <div class="clear_btn flex justify-center items-center flex-col mt-3">
                    <h4 class="font-bold uppercase">Firma del jefe de área</h4>
                    <div id="clear-button-2"
                        class="inline-block mt-2 bg-orange-600 hover:bg-orange-700 p-3 transition-colors cursor-pointer uppercase font-bold text-white rounded-lg formulario__firma--clear">
                        <span>Limpiar</span>
                    </div>
                </div>
            </div>
        </fieldset>
        <fieldset class="p-5 mb-2 shadow-2xl">
            <legend class="text-xl font-bold uppercase">Datos del solicitante</legend>
            <div class="flex justify-center items-center flex-col">
                <canvas id="signature-pad" width="350" height="200"
                    class="bg-gray-50 mt-10 rounded-xl border border-black"></canvas>
                <div class="clear_btn flex justify-center items-center flex-col mt-3">
                    <h4 class="font-bold uppercase">Firma del solicitante</h4>
                    <div id="clear-button"
                        class="inline-block mt-5 bg-orange-600 hover:bg-orange-700 p-3 transition-colors cursor-pointer uppercase font-bold text-white rounded-lg formulario__firma--clear">
                        <span>Limpiar</span>
                    </div>
                </div>
            </div>
        </fieldset>
        <input type="hidden" value="" id="firma" name="firma_solicitante">
        <input type="hidden" value="" id="firma2" name="firma_supervisor">
        <input id="btnSaveOT" type="submit" value="Guardar" class="btn">
    </form>
</div>
@endsection