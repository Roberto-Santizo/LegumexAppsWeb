<div>
    <fieldset class="border border-black">
        <legend class="text-2xl font-bold">Departamento de mantenimiento</legend>
        <div class="flex gap-5 p-5">
            <div class="flex flex-col justify-center w-1/2">
                <div class="mb-5 flex flex-col ">
                    <label for="trabajo_realizado" class="font-bold">Trabajo realizado: </label>
                    <textarea class="border border-black" name="trabajo_realizado" id="trabajo_realizado" cols="30"
                        rows="5">{{ ($ot->trabajo_realizado) ? $ot->trabajo_realizado : '' }}</textarea>

                    @error('trabajo_realizado')
                    <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-5 flex flex-col">
                    <label for="repuestos_utilizados" class="font-bold">Repuestos utilizados: </label>
                    <textarea class="border border-black" name="repuestos_utilizados" id="repuestos_utilizados"
                        cols="30" rows="5">{{ ($ot->repuestos_utilizados) ? $ot->repuestos_utilizados : '' }}</textarea>

                    @error('repuestos_utilizados')
                    <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }}</p>
                    @enderror
                </div>


                <div class="flex gap-10">
                    <div class="mb-5 flex flex-col">
                        <label for="hora_inicio" class="font-bold text-start">Hora de inicio: </label>
                        <input type="time" name="hora_inicio" id="hora_inicio" class="border border-black p-2 rounded"
                            placeholder="Nombre del jefe de mantenimiento">
                        @error('hora_inicio')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-5 flex flex-col">
                        <label for="hora_final" class="font-bold text-start">Hora de final: </label>
                        <input type="time" name="hora_final" id="hora_final" class="border border-black p-2 rounded"
                            placeholder="Nombre del jefe de mantenimiento">
                        @error('hora_final')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class=" p-3 shadow-lg rounded">
                <div class="mb-5 flex flex-col">
                    <label for="nombre_mecanico" class="font-bold text-start">Nombre: </label>
                    <input type="text" name="nombre_mecanico" id="nombre_mecanico"
                        class="border border-black p-2 rounded" disabled placeholder="{{ $ot->usuario->name }}">
                    @error('nombre_mecanico')
                    <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-5 flex flex-col">
                    <label for="fecha_entrega" class="font-bold text-start">Fecha de entrega: </label>
                    <input type="text" name="fecha_entrega" disabled id="fecha_entrega"
                        class="border border-black p-2 rounded" value="{{now()->format('d-m-Y') }}">
                    @error('fecha_entrega')
                    <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }}</p>
                    @enderror
                    <input type="hidden" name="fecha_entrega" value="{{now()->format('d-m-Y') }}">
                </div>
                <div class="flex flex-col justify-center items-center">
                    <canvas id="signature-pad-2" class="border border-black w-full lg:w-96"></canvas>
                    <div class="clear_btn flex flex-col items-center">
                        <h4 class="text-xl font-bold">Mecánico Asignado</h4>
                        <div id="clear-button-2"
                            class="inline-block mt-5 bg-orange-600 hover:bg-orange-700 p-3 transition-colors cursor-pointer uppercase font-bold text-white rounded-lg">
                            <span>Limpiar</span></div>
                    </div>
                    <input type="hidden" id="firma" name="firma_mecanico">
                </div>
            </div>
        </div>

    </fieldset>

    <fieldset class="p-5 border border-black">
        <legend class="text-xl font-bold uppercase">Captura de Imágenes</legend>

        <div>
            <h1 class="font-bold text-2xl mb-5 text-center">Imagenes Capturadas: </h1>
            <div class="flex justify-center items-center flex-wrap gap-2" id="results">
            </div>
        </div>

        <div id="camera">
            <div class="my-5" id="camera_fieldset">
                <div class="flex flex-col justify-center items-center mb-5 ">
                    <div id="my_camera"></div>
                    <div id="takesnapshot"
                        class="text-white font-bold bg-orange-500 cursor-pointer hover:bg-orange-600 inline-block p-2 rounded my-5">
                        <i class="fa-solid fa-camera"></i>
                        Tomar Foto
                    </div>
                    <p class="text-xs">(Tome el menor número de fotos posibles)</p>
                </div>


                <div class="bg-orange-500 w-max text-white font-bold p-2 rounded uppercase hover:bg-orange-600 cursor-pointer mt-5 flex justify-center items-center gap-2"
                    id="upload_button">
                    <p>Guardar Fotos</p>
                    <x-loading-icon />
                </div>
            </div>
            <input type="hidden" id="folder_url" name="folder_url">
            <input type="hidden" id="folder_id" name="folder_id" value="{{ $ot->folder_id }}">
    </fieldset>


    <fieldset class="mt-5 border border-black flex justify-around">
        <legend class="text-2xl font-bold">Control de calidad</legend>

        <div class="text-start font-bold flex flex-col justify-center">

            <div class="flex items-center gap-5 justify-between">
                <label for="devolucion_equipo">SE DEVOLVIÓ EQUIPO FIJO LIMPIO (SI APLICA)</label>
                <input class="h-6 w-6 mt-2" type="checkbox" name="devolucion_equipo" value="1">
            </div>

            <div class="flex items-center gap-5 justify-between">
                <label for="limpieza_equipo">LIMPIEZA ADECUADA DEL EQUIPO</label>
                <input class="h-6 w-6 mt-2" type="checkbox" name="limpieza_equipo" value="1">
            </div>

            <div class="flex items-center gap-5 justify-between">
                <label for="orden_area">ORDEN EN ÁREA DE TRABAJO</label>
                <input class="h-6 w-6 mt-2" type="checkbox" name="orden_area" value="1">
            </div>

            <div class="flex items-center gap-5 justify-between">
                <label for="liberacion_trabajo">LIBERACIÓN DE TRABAJO</label>
                <input class="h-6 w-6 mt-2" type="checkbox" name="liberacion_trabajo" value="1">
            </div>

        </div>

        <div class=" p-3 shadow-lg rounded">
            <div class="mt-5">
                <label for="c_calidad_id" class="mb-2 block uppercase text-gray-500 font-bold">Nombre del Supervisor
                    de
                    Área:</label>
                <select name="c_calidad_id" id="c_calidad_id" class="w-full p-4 rounded select">
                    <option value="" class="opcion-defaul" selected disabled>---SELECCIONE UNA OPCIÓN---</option>
                    @foreach ($supervisores as $supervisor)
                    <option value="{{ $supervisor->id }}">{{ $supervisor->name . ' - ' . $supervisor->role->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-5 flex flex-col">
                <label for="fecha_inspeccion_calidad" class="font-bold text-start">Fecha de inspección: </label>
                <input type="text" disabled name="fecha_inspeccion_calidad" id="fecha_inspeccion_calidad"
                    class="border border-black p-2 rounded" value="{{ now()->format('d-m-Y') }}">
                @error('fecha_inspeccion_calidad')
                <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }}</p>
                @enderror
                <input type="hidden" name="fecha_inspeccion_calidad" value="{{now()->format('d-m-Y') }}">
            </div>
            <div class="flex flex-col justify-center items-center">
                <canvas id="signature-pad-3" class="border border-black w-full lg:w-96"></canvas>
                <div class="clear_btn flex flex-col items-center">
                    <h4 class="text-xl font-bold">Control de calidad</h4>
                    <div id="clear-button-3"
                        class="inline-block mt-5 bg-orange-600 hover:bg-orange-700 p-3 transition-colors cursor-pointer uppercase font-bold text-white rounded-lg">
                        <span>Limpiar</span></div>
                </div>
                <input type="hidden" id="firma2" name="firma_calidad">
            </div>
        </div>

    </fieldset>

    <input type="hidden" id="estado" name="estado_id" value="2">
</div>