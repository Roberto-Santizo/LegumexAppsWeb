<div>
    @error('error')
        <x-alerta-error :message="$message" />   
    @enderror

    @forelse ($tareas as $tarea)
    <div class="flex flex-col md:grid md:grid-cols-3 md:grid-rows-4 mt-5 justify-between p-5 rounded-xl shadow-xl border-l-8 border-green-500 ">
        @if($successMessage && $successTareaLoteId === $tarea->id)
            <div class="border border-green-500 bg-green-100 text-green-700 font-bold uppercase p-2 mt-5 mb-5  text-sm flex flex-row gap-2 items-center">
                <i class="fa-solid fa-circle-check"></i>
                {{ $successMessage }}
            </div>
        @endif

        <div class="{{ $successMessage ? 'row-start-2' : 'row-start-1' }} col-span-2 row-span-3 md:text-base text-xs">
            <p><span class="uppercase font-bold">Nombre del Lote:</span> {{ $tarea->lote->nombre }}</p>
            <p><span class="uppercase font-bold">Semana:</span> {{ $plansemanalfinca->semana }}</p>
            <p><span class="uppercase font-bold">Tarea:</span> {{ $tarea->tarea->tarea }}</p>
            <p><span class="uppercase font-bold">Horas Necesarias:</span> {{ $tarea->horas }} horas</p>

            @if (!$tarea->asignacion)
            <p><span class="uppercase font-bold">Cupos disponibles:</span> {{ ($tarea->personas -
                $tarea->cupos_utilizados) }}</p>
            @else
            <p><span class="uppercase font-bold">Total de personas asignadas:</span> {{ ($tarea->users->count()) }}</p>
            @endif

            @can('create plan semanal')
            <p><span class="uppercase font-bold text-black">Presupuesto:</span> <span
                    class="text-green-500 font-black">Q{{ $tarea->presupuesto }}</span></p>
            @endcan


            @if($tarea->asignacion)
            <p><span class="uppercase font-bold">Fecha de Asignación:</span> {{
                $tarea->asignacion->created_at->format('d-m-Y h:i:s A') }}</p>
            @endif

            @if($tarea->cierre)
            <p><span class="uppercase font-bold">Fecha de cierre: </span>{{$tarea->cierre->created_at->format('d-m-Y
                h:i:s A') }}</p>
            @endif
        </div>

        <div
            class="cols-start-1 {{ $successMessage ? 'row-start-5' : 'row-start-4' }} col-span-2 flex gap-2 md:text-base text-xs">
            @if($tarea->asignacion && $tarea->asignacion->use_dron)
            <div
                class="bg-orange-500 w-24 text-white mt-2 font-bold py-2 px-1 flex justify-center items-center rounded">
                <iconify-icon icon="hugeicons:drone" class="text-3xl"></iconify-icon>
            </div>
            @endif

            @if ($tarea->extraordinaria)
            <p class="tag-blue mt-2">Extraordinaria</p>
            @endif

            @if ($tarea->movimientos->count() > 0)
            <p class="tag-red mt-2">Atrasada</p>
            @endif
        </div>

        <div class="col-start-3 {{ $successMessage ? 'row-start-2' : 'row-start-1' }} row-span-4 flex md:justify-end p-5 justify-center">
            @if(!$tarea->cierre)
            <div class="flex flex-col justify-center items-center gap-5">
                @if(!$tarea->asignacion)
                <div class="flex md:flex-col gap-10 md:gap-2 flex-row mt-5 md:mt-0 ">
                    @if($lote && $plansemanalfinca->semana >= $semanaActual)
                    <a href="{{ route('planSemanal.Asignar',[$lote,$plansemanalfinca,$tarea->tarea, $tarea]) }}">
                        <i title="Asignar Empleados"
                            class="fa-solid fa-square-plus text-2xl cursor-pointer hover:text-gray-500"></i>
                    </a>
                    @endif


                    @can('create plan semanal')
                    <button wire:click="$dispatch('eliminar',{{ $tarea->id }})">
                        <i title="Eliminar Tarea"
                            class="fa-solid fa-trash text-2xl cursor-pointer hover:text-gray-500"></i>
                    </button>
                    @endcan
                </div>
                @else
                <div class="mt-5 flex md:flex-col flex-row justify-center items-center gap-5">
                    @if($tarea->cierreParcialActivo()->get()->isEmpty())
                    <button wire:click="$dispatch('terminar',{{ $tarea->id }})">
                        <i class="fa-solid fa-circle-check  text-2xl cursor-pointer hover:text-gray-500"></i>
                    </button>

                    <a href="{{ route('planSemanal.tareaLote.show',$tarea) }}">
                        <i title="Información de tarea"
                            class="fa-solid fa-circle-info text-2xl hover:text-gray-600"></i>
                    </a>
                    <iconify-icon icon="zondicons:pause-solid"
                        class="text-2xl cursor-pointer hover:text-gray-500 text-orange-500" title="Pausar"
                        wire:click="$dispatch('pausarTarea',{{ $tarea->id }})"></iconify-icon>
                    @else
                    <iconify-icon icon="gridicons:play"
                        class="text-3xl cursor-pointer hover:text-gray-500 text-green-500" title="Reanudar"
                        wire:click="$dispatch('reanudarTarea',{{ $tarea->id }})"></iconify-icon>
                    @endif
                    
                    @role('admin')
                        <button wire:click="$dispatch('cleanTask',{{ $tarea }})">
                            <i class="fa-solid fa-broom text-2xl cursor-pointer hover:text-gray-500"
                            title="Limpiar Asignación"></i>
                        </button>
                    @endrole
                </div>
                @endif

                <div class="space-y-2">
                    @hasanyrole('admin|adminagricola')
                        <div>
                            <a href="{{ route('planSemanal.tareaLote.edit',$tarea) }}">
                                <i title="Editar Tarea"
                                    class="fa-solid fa-arrow-right-arrow-left text-2xl cursor-pointer hover:text-gray-500"></i>
                            </a>
                        </div>
                    @endhasanyrole
                </div>
            </div>
            @else
            <div>
                <div class="flex md:flex-col flex-row gap-5 justify-center items-center">
                    <i title="La tarea fue realizada" class="fa-solid fa-circle-check text-2xl text-green-500"></i>

                    <a href="{{ route('planSemanal.tareaLote.show',$tarea) }}">
                        <i title="Información de tarea"
                            class="fa-solid fa-circle-info text-2xl hover:text-gray-600"></i>
                    </a>

                    @if ($tarea->extendido)
                    <div class="bg-green-500 text-white font-bold p-2 rounded-xl">
                        <p>{{ $tarea->ingresados }} / {{ ( $tarea->users->count()) }}</p>
                    </div>
                    @endif

                    @role('admin')
                    <div>
                        <a href="{{ route('planSemanal.tareaLote.edit',$tarea) }}">
                            <i title="Editar Tarea"
                                class="fa-solid fa-arrow-right-arrow-left text-2xl cursor-pointer hover:text-gray-500"></i>
                        </a>
                    </div>
                    @endrole
                </div>

            </div>

            @endif
        </div>
    </div>
    @empty
    <p class="font-bold uppercase text-3xl text-center">No existen tareas en este lote</p>
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

        Livewire.on('cleanTask', tareaId => {
            Swal.fire({
            title: "¿Deseas limpiar la asignación de la tarea?",
            text: "Una vez limpiada la tarea no se podrá recuperar",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "¡Si, limpiar!",
            cancelButtonText: "Cancelar"
            }).then((result) => {
                if (result.isConfirmed) {
                    
                    Livewire.dispatch('limpiarTarea', {tarea: tareaId});

                    Swal.fire({
                        title: "¡Se limpió la asignación correctamente!",
                        icon: "success"
                    });
                }
            });
        });

        Livewire.on('terminar', tareaId =>{
            Livewire.dispatch('terminarTarea', {tarea: tareaId});
        })

        Livewire.on('pausarTarea', tareaId =>{
            Livewire.dispatch('pausar', {tarea: tareaId});
        })

        Livewire.on('reanudarTarea', tareaId =>{
            Livewire.dispatch('reanudar', {tarea: tareaId});
        })
</script>
@endpush