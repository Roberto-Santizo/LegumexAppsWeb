<div>
    <div class="flex flex-col gap-5">
        
        <div class="flex flex-row justify-between items-center gap-2 bg-green-moss font-bold p-3 rounded-xl">
            <table class="tabla">
                <thead class="tabla-head">
                    <tr class="text-xs md:text-sm">
                        <th scope="col" class="encabezado">Codigo</th>
                        <th scope="col" class="encabezado">Nombre del Empleado</th>
                        <th scope="col" class="encabezado">Fecha de Asignación</th>
                        <th scope="col" class="encabezado">Acción</th>
                    </tr>
                </thead>
                <tbody class="tabla-body">
                    @foreach ($asignaciones as $asignacion)
                    <tr>
                        <td class="campo">{{ $asignacion->codigo }}</td>
                        <td class="campo">{{ $asignacion->nombre }}</td>
                        <td class="campo">{{ $asignacion->created_at->format('d-m-Y h:i:s A') }}</td>
                        <td class="campo">
                            @role('admin')
                            <button>
                                <i wire:click="$dispatch('eliminar',{{ $asignacion->id }})" title="Desasignar Empleado"
                                    class="fa-solid fa-circle-xmark text-xl cursor-pointer hover:text-red-500"></i>
                            </button>
                            @endrole
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
       
    </div>
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        Livewire.on('eliminar', asignacionId => {
                Swal.fire({
                title: "¿Deseas desasignar a este usuario?",
                text: "Una vez desasignada no se podrá volver a asignar",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "¡Si, desasignar!",
                cancelButtonText: "Cancelar"
                }).then((result) => {
                    if (result.isConfirmed) {
                        
                        Livewire.dispatch('eliminarAsignacion', {asignacion: asignacionId});

                        Swal.fire({
                            title: "¡Se desasignó correctamente!",
                            text: "El usuario fue desasignado correctamente",
                            icon: "success"
                        });
                    }
                });
            });
    </script>
    @endpush
</div>