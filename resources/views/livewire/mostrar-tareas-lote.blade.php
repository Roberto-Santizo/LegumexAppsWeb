<div>
    @forelse ($tareas as $tarea)
    <div class="mt-5 flex flex-col md:flex-row justify-between p-5 rounded-xl shadow-xl border-l-8 border-green-500 ">
        <div class="text-xs md:text-xl">
            @if($successMessage && $successTareaLoteId === $tarea->id)
            <div
                class="border border-green-500 bg-green-100 text-green-700 font-bold uppercase p-2 mt-5 mb-5  text-sm flex flex-row gap-2 items-center">
                {{ $successMessage }}
            </div>
            @endif
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


            <p><span class="uppercase font-bold">Horas Necesarias:</span> {{ $tarea->horas }} horas</p>
            @if($tarea->asignacion)
            <p><span class="uppercase font-bold">Fecha de Asignación:</span> {{
                $tarea->asignacion->created_at->format('d-m-Y h:i:s') }}</p>
            @endif

            @if($tarea->cierre)
            <p>
                <span class="uppercase font-bold">
                    Fecha de cierre:
                </span>
                {{$tarea->cierre->created_at->format('d-m-Y h:i:s A') }}
            </p>
            @endif

            @if ($atrasadas)
            <p class="tag-red mt-2">Atrasada</p>
            @endif

            @if ($tarea->extraordinaria)
            <p class="tag-blue mt-2">Extraordinaria</p>
            @endif

            @if ($tarea->movimientos->count() > 0)
            <p class="tag-red mt-2">Atrasada</p>
            <p class="tag-red mt-2">Origen: {{ $tarea->plansemanal->finca->finca }} - SEMANA {{$tarea->semana_origen}}
            </p>
            @endif
        </div>

        <div class="flex flex-col items-center justify-between">

            <div>
                @if(!$tarea->cierre)
                @if(!$tarea->asignacion)
                <div class="flex md:flex-col gap-10 md:gap-2 flex-row mt-5 md:mt-0 ">
                    @if($lote && $plansemanalfinca->semana >= $semanaActual)
                    <a href="{{ route('planSemanal.Asignar',[$lote,$plansemanalfinca,$tarea->tarea, $tarea]) }}">
                        <i title="Asignar Empleados"
                            class="fa-solid fa-square-plus text-2xl cursor-pointer hover:text-gray-500"></i>
                    </a>
                    @endif


                    @can('create plan semanal')
                    <a href="{{ route('planSemanal.tareaLote.edit',$tarea) }}">
                        <i title="Editar Tarea"
                            class="fa-solid fa-arrow-right-arrow-left text-2xl cursor-pointer hover:text-gray-500"></i>
                    </a>

                    <button wire:click="$dispatch('eliminar',{{ $tarea->id }})">
                        <i title="Eliminar Tarea"
                            class="fa-solid fa-trash text-2xl cursor-pointer hover:text-gray-500"></i>
                    </button>
                    @endcan
                </div>
                @else
                <div class="mt-5 flex flex-col gap-5">

                    <button wire:click="$dispatch('terminar',{{ $tarea->id }})">
                        <i class="fa-solid fa-circle-check  text-2xl cursor-pointer hover:text-gray-500"></i>
                    </button>

                    <a href="{{ route('planSemanal.tareaLote.show',$tarea) }}">
                        <i title="Información de tarea"
                            class="fa-solid fa-circle-info text-2xl hover:text-gray-600"></i>
                    </a>


                </div>

                @endif
                @else
                <div class="flex flex-col gap-5">

                    <i title="La tarea fue realizada" class="fa-solid fa-circle-check text-2xl text-green-500 mt-5"></i>

                    <a href="{{ route('planSemanal.tareaLote.show',$tarea) }}">
                        <i title="Información de tarea"
                            class="fa-solid fa-circle-info text-2xl hover:text-gray-600"></i>
                    </a>
                </div>
                @endif

            </div>

            @if ($tarea->extendido)
            <div class="bg-green-500 text-white font-bold p-2 rounded-xl">
                <p>{{ $tarea->ingresados }} / {{ ($tarea->personas - $tarea->cupos) }}</p>
            </div>
            @endif

        </div>
    </div>
    @empty
    <p class="text-center font-bold uppercase">No existen tareas atrasadas</p>
    @endforelse

</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    Livewire.on('eliminar', tareaId => {
        Swal.fire({
        title: "¿Deseas eliminar esta tarea?",
        text: "Una vez eliminada la tarea no se podrá recuperar",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "¡Si, eliminar!",
        cancelButtonText: "Cancelar"
        }).then((result) => {
            if (result.isConfirmed) {
                
                Livewire.dispatch('eliminarTarea', {tarea: tareaId});

                Swal.fire({
                    title: "¡Se eliminó la tarea!",
                    text: "La tarea ha sido eliminada correctamente",
                    icon: "success"
                });
            }
        });
    });

    Livewire.on('terminar', tareaId =>{
        Livewire.dispatch('terminarTarea', {tarea: tareaId});
    })
</script>
@endpush