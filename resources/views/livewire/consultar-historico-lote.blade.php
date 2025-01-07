<div>
    <div class="my-5 flex justify-end gap-5">
        <select wire:model="lote_id" id="lote_id">
            <option value="">--SELECCIONE UN LOTE--</option>
            @foreach ($lotes as $lote)
                <option value="{{ $lote->id }}">{{ $lote->nombre }}</option>
            @endforeach
        </select>

        <select wire:model="periodo" id="periodo">
            <option value="">--SELECCIONE UN AÑO--</option>
            @foreach ($periodos as $periodo)
                <option value="{{ $periodo }}">{{ $periodo }}</option>
            @endforeach
        </select>

        <button wire:click="cargarDatos" class="btn bg-green-moss hover:bg-green-meadow">
            Buscar Datos
        </button>
    </div>

    <div wire:loading wire:target="cargarDatos">
        <div class="loader animate-spin border-t-2 border-blue-500 rounded-full w-24 h-24"></div>
    </div>

    <div wire:loading.remove>
        @forelse ($tareas as $tarea)
            <div>
                <div
                    class="flex flex-col md:grid md:grid-cols-3 md:grid-rows-4 mt-5 justify-between p-5 rounded-xl shadow-xl border-l-8 border-green-500 ">
                    <div class="col-span-2 row-span-3 md:text-base text-xs">
                        @role('admin')
                            <p><span class="uppercase font-bold">ID:</span> {{ $tarea->id }}</p>
                        @endrole
                        <p><span class="uppercase font-bold">Nombre del Lote:</span> {{ $tarea->lote->nombre }}</p>
                        <p><span class="uppercase font-bold">Semana:</span> {{ $tarea->plansemanal->semana }}</p>
                        <p><span class="uppercase font-bold">Tarea:</span> {{ $tarea->tarea->tarea }}</p>
                        <p><span class="uppercase font-bold">Horas Necesarias:</span> {{ $tarea->horas }} horas</p>
                    </div>
                </div>
            </div>
        @empty
            <div class="flex justify-center items-center text-2xl gap-2">
                <i class="fa-solid fa-circle-exclamation text-red-500"></i>
                <p class="uppercase font-bold">No existen datos de este lote o seleccione un lote</p>
            </div>
        @endforelse
    </div>
</div>
