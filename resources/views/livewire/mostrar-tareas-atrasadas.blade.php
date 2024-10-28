<div>
    @forelse ($tareasFiltradas as $tarea)
    <div class="mt-5 flex flex-col md:flex-row justify-between p-5 rounded-xl shadow-xl border-l-8 border-green-500 ">
        <div class="text-xs md:text-xl">
            <p><span class="uppercase font-bold">Nombre del Lote:</span> {{ $tarea->lote->nombre }}</p>
            <p><span class="uppercase font-bold">Semana:</span> {{ $plansemanalfinca->semana }}</p>
            <p><span class="uppercase font-bold">Tarea:</span> {{ $tarea->tarea->tarea }}</p>
            @if (!$tarea->asignacion)
            <p><span class="uppercase font-bold">Cupos disponibles:</span> {{ ($tarea->personas -
                $tarea->cupos_utilizados) }}</p>
            @else
            <p><span class="uppercase font-bold">Total de personas asignadas:</span> {{ ($tarea->users->count()) }}</p>
            @endif
            @can('create plan semanal')
                <p><span class="uppercase font-bold">Presupuesto:</span> Q{{ $tarea->presupuesto }}</p>
            @endcan

            <p class="tag-red mt-2">Atrasada</p>
        </div>

        <div class="flex flex-col items-center justify-between">
            <div class="mt-5">
                <a href="{{ route('planSemanal.tareaLote.edit',$tarea) }}">
                    <i title="Editar Tarea"
                        class="fa-solid fa-arrow-right-arrow-left text-2xl cursor-pointer hover:text-gray-500"></i>
                </a>
            </div>
        </div>
        @empty
            <p class="text-center font-bold uppercase">No existen tareas atrasadas</p>
        @endforelse

    </div>