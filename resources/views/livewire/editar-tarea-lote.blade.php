<div class="bg-white p-6 rounded-lg shadow-lg mt-10 md:mt-5 container xl:w-2/3  mx-auto">
    <form wire:submit.prevent='editarTarea' novalidate>
        <x-alertas />

        @hasanyrole('admin|adminagricola')
        <x-input type="number" wire:model="personas" name="personas" label="Total de Personas Necesarias"
            value="{{ old('personas') }}" placeholder="Ingrese el total de personas necesarias para la tarea" />

        <x-input type="number" wire:model="presupuesto" name="presupuesto" label="Presupuesto de la Tarea"
            value="{{ old('presupuesto') }}" placeholder="Presupuesto de la Tarea en Quetzales" />

        <x-input type="number" wire:model="horas" name="horas" label="Horas Necesarias" value="{{ old('horas') }}"
            placeholder="Horas necesarias para la Tarea" />

        @endhasanyrole
        
        <div class="mb-5">
            <label for="plan_semanal_finca_id" class="label-input">Seleccione el plan al que desea mover la tarea </label>
            <select wire:model="plan_semanal_finca_id" name="plan_semanal_finca_id" class="w-full p-4 rounded bg-gray-50">
                <option value="" class="opcion-default" selected disabled>---SELECCIONE UNA OPCIÓN---</option>
                @foreach ($planes as $plan)
                <option value="{{ $plan->id }}" >
                    {{ $plan->finca->finca }} - Semana {{ $plan->semana }}
                </option>
                @endforeach
            </select>
            @error('plan_semanal_finca_id')
                <livewire:mostrar-alerta :message="$message" />
            @enderror
        </div>


        <div class="flex justify-end mt-10">
            <input type="submit" value="Guardar"
                class=" btn bg-green-moss hover:bg-green-meadow">
        </div>

    </form>
</div>