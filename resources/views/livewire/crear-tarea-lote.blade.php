<div class="bg-white p-6 rounded-lg shadow-lg mt-10 md:mt-5 container xl:w-2/3  mx-auto">
    @error('error')
        <x-alerta-error :message="$message" />
    @enderror
    <form wire:submit.prevent='crearTareaLoteExt' novalidate>
        <x-alertas />

        <x-input type="number" wire:model="personas" name="personas" label="Total de Personas Necesarias"
            value="{{ old('personas') }}" placeholder="Ingrese el total de personas necesarias para la tarea" />

        <x-input type="number" wire:model="horas" wire:input='calcPresupuesto' name="horas" label="horas de la Tarea" value="{{ old('horas') }}"
            placeholder="Horas necesarias para la tarea" />

        <div class="mb-5">
            <label for="presupuesto" class="label-input">Presupuesto de la Tarea:</label>
            <input type="number" id="presupuesto" name="presupuesto" class="p-3 w-full rounded-lg border opacity-50"
                placeholder="Presupuesto de la Tarea" autocomplete="off" value="{{ $presupuesto }}" disabled>
        </div>

        <div class="mb-5">
            <label for="tarea_id" class="label-input">Seleccione la tarea extraordinaria </label>
            <div class="mb-4 opacity-40">
                <input type="text" wire:model='searchTerm' wire:input='buscarTarea' placeholder="Buscar tarea..."
                    class="w-full p-2 border rounded shadow-sm" />
            </div>
            <select wire:model="tarea_id" name="tarea_id" class="w-full p-4 rounded bg-gray-50">
                <option value="" class="opcion-default" selected>---SELECCIONE UNA OPCIÓN---</option>
                @foreach ($tareasFiltradas as $tarea)
                    <option value="{{ $tarea->id }}">
                        {{ $tarea->tarea }} - {{ $tarea->code }}
                    </option>
                @endforeach
            </select>
            @error('tarea_id')
                <livewire:mostrar-alerta :message="$message" />
            @enderror
        </div>

        <div class="mb-5">
            <label for="plan_semanal_finca_id" class="label-input">Seleccione el plan semanal </label>
            <select wire:model="plan_semanal_finca_id" name="plan_semanal_finca_id"
                class="w-full p-4 rounded bg-gray-50">
                <option value="" class="opcion-default" selected>---SELECCIONE UNA OPCIÓN---</option>
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
            <label for="tarea_id" class="label-input">Seleccione el lote </label>
            <select wire:model="lote_id" name="tarea_id" class="w-full p-4 rounded bg-gray-50">
                <option value="" class="opcion-default" selected>---SELECCIONE UNA OPCIÓN---</option>
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

        <div class="mb-5">
            <label for="extraordinaria" class="label-input">Seleccione el tipo de la tarea</label>
            <select wire:model="extraordinaria" name="extraordinaria" class="w-full p-4 rounded bg-gray-50">
                <option value="" class="opcion-default" selected>---SELECCIONE UNA OPCIÓN---</option>
                <option value="1">EXTRAORDINARIA</option>
                <option value="0">NO EXTRAORDINARIA</option>
            </select>
            @error('extraordinaria')
                <livewire:mostrar-alerta :message="$message" />
            @enderror
        </div>



        <fieldset class="border p-5">
            <legend class="text-2xl text-gray-400 font-bold">Insumos Relacionados</legend>
            <div class="w-full flex justify-end">
                <button wire:click='openModal()' type="button"
                    class="btn bg-orange-500 hover:bg-orange-600 md:text-normal text-xs">
                    <i class="fa-solid fa-plus"></i>
                    Agregar Insumo
                </button>
            </div>

            @if (count($insumos) > 0)
                <table class="tabla mt-10">
                    <thead class="bg-blue-300">
                        <tr class="text-white text-xs md:text-sm">
                            <th scope="col" class="encabezado">
                                Insumo</th>
                            <th scope="col" class="encabezado text-center">
                                Cantidad Asignada</th>
                            <th scope="col" class="encabezado">
                                Acciones</th>
                        </tr>
                    </thead>

                    <tbody class="tabla-body">
                        @foreach ($insumos as $insumo)
                            <tr>
                                <td class="campo">{{ $insumo['insumo'] }}</td>
                                <td class="campo">{{ $insumo['cantidad'] }} {{ $insumo['medida'] }}</td>
                                <td class="campo">
                                    <div class="flex flex-row gap-3">
                                        <button type="button"
                                            wire:click='eliminarInsumo( "{{ $insumo['id_insumo'] }}" )'>
                                            <i title="Eliminar"
                                                class="fa-solid fa-trash text-2xl hover:text-gray-500"></i>
                                        </button>

                                        <button type="button" wire:click='editInsumo("{{ $insumo['id_insumo'] }}")'>
                                            <i title="Editar"
                                                class="fa-solid fa-pen-to-square text-2xl hover:text-gray-500"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="p-5">

                </div>
            @else
                <p class="text-center md:text-2xl text-sm mt-5">Sin insumos</p>
            @endif
        </fieldset>

        <div class="flex justify-end mt-10">
            <input type="submit" value="Guardar" class="btn bg-green-moss hover:bg-green-meadow">
        </div>
    </form>

    @if ($open)
        <livewire:add-insumo-modal />
    @endif

    @if ($openEditing)
        <livewire:add-insumo-cantidad-modal :insumosAgregados="$insumos" :editing="true" :insumo="$editingInsumo" />
    @endif
</div>
