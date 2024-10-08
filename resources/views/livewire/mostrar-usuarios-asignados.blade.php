<div>
    @foreach ($asignaciones as $asignacion)
            <div class="flex flex-row justify-between items-center gap-2 bg-green-moss text-white font-bold p-3 rounded-xl">
               <div class="flex flex-row gap-3">
                    <p>{{  $asignacion->codigo }}</p>
                    <p>{{  $asignacion->nombre }}</p>
               </div>
                <div>
                    <button>
                        <i wire:click="$dispatch('eliminar',{{ $asignacion->id }})" title="Desasignar Empleado" class="fa-solid fa-circle-xmark text-3xl cursor-pointer hover:text-red-500"></i>
                    </button>
                </div>
            </div>
    @endforeach

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
