<div>

    <div class="flex justify-end flex-col gap-5">
        @role('admin|adminmanto')
        <div class="flex justify-end">
            <i class="fa-solid fa-bars icon-link" wire:click='openModal()'></i>
        </div>
        @endrole
        <x-link class="bg-orange-600 hover:bg-orange-800" route="areas.create" text="Crear Área" />
    </div>


    <div>
        <x-areas-ubicaciones-filter class="{{ ($isOpen) ? 'slide-in-active slide-in' : 'slide-out-active-right' }}" />
    </div>

    <div class="mt-10">
        <table class="tabla">
            <thead class="tabla-head">
                <tr class="text-xs md:text-sm">
                    <th scope="col" class="encabezado">Área</th>
                    <th scope="col" class="encabezado">Planta</th>
                    <th scope="col" class="encabezado">Ver</th>
                </tr>
            </thead>
            <tbody class="tabla-body">
                @foreach ($areas as $area)
                <tr>
                    <td class="campo">{{ $area->area }}</td>
                    <td class="campo">{{ $area->planta->name }}</td>
                    <td class="campo">
                        <a href="{{ route('areas.show',$area) }}">
                            <iconify-icon icon="mdi:eye" class="icon-link"></iconify-icon>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="my-10">
        {{ $areas->links() }}
    </div>
</div>