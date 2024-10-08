@extends('layouts.agricola')

@section('titulo')
Dashboard Agricola
@endsection

@section('contenido')
<div class="flex flex-col gap-5 xl:grid xl:grid-cols-8 mt-10">
    <div
        class="flex flex-col justify-center items-center col-start-1 col-span-2 bg-green-moss rounded-lg p-4 shadow-2xl text-gray-600 text-md">
        <div>
            <svg width="400" height="200" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                <g id="SVGRepo_iconCarrier">
                    <circle cx="12" cy="9" r="3" stroke="#598234" stroke-width="1.5"></circle>
                    <circle cx="12" cy="12" r="10" stroke="#598234" stroke-width="1.5"></circle>
                    <path d="M17.9691 20C17.81 17.1085 16.9247 15 11.9999 15C7.07521 15 6.18991 17.1085 6.03076 20"
                        stroke="#598234" stroke-width="1.5" stroke-linecap="round"></path>
                </g>
            </svg>
        </div>
        <p class="font-bold">{{ auth()->user()->name }}</p>
        <p class="font-bold">{{ auth()->user()->getRoleNames()->first() }}</p>
        <p class="font-bold">{{ auth()->user()->email }}</p>
    </div>

    @can('create plan semanal')
        <div class=" col-start-3 col-span-3 bg-green-moss rounded-2xl shadow-xl">
            <div class="bg-green-meadow w-full p-5 flex flex-row gap-2 items-center text-white rounded-t-2xl">
                <h1 class="text-2xl font-bold">Descarga de Reporteria</h1>
            </div>

            <div class="bg-white flex flex-row gap-5 justify-center items-center shadow-xl p-3 my-5 mx-5">
                <p class="font-bold uppercase text-sm">Control de Presupuesto de Semana {{  $semana_actual }}</p>
                <div  class="flex justify-center items-center">
                    <a href="{{ route('reporte.ControlPresupuesto') }}">
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
                                    <a href="{{ route('reporte.PlanSemanal',$plan->id) }}">
                                        <i title="Reporte Tareas Generales"
                                            class="fa-solid fa-file-arrow-down text-3xl hover:text-gray-500 cursor-pointer"></i>
                                    </a>
                            </div>
                            </td>
                            <td>
                            <div class="flex justify-center items-center">
                                    <a href="{{ route('reporte.PlanillaSemanal',$plan->id) }}">
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
        <div class=" col-start-6 col-span-3 bg-green-moss rounded-2xl shadow-xl">
            <div class="bg-green-meadow w-full p-5 flex flex-row gap-2 items-center text-white rounded-t-2xl">
                <h1 class="text-2xl font-bold">Planes Semanales Acciones</h1>
            </div>

            <div class="grid grid-cols-3 lg:flex lg:flex-row lg:items-center lg:flex-wrap gap-5 p-5">
                <a href="{{ route('planSemanal.create') }}"
                    class="flex flex-col justify-between items-center hover:bg-green-600 rounded-xl lg:p-5 grow-animation-sm">
                    <svg width="100" height="50" viewBox="0 -0.5 17 17" version="1.1" xmlns="http://www.w3.org/2000/svg"
                        xmlns:xlink="http://www.w3.org/1999/xlink" class="si-glyph si-glyph-circle-plus" fill="#000000">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <title>933</title>
                            <defs> </defs>
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <path
                                    d="M9.021,0.097 C4.625,0.097 1.063,3.655 1.063,8.04 C1.063,12.428 4.625,15.985 9.021,15.985 C13.416,15.985 16.979,12.427 16.979,8.04 C16.979,3.654 13.415,0.097 9.021,0.097 L9.021,0.097 Z M11.325,9.082 L10.088,9.082 L10.088,10.319 C10.088,11.298 10.147,12.088 9,12.088 C7.856,12.088 7.912,11.298 7.912,10.319 L7.912,9.082 L6.675,9.082 C5.696,9.082 4.906,9.138 4.906,7.994 C4.906,6.848 5.696,6.906 6.675,6.906 L7.912,6.906 L7.912,5.669 C7.912,4.69 7.856,3.9 9,3.9 C10.146,3.9 10.088,4.69 10.088,5.669 L10.088,6.906 L11.325,6.906 C12.304,6.906 13.094,6.847 13.094,7.994 C13.094,9.138 12.304,9.082 11.325,9.082 L11.325,9.082 Z"
                                    fill="#598234" class="si-glyph-fill"> </path>
                            </g>
                        </g>
                    </svg>
                    <p class="text-sm text-center font-bold uppercase text-white">Crear Plan Semanal</p>
                </a>
                <a href="{{ route('planSemanal.tareaLote.create') }}"
                    class="flex flex-col justify-between items-center hover:bg-green-600 rounded-xl lg:p-5 grow-animation-sm">
                    <svg width="100" height="50" viewBox="0 -0.5 17 17" version="1.1" xmlns="http://www.w3.org/2000/svg"
                        xmlns:xlink="http://www.w3.org/1999/xlink" class="si-glyph si-glyph-circle-plus" fill="#000000">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <title>933</title>
                            <defs> </defs>
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <path
                                    d="M9.021,0.097 C4.625,0.097 1.063,3.655 1.063,8.04 C1.063,12.428 4.625,15.985 9.021,15.985 C13.416,15.985 16.979,12.427 16.979,8.04 C16.979,3.654 13.415,0.097 9.021,0.097 L9.021,0.097 Z M11.325,9.082 L10.088,9.082 L10.088,10.319 C10.088,11.298 10.147,12.088 9,12.088 C7.856,12.088 7.912,11.298 7.912,10.319 L7.912,9.082 L6.675,9.082 C5.696,9.082 4.906,9.138 4.906,7.994 C4.906,6.848 5.696,6.906 6.675,6.906 L7.912,6.906 L7.912,5.669 C7.912,4.69 7.856,3.9 9,3.9 C10.146,3.9 10.088,4.69 10.088,5.669 L10.088,6.906 L11.325,6.906 C12.304,6.906 13.094,6.847 13.094,7.994 C13.094,9.138 12.304,9.082 11.325,9.082 L11.325,9.082 Z"
                                    fill="#598234" class="si-glyph-fill"> </path>
                            </g>
                        </g>
                    </svg>
                    <p class="text-sm text-center font-bold uppercase text-white">Crear Tarea</p>
                </a>

                <a href="{{ route('planSemanal.tareaLote.create') }}"
                    class="flex flex-col justify-between items-center hover:bg-green-600 rounded-xl lg:p-5 grow-animation-sm">
                    <svg width="100" height="50" viewBox="0 -0.5 17 17" version="1.1" xmlns="http://www.w3.org/2000/svg"
                        xmlns:xlink="http://www.w3.org/1999/xlink" class="si-glyph si-glyph-circle-plus" fill="#000000">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <title>933</title>
                            <defs> </defs>
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <path
                                    d="M9.021,0.097 C4.625,0.097 1.063,3.655 1.063,8.04 C1.063,12.428 4.625,15.985 9.021,15.985 C13.416,15.985 16.979,12.427 16.979,8.04 C16.979,3.654 13.415,0.097 9.021,0.097 L9.021,0.097 Z M11.325,9.082 L10.088,9.082 L10.088,10.319 C10.088,11.298 10.147,12.088 9,12.088 C7.856,12.088 7.912,11.298 7.912,10.319 L7.912,9.082 L6.675,9.082 C5.696,9.082 4.906,9.138 4.906,7.994 C4.906,6.848 5.696,6.906 6.675,6.906 L7.912,6.906 L7.912,5.669 C7.912,4.69 7.856,3.9 9,3.9 C10.146,3.9 10.088,4.69 10.088,5.669 L10.088,6.906 L11.325,6.906 C12.304,6.906 13.094,6.847 13.094,7.994 C13.094,9.138 12.304,9.082 11.325,9.082 L11.325,9.082 Z"
                                    fill="#598234" class="si-glyph-fill"> </path>
                            </g>
                        </g>
                    </svg>
                    <p class="text-sm text-center font-bold uppercase text-white">Crear Tarea Ext</p>
                </a>
            </div>
            
        </div>
    @endcan

    <div class=" col-start-5 col-span-5 bg-green-moss rounded-2xl shadow-xl">
        <div class="bg-green-meadow w-full p-5 flex flex-row gap-2 items-center text-white rounded-t-2xl">
            <h1 class="text-2xl font-bold">Control de tareas</h1>
        </div>

        <div class="flex flex-col gap-5 p-5 text-xs md:text-xl">
            @forelse ($planes as $plan)
            <a href="{{ route('planSemanal.show',$plan) }}"
                class="flex flex-row gap-5 font-bold text-white bg-green-meadow p-3 rounded-xl justify-between shadow-xl grow-animation-sm">
                <p>{{ $plan->finca->finca }} - Semana {{ $plan->semana }} </p>
                <div class="flex flex-row gap-2 justify-center items-center">

                    <p class="uppercase">Tareas Completadas: {{ $plan->tareasRealizadas->count()
                        }}/{{$plan->tareasTotales->count() }}</p>

                    @if ($plan->tareasRealizadas->count() === $plan->tareasTotales->count())
                    <i title="La tarea fue realizada" class="fa-solid fa-circle-check text-2xl text-green-300"></i>
                    @endif
                </div>
            </a>
            @empty
            <p class="text-center font-bold text-white uppercase">Aún no existen planes para esta semana</p>
            @endforelse
        </div>

    </div>

    <div class=" col-start-1 col-span-8 bg-green-moss rounded-2xl shadow-xl">
        <div class="bg-green-meadow w-full p-5 flex flex-row gap-2 items-center text-white rounded-t-2xl">
            <h1 class="text-2xl font-bold">Control de Tareas en Proceso y Asignaciones</h1>
        </div>

        <div class="flex flex-col gap-5 p-5 text-xs md:text-xl">
            @forelse ($tareas as $tarea)
                <a href="{{ route('planSemanal.tareaLote.show',$tarea) }}"
                    class="flex flex-row gap-5 font-bold text-white bg-green-meadow p-3 rounded-xl justify-between shadow-xl grow-animation-sm">
                        <div class="flex flex-row gap-5">
                            <i class="fa-solid fa-clock text-orange-500 text-xl" title="Aún no han sido terminadas todas las tareas"></i>
                            <p>Tarea: {{ $tarea->tarea->tarea}}</p>
                        </div>

                    <p>Usuarios Asignados: {{ $tarea->users->count()}} / {{ $tarea->personas }}</p>
                </a>
            @empty
                <p class="text-center font-bold text-white uppercase">No hay tareas en proceso</p>
            @endforelse
        </div>

    </div>

    <div class=" col-start-1 col-span-4 row-start-2 bg-green-moss rounded-2xl shadow-xl ">
        <div class="bg-green-meadow w-full p-5 flex flex-row gap-2 items-center text-white rounded-t-2xl">
            <h1 class="text-2xl font-bold">Resumen de Horas Por Empleado Semana {{ $semana_actual }}</h1>
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
                        <td class="campo">{{ $usuario->horas_totales }} @choice('hora|horas',$usuario->horas_totales)</td>
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

</div>
@endsection