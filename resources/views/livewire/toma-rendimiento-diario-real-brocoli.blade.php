<div class="mt-10">
    <div class="shadow-xl p-5 rounded-xl flex flex-row justify-between items-center">
        <div>
            <h2 class="text-3xl font-bold">Información de Cosecha de {{ $sumaPorFecha[0]->fecha }}</h2>
            <h3 class="text-xl">Total de Libras Reportadas en Finca: <span class="font-bold">{{ $totalLibrasFincaReportado }} LBS</span></h3>
            <p class="text-xl">Total de Personas que Cosecharon: <span class="font-bold">{{ $tarealotecosecha->users()->whereDate('created_at',$asignacion->created_at)->count() }}</span></p>
            <p class="text-xl">Plantas Cosechadas: <span class="font-bold">{{ $plantas_cosechadas }}</span></p>
            <p class="text-xl">Peso por Planta: <span class="font-bold">{{ $pesoLbCabeza }}</span> LBS</p>
            <p class="text-xl">Rendimiento Teorico Por Persona: <span class="font-bold">{{ $rendimientoTeoricoPorPersona }}</span> LBS</p>
            @can('create plan semanal')
                <p class="text-xl">Conversion de Libras a Quetzales: <span class="font-bold">Q {{ $montoTotal }}</span></p> 
            @endcan
                
    
        </div>
        <div class="text-xl font-bold flex flex-row gap-5 justify-center items-center">
            <p>Total Libras ingresdas en planta: </p>
            <input wire:model.lazy="totalLibrasPlantaIngresado" class="border p-3 w-full rounded-lg" type="number">
        </div>
    </div>

    <div class="mt-10 flex flex-col gap-5">
        
        <div class="flex flex-row gap-10 justify-between p-3 text-white font-bold rounded-xl shadow-xl">
            <table class="tabla">
                <thead class="bg-green-meadow">
                    <tr class="text-xs md:text-sm rounded uppercase">
                        <th scope="col" class="text-white">Codigo</th>
                        <th scope="col" class="text-white">Empleado</th>
                        <th scope="col" class="text-white">Fecha</th>
                        <th scope="col" class="text-white">Total de Libras Cosechadas</th>
                        <th scope="col" class="text-white">Porcentaje Respectivo</th>
                        <th scope="col" class="text-white">Monto Ganado</th>
                    </tr>
                </thead>
                <tbody class="tabla-body text-black">
                    @foreach ($asignaciones as $asignacion)
                    <tr>
                        <td>{{ $asignacion->codigo }}</td>
                        <td>{{ $asignacion->nombre }}</td>
                        <td class="text-center">{{ $asignacion->created_at->format('d-m-Y') }}</td>
                        <td class="text-center">{{ $asignacion->libras_asignacion }} lbs</td>
                        <td class="text-center">{{ round($asignacion->porcentaje,2) }} %</td>
                        <td class="text-center">Q {{ round($asignacion->monto_ganado,2) }}</td>
                    </tr>

                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <button class="btn bg-green-moss hover:bg-green-meadow mt-10" wire:click="$dispatch('registrar')">
        Guardar Registro
    </button>
</div>


@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    Livewire.on('registrar', () => {
        Livewire.dispatch('RegistrarLibras')
    });
</script>
@endpush