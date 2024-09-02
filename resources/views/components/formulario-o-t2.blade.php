<div>
    <fieldset class="flex flex-col gap-5 border p-5 justify-center items-center mt-5">
        <legend class="text-xl font-bold">Departamento de Mantenimiento</legend>
        <div class="flex gap-5">
            
            <div class="border p-3 shadow rounded">
                <div class="mb-5 flex flex-col">
                    <label for="jefemanto_nombre" class="font-bold text-start">Nombre: </label>
                    <input type="text" name="jefemanto_nombre" id="jefemanto_nombre" class="border border-black p-2 rounded" placeholder="Nombre del jefe de mantenimiento" disabled value="{{ auth()->user()->name }}">
                    <input type="hidden" name="jefemanto_nombre" value="{{ auth()->user()->name }}">
                    @error('jefemanto_nombre')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-5">
                    <label for="fecha_inspeccion" class="mb-2 block uppercase text-gray-500 font-bold">Fecha de inspección: </label>
                    <input
                        type="text" 
                        id="fecha_inspeccion"
                        name="fecha_inspeccion"
                        class="border p-3 w-full rounded-lg @error('fecha_inspeccion') border-red-500 @enderror"    
                        value="{{ now()->format('d-m-Y') }}"
                        disabled
                    >
        
                    <input type="hidden" name="fecha_inspeccion" value="{{ now()->format('d-m-Y') }}">                                
                                                
                    @error('fecha_inspeccion')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <canvas id="signature-pad-3" class="border border-black w-80"></canvas>    
                    <div class="flex flex-col items-center">
                        <h4 class="text-xl font-bold">Jefe de mantenimiento</h4>
                        <div id="clear-button-3" class="btn"><span>Limpiar</span></div>
                    </div>
                </div> 
            </div>
        </div>

        <input type="hidden" id="estado" name="estado_id" value="3">
        <input type="hidden" id="firma2" name="jefemanto_firma">

  </fieldset>
</div>