    <div class="flex fixed inset-0 z-50 items-center justify-center bg-gray-500 bg-opacity-75">
        <div class="h-2/3 md:w-1/3 w-4/5 flex flex-col gap-5 bg-white p-2 rounded shadow-xl">
            <div class="flex justify-between items-center">
                <h2 class="p-2 font-bold text-xl uppercase">Recuento de Uso de Insumos</h2>
                <button wire:click='closeModal' type="button">
                    <iconify-icon icon="typcn:delete" class="text-3xl hover:text-red-600 cursor-pointer"></iconify-icon>
                </button>
            </div>
            <div class="p-5 space-y-10 overflow-y-auto">
                @if ($errors->has('error'))
                    <div
                        class="border border-red-500 bg-red-100 text-red-700 font-bold uppercase p-2 mt-2 text-sm flex flex-row gap-2 items-center mr-10 mb-5">
                        {{ $errors->first('error') }}
                    </div>
                @endif
                @foreach ($tarea->insumos as $insumo)
                    <div class="md:grid md:grid-cols-2 flex flex-col shadow-xl p-5 border border-gray-300 rounded">
                        <div class="flex flex-col justify-center items-center">
                            <p class="font-bold text-sm text-center">{{ $insumo->insumo->insumo }}</p>
                            <p class="font-bold text-green-600">{{ $insumo->insumo->medida }}</p>
                        </div>

                        @if (!$insumo->cantidad_usada)
                            <div class="flex flex-col">
                                <input wire:model.defer="registro.{{ $insumo->id }}" type="number"
                                    class="text-black p-2 rounded"
                                    placeholder="Cantidad usada en {{ $insumo->insumo->medida }}">
                                <button wire:click="registrarDato({{ $insumo->id }})"
                                    class="btn bg-green-moss mt-2 hover:bg-green-700">
                                    Guardar
                                </button>
                            </div>
                        @else
                            <div class="flex flex-col justify-center items-center">
                                <p class="font-bold">Cantidad usada:</p>
                                <p class="font-bold text-xl">{{ $insumo->cantidad_usada }} {{ $insumo->insumo->medida }}
                                </p>
                            </div>
                        @endif
                    </div>
                @endforeach
                <button wire:click='cerrarAsignacion' class="btn bg-green-moss mt-2 hover:bg-green-700 w-full">
                    Cerrar Asignación
                </button>
            </div>
        </div>
    </div>
