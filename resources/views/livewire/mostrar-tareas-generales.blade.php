<div>
    <div class="my-5 flex justify-end">
        <form wire:submit.prevent='buscar' class="flex flex-row gap-5 justify-center items-center">
            <div>
                <input type="text" class="p-2 border w-64" placeholder="Nombre de la tarea" wire:model='nombre_tarea'>
            </div>

            <x-boton-buscador />
        </form>
    </div>
    <div class="flex justify-end gap-5">
        <x-link class="bg-green-moss hover:bg-green-meadow" route="tareas.create" text="Crear Tarea" />
        <x-link class="bg-green-moss hover:bg-green-meadow" route="tareas.carga" text="Carga Masiva de Tareas" />
    </div>
    <div class="overflow-x-auto mt-10">
        <table class="tabla">
            <thead class="tabla-head">
                <tr class="text-xs md:text-sm">
                    <th scope="col" class="encabezado text-left">
                        Nombre de la Tarea</th>
                    <th scope="col" class="encabezado text-left">
                        Codigo</th>
                    <th scope="col" class="encabezado text-center">
                        Acciones</th>
                </tr>

            </thead>
            <tbody class="tabla-body">
                @foreach ($tareas as $tarea)
                <tr>
                    <td class="campo">{{ $tarea->tarea }}</td>
                    <td class="campo">{{ $tarea->code }}</td>

                    <td class="campo flex flex-row gap-5">
                        <a href="{{ route('tareas.edit',$tarea) }}">
                            <i class="fa-solid fa-pen icon-link"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="my-10">
        {{ $tareas->links() }}
    </div>
</div>