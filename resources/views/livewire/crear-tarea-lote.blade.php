<div class="bg-white p-6 rounded-lg shadow-lg mt-10 md:mt-5 container xl:w-2/3  mx-auto">
    <form wire:submit.prevent='crearTareaLoteExt' novalidate>
        <x-alertas />

        <x-input type="number" wire:model="personas" name="personas" label="Total de Personas Necesarias"
            value="{{ old('personas') }}" placeholder="Ingrese el total de personas necesarias para la tarea" />

        <x-input type="number" wire:model="presupuesto" name="presupuesto" label="Presupuesto de la Tarea"
            value="{{ old('presupuesto') }}" placeholder="Presupuesto de la Tarea en Quetzales" />

        <x-input type="number" wire:model="horas" name="horas" label="Horas Necesarias" value="{{ old('horas') }}"
            placeholder="Horas necesarias para la Tarea" />

        <div class="mb-5">
            <label for="tarea_id" class="label-input">Seleccione la tarea extraordinaria </label>
            <select wire:model="tarea_id" name="tarea_id" class="w-full p-4 rounded bg-gray-50 select">
                <option value="" class="opcion-default" selected disabled>---SELECCIONE UNA OPCIÓN---</option>
                @foreach ($tareas as $tarea)
                <option value="{{ $tarea->id }}">
                    {{ $tarea->code }}
                </option>
                @endforeach
            </select>
            @error('tarea_id')
                <livewire:mostrar-alerta :message="$message" />
            @enderror
        </div>

        <div class="mb-5">
            <label for="tarea_id" class="label-input">Seleccione el plan semanal </label>
            <select wire:model="plan_semanal_finca_id" name="tarea_id" class="w-full p-4 rounded bg-gray-50 select">
                <option value="" class="opcion-default" selected disabled>---SELECCIONE UNA OPCIÓN---</option>
                @foreach ($planes as $plan)
                <option value="{{ $plan->id }}">
                    {{ $plan->finca->finca }} - {{ $plan->semana }}
                </option>
                @endforeach
            </select>
            @error('tarea_id')
                <livewire:mostrar-alerta :message="$message" />
            @enderror
        </div>

        <div class="mb-5">
            <label for="tarea_id" class="label-input">Seleccione el lote </label>
            <select wire:model="lote_id" name="tarea_id" class="w-full p-4 rounded bg-gray-50 select">
                <option value="" class="opcion-default" selected disabled>---SELECCIONE UNA OPCIÓN---</option>
                @foreach ($lotes as $lote)
                <option value="{{ $lote->id }}">
                    {{ $lote->nombre }}
                </option>
                @endforeach
            </select>
            @error('tarea_id')
                <livewire:mostrar-alerta :message="$message" />
            @enderror
        </div>

        <div class="flex justify-end mt-10">
            <input type="submit" value="Guardar"
                class="btn bg-green-moss hover:bg-green-meadow">
        </div>

    </form>
</div>