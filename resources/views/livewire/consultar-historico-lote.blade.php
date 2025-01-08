<div>
    <div class="my-5 flex justify-end gap-5">
        <form>
            <select wire:change='fetchLotes' wire:model="finca_id" id="finca_id">
                <option value="">--SELECCIONE UNA FINCA--</option>
                @foreach ($fincas as $finca)
                    <option value="{{ $finca->id }}">{{ $finca->finca }}</option>
                @endforeach
            </select>

            <select wire:change='cargarDatos' wire:model="lote_id" id="lote_id">
                <option value="">--SELECCIONE UN LOTE--</option>
                @foreach ($lotes as $lote)
                    <option value="{{ $lote->id }}">{{ $lote->nombre }}</option>
                @endforeach
            </select>

            <select wire:change='cargarDatos' wire:model="periodo" id="periodo">
                <option value="">--SELECCIONE UN AÑO--</option>
                @foreach ($periodos as $periodo)
                    <option value="{{ $periodo }}">{{ $periodo }}</option>
                @endforeach
            </select>
        </form>
    </div>

    <div wire:loading wire:target="cargarDatos">
        <div class="loader animate-spin border-t-2 border-blue-500 rounded-full w-24 h-24"></div>
    </div>

    <div wire:loading.remove>
        @if ($lote_id)
            <div class="w-full">
                <h2 class="bg-green-moss mb-5 p-1 text-center font-bold text-white uppercase text-2xl">Información de Lote {{ $selected_lote->nombre }}</h2>
            </div>
        @endif

        @forelse ($tareas as $semana => $tareas)
            <div class="shadow-lg p-10 space-y-5">
                <h2 class="text-center font-bold text-3xl uppercase">SEMANA DE APLICACIÓN: {{ $semana }}</h2>
                <table class="tabla">
                    <thead class="tabla-head">
                        <tr class="text-xs md:text-sm">
                            <th scope="col" class="encabezado">Tarea</th>
                            <th scope="col" class="encabezado">Estado</th>
                            <th scope="col" class="encabezado">Horas Teoricas</th>
                            <th scope="col" class="encabezado">Horas Reales</th>
                            <th scope="col" class="encabezado">Rendimiento</th>
                            <th scope="col" class="encabezado">Insumos</th>
                            <th scope="col" class="encabezado">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="tabla-body">
                        @foreach ($tareas as $tarea)
                            <tr>
                                <td class="campo">{{ $tarea->tarea->tarea }}</td>
                                <td class="campo">
                                    <p
                                        class="{{ $tarea->cierre ? 'bg-green-500' : 'bg-red-500' }}  text-center p-0.5 text-white font-bold rounded">
                                        {{ $tarea->cierre ? 'CERRADA' : 'SIN CIERRE' }}</p>
                                </td>
                                <td class="campo">{{ $tarea->horas }}</td>
                                <td class="campo">
                                    {{ $tarea->cierre
                                        ? round($tarea->asignacion->created_at->diffInHours($tarea->cierre->created_at), 3)
                                        : 'SIN
                                                                RENDIMIENTO' }}
                                </td>
                                <td class="campo">
                                    {{ $tarea->cierre
                                        ? round(($tarea->horas / $tarea->asignacion->created_at->diffInHours($tarea->cierre->created_at)) * 100, 2) . '%'
                                        : 'SIN RENDIMIENTO' }}
                                </td>
                                <td class="campo">
                                    @forelse ($tarea->insumos as $insumo)
                                        <div class="grid grid-cols-2 gap-1">
                                            <p>{{ $insumo->insumo->insumo }} </p>
                                            <p>{{ $insumo->cantidad_usada ?? 0 }} / {{ $insumo->cantidad_asignada }}
                                            </p>
                                        </div>
                                    @empty
                                        <p>NO CUENTA CON INSUMOS</p>
                                    @endforelse
                                </td>
                                <td class="campo">
                                    @if ($tarea->cierre)
                                        <a href="{{ route('planSemanal.tareaLote.show', $tarea->id) }}"
                                            target="_blank">
                                            <i class="fa-solid fa-eye text-2xl"></i>
                                        </a>
                                    @else
                                        <p>SIN CIERRE</p>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @empty
                <div class="flex justify-center items-center text-2xl gap-2">
                    <i class="fa-solid fa-circle-exclamation text-red-500"></i>
                    <p class="uppercase font-bold">No existen datos de este lote o seleccione un lote</p>
                </div>
            @endforelse
        </div>
    </div>
