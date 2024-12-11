<div>
    <div class="flex fixed inset-0 z-50 items-center justify-center bg-gray-500 bg-opacity-50 text-sm md:text-base">
        <div class="h-auto md:w-1/3 w-2/3 flex flex-col gap-5 bg-white rounded shadow-xl p-5">
            <div class="flex justify-between items-center">
                <h2 class="p-2 font-bold text-xl uppercase">Insumo: {{ $insumo['insumo'] }} - <span class="text-green-500 font-bold ">{{ $insumo['medida'] }}</span></h2>
                <button wire:click='closeModal' type="button">
                    <iconify-icon icon="typcn:delete" class="text-3xl hover:text-red-600 cursor-pointer"></iconify-icon>
                </button>
            </div>
           
            <div class="space-y-5 overflow-y-auto">
                <form wire:submit.prevent='handleSubmit'>
                    @error('error')
                        <livewire:mostrar-alerta :message="$message" />
                    @enderror
                    <div class="flex flex-col gap-2 sticky top-0">
                        <label for="cantidad" class="text-sm font-medium">Cantidad del insumo:</label>
                        <input wire:model='cantidad' autocomplete="off" class="border border-black p-2 rounded w-full" type="number" id="cantidad_insumo" placeholder="Cantidad de insumo segun la unidad de medida...">
                        @error('cantidad_insumo')
                            <livewire:mostrar-alerta :message="$message" />
                        @enderror
                    </div>
                    <input type="submit" class="btn bg-green-moss hover:bg-green-meadow mt-10" value="Agregar Insumo">
                </form>
            </div>
        </div>
    </div>
</div>
