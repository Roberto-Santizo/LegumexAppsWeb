<div class="w-1/2 mx-auto">
    <form class="flex flex-col" wire:submit.prevent='save'>
        <div>
            <label for="name" class="font-bold text-xl">Nombre del Accesorio:</label>
            <input wire:model="name" type="text" id="name" class="w-full border rounded px-3 py-2"
                placeholder="Nombre de la nueva ubicación" autocomplete="off"/>
            @error('name')
                <x-alerta-error :message="$message" />
            @enderror
        </div>

        
        <div class="btn bg-orange-600 hover:bg-orange-800 mt-10">
            <button class="flex justify-center items-center p-2 gap-2" type="submit">
                <iconify-icon icon="circum:save-down-2" class="text-2xl"></iconify-icon>
                <p class="uppercase">Guardar</p>
            </button>
        </div>
    </form>
</div>
