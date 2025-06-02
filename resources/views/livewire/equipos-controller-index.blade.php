<div>
    @role('admin|adminmanto')
        <div class="flex justify-end flex-row items-center gap-10 mt-5">
            <i class="fa-solid fa-bars icon-link" wire:click='openModalFilters()'></i>
        </div>
    @endrole
    <div class="mt-10 overflow-x-auto">
        <table class="tabla min-w-full">
            <thead class="tabla-head">
                <tr class="text-xs md:text-sm">
                    <th scope="col" class="encabezado">Equipo</th>
                    <th scope="col" class="encabezado">Codigo</th>
                    <th scope="col" class="encabezado">Modelo</th>
                    <th scope="col" class="encabezado">Serie</th>
                    <th scope="col" class="encabezado">Área</th>
                    <th scope="col" class="encabezado">Planta</th>
                    <th scope="col" class="encabezado">Estado</th>
                    <th scope="col" class="encabezado">Acciones</th>
                </tr>
            </thead>
            <tbody class="tabla-body">
                @foreach ($equipos as $equipo)
                <tr>
                    <td class="campo">{{ $equipo->code }}</td>
                    <td class="campo">{{ $equipo->name }}</td>
                    <td class="campo">{{ $equipo->serie }}</td>
                    <td class="campo">{{ $equipo->modelo }}</td>
                    <td class="campo">
                        {{ $equipo->area->area }}
                    </td>
                    <td class="campo">
                        {{ $equipo->area->planta->name }}
                    </td>
                    <td class="campo">
                        <button class="btn {{ $equipo->status ? 'bg-green-500' : 'bg-red-500' }}">{{ $equipo->status ? 'ACTIVO' : 'INACTIVO' }}</button>
                    </td>
                    <td class="flex gap-5">
                        <a href="{{ route('equipos.show',$equipo) }}">
                            <i class="fa-solid fa-eye icon-link" title="Ver ficha del equipo"></i>
                        </a>

                        <a href="{{ route('equipos.edit',$equipo) }}">
                            <i class="fa-solid fa-pen-to-square icon-link" title="Editar ficha del equipo"></i>
                        </a>
                    </td>
                </tr>
                @endforeach 
            </tbody>
        </table>
        <div class="mt-10">
            {{ $equipos->links() }}
        </div>
    </div>

    <x-equipos-filter class="{{ ($openFilters) ? 'slide-in-active slide-in' : 'slide-out-active-right' }}" />
</div>
