<div>
    <div class="mt-10 p-5 shadow-xl rounded-xl">
        <div class=" flex flex-col gap-5 justify-between md:flex-row md:gap-0">
            <h2 class="text-4xl font-bold">Ubicaciones Relacionadas a esta Área</h2>
            <button wire:click='openModal()' class="btn bg-orange-600 hover:bg-orange-800 text text">
                <div class="flex justify-center items-center gap-3">
                    <iconify-icon icon="material-symbols:add" class="text-2xl"></iconify-icon>
                    <p>Agregar Ubicación</p>
                </div>
            </button>
        </div>

        @error('error')
            <x-alerta-error :message="$message" />
        @enderror
        <div class="mt-10 flex flex-col gap-5">
            @foreach ($area->elementos as $elemento)
            <div class="flex flex-row justify-between p-5 bg-gray-100 rounded">
                <p class="text-xl font-bold">{{ $elemento->elemento }}</p>
                <iconify-icon icon="material-symbols:delete" class="text-4xl hover:text-red-600 cursor-pointer" wire:click="$dispatch('eliminar',{{ $elemento->id }})"></iconify-icon>
            </div>
            @endforeach
        </div>
    </div>

    @if ($isOpen) 
        <livewire:modal-elemento-form />
     @endif 
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        Livewire.on('eliminar', elemento_id => {
                Swal.fire({
                title: "¿Deseas eliminar esta ubicación?",
                text: "Una vez eliminada se eliminarán todos los registros asociados",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "¡Si, Eliminar!",
                cancelButtonText: "Cancelar"
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.dispatch('eliminarUbicacion', {elemento: elemento_id});
                    }
                });
            });
    </script>
    @endpush