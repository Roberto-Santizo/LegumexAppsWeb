<div>
    @forelse ($tareas as $tarea)
        <div class="mt-5 flex flex-col md:flex-row justify-between p-5 rounded-xl shadow-xl border-l-8 border-green-500 ">
            <div class="text-xs md:text-xl">
                @if($successMessage && $successTareaLoteId === $tarea->id)
                        <div class="border border-green-500 bg-green-100 text-green-700 font-bold uppercase p-2 mb-5 text-sm flex flex-row gap-2 items-center">
                            <i class="fa-solid fa-circle-check"></i>    
                            {{ $successMessage }}
                        </div>
                    @endif
                <div class="text-xs md:text-xl">
                    <p><span class="uppercase font-bold">Nombre del Lote:</span> {{ $tarea->lote->nombre }}</p>
                    <p><span class="uppercase font-bold">Semana:</span> {{ $plansemanalfinca->semana }}</p>
                    <p><span class="uppercase font-bold">Tarea:</span> {{ $tarea->tarea->tarea }}</p>
                </div>
            </div>
            <div class="flex flex-col items-center justify-between">
                <div class="flex flex-col gap-5">
                    @if (!$tarea->cierreSemanal)
                        @if (!$tarea->cierreDiario)
                            @if (!$tarea->asignacionDiaria)
                            <div class="flex md:flex-col gap-10 md:gap-2 flex-row mt-5 md:mt-0 ">
                                <a href="{{ route('planSemanal.AsignarEmpleadosCosecha',[$lote,$plansemanalfinca,$tarea->tarea, $tarea]) }}">
                                    <i  title="Asignar Empleados"
                                        class="fa-solid fa-square-plus text-2xl cursor-pointer hover:text-gray-500"
                                    ></i>
                                </a>
                            @else
                                <div class="mt-5">
                                    <a href="{{ route('planSemanal.tareasCosechaLoteRendimiento',[$lote,$plansemanalfinca,$tarea]) }}">
                                        <i title="Registrar Rendimiento" class="fa-solid fa-list-ol text-2xl cursor-pointer hover:text-gray-500"></i>
                                    </a>
                                </div>
                            @endif
                        @else
                            <i title="La tarea fue realizada" class="fa-solid fa-circle-check text-2xl text-green-500 mt-5"></i>
                            
                            @can('create plan semanal')
                                <a href="{{ route('planSemanal.tareasCosechaLoteRendimiento.real',[$lote,$plansemanalfinca,$tarea]) }}">
                                    <i title="Registrar datos que entraron a planta" class="fa-solid fa-table-list text-2xl cursor-pointer hover:text-gray-500"></i>
                                </a>
                            @endcan
                        @endif

                        @can('create plan semanal')
                            <button wire:click="$dispatch('eliminar',{{ $tarea->id }})">
                                <i title="Eliminar Tarea" class="fa-solid fa-trash text-2xl cursor-pointer hover:text-gray-500"></i>
                            </button>  
                        @endcan

                        <button wire:click="$dispatch('terminar',{{ $tarea->id }})">
                            <i title="Finalizar Cosecha Semanal" class="fa-solid fa-calendar-check  text-2xl cursor-pointer hover:text-gray-500"></i>
                        </button>

                    @else
                        <i class="fa-solid fa-calendar-check  text-2xl text-green-500"></i> 
                    @endif
                    
                </div>

            </div>
        </div>
    @empty
        <p class="text-center uppercase text-2xl font-bold">No existen tareas de cosecha</p>
    @endforelse

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            Livewire.on('eliminar', tareaId => {
                Swal.fire({
                title: "¿Deseas eliminar esta tarea?",
                text: "Una vez eliminada la tarea no se podrá recuperar ni los registros asociados",
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

            Livewire.on('terminar', tareaId => {
                Swal.fire({
                title: "¿Deseas darle cierre semanal a esta tarea?",
                text: "Una vez cerrada semanalmente no se podrá volvera abrir esta tarea",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "¡Si, cerrar!",
                cancelButtonText: "Cancelar"
                }).then((result) => {
                    if (result.isConfirmed) {
                        
                        Livewire.dispatch('terminarTarea', {tarea: tareaId});

                        Swal.fire({
                            title: "¡Se eliminó la tarea!",
                            text: "La tarea ha sido eliminada correctamente",
                            icon: "success"
                        });
                    }
                });
            });

      </script>
    @endpush
</div>