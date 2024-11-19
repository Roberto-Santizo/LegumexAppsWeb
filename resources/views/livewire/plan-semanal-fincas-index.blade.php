<div class="overflow-x-auto mt-10">
    <div class="flex justify-end my-5">
        @role('admin|adminagricola')
        <div class="flex justify-end">
            <i class="fa-solid fa-bars icon-link" wire:click='openModal()'></i>
        </div>
        @endrole

        <div class="max-w-sm">
            <x-plan-semanal-filtros class="{{ ($isOpen) ? 'slide-in-active slide-in' : 'slide-out-active-right' }}" />
        </div>
    </div>

    <table class="tabla">
        <thead class="tabla-head">
            <tr class="text-xs md:text-sm">
                <th scope="col" class="encabezado">
                    Estatus</th>
                <th scope="col" class="encabezado">
                    Finca</th>
                <th scope="col" class="encabezado">
                    Semana</th>
                <th scope="col" class="encabezado">
                    Año</th>
                <th scope="col" class="encabezado">
                    Fecha de Creación</th>
                @can('create plan semanal')
                <th scope="col" class="encabezado">
                    Control Presupueto</th>
                <th scope="col" class="encabezado">
                    Monto Extraordinario</th>
                @endcan

                <th scope="col" class="encabezado">
                    Control Tareas</th>
                <th scope="col" class="encabezado">
                    Control Tareas Cosecha</th>
                <th scope="col" class="encabezado text-center">
                    Tareas</th>
                {{-- <th scope="col" class="encabezado text-center">
                    Tareas Atrasadas</th> --}}

                @can('create plan semanal')
                <th scope="col" class="encabezado text-center">
                    Reporte General</th>
                <th scope="col" class="encabezado text-center">
                    Planilla Semanal</th>
                @endcan
            </tr>
        </thead>
        <tbody class="tabla-body">
            @forelse ($planes as $plansemanalfinca)
            <tr>
                <td class="campo">
                    @if ($plansemanalfinca->tareasRealizadas->count() === $plansemanalfinca->tareasTotales->count())
                    <i class="fa-solid fa-circle-check text-green-500 text-xl"
                        title="Todas las tareas fueron completada"></i>
                    @else
                    <i class="fa-solid fa-clock text-orange-500 text-xl"
                        title="Aún no han sido terminadas todas las tareas"></i>
                    @endif
                </td>
                <td class="campo">{{ $plansemanalfinca->finca->finca }}</td>
                <td class="campo">{{ $plansemanalfinca->semana }}</td>
                <td class="campo">{{ $plansemanalfinca->year }}</td>
                <td class="campo">{{ $plansemanalfinca->created_at->format('d-m-Y') }}</td>
                @can('create plan semanal')
                <td class="campo">Q {{ $plansemanalfinca->presupuesto_general_gastado }} / Q {{
                    $plansemanalfinca->presupuesto_general}}</td>
                <td class="campo">Q {{ $plansemanalfinca->presupuesto_extraordinario_gastado }} / Q {{
                    $plansemanalfinca->presupuesto_extraordinario}}</td>
                @endcan

                <td class="campo"> <span class="bg-sky-500 p-2 text-white rounded-xl">{{
                        $plansemanalfinca->tareasRealizadas->count() }} / {{ $plansemanalfinca->tareasTotales->count()
                        }}</span></td>
                <td class="campo"> <span class="bg-sky-500 p-2 text-white rounded-xl">{{
                        $plansemanalfinca->tareasCosechasTerminadas->count() }} /
                        {{$plansemanalfinca->tareasCosechaTotales->count() }}</span></td>
                <td class="campo">
                    <a class="btn bg-green-moss hover:bg-green-meadow"
                        href="{{ route('planSemanal.show',$plansemanalfinca) }}">
                        Ver Tareas Semanales
                    </a>
                </td>

                {{-- <td class="campo">
                    @if ($plansemanalfinca->tareasRealizadas->count() == 0 && $plansemanalfinca->semana < now()->
                        weekOfYear)
                        <a class="btn-red" href="{{ route('planSemanal.atrasadas',$plansemanalfinca) }}">
                            Ver Tareas Atrasadas
                        </a>
                        @endif
                </td> --}}

                @can('create plan semanal')
                <td class="campo text-center">
                    <a href="{{ route('reporte.PlanSemanal',$plansemanalfinca->id) }}">
                        <i title="Reporte Tareas Generales"
                            class="fa-solid fa-file-arrow-down text-3xl hover:text-gray-500 cursor-pointer"></i>
                    </a>
                </td>

                <td class="campo text-center">
                    <a href="{{ route('reporte.PlanillaSemanal',$plansemanalfinca->id) }}">
                        <i title="Planilla General Semanal"
                            class="fa-solid fa-file-arrow-down text-3xl hover:text-gray-500 cursor-pointer"></i>
                    </a>
                </td>
                @endcan
            </tr>
            @empty

            @endforelse
        </tbody>
    </table>

    @if ($planes->count() == 0)
    <div class="w-full flex justify-center items-center mt-10">
        <p class="text-3xl font-bold uppercase">No existen registros</p>
    </div>
    @endif

    <div class="mt-4">
        {{ $planes->links() }}
    </div>
</div>