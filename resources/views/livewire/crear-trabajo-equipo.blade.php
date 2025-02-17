<div>
    <div class="flex fixed inset-0 z-40 items-center justify-center bg-gray-500 bg-opacity-75 md:text-base text-sm">
        <div class="h-2/3 md:w-1/3 w-2/3 flex flex-col gap-5 bg-white rounded shadow-xl p-5">
            <div class="flex justify-between items-center">
                <h2 class="p-2 font-bold md:text-xl text-sm uppercase">Crear Trabajo Equipo</h2>
                <button wire:click='closeModal' type="button">
                    <iconify-icon icon="typcn:delete" class="text-3xl hover:text-red-600 cursor-pointer"></iconify-icon>
                </button>
            </div>

            
            <form class="space-y-5"  wire:submit.prevent='createTrabajo'>
                <div class="space-y-2">
                    <label for="descripcion" class="font-bold text-xl">Descripción del trabajo:</label>
                    <input wire:model="descripcion" type="text" id="descripcion" class="w-full border rounded px-3 py-2" autocomplete="off" placeholder="Descripción del trabajo"/>
                    @error('descripcion')
                        <x-alerta-error :message="$message" />
                    @enderror
                </div>

                <div class="space-y-2">
                    <label for="fecha_planificacion" class="font-bold text-xl">Fecha de planificación:</label>
                    <input wire:model="fecha_planificacion" type="date" id="fecha_planificacion" class="w-full border rounded px-3 py-2" autocomplete="off"/>
                    @error('fecha_planificacion')
                        <x-alerta-error :message="$message" />
                    @enderror
                </div>
        
                <div class="btn bg-orange-600 hover:bg-orange-800 mt-10 w-full text-center">
                    <button class="flex justify-center items-center p-2 gap-2 w-full" type="submit">
                        <p class="uppercase text-center">Crear Trabajo</p>
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
