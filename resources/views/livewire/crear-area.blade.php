<div class="mx-auto ">
    <form class="flex flex-col gap-5">
        <fieldset>
            <div>
                <label for="area" class="font-bold text-xl">Nombre del Área:</label>
                <input wire:model="area" type="text" id="area" class="w-full border rounded px-3 py-2"
                    placeholder="Nombre de la nueva ubicación" />
                @error('area')
                <x-alerta-error :message="$message" />
                @enderror
            </div>

            <div class="flex flex-col">
                <label class="font-bold text-xl" for="planta_id">Planta:</label>
                <select wire:model='planta_id' class="border p-3 border-black">
                    <option selected disabled>--SELECCIONE UNA PLANTA--</option>
                    @foreach ($plantas as $planta)
                    <option value="{{ $planta->id }}">{{ $planta->name }}</option>
                    @endforeach
                </select>
            </div>
        </fieldset>

        <fieldset>
            <div class=" flex flex-col gap-5 justify-between md:flex-row md:gap-0">
                <h2 class="text-xl mb-5 font-bold">Ubicaciónes del Área</h2>
                <button wire:click='openModal()' type="button" class="btn bg-orange-600 hover:bg-orange-800 text text">
                    <div class="flex justify-center items-center gap-3">
                        <iconify-icon icon="material-symbols:add" class="text-2xl"></iconify-icon>
                        <p>Agregar Ubicación</p>
                    </div>
                </button>
            </div>
            
            
            <div class="p-5 mt-10">
                @forelse ($ubicaciones as $ubicacion)
                    <p>{{ $ubicacion->elemento }}</p>
                @empty
                    <p class="uppercase text-center font-bold">No existen ubicaciones aún, asegurese de ingresar por lo menos una ubicación</p>
                @endforelse
            </div>

        @if ($open)
            <livewire:modal-elemento-form />
        @endif
        </fieldset>

        <div class="btn bg-orange-600 hover:bg-orange-800">
            <button class="flex justify-center items-center p-2 gap-2" type="submit">
                <iconify-icon icon="circum:save-down-2" class="text-2xl"></iconify-icon>
                <p class="uppercase">Guardar</p>
            </button>
        </div>

    </form>
</div>