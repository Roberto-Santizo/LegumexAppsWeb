<div>
    @foreach ($ordenes as $ot)
        <div class="mt-5 flex flex-col md:flex-row justify-between p-5 rounded-xl shadow-xl border-l-8 ">
            <div class="text-xs md:text-xl flex w-full justify-between">
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
                    <x-options-ordenes-trabajo :ot="$ot" />
                @endif
            </div>
        </div>
    @endforeach
</div>
