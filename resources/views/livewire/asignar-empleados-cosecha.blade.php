<div class="md:grid md:grid-cols-3 mt-10 flex flex-col">
    <div class="col-span-2">
        <h1 class="text-2xl font-bold">Información de la tarea: </h1>

        <div class="flex gap-2">
            <p class="text-xl font-bold">Fecha de la asignación: </p>
            <p class="text-xl font-bold">{{ now()->format('d-m-Y') }}</p>
        </div>

        <div class="flex gap-2">
            <p class="text-xl font-bold">Total de rendimiento teorico: </p>
            <p class="text-xl font-bold">{{ $total }}</p>
        </div>

        <div class="mt-5 md:w-1/2 w-full">
            <h1 class="text-2xl font-bold">Empleados Asignados a esta tarea: </h1>

            <div id="usuariosAsignadosContainer" class="flex flex-col gap-2 mt-5 overflow-y-auto h-96 mb-5">
                @foreach ($asignados as $asignado)
                    <div wire:click="$dispatch('desAsignar',{{ $asignado->id }})" class="border p-3 selected text-white rounded cursor-pointer">
                        <div class="flex flex-row items-center gap-3">
                            <i class="fa-solid fa-user text-2xl"></i>
                            <div>
                                <p class="font-bold">{{ $asignado->nombre }}</p>
                                {{-- <p class="font-bold">Horas del día de hoy: {{ round($asignado->horas_totales,2) }}</p> --}}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div>
        <h1 class="text-2xl font-bold">Empleados Disponibles: </h1>
        <input type="text" id="buscarUsuario" placeholder="Buscar usuario..."
            class="border p-2 rounded mt-4 mb-4 w-full">

        <div class="mt-2 flex flex-col gap-2 overflow-y-auto h-96" id="disponiblesContainer">

            @foreach ($ingresos as $ingreso)
            <div wire:click="$dispatch('asignar',{{$ingreso->emp_id }})" class="bg-green-moss hover:bg-green-meadow btn empleadosBuscar">
                <div class="flex flex-row items-center gap-3">
                    <i class="fa-solid fa-user text-2xl"></i>
                    <div>
                        <p class="font-bold">{{ $ingreso->empleado->first_name }}</p>
                        <p class="font-bold">Horas del día de hoy: {{ round($ingreso->horas_totales,2) }}</p>
                        <input type="hidden" value="{{ $ingreso->emp_id }}" id="usuario_id">
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <form method="POST" action="" class="mt-10 md:mt-0">
        @csrf
        <input type="hidden" value="" id="tarealote_id" name="tarealote_id">
        <input type="submit" value="Cerrar Asignación Diaria" class="btn bg-green-moss hover:bg-green-meadow">
    </form>

    @push('scripts')
        <script>
            Livewire.on('asignar', emp_id => {
                Livewire.dispatch('AsignarEmpleado', {empleado: emp_id});
            });

            Livewire.on('desAsignar', asignacionId => {
                Livewire.dispatch('DesasignarEmpleado', {asignacion: asignacionId})
            });
        </script>
    @endpush
</div>