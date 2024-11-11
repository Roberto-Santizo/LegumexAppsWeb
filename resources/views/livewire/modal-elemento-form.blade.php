<div>  
    <div class="flex fixed inset-0 z-50 items-center justify-center bg-gray-500 bg-opacity-75">
        <div class="w-1/3 flex flex-col gap-5 bg-white p-2 rounded shadow-xl">
            <div class="flex justify-between items-center">
                <h2 class="p-2 font-bold text-xl uppercase">Formulario Nueva Área</h2>
                <button wire:click='closeModal' type="button">
                    <iconify-icon icon="typcn:delete" class="text-3xl hover:text-red-600 cursor-pointer"></iconify-icon>
                </button>
            </div>

            <div class="p-5">
                <form wire:submit.prevent='guardar'>
                    <div class="space-y-2">
                        <label for="ubicacion" class="block text-sm font-medium">Nombre de la Ubicación:</label>
                        <input autocomplete="off" wire:model="ubicacion" type="text" id="ubicacion" class="w-full border rounded px-3 py-2" placeholder="Nombre de la nueva ubicación"/>

                        @error('ubicacion')
                            <x-alerta-error :message="$message" />
                        @enderror
                    </div>
                    

                    <div class="mt-5 flex justify-end">
                        <input type="submit" class="btn bg-orange-600 hover:bg-orange-800" value="Guardar">
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
</div>