<div>
    <div class="flex fixed inset-0 z-50 items-center justify-center bg-gray-500 bg-opacity-75">
        <div class="h-2/3 w-1/3 flex flex-col gap-5 bg-white rounded shadow-xl p-5">
            <div class="flex justify-between items-center">
                <h2 class="p-2 font-bold text-xl uppercase">Recuento de Uso de Insumos</h2>
                <button wire:click='closeModal' type="button">
                    <iconify-icon icon="typcn:delete" class="text-3xl hover:text-red-600 cursor-pointer"></iconify-icon>
                </button>
            </div>
            <div class="flex flex-col gap-2 sticky top-0">
                <label for="nombre_insumo" class="text-sm font-medium">Nombre del insumo:</label>
                <input autocomplete="off" class="border border-black p-2 rounded w-full" type="text"
                    wire:model="nombre_insumo" id="nombre_insumo" placeholder="Coloque el nombre del insumo..."
                    wire:input='buscarInsumo'>
            </div>
            <div class="space-y-5 overflow-y-auto">

                @foreach ($insumos as $insumo)
                    <div class="p-2 border bg-gray-100 shadow rounded-lg hover:bg-gray-200 cursor-pointer"
                        wire:click='agregarInsumo({{ $insumo->id }})'>
                        {{ $insumo->insumo }}
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
