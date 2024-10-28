<div>
    <div class="bg-white p-6 rounded-lg shadow-lg mt-10 md:mt-5 container xl:w-2/3  mx-auto">
        @error('error')
            <x-alerta-error :message="$message" />
        @enderror
        <form wire:submit.prevent='crearTareaLoteCosecha' novalidate class="mt-5">
            
    
            <div class="mb-5">
                <label for="plan_semanal_finca_id" class="label-input">Seleccione el plan semanal </label>
                <select wire:model="plan_semanal_finca_id" name="plan_semanal_finca_id" class="w-full p-4 rounded bg-gray-50 select">
                    <option value="" class="opcion-default" selected >---SELECCIONE UNA OPCIÓN---</option>
                    @foreach ($planes as $plan)
                    <option value="{{ $plan->id }}">
                        {{ $plan->finca->finca }} - {{ $plan->semana }}
                    </option>
                    @endforeach
                </select>
                @error('plan_semanal_finca_id')
                    <livewire:mostrar-alerta :message="$message" />
                @enderror
            </div>
    
            <div class="mb-5">
                <label for="lote_id" class="label-input">Seleccione el lote </label>
                <select wire:model="lote_id" name="lote_id" class="w-full p-4 rounded bg-gray-50 select">
                    <option value="" class="opcion-default" selected >---SELECCIONE UNA OPCIÓN---</option>
                    @foreach ($lotes as $lote)
                    <option value="{{ $lote->id }}">
                        {{ $lote->nombre }}
                    </option>
                    @endforeach
                </select>
                @error('lote_id')
                    <livewire:mostrar-alerta :message="$message" />
                @enderror
            </div>

            <div class="mb-5">
                <label for="tarea_cosecha_id" class="label-input">Seleccione la cosecha </label>
                <select wire:model="tarea_cosecha_id" name="tarea_cosecha_id" class="w-full p-4 rounded bg-gray-50 select">
                    <option value="" class="opcion-default" selected >---SELECCIONE UNA OPCIÓN---</option>
                    @foreach ($tareas as $tarea)
                    <option value="{{ $tarea->id }}">
                        {{ $tarea->tarea }} - {{ $tarea->code }}
                    </option>
                    @endforeach
                </select>
                @error('tarea_cosecha_id')
                    <livewire:mostrar-alerta :message="$message" />
                @enderror
            </div>
    
            <div class="flex justify-end mt-10">
                <input type="submit" value="Guardar"
                    class="btn bg-green-moss hover:bg-green-meadow">
            </div>
    
        </form>
    </div>
</div>
