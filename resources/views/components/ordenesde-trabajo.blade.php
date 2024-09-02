<div>
    @foreach ($ots as $ot)
    <div class="mt-5 flex flex-col md:flex-row justify-between p-5 rounded-xl shadow-xl border-l-8 ">
        <div class="text-xs md:text-xl">
            <p><span class="uppercase font-bold">Nombre del solicitante:</span> {{ $ot->nombre_solicitante }}</p>
            <p><span class="uppercase font-bold">Planta:</span> {{ $ot->planta->name }}</p>
            <p><span class="uppercase font-bold">Area:</span> {{ $ot->area->area }}</p>
            @if ($ot->elemento_id)
            <p><span class="uppercase font-bold">Ubicacion:</span> {{ $ot->elemento->elemento }}</p>
            @endif

            @if($ot->especifique)
            <p><span class="uppercase font-bold">Área especifica:</span> {{ $ot->especifique }}</p>
            @endif

            @if($ot->equipo_problema)
            <p><span class="uppercase font-bold">Equipo con problema:</span> {{ ($ot->equipo_problema) }}</p>
            @endif

            <p><span class="uppercase font-bold">Problema:</span> {{ $ot->problema_detectado }}</p>
            <p><span class="uppercase font-bold">Fecha de creacion:</span> {{ $ot->created_at->diffForHumans(); }}</p>
            <p><span class="uppercase font-bold">Fecha propuesta de entrega:</span> {{
                \Illuminate\Support\Carbon::parse($ot->fecha_propuesta)->format('d-m-Y'); }}</p>

            @if ($ot->estado_id != 5)
            <p><span class="uppercase font-bold">Mecánico Asignado:</span> {{ ($ot->mecanico_id) ? $ot->usuario->name :
                'No tiene mecánico asignado' }}</p>
            <p><span class="uppercase font-bold">Fecha de asignación:</span> {{ ($ot->fecha_asignacion) ?
                \Illuminate\Support\Carbon::parse($ot->fecha_asignacion)->format('d-m-Y') : 'Sin fecha de asignación' }}
            </p>
            @endif

            <p class="uppercase font-bold mt-5 block">Estado: <span
                    class="text-white p-2 rounded-lg  {{ ($ot->estado_id === 1) ? 'bg-yellow-500' : (($ot->estado_id === 2) ? 'bg-orange-500' : (($ot->estado_id === 3) ? 'bg-green-500' : 'bg-red-500')) }}">{{
                    $ot->estado->estado }}</span></p>

            <div class="flex flex-col md:flex-row gap-2 my-5">
                <div>
                    @if($ot->rechazada)
                    <p class="text-white p-2 rounded-lg bg-red-500 uppercase font-bold inline-block">Fue rechazada</p>
                    @endif
                </div>

                <div>
                    @if (($ot->fecha_propuesta < \Carbon\Carbon::now()->format('Y-m-d') && $ot->estado_id != 3))
                        <p class=" bg-red-500 inline-block p-2 font-bold text-white rounded">ATRASADA</p>
                    @elseif (($ot->fecha_propuesta == \Carbon\Carbon::now()->format('Y-m-d') && $ot->estado_id != 3))
                        <p class=" bg-blue-500 inline-block p-2 font-bold text-white rounded">SE ENTREGA EL DÍA DE HOY</p>
                    @endif
                </div>
            </div>
        </div>

        @if($ot->estado_id != 5)
        <div>
            <div
                class="bg-gray-200 p-1 md:p-5 rounded-lg shadow md:ml-5 flex md:flex-col flex-row gap-5 items-center justify-around w-full  md:w-min">
                
              

                @if (!($ot->weburl))
                <i title="{{ ($ot->urgencia == 1) ? 'ALTA' : (($ot->urgencia==2) ? 'MODERADA' : 'BAJA') }}"
                    class="text-2xl fa-sharp fa-solid fa-circle-exclamation {{ ($ot->urgencia == 1) ? 'text-red-500' : (($ot->urgencia==2) ? 'text-yellow-500' : 'text-green-500') }}"></i>
                @endif
                
                <a href="{{ $ot->folder_url }}" target="_blank">
                    <i class="fa-solid fa-image text-2xl hover:text-gray-500"></i>
                </a>

                @if(!$ot->mecanico_id)
                @role('auxmanto')
                <livewire:asignar-mecanico :ot="$ot" />
                @endrole
                @endif

                @if($ot->mecanico_id)
                @if(($ot->mecanico_id == auth()->user()->id && $ot->estado_id == 1))
                <a href="{{ route('documentoOT.show',$ot) }}">
                    <i class="fa-solid fa-pen-to-square text-2xl hover:text-gray-500"></i>
                </a>
                @endif
                @endif

                @if($ot->weburl)
                <td class="px-4 py-4 whitespace-nowrap ">
                    <a href="{{ $ot->weburl }}" target="_blank">
                        <i class="fa-solid fa-file text-2xl hover:text-gray-500"></i>
                    </a>
                </td>
                @else
                    @if ($ot->estado_id == 3)
                        @hasanyrole('admin|adminmanto')
                            <td class="px-4 py-4 whitespace-nowrap ">
                                <a title="Generar Archivo" href="{{ route('documentoOT.documento',$ot) }}">
                                    <i class="fa-solid fa-folder-plus text-xl hover:text-red-500"></i>
                                </a>
                            </td>
                        @endhasanyrole
                    @endif
                @endif

                @hasanyrole('admin|adminmanto')
                    @if ($ot->estado_id == 1)
                        <livewire:mecanico-selector :ot="$ot" />
                    @endif

                    @if($ot->estado_id != 5)
                        @if(!($ot->weburl))
                            <form class="delete-ot" id="deleteForm" action="{{ route('documentoOT.destroy', $ot) }}"
                                method="POST">
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="icon-button" title="Eliminar Orden de Trabajo">
                                    <i class="fa-solid fa-trash icon-link"></i>
                                </button>
                            </form>
                        @endif
                    @endif

                    
                    @if ($ot->estado_id == 2)
                    <a href="{{ route('documentoOT.show',$ot) }}">
                        <i class="fa-solid fa-pen-to-square icon-link"></i>
                    </a>
                    @endif

                @endhasanyrole
            </div>
        </div>
        @endif
    </div>
    @endforeach
</div>