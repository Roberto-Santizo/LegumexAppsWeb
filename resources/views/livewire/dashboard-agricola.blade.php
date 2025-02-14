<div>
    @php
        $color = '#186b1f';
    @endphp
    <div>
        @hasanyrole('admin|adminagricola')
            <div class="flex justify-end">
                <i class="fa-solid fa-bars icon-link" wire:click='openModal()'></i>
            </div>
            <x-dashboard-agricola-filters class="{{ $isOpen ? 'slide-in-active slide-in' : 'slide-out-active-right' }}" />
        @endhasanyrole
    </div>

    <div>
        <div class="mt-5 md:text-4xl text-xl flex flex-col gap-2 justify-center">
            <h2 class="uppercase font-bold">Semana en Presentación: {{ $semana_actual }} <span
                    class="text-sm">(calendario)</span></h2>
        </div>

        <div class="flex flex-col gap-5 xl:grid xl:grid-cols-12 mt-10 ">

            <div class="col-start-1 col-span-3 bg-green-moss rounded-2xl shadow-xl">
                <div class="bg-green-meadow w-full p-5 flex flex-row gap-2 items-center text-white rounded-t-2xl">
                    <h1 class="text-xl font-bold uppercase">Horas Dron Semanal</h1>
                </div>
                <div class="flex flex-col justify-center items-center p-5">
                    <x-dron-icon />
                    <p class="text-4xl text-white font-black">{{ $horasDron / 2 }} Horas</p>
                </div>
            </div>

            @can('create plan semanal')
                <div class=" col-start-4 col-span-4 bg-green-moss rounded-2xl shadow-xl">
                    <div class="bg-green-meadow w-full p-5 flex flex-row gap-2 items-center text-white rounded-t-2xl">
                        <h1 class="text-xl font-bold uppercase">Descarga de Reporteria</h1>
                    </div>

                    <div class="bg-white flex flex-row gap-5 justify-center items-center shadow-xl p-3 my-5 mx-5">
                        <p class="font-bold uppercase text-sm">Control de Presupuesto de Semana {{ $semana_actual }}</p>
                        <div class="flex justify-center items-center">
                            <a href="{{ route('reporte.ControlPresupuesto', $semana_actual) }}">
                                <i title="Control de presupuesto"
                                    class="fa-solid fa-file-arrow-down text-3xl hover:text-gray-500 cursor-pointer"></i>
                            </a>
                        </div>
                    </div>


                    <div class="p-2 h-96 overflow-y-auto">
                        <table class="tabla">
                            <thead class="bg-green-meadow">
                                <tr class="text-xs md:text-sm rounded">
                                    <th scope="col" class="text-white">Finca</th>
                                    <th scope="col" class="text-white">Semana</th>
                                    <th scope="col" class="text-white">Tareas Generales</th>
                                    <th scope="col" class="text-white">Planilla Semanal</th>
                                </tr>
                            </thead>
                            <tbody class="tabla-body">
                                @foreach ($planes as $plan)
                                    <tr>
                                        <td class="campo">{{ $plan->finca->finca }}</td>
                                        <td class="campo">{{ $plan->semana }}</td>
                                        <td>
                                            <div class="flex justify-center items-center">
                                                <a href="{{ route('reporte.PlanSemanal', $plan->id) }}">
                                                    <i title="Reporte Tareas Generales"
                                                        class="fa-solid fa-file-arrow-down text-3xl hover:text-gray-500 cursor-pointer"></i>
                                                </a>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="flex justify-center items-center">
                                                <a href="{{ route('reporte.PlanillaSemanal', $plan->id) }}">
                                                    <i title="Planilla General Semanal"
                                                        class="fa-solid fa-file-arrow-down text-3xl hover:text-gray-500 cursor-pointer"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endcan

            @can('create plan semanal')
                <div class=" col-start-8 col-span-5 bg-green-moss rounded-2xl shadow-xl">
                    <div class="bg-green-meadow w-full p-5 flex flex-row gap-2 items-center text-white rounded-t-2xl">
                        <h1 class="text-xl font-bold uppercase">Planes Semanales Acciones</h1>
                    </div>

                    <div class="grid grid-cols-3 lg:flex lg:flex-row lg:items-center lg:flex-wrap gap-5 p-5">
                        <a href="{{ route('planSemanal.create') }}"
                            class="flex flex-col justify-between items-center hover:bg-green-meadow rounded-xl lg:p-5 grow-animation-sm">
                            <x-circle-plus :color="$color" />
                            <p class="text-sm text-center font-bold uppercase text-white">Crear Plan Semanal</p>
                        </a>
                        <a href="{{ route('planSemanal.tareaLote.create') }}"
                            class="flex flex-col justify-between items-center hover:bg-green-meadow rounded-xl lg:p-5 grow-animation-sm">
                            <x-circle-plus :color="$color" />
                            <p class="text-sm text-center font-bold uppercase text-white">Crear Tarea</p>
                        </a>

                        <a href="{{ route('planSemanal.tareaLote.create') }}"
                            class="flex flex-col justify-between items-center hover:bg-green-meadow rounded-xl lg:p-5 grow-animation-sm">
                            <x-circle-plus :color="$color" />
                            <p class="text-sm text-center font-bold uppercase text-white">Crear Tarea Ext</p>
                        </a>
                    </div>

                </div>
            @endcan

            <div class=" col-start-1 col-span-5 row-start-2 bg-green-moss rounded-2xl shadow-xl">
                <div class="bg-green-meadow w-full p-5 flex flex-row gap-2 items-center text-white rounded-t-2xl">
                    <h1 class="text-xl font-bold uppercase">Resumen de Horas Por Empleado Semana {{ $semana_actual }}</h1>
                </div>

                <div class="p-2 h-96 overflow-y-auto">
                    <table class="tabla">
                        <thead class="bg-green-meadow">
                            <tr class="text-xs md:text-sm rounded">
                                <th scope="col" class="text-white">Codigo</th>
                                <th scope="col" class="text-white">Empleado</th>
                                <th scope="col" class="text-white">Total de Horas</th>
                                <th scope="col" class="text-white">Activo</th>
                            </tr>
                        </thead>
                        <tbody class="tabla-body">
                            @foreach ($usuarios as $usuario)
                                <tr>
                                    <td class="campo">{{ $usuario->last_name }}</td>
                                    <td class="campo">{{ $usuario->first_name }}</td>
                                    <td class="campo">{{ $usuario->horas_totales }}
                                        @choice('hora|horas', $usuario->horas_totales)</td>
                                    <td class="campo">
                                        @if ($usuario->activo)
                                            <i class="fa-solid fa-circle-check text-md text-green-300"></i>
                                        @else
                                            <i class="fa-solid fa-circle-xmark text-md"></i>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class=" col-start-6 col-span-7 bg-green-moss rounded-2xl shadow-xl">
                <div class="bg-green-meadow w-full p-5 flex flex-row gap-2 items-center text-white rounded-t-2xl">
                    <h1 class="text-xl font-bold uppercase">Control de tareas</h1>
                </div>

                <div class="flex flex-col gap-5 p-5 text-xs md:text-xl">
                    @forelse ($planes as $plan)
                        <a href="{{ route('planSemanal.show', $plan) }}"
                            class="flex flex-row gap-5 font-bold text-white bg-green-meadow p-3 rounded-xl justify-between shadow-xl grow-animation-sm">
                            <p>{{ $plan->finca->finca }} - Semana {{ $plan->semana }} </p>
                            <div class="flex flex-row gap-2 justify-center items-center">

                                <p class="uppercase">Tareas Completadas:
                                    {{ $plan->tareasRealizadas->count() }}/{{ $plan->tareasTotales->count() }}</p>

                                @if ($plan->tareasRealizadas->count() === $plan->tareasTotales->count())
                                    <i title="La tarea fue realizada"
                                        class="fa-solid fa-circle-check text-2xl text-green-300"></i>
                                @endif
                            </div>
                        </a>
                    @empty
                        <p class="text-center font-bold text-white uppercase">Aún no existen planes para esta semana
                        </p>
                    @endforelse
                </div>

            </div>


            <div class=" col-start-1 col-span-12 bg-green-moss rounded-2xl shadow-xl">
                <div class="bg-green-meadow w-full p-5 flex flex-row gap-2 items-center text-white rounded-t-2xl">
                    <h1 class="text-xl font-bold uppercase">Control de Tareas en Proceso y Asignaciones</h1>
                </div>

                <div class="flex flex-col gap-5 p-5 text-xs md:text-xl">
                    @forelse ($tareasEnProceso as $tareaEnProceso)
                        @php
                            $icon = !$tareaEnProceso->cierreParcialActivo->isEmpty()
                                ? 'fa-solid fa-circle-play'
                                : 'fa-solid fa-clock';
                        @endphp
                        <a href="{{ route('planSemanal.tareaLote.show', $tareaEnProceso) }}"
                            class="flex flex-row gap-5 font-bold text-white bg-green-meadow p-3 rounded-xl justify-between shadow-xl grow-animation-sm">
                            <div class="flex flex-row gap-5">
                                <i class="{{ $icon }} text-orange-500 text-2xl"></i>
                                <p>Tarea: {{ $tareaEnProceso->tarea->tarea }} -
                                    {{ $tareaEnProceso->plansemanal->finca->finca }}
                                    - {{ $tareaEnProceso->lote->nombre }}
                                    - S{{ $tareaEnProceso->plansemanal->semana }}</p>

                            </div>

                            @if ($tareaEnProceso->asignacion->use_dron)
                                <div
                                    class="bg-orange-500 text-white font-bold flex justify-center p-1 items-center rounded">
                                    <iconify-icon icon="hugeicons:drone" class="text-3xl"></iconify-icon>
                                </div>
                            @else
                                <p>Usuarios Asignados: {{ $tareaEnProceso->users->count() }} /
                                    {{ $tareaEnProceso->personas }}</p>
                            @endif
                        </a>
                    @empty
                        <p class="text-center font-bold text-white uppercase">No hay tareas en proceso</p>
                    @endforelse
                </div>
            </div>

            <div class=" col-start-1 col-span-12 bg-green-moss rounded-2xl shadow-xl">
                <div class="bg-green-meadow w-full p-5 flex flex-row gap-2 items-center text-white rounded-t-2xl">
                    <h1 class="text-xl font-bold uppercase">Control de Tareas Terminadas</h1>
                </div>

                <div class="p-2 h-auto overflow-y-auto">
                    @if ($tareasRealizadasEnSemana->count() > 0)
                        <table class="tabla">
                            <thead class="tabla-head">
                                <tr class="text-xs md:text-sm">
                                    <th scope="col" class="encabezado"></th>
                                    <th scope="col" class="encabezado">Tarea</th>
                                    <th scope="col" class="encabezado">Finca</th>
                                    <th scope="col" class="encabezado">Lote</th>
                                    <th scope="col" class="encabezado">Fecha Inicio</th>
                                    <th scope="col" class="encabezado">Fecha Cierre</th>
                                    <th scope="col" class="encabezado">Semana</th>
                                    <th scope="col" class="encabezado">Acción</th>
                                </tr>
                            </thead>
                            <tbody class="tabla-body">
                                @foreach ($tareasRealizadasEnSemana as $tareaTerminada)
                                    <tr>
                                        <td class="text-center">
                                            <i title="La tarea fue realizada"
                                                class="fa-solid fa-circle-check text-2xl text-green-500"></i>
                                        </td>
                                        <td class="campo">{{ $tareaTerminada->tarea->tarea }}</td>
                                        <td class="campo">{{ $tareaTerminada->plansemanal->finca->finca }}</td>
                                        <td class="campo">{{ $tareaTerminada->lote->nombre }}</td>
                                        <td class="campo">
                                            {{ $tareaTerminada->asignacion->created_at->format('d-m-Y h:m:s A') }}</td>
                                        <td class="campo">
                                            {{ $tareaTerminada->cierre->created_at->format('d-m-Y h:m:s A') }}</td>
                                        <td class="campo">{{ $tareaTerminada->plansemanal->semana }}</td>
                                        <td class="campo">
                                            <a href="{{ route('planSemanal.tareaLote.show', $tareaTerminada) }}"
                                                target="_blank">
                                                <i class="fa-solid fa-eye text-2xl hover:text-gray-500"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="text-center font-bold text-white uppercase">No hay tareas terminadas de esta semana
                        </p>
                    @endif

                </div>
            </div>

            <div class=" col-start-1 col-span-12 bg-green-moss rounded-2xl shadow-xl">
                <div class="bg-green-meadow w-full p-5 flex flex-row gap-2 items-center text-white rounded-t-2xl">
                    <h1 class="text-xl font-bold uppercase">Control de Cosechas</h1>
                </div>

                <div class="flex flex-col gap-5 p-5 text-xs md:text-xl">
                    @forelse ($tareasCosecha as $tareacosecha)
                        @foreach ($tareacosecha->asignaciones as $asignacion)
                            @if ($asignacion && !$asignacion->cierre)
                                <a href="{{ route('planSemanal.tareaLoteCosecha.show', $tareacosecha) }}"
                                    target="_blank"
                                    class="flex flex-row gap-5 font-bold text-white bg-green-meadow p-3 rounded-xl justify-between shadow-xl grow-animation-sm">
                                    <div class="flex flex-row gap-5">
                                        <i class="fa-solid fa-clock text-orange-500 text-xl"
                                            title="Aún no han sido terminadas todas las tareas"></i>
                                        <p>Tarea: {{ $tareacosecha->tarea->tarea }} -
                                            {{ $tareacosecha->lote->nombre }} -
                                            {{ $tareacosecha->plansemanal->finca->finca }} -
                                            S{{ $tareacosecha->plansemanal->semana }}
                                            - {{ $asignacion->created_at->format('d-m-Y') }}</p>
                                    </div>
                                    <p>Usuarios Asignados:
                                        {{ $tareacosecha->users()->whereDate('created_at', $asignacion->created_at)->count() }}
                                    </p>
                                </a>
                            @endif
                        @endforeach
                    @empty
                        <p class="text-center font-bold text-white uppercase">No existen cosechas activas</p>
                    @endforelse
                </div>
            </div>

            <div class=" col-start-1 col-span-12 bg-green-moss rounded-2xl shadow-xl">
                <div class="bg-green-meadow w-full p-5 flex flex-row gap-2 items-center text-white rounded-t-2xl">
                    <h1 class="text-xl font-bold uppercase">Control de Cosecha Terminadas</h1>
                </div>

                <div class="flex flex-col gap-5 p-5 text-xs md:text-xl">
                    @if ($tareasCosecha->count() > 0)
                        <table class="tabla">
                            <thead class="tabla-head">
                                <tr class="text-xs md:text-sm">
                                    <th scope="col" class="encabezado"></th>
                                    <th scope="col" class="encabezado">Tarea</th>
                                    <th scope="col" class="encabezado">Finca</th>
                                    <th scope="col" class="encabezado">Lote</th>
                                    <th scope="col" class="encabezado">Semana</th>
                                    <th scope="col" class="encabezado">Fecha</th>
                                    <th scope="col" class="encabezado">Acción</th>
                                </tr>
                            </thead>
                            <tbody class="tabla-body">
                                @foreach ($tareacosecha->asignaciones as $asignacion)
                                    @if ($asignacion && $asignacion->cierre)
                                        <tr>
                                            <td class="text-center">
                                                <i title="La tarea fue realizada"
                                                    class="fa-solid fa-circle-check text-2xl text-green-500"></i>
                                            </td>
                                            <td class="campo">{{ $tareacosecha->tarea->tarea }}</td>
                                            <td class="campo">{{ $tareacosecha->plansemanal->finca->finca }}</td>
                                            <td class="campo">{{ $tareacosecha->lote->nombre }}</td>
                                            <td class="campo">{{ $tareacosecha->plansemanal->semana }}</td>
                                            <td class="campo">{{ $asignacion->created_at->format('d-m-Y') }}</td>
                                            <td class="campo">
                                                <a href="{{ route('planSemanal.tareaCosechaResumen', $tareacosecha) }}"
                                                    target="_blank">
                                                    <i class="fa-solid fa-eye text-2xl hover:text-gray-500"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="text-center font-bold text-white uppercase">No existen cosechas terminadas esta semana</p>
                    @endif

                </div>
            </div>
        </div>
    </div>

</div>
