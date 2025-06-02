<div {{ $attributes->merge(['class' => 'fixed inset-0 z-50 flex justify-end']) }}>
    <div class="w-80 md:w-full max-w-md h-full bg-white p-10 shadow-xl overflow-y-auto ">
        <div class="flex flex-row justify-between items-center mb-6">
            <h2 class="text-2xl font-bold">Filtros</h2>
            <i class="fa-solid fa-xmark icon-link" wire:click='openModalFilters()'></i>
        </div>

        <div class="space-y-6">
            <form wire:submit.prevent='mostrarDatos' class="flex flex-col gap-5">
    
                <div class="space-y-2">
                    <label for="nombre_solicitante" class="block text-sm font-medium">Nombre del Solicitante:</label>
                    <input autocomplete="off" wire:input='buscarDatos' wire:model="nombre_solicitante" type="text" id="nombre_solicitante" placeholder="Nombre del solicitante" class="w-full border rounded px-3 py-2" />
                </div>

                <div class="space-y-2">
                    <label for="area" class="block text-sm font-medium">Nombre del área:</label>
                    <input autocomplete="off" wire:input='buscarDatos' wire:model="area" type="text" id="area" placeholder="Nombre del área" class="w-full border rounded px-3 py-2" />
                </div>

                <div class="space-y-2">
                    <label for="codigo" class="block text-sm font-medium">Codigo de la orden:</label>
                    <input autocomplete="off" wire:input='buscarDatos' wire:model="codigo" type="text" id="codigo" placeholder="Código de correlativo de la orden" class="w-full border rounded px-3 py-2" />
                </div>

                 <div class="space-y-2">
                    <label for="mecanico" class="block text-sm font-medium">Mecanico asignado:</label>
                    <input autocomplete="off" wire:input='buscarDatos' wire:model="mecanico" type="text" id="mecanico" placeholder="Nombre del a persona que realizó la orden de trabajo" class="w-full border rounded px-3 py-2" />
                </div>


                <div class="space-y-2">
                    <label for="planta" class="block text-sm font-medium">Planta</label>
                    <select wire:change='buscarDatos' wire:model="planta" class="w-full p-2 uppercase">
                        <option value="">--Seleccione una planta--</option>
                        @foreach ($plantas as $planta)
                            <option value="{{$planta->id}}">{{ $planta->name }}</option>
                        @endforeach
                    </select>
                </div>
            </form>

            <div class="flex justify-center items-center">
                <button class="btn bg-orange-600 hover:bg-orange-800" type="submit" wire:click='borrarFiltros()'>Borrar Filtros</button>
            </div>
        </div>
    </div>
</div>