<div {{ $attributes->merge(['class' => 'fixed inset-0 z-50 flex justify-end']) }}>
    <div class="w-80 md:w-full max-w-md h-full bg-white p-10 shadow-xl overflow-y-auto ">
        <div class="flex flex-row justify-between items-center mb-6">
            <h2 class="text-2xl font-bold">Filtros</h2>
            <i class="fa-solid fa-xmark icon-link" wire:click='closeModal()'></i>
        </div>

        <div class="space-y-6">
            <form wire:submit.prevent='buscarDatos()' class="flex flex-col gap-5">
        
                <div class="space-y-2">
                    <label for="finca" class="block text-sm font-medium">Fincas</label>
                    <select  wire:model="finca" class="w-full p-2 uppercase">
                        <option value="0">Todos</option>
                        @foreach ($fincas as $finca)
                            <option value="{{$finca->id}}">{{ $finca->finca }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="space-y-2">
                    <label for="semanaNueva" class="block text-sm font-medium">Semanas Disponibles</label>
                    <select  wire:model="semanaNueva" class="w-full p-2 uppercase">
                        <option value="0">Todos</option>
                        @foreach ($semanas as $semana)
                            <option value="{{$semana}}">Semana: {{ $semana }}</option>
                        @endforeach
                    </select>
                </div>
                <button class="btn bg-orange-600 hover:bg-orange-800" type="submit">Aplicar Filtros</button>

            <div class="flex justify-center items-center">
                <button class="btn bg-orange-600 hover:bg-orange-800" type="submit" wire:click='borrarFiltros()'>Borrar Filtros</button>
            </div>
        </div>
    </div>
</div>