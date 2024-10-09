<div>
    @forelse ($tareas as $tarea)
        <div class="mt-5 flex flex-col md:flex-row justify-between p-5 rounded-xl shadow-xl border-l-8 border-green-500 ">
            <div class="text-xs md:text-xl">
                <p><span class="uppercase font-bold">Nombre del Lote:</span> {{ $tarea->lote->nombre }}</p>
                <p><span class="uppercase font-bold">Semana:</span> {{ $plansemanalfinca->semana }}</p>
                <p><span class="uppercase font-bold">Tarea:</span> {{ $tarea->tarea->tarea }}</p>
            </div>
            <div class="flex flex-col items-center justify-between">

                <div>
                    @if(!$tarea->cierre)
                        @if(!$tarea->asignacion)
                        <div class="flex md:flex-col gap-10 md:gap-2 flex-row mt-5 md:mt-0 ">
                                @if($lote && $plansemanalfinca->semana >= $semanaActual)
                                    <a href="{{ route('planSemanal.AsignarEmpleadosCosecha',[$lote,$plansemanalfinca,$tarea->tarea, $tarea]) }}">
                                        <i title="Asignar Empleados"
                                            class="fa-solid fa-square-plus text-2xl cursor-pointer hover:text-gray-500"></i>
                                    </a>
                                @endif

{{-- 
                                @can('create plan semanal')
                                    <a href="{{ route('planSemanal.tareaLote.edit',$tarea) }}">
                                        <i title="Editar Tarea" class="fa-solid fa-arrow-right-arrow-left text-2xl cursor-pointer hover:text-gray-500"></i>
                                    </a>

                                    <button wire:click="$dispatch('eliminar',{{ $tarea->id }})">
                                        <i title="Eliminar Tarea" class="fa-solid fa-trash text-2xl cursor-pointer hover:text-gray-500"></i>
                                    </button>
                                @endcan --}}
                            </div>
                        @else
                        {{-- <div class="mt-5">
                            <form action="{{ route('planSemanal.storediario') }}" method="POST">
                                @csrf
                                <input type="hidden" value="{{ $tarea->id }}" name="tarea_lote_id">
                                <button type="submit"><i class="fa-solid fa-circle-check text-2xl hover:text-gray-600"></i></button>
                            </form>
                        </div> --}}
                        @endif
                    @else
                        <i title="La tarea fue realizada" class="fa-solid fa-circle-check text-2xl text-green-500 mt-5"></i>
                    @endif

                </div>

                {{-- @if ($tarea->extendido)
                    <div class="bg-green-500 text-white font-bold p-2 rounded-xl">
                        <p>{{ $tarea->ingresados }} / {{ ($tarea->personas - $tarea->cupos) }}</p>
                    </div>
                @endif --}}

            </div>
        </div>
    @empty
        <p>No existen tareas de cosecha</p>
    @endforelse
{{-- 
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
        </script>
    @endpush --}}
</div>