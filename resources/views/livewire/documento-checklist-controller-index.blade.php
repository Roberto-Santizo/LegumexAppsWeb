<div>
    <div>
        @role('admin|adminmanto')
        <div class="flex justify-end">
            <i class="fa-solid fa-bars icon-link" wire:click='openModal()'></i>
        </div>
        @endrole

        @can('create documentocp')
        <div class="mt-10">
            <x-link route="documentocp.select" text="Crear Documento" class="btn bg-orange-600 hover:bg-orange-800" />
        </div>
        @endcan

        @error('error')
        <x-alerta-error :message="$message" />
        @enderror
    </div>

     <div>
        <x-documentos-checklist-filter
            class="{{ ($isOpen) ? 'slide-in-active slide-in' : 'slide-out-active-right' }}" />
    </div>  

    <div class="overflow-x-auto mt-10 overflow-y-hidden">
        @if ($documentos->count() > 0)
        <table class="tabla">
            <thead class="tabla-head">
                <tr class="text-xs md:text-sm">
                    <th scope="col" class="encabezado">Planta</th>
                    <th scope="col" class="encabezado">Fecha</th>
                    <th scope="col" class="encabezado">Acción</th>
                    <th scope="col" class="encabezado">Ordenes de Trabajo relacionadas</th>
                    <th scope="col" class="encabezado">Empleado que lo Realizó</th>
                    <th scope="col" class="encabezado">Eliminar</th>
                </tr>
            </thead>
            <tbody class="tabla-body">
                @foreach ($documentos as $documento)
                <tr>
                    <td class="campo">{{ $documento->planta->name }}</td>
                    <td class="campo">{{ $documento->fecha }}</td>
                    @if ($documento->estado === 1)
                    <td class="px-4 py-2 whitespace-nowrap">
                        <a href="{{ route('documentocp.document', $documento) }}">
                            <i class="fa-solid fa-print icon-link"></i>
                        </a>
                    </td>
                    @elseif ($documento->estado === 2)
                    <td class="px-4 py-2 whitespace-nowrap">
                        <a href="{{ $documento->weburl }}" target="_blank">
                            <i class="fa-solid fa-file icon-link"></i>
                        </a>
                    </td>
                    @endif
                    <td>
                        <a href="{{ route('documentocp.showordeneschecklist', $documento) }}"
                            class="btn mb-2 bg-orange-500 hover:bg-orange-600 mt-2">Ver Ordenes de trabajo</a>
                    </td>
                    <td class="campo">
                        @if ($documento->user)
                            {{ $documento->user->name }}
                        @endif
                    </td>

                    @role('admin')
                    <td>
                        <i class="fa-solid fa-trash icon-link" wire:click="$dispatch('eliminar',{{ $documento }})"></i>
                    </td>
                    @endrole
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <p class="text-center text-xl">No existen documentos </p>
        @endif
    </div>

    <div class="my-10 flex justify-end w-full">
        {{ $documentos->links() }}
    </div>

    @push('scripts')
    <script>
        Livewire.on('eliminar', documento => {
            Swal.fire({
                    title: 'Advertencia',
                    text: `Una vez eliminado el registro no se podrá recuperar`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, continuar',
                    cancelButtonText: 'No'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.dispatch('eliminarDocumento',{documento});
                    }
                });
        });

        Livewire.on('documentoEliminado', () => {
            Swal.fire(
                'Listo!',
                'Checklist Preoperacional Eliminado',
                'success'
            );
        });
    </script>
    @endpush
</div>
