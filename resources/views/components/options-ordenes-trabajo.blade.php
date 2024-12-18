<div class="flex md:flex-col flex-row gap-5 items-center justify-around">
    @if (!$ot->weburl)
        <i class="text-2xl fa-sharp fa-solid fa-circle-exclamation {{ $priority }}"></i>
    @endif

    <a href="{{ $ot->folder_url }}" target="_blank">
        <i class="fa-solid fa-image text-2xl hover:text-gray-500"></i>
    </a>

    @if (!$ot->mecanico_id)
        <i title="Tomar Trabajo" class="fa-solid fa-user-plus icon-link" wire:click="$dispatch('tomarTrabajo',{{ $ot->id }})"></i>
    @endif

    @if ($ot->mecanico_id)
        @if ($ot->mecanico_id == auth()->user()->id && $ot->estado_id == 1)
            <a href="{{ route('documentoOT.show', $ot) }}">
                <i class="fa-solid fa-pen-to-square text-2xl hover:text-gray-500"></i>
            </a>
        @endif
    @endif

    @if ($ot->weburl)
        <td class="px-4 py-4 whitespace-nowrap ">
            <a href="{{ $ot->weburl }}" target="_blank">
                <i class="fa-solid fa-file text-2xl hover:text-gray-500"></i>
            </a>
        </td>
    @else
        @if ($ot->estado_id == 3)
            <td class="px-4 py-4 whitespace-nowrap ">
                <a title="Generar Archivo" href="{{ route('documentoOT.documento', $ot) }}">
                    <i class="fa-solid fa-folder-plus text-xl hover:text-red-500"></i>
                </a>
            </td>
        @endif
    @endif
</div>
