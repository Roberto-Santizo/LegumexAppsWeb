<div>
    <div>
        @role('admin|adminmanto')
            <div class="flex justify-end">
                <i class="fa-solid fa-bars icon-link" wire:click='openModal()'></i>
            </div>
        @endrole

        @can('create documentold')
            <div class="mt-10">
                <x-link route="documentold.create" text="Crear Documento" icon="fa-solid fa-plus"
                    class="btn bg-orange-600 hover:bg-orange-800" />
            </div>
        @endcan

        <div id="FiltrosBtn" class="mt-10 md:hidden btn bg-orange-600 hover:bg-orange-800">
            <i class="fa-solid fa-plus"></i>
            Filtros
        </div>
    </div>

    <div>
        <x-documentos-lavado-filter class="{{ $isOpen ? 'slide-in-active slide-in' : 'slide-out-active-right' }}" />
    </div>

    <div class="flex" id="filtros">
        <div class="overflow-x-auto mt-10 w-full col-span-5">
            @if ($documentos->count() > 0)
                <table class="tabla">
                    <thead class="tabla-head">
                        <tr class="text-xs md:text-sm">
                            <th scope="col" class="encabezado">Técnico de mantenimiento</th>
                            <th scope="col" class="encabezado">Planta</th>
                            <th scope="col" class="encabezado">Área</th>
                            <th scope="col" class="encabezado">Fecha</th>
                            <th scope="col" class="encabezado">Acción</th>
                            @role('admin|adminmanto')
                                <th scope="col" class="encabezado">Eliminar</th>
                            @endrole

                        </tr>
                    </thead>
                    <tbody class="tabla-body">
                        @foreach ($documentos as $documento)
                            <tr>
                                <td class="campo">{{ $documento->tecnico_mantenimiento }}</td>
                                <td class="campo">{{ $documento->planta->name }}</td>
                                <td class="campo">{{ $documento->area->area }}</td>
                                <td class="campo">{{ $documento->fecha }}</td>

                                @if ($documento->estado === 0)
                                    <td class="px-4 py-2 whitespace-nowrap ">
                                        @can('create documentold')
                                            <a href="{{ route('documentold.edit', $documento) }}">
                                                <i class="fa-solid fa-pen-to-square icon-link"></i>
                                            </a>
                                        @endcan
                                    </td>
                                @elseif ($documento->estado === 1)
                                    <td class="px-4 py-2 whitespace-nowrap">
                                        @can('create documentold')
                                            <a href="{{ route('documentold.document', $documento) }}">
                                                <i class="fa-solid fa-print icon-link"></i>
                                            </a>
                                        @endcan
                                    </td>
                                @elseif ($documento->estado === 2)
                                    <td class="px-4 py-2 whitespace-nowrap">
                                        <a href="{{ $documento->weburl }}" target="_blank">
                                            <i class="fa-solid fa-file icon-link"></i>
                                        </a>
                                    </td>
                                @endif

                                @role('admin')
                                    <td>
                                        <i class="fa-solid fa-trash icon-link"
                                            wire:click="$dispatch('eliminar',{{ $documento }})"></i>
                                    </td>
                                @endrole
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-center text-xl">No existen documentos</p>
            @endif


            <div class="my-10 flex justify-end w-full">
                {{ $documentos->links() }}
            </div>
        </div>

    </div>
</div>

@push('scripts')
    <script>
        Livewire.on('eliminar', documento => {
            Swal.fire({
                title: 'Advertencia',
                text: `Una vez eliminado el registro no se podrá recurperar`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, continuar',
                cancelButtonText: 'No'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.dispatch('eliminarDocumento', {
                        documento
                    });

                    Swal.fire(
                        'Listo!',
                        'Orden de trabajo eliminada',
                        'success'
                    )
                }
            });
        });
    </script>
@endpush
