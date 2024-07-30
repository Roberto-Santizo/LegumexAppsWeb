<div>
    <fieldset class="flex gap-5 border p-5 mt-5">
        <legend class="text-xl font-bold">Control de calidad</legend>
        
        <div class="flex flex-col items-start">
            <div class="mb-5 flex justify-center items-center gap-5 bg-gray-50 p-5 rounded-lg">
                <label for="limpieza" class="font-bold text-start">Se devolvió equipo fijo limpio (SI APLICA): </label>
                <input type="checkbox" name="limpieza" id="limpieza" class="h-6 w-6 mt-2">
                @error('devolucion_equipo')
                    <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-5 flex justify-center items-center gap-5 bg-gray-50 p-5 rounded-lg">
                <label for="limpieza" class="font-bold text-start">Limpieza adecuada del equipo y área de trabajo: </label>
                <input type="checkbox" name="limpieza" id="limpieza" class="h-6 w-6 mt-2">
                @error('limpieza')
                    <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-5 flex justify-center items-center gap-5 bg-gray-50 p-5 rounded-lg">
                <label for="orden" class="font-bold text-start">Orden en área de trabajo</label>
                <input type="checkbox" name="orden" id="orden" class="h-6 w-6 mt-2">
                @error('orden')
                    <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-5 flex justify-center items-center gap-5 bg-gray-50 p-5 rounded-lg">
                <label for="liberacion" class="font-bold text-start">Liberación de trabajo</label>
                <input type="checkbox" name="liberacion" id="liberacion" class="h-6 w-6 mt-2">
                @error('liberacion')
                    <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div>
            <div class="mb-5 flex flex-col">
                <label for="nombre_calidad" class="font-bold text-start">Nombre: </label>
                <input autocomplete="off" type="text" name="nombre_calidad" id="nombre_calidad" class="border border-black p-2 rounded" placeholder="Nombre del técnico de control de calidad">
                @error('nombre_calidad')
                    <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-5 flex flex-col">
                <label for="fecha_inspeccion" class="font-bold text-start">Fecha de inspección: </label>
                <input type="date" name="fecha_inspeccion" id="fecha_inspeccion" class="border border-black p-2 rounded" min="{{ now()->format('Y-m-d')}}">
                @error('fecha_inspeccion')
                    <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <canvas id="signature-pad-4" class="border border-black w-full lg:w-96"></canvas>    
                <div class="flex flex-col items-center">
                    <h4 class="text-xl font-bold">Control de calidad</h4>
                    <div id="clear-button-4" class="inline-block mt-5 bg-orange-600 hover:bg-orange-700 p-3 transition-colors cursor-pointer uppercase font-bold text-white rounded-lg"><span>Limpiar</span></div>
                </div>
            </div> 
        </div>

  </fieldset>
</div>