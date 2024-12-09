<div class="max-w-4xl mx-auto shadow-xl rounded-xl p-5">
    <form wire:submit='update' novalidate>
        <x-input type="text" name='insumo' wire:model='insumo' label="Nombre del insumo:"
            placeholder="Nombre del insumo" />

        <x-input type="text" name='code' wire:model='code' label="Codigo del insumo:" placeholder="Codigo del insumo" />


        <x-input type="text" name='medida' wire:model='medida' label="Unidad de medida del insumo:" placeholder="Unidad de medida del insumo" />

        <div class="flex justify-end mt-10">
            <input type="submit" value="Guardar" class=" btn bg-green-moss hover:bg-green-meadow">
        </div>

    </form>
</div>