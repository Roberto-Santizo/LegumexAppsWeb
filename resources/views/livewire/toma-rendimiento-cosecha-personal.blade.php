<div class="mt-10 flex flex-col gap-5">
    @foreach ($asignaciones as $asignacion)
        <div class="shadow-xl p-5 bg-green-meadow text-white rounded-xl flex md:flex-row flex-col gap-5 justify-between">
            <div>
                <p class="font-bold">{{ $asignacion->nombre }}</p>
                <p class="font-bold uppercase text-2xl">Libras cosechadas: {{ $asignacion->libras_asignacion }} lbs</p>
            </div>

            @if (!$asignacion->libras_asignacion)
                <div class="flex flex-col">
                    <input type="text" wire:model.defer="registro.{{ $asignacion->id }}" class="text-black p-2 rounded" placeholder="Registrar libras del día...">
                    <div class="flex flex-row gap-2 justify-center items-center bg-red-500 p-2 text-white font-bold uppercase text-xs rounded mt-5">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        <p>El dato se registra en libras</p>
                    </div>
                    <button wire:click="registrarDato({{ $asignacion->id }})" class="btn bg-green-moss mt-2 hover:bg-green-700">
                        Guardar
                    </button>
                </div>
            @endif
        </div>
    @endforeach
    @if($errors->has('error'))
        <div class="border border-red-500 bg-red-100 text-red-700 font-bold uppercase p-2 mt-2 text-sm flex flex-row gap-2 items-center mr-10 mb-5">
            {{ $errors->first('error') }}
        </div>
    @endif
    <button wire:click="$dispatch('cerrar')" class="btn bg-green-moss hover:bg-green-meadow">
        <p>Cerrar Asignación Diaria</p>
    </button>
</div>

@push('scripts')
        <script>
            Livewire.on('cerrar', () => {
                Livewire.dispatch('cerrarAsignacion')
            });
        </script>
    @endpush
