<div>
    @role('admin|adminagricola')
        <div class="flex justify-between flex-row items-center gap-10">
            <x-link-volver ruta="documentoOT" class="bg-orange-500 hover:bg-orange-600" />
            <i class="fa-solid fa-bars icon-link" wire:click='openModalFilters()'></i>
        </div>
    @endrole
    @forelse ($ordenes as $ot)
        <div class="mt-5 flex flex-col md:flex-row justify-between p-5 rounded-xl shadow-xl border-l-8 ">
            <div class="text-xs md:text-xl flex flex-col md:flex-row w-full justify-between">
                <div>
                    <x-label-component :label="'DOC NO'" :value="$ot->correlativo" />
                    <x-label-component :label="'NOMBRE DEL SOLICITANTE'" :value="$ot->nombre_solicitante" />
                    <x-label-component :label="'PLANTA'" :value="$ot->planta->name" />
                    <x-label-component :label="'ÁREA'" :value="$ot->area->area" />

                    @if ($ot->elemento_id)
                        <x-label-component :label="'UBICACIÓN'" :value="$ot->elemento->elemento" />
                    @endif

                    @if ($ot->especifique)
                        <x-label-component :label="'ÁREA ESPECIFICA'" :value="$ot->especifique" />
                    @endif

                    @if ($ot->equipo_problema)
                        <x-label-component :label="'EQUIPO CON PROBLEMA'" :value="$ot->equipo_problema" />
                    @endif


                    <x-label-component :label="'PROBLEMA'" :value="$ot->problema_detectado" />
                    <x-label-component :label="'FECHA DE CREACIÓN'" :value="$ot->created_at->diffForHumans()" />
                    <x-label-component :label="'FECHA PROPUESTA DE ENTREGA'" :value="$ot->fecha_propuesta->format('d-m-Y')" />

                    @if ($ot->estado_id != 5)
                        <x-label-component :label="'MECÁNICO ASIGNADO'" :value="$ot->mecanico_id ? $ot->usuario->name : 'No tiene mecánico asignado'" />
                        <x-label-component :label="'FECHA DE ASIGNACIÓN'" :value="$ot->fecha_asignacion
                            ? $ot->fecha_asignacion->format('d-m-Y h:m:s A')
                            : 'Sin fecha de asignación'" />
                    @endif


                    <div class="flex flex-col md:flex-row gap-2 my-5">
                        <x-tag :label="$estado->estado" class="{{ $labelEstado }}" />
                        @if ($ot->rechazada)
                            <x-tag :label="'Fue Rechazada'" class="bg-red-500" />
                        @endif

                        @if ($ot->fecha_propuesta < now()->format('Y-m-d') && $ot->estado_id != 3)
                            <x-tag :label="'ATRASADA'" class="bg-red-500" />
                        @elseif ($ot->fecha_propuesta == now()->format('Y-m-d') && $ot->estado_id != 3)
                            <x-tag :label="'SE ENTREGA EL DÍA DE HOY'" class="bg-blue-500" />
                        @endif
                    </div>
                </div>

                @if ($ot->estado_id != 5)
                    <div
                        class="flex md:flex-col flex-row justify-center md:justify-normal items-center bg-gray-200 shadow rounded md:p-5 p-1 gap-5">
                        <x-options-ordenes-trabajo :ot="$ot" />
                        @if ($ot->estado_id == 1 && !$ot->mecanico_id)
                            <i wire:click="asignarMecanicoModal({{ $ot }})" title="Asignar Mecánico"
                                class="fa-solid fa-person-circle-plus icon-link"></i>
                        @elseif ($ot->estado_id == 1 && $ot->mecanico_id)
                            @hasanyrole('admin|adminmanto')
                                <i wire:click='desasignarMecanico({{ $ot }})' title="Desasignar Mécanico"
                                class="fa-solid fa-person-circle-xmark icon-link"></i>
                            @endhasanyrole
                        @endif

                        @hasanyrole('admin|adminmanto')
                            @if ($ot->estado_id != 5)
                                @if (!$ot->weburl)
                                    <button type="button" class="icon-button" title="Eliminar Orden de Trabajo"
                                        wire:click="$dispatch('eliminar',{{ $ot->id }})">
                                        <i class="fa-solid fa-trash icon-link"></i>
                                    </button>
                                @endif
                            @endif


                            @if ($ot->estado_id == 2)
                                <a href="{{ route('documentoOT.show', $ot) }}">
                                    <i class="fa-solid fa-pen-to-square icon-link"></i>
                                </a>
                            @endif
                        @endhasanyrole
                    </div>
                @endif
            </div>
        </div>
    @empty
        <p class="text-center uppercase font-bold text-2xl">No existen ordenes de trabajo</p>
    @endforelse

    @if ($open)
        <livewire:mecanico-selector :ot="$otSelected" />
    @endif

    <x-ordenes-trabajo-filters class="{{ ($openFilters) ? 'slide-in-active slide-in' : 'slide-out-active-right' }}" />

    <div class="mt-10">
        {{ $ordenes->links() }}
    </div>
</div>

@push('scripts')
    <script>
        Livewire.on('eliminar', ot_id => {
            Swal.fire({
                title: 'Advertencia',
                text: `La orden de trabajo será eliminada permanentemente ¿Desea eliminar la orden de trabajo?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, continuar',
                cancelButtonText: 'No'
            }).then((result) => {
                Livewire.dispatch('eliminarOT', {
                    ot: ot_id
                });
            });
        });

        Livewire.on('tomarTrabajo', ot_id => {
            Swal.fire({
                title: 'Advertencia',
                text: `¿Esta seguro que desea tomar la orden? No podrá ser revertido solamente por el administrador`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, continuar',
                cancelButtonText: 'No'
            }).then((result) => {
                Livewire.dispatch('takeTrabajo', {
                    ot: ot_id
                });
            });
        });
    </script>
    </script>
@endpush
