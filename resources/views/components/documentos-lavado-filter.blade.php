<div {{ $attributes->merge(['class' => 'fixed inset-0 z-50 flex justify-end']) }}>
    <div class="w-80 md:w-full max-w-md h-full bg-white p-10 shadow-xl overflow-y-auto ">
        <div class="flex flex-row justify-between items-center mb-6">
            <h2 class="text-2xl font-bold">Filtros</h2>
            <i class="fa-solid fa-xmark icon-link" wire:click='openModal()'></i>
        </div>

        <div class="space-y-6">
            <form wire:submit.prevent='mostrarDatos' class="flex flex-col gap-5">
                
                <div class="space-y-2">
                    <label for="tecnico" class="block text-sm font-medium">Técnico Mantenimiento</label>
                    <input wire:model="tecnico" type="text" id="tecnico" placeholder="Nombre del técnico" class="w-full border rounded px-3 py-2" autocomplete="off"/>
                </div>

                <div class="space-y-2">
                    <label for="area" class="block text-sm font-medium">Área</label>
                    <input wire:model="area" type="text" id="area" placeholder="Nombre del área" class="w-full border rounded px-3 py-2" autocomplete="off"/>
                </div>

                <div class="space-y-2">
                    <label for="fecha" class="block text-sm font-medium">Fecha:</label>
                    <input wire:model="fecha" type="date" id="fecha" class="w-full border rounded px-3 py-2" />
                </div>

                <div class="space-y-2">
                    <label for="planta" class="block text-sm font-medium">Planta</label>
                    <select  wire:model="planta" class="w-full p-2 uppercase">
                        <option value="0">--Seleccione una planta--</option>
                        @foreach ($plantas as $planta)
                            <option value="{{$planta->id}}">{{ $planta->name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <button class="btn bg-orange-600 hover:bg-orange-800" type="submit">Aplicar Filtros</button>
            </form>

            <div class="flex justify-center items-center">
                <button class="btn bg-orange-600 hover:bg-orange-800" type="submit" wire:click='borrarFiltros()'>Borrar Filtros</button>
            </div>
        </div>
    </div>
</div>