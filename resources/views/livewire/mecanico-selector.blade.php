<div>
    <div class="flex fixed inset-0 z-40 items-center justify-center bg-gray-500 bg-opacity-75 md:text-base text-sm">
        <div class="h-2/3 md:w-1/3 w-2/3 flex flex-col gap-5 bg-white rounded shadow-xl p-5">
            <div class="flex justify-between items-center">
                <h2 class="p-2 font-bold md:text-xl text-sm uppercase">Mécanicos: </h2>
                <button wire:click='closeModal' type="button">
                    <iconify-icon icon="typcn:delete" class="text-3xl hover:text-red-600 cursor-pointer"></iconify-icon>
                </button>
            </div>
            <div class="flex flex-col gap-2 sticky top-0">
                <label for="nombre_usuario" class="text-sm font-medium">Nombre del insumo:</label>
                <input autocomplete="off" class="border border-black p-2 rounded w-full text-sm" type="text"
                    wire:model="nombre_usuario" id="nombre_usuario" placeholder="Coloque el nombre del usuario..."
                    wire:input='buscarUsuario'>
            </div>
            <div class="space-y-5 overflow-y-auto">
                    @foreach ($usuarios as $usuario)
                    <div wire:click='asignarMecanico({{ $usuario }})' class="p-2 border bg-gray-100 shadow rounded-lg hover:bg-gray-200 cursor-pointer">
                        {{ $usuario->name }}
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
