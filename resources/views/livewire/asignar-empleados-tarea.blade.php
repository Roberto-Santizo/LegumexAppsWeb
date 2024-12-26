<div class="md:grid md:grid-cols-3 mt-10 flex flex-col">
    <div class="col-span-2">
        @if ($errors->has('error'))
            <div
                class="border border-red-500 bg-red-100 text-red-700 font-bold uppercase p-2 mt-2 text-sm flex flex-row gap-2 items-center mr-10 mb-5">
                {{ $errors->first('error') }}
            </div>
        @endif
        <div class="w-1/2">
            <h1 class="text-2xl font-bold">Información de la tarea: </h1>

            <div class="flex gap-2">
                <p class="text-xl font-bold">Descripcion: </p>
                <p>{{ $tarea->descripcion }}</p>
            </div>

            <div class="flex gap-2">
                <p class="text-xl font-bold">Cupos Disponibles: </p>
                <p class="text-xl font-bold">{{ $tarealote->cupos }}</p>
            </div>

            <div class="flex gap-2">
                <p class="text-xl font-bold">Cupos Minimos: </p>
                <p class="text-xl font-bold">{{ $cuposMinimos }}</p>
            </div>

            <div class="flex gap-2">
                <p class="text-xl font-bold">Fecha de la asignación: </p>
                <p class="text-xl font-bold">{{ now()->format('d-m-Y') }}</p>
            </div>

            @if ($tarealote->insumos->count() > 0)
                <div class="space-y-5">
                    <h2 class="text-xl uppercase font-bold mt-5">Insumos:</h2>
                    <x-insumos-table :insumos="$tarealote->insumos" :asignacion="true" />
                </div>
            @endif
        </div>


        <div class="mt-5 md:w-1/2 w-full shadow-xl rounded-lg p-5 mb-5">
            <div id="usuariosAsignadosContainer" class="flex flex-col gap-2 mt-5 overflow-y-auto h-96 mb-5">
                @forelse ($asignados as $asignado)
                    <div wire:click="$dispatch('desAsignar',{{ $asignado->id }})"
                        class="bg-green-moss hover:bg-green-meadow btn">
                        <div class="flex flex-row items-center gap-3">
                            <i class="fa-solid fa-user text-2xl"></i>
                            <div>
                                <p class="font-bold">{{ $asignado->nombre }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-xl font-bold">No hay empleados asignados a esta tarea</p>
                @endforelse
            </div>
        </div>
    </div>
    <div>
        <button
            class="flex w-full justify-center items-center gap-2 p-2 mb-5 bg-orange-500 text-white text-center rounded shadow hover:bg-orange-800 transition-all duration-300"
            wire:click="$dispatch('useDron')">
            <iconify-icon icon="hugeicons:drone" class="text-3xl"></iconify-icon>
            <p class="uppercase text-xl font-bold ">Tarea con Dron</p>
        </button>
        <h1 class="text-2xl font-bold">Empleados Disponibles: </h1>
        <input type="text" id="buscarUsuario" placeholder="Buscar usuario..."
            class="border p-2 rounded mt-4 mb-4 w-full">

        <div class="mt-2 flex flex-col gap-2 overflow-y-auto h-96" id="disponiblesContainer">

            @foreach ($ingresos as $ingreso)
                <div wire:click="$dispatch('asignar',{{ $ingreso->emp_id }})"
                    class="bg-green-moss hover:bg-green-meadow btn empleadosBuscar">
                    <div class="flex flex-row items-center gap-3">
                        <i class="fa-solid fa-user text-2xl"></i>
                        <div>
                            <p class="font-bold">{{ $ingreso->empleado->first_name }}</p>
                            <p class="font-bold">Horas del día de hoy: {{ round($ingreso->horas_totales, 2) }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <button wire:click="$dispatch('cerrar')" class="btn bg-green-moss hover:bg-green-meadow">
        <p>Cerrar Asignación Diaria</p>
    </button>

    @push('scripts')
        <script>
            Livewire.on('useDron', () => {
                Swal.fire({
                    title: 'Advertencia',
                    text: `Esta tarea será realizada utilizando dron, ¿desea continuar?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, continuar',
                    cancelButtonText: 'No'
                }).then((result) => {
                    Livewire.dispatch('AsignarDron');
                });
            });

            Livewire.on('asignar', emp_id => {
                Livewire.dispatch('AsignarEmpleado', {
                    empleado: emp_id
                });
            });

            Livewire.on('desAsignar', asignacionId => {
                Livewire.dispatch('DesasignarEmpleado', {
                    asignacion: asignacionId
                })
            });
            Livewire.on('cerrar', () => {
                Livewire.dispatch('cerrarAsignacion')
            });

            window.addEventListener('mostrarAlertaCierre', event => {
                const cuposMinimos = event.detail[0].cuposMinimos;
                Swal.fire({
                    title: 'Advertencia',
                    text: `El número de asignados es menor que el mínimo requerido: ${cuposMinimos}. ¿Deseas continuar?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, continuar',
                    cancelButtonText: 'No'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.dispatch('cerrarAsignacionForzada');
                    }
                });
            });
        </script>
    @endpush
</div>
