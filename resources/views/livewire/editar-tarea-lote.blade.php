<div class="bg-white p-6 rounded-lg shadow-lg mt-10 md:mt-5 container xl:w-2/3  mx-auto">
    <form wire:submit.prevent='editarTarea' novalidate class="space-y-10">
        <x-alertas />

        <fieldset class="border p-5">
            <legend class="text-xl uppercase font-bold">Información de tarea</legend>
            @if (!$tarea->asignacion)
                <x-input type="number" wire:model="personas" name="personas" label="Total de Personas Necesarias"
                    value="{{ old('personas') }}" placeholder="Ingrese el total de personas necesarias para la tarea" />
            @endif

            <x-input type="number" wire:model="presupuesto" name="presupuesto" label="Presupuesto de la Tarea"
                value="{{ old('presupuesto') }}" placeholder="Presupuesto de la Tarea en Quetzales" />

            <x-input type="number" wire:model="horas" name="horas" label="Horas Necesarias"
                value="{{ old('horas') }}" placeholder="Horas necesarias para la Tarea" />

            <div class="mb-5">
                <label for="plan_semanal_finca_id" class="label-input">Seleccione el plan al que desea mover la tarea
                </label>
                <select wire:model="plan_semanal_finca_id" name="plan_semanal_finca_id"
                    class="w-full p-4 rounded bg-gray-50">
                    <option value="" class="opcion-default" selected disabled>---SELECCIONE UNA OPCIÓN---</option>
                    @foreach ($planes as $plan)
                        <option value="{{ $plan->id }}">
                            {{ $plan->finca->finca }} - Semana {{ $plan->semana }}
                        </option>
                    @endforeach
                </select>
                @error('plan_semanal_finca_id')
                    <livewire:mostrar-alerta :message="$message" />
                @enderror
            </div>
        </fieldset>

        @role('admin')
            <fieldset class="border p-5">
                <legend class="text-xl uppercase font-bold">Horas y fechas de asignaciones</legend>
                @if ($tarea->asignacion)
                    <div class="grid grid-cols-2 gap-5">
                        <x-input type="date" wire:model="fechaAsignacion" name="fechaAsignacion"
                            label="Fecha de Asignación" value="{{ old('fechaAsignacion') }}" />
                        <x-input type="time" wire:model="horaAsignacion" name="horaAsignacion"
                            label="Hora de la Asignacion" value="{{ old('horaAsignacion') }}" />
                    </div>
                @endif

                @if ($tarea->cierre)
                    <div class="grid grid-cols-2 gap-5">
                        <x-input type="date" wire:model="fechaCierre" name="fechaCierre" label="Fecha de Cierre"
                            value="{{ old('fechaCierre') }}" />
                        <x-input type="time" wire:model="horaCierre" name="horaCierre" label="Hora de Cierre"
                            value="{{ old('horaCierre') }}" />
                    </div>
                @endif
            </fieldset>
        @endrole

        <div class="flex justify-end mt-10">
            <input type="submit" value="Guardar" class=" btn bg-green-moss hover:bg-green-meadow">
        </div>

    </form>
</div>
