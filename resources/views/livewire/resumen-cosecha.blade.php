<div>
    <div class="mt-5 flex flex-col gap-5 shadow-xl p-5">
        <div class="flex justify-between">
            <h2 class="text-2xl uppercase font-bold">Información de la Cosecha</h2>
            <a href="{{ route('reporte.ControlCosecha',$tarealotecosecha) }}">
                <i title="Exportar datos" class="fa-solid fa-file-export icon-link"></i>
            </a>
        </div>
        <div class="text-xl">
           
            <p><span class="font-bold">Cultivo: </span> {{$tarealotecosecha->tarea->cultivo->cultivo}}</p>
            <p><span class="font-bold">Total de Libras Registradas en Finca: </span> {{$totalLibras}} lbs</p>
        </div>
        <div class="flex flex-col gap-5 uppercase">
            <h2 class="text-xl font-bold">Fechas que se Cosecharon: </h2>
            <div class="flex flex-row gap-10 justify-between text-white font-bold rounded-xl shadow-xl">
                <table class="tabla">
                    <thead class="bg-green-meadow">
                        <tr class="text-xs md:text-sm rounded uppercase">
                            <th scope="col" class="text-white">FECHA</th>
                            <th scope="col" class="text-white">TOTAL LIBRAS FINCA</th>
                            <th scope="col" class="text-white">TOTAL LIBRAS PLANTA</th>
                            <th scope="col" class="text-white">TOTAL PLANTAS COSECHADAS</th>
                            <th scope="col" class="text-white">Hora de Inicio</th>
                            <th scope="col" class="text-white">Hora de Cierre</th>
                            <th scope="col" class="text-white">HORAS EMPLEADAS</th>
                            <th scope="col" class="text-white">Mostrando</th>
                        </tr>
                    </thead>
                    <tbody class="tabla-body text-black">
                        @foreach ($asignaciones as $asignacion)
                        <tr class="{{ ($asignacion->id === $asignacionSelected ? 'bg-gray-200' : '')  }} cursor-pointer hover:bg-gray-200 text-center" 
                            wire:click="$dispatch('actualizar',{{ $asignacion->id }})">
                            <td>{{ $asignacion->fechaCosecha }}</td>
                            <td class="text-center"> {{ $asignacion->totalCosechadoFinca }} lbs</p>
                            <td class="text-center p-5"> {{ $asignacion->totalCosechadoPlanta }} lbs</td>
                            <td class="text-center p-5"> {{ $asignacion->cierre->plantas_cosechadas }}</td>
                            <td class="text-center"> {{ $asignacion->fechaInicio }} </p>
                            <td class="text-center"> {{ $asignacion->fechaFinal }} </p>
                            <td class="text-center"> {{ $asignacion->TotalHoras }} horas</p>
                            <td>
                                @if ($asignacion->id === $asignacionSelected)
                                <div class="flex justify-center items-center">
                                    <i class="fa-solid fa-eye text-2xl"></i>
                                </div>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <div class="mt-5 flex flex-col gap-5 p-5">
        <h2 class="text-2xl uppercase font-bold">Información de la Cosecha Por Empleado</h2>

        <div class="flex flex-row gap-10 justify-between p-3 text-white font-bold rounded-xl shadow-xl">
            
            <table class="tabla">
                <thead class="bg-green-meadow">
                    <tr class="text-xs md:text-sm rounded uppercase">
                        <th scope="col" class="text-white">Codigo</th>
                        <th scope="col" class="text-white">Empleado</th>
                        <th scope="col" class="text-white">Fecha</th>
                        <th scope="col" class="text-white">Total de Libras Cosechadas (finca)</th>
                        <th scope="col" class="text-white">Total de Libras Cosechadas Ajustado (planta) </th>
                        <th scope="col" class="text-white">Horas Empleadas</th>
                    </tr>
                </thead>
                <tbody class="tabla-body text-black">
                    @foreach ($asignacionesUsuarios as $asignacion)
                    <tr>
                        <td>{{ $asignacion->codigo }}</td>
                        <td class="uppercase">{{ $asignacion->nombre }}</td>
                        <td class="text-center">{{ $asignacion->created_at->format('d-m-Y') }}</td>
                        <td class="text-center">{{ $asignacion->libras_asignacion }} lbs</td>
                        <td class="text-center">{{ $asignacion->libras_asignacion_planta }} lbs</td>
                        <td class="text-center">{{ round($asignacion->total_horas,2) }} horas</td>
                    </tr>

                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script src="//unpkg.com/alpinejs" defer></script>
<script>
    Livewire.on('actualizar', asignacionId => {
            Livewire.dispatch('actualizarFecha', {asignacion : asignacionId})
        });
</script>
@endpush