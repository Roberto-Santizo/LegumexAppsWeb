<div class="max-w-4xl mx-auto shadow-xl p-5 rounded mt-10">
    <form wire:submit='save' novalidate>
        @csrf
    
        <x-alertas />
    
        <x-input type="text" name="insumo" wire:model='insumo' label="Nombre del insumo:" value="{{ old('insumo') }}"
            placeholder="Nombre del insumo" />

        <x-input type="text" name="code" wire:model='code' label="Codigo del insumo:" value="{{ old('code') }}"
            placeholder="Codigo del insumo" />
    
        <div class="flex justify-end mt-10">
            <input type="submit" value="Guardar" class=" btn bg-green-moss hover:bg-green-meadow">
        </div>
    
    </form>
</div>