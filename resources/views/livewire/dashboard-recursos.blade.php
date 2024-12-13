<div class="w-full h-full">
    <div>
        @hasanyrole('admin|auxrrhh')
            <div class="flex justify-end">
                <i class="fa-solid fa-bars icon-link" wire:click='openModal()'></i>
            </div>
            <x-dashboard-agricola-filters class="{{ $isOpen ? 'slide-in-active slide-in' : 'slide-out-active-right' }}" />
        @endhasanyrole
    </div>

    <div>
        <div class="mt-5 text-xl flex flex-col gap-2 justify-center">
            <h2 class="uppercase font-bold">Semana en Presentación: {{ $semana_actual }} <span
                    class="text-sm">(calendario)</span></h2>
        </div>

        <div class="flex flex-col gap-5 xl:grid xl:grid-cols-12 mt-10 "> {{-- CONTENEDOR PRINCIPAL --}}
            <div
                class="flex flex-col justify-center items-center col-start-1 col-span-2 bg-green-moss rounded-lg p-4 shadow-2xl text-gray-600 text-md">
                <div>
                    <svg width="400" height="200" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <circle cx="12" cy="9" r="3" stroke="#598234" stroke-width="1.5"></circle>
                            <circle cx="12" cy="12" r="10" stroke="#598234" stroke-width="1.5"></circle>
                            <path
                                d="M17.9691 20C17.81 17.1085 16.9247 15 11.9999 15C7.07521 15 6.18991 17.1085 6.03076 20"
                                stroke="#598234" stroke-width="1.5" stroke-linecap="round"></path>
                        </g>
                    </svg>
                </div>
                <p class="font-bold">{{ auth()->user()->name }}</p>
                <p class="font-bold">{{ auth()->user()->getRoleNames()->first() }}</p>
                <p class="font-bold">{{ auth()->user()->email }}</p>
            </div>

            <div class=" col-start-3 col-span-4 bg-green-moss rounded-2xl shadow-xl">
                <div class="bg-green-meadow w-full p-5 flex flex-row gap-2 items-center text-white rounded-t-2xl">
                    <h1 class="text-2xl font-bold">Descarga de Reporteria</h1>
                </div>

                <div class=" p-2 h-96 overflow-y-auto">
                    <table class="tabla">
                        <thead class="bg-green-meadow">
                            <tr class="text-xs md:text-sm rounded">
                                <th scope="col" class="text-white">Finca</th>
                                <th scope="col" class="text-white">Semana</th>
                                <th scope="col" class="text-white">Detalle de Tareas por Usuario</th>
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
                                            <i title="Detalle de Tareas por Usuario"
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

            <div class="bg-green-moss col-start-7 col-span-7 rounded-t-2xl">
                <div class="bg-green-meadow w-full p-5 flex flex-row gap-2 items-center text-white rounded-t-2xl">
                    <h1 class="text-2xl font-bold">Resumen de Horas Por Empleado Semana {{ $semana_actual }}</h1>
                </div>
                <div class="p-2 h-96 overflow-y-auto">
                    <table class="tabla">
                        <thead class="bg-green-meadow">
                            <tr class="text-xs md:text-sm rounded">
                                <th scope="col" class="text-white">Codigo</th>
                                <th scope="col" class="text-white">Empleado</th>
                                <th scope="col" class="text-white">Finca</th>
                                <th scope="col" class="text-white">Total de Horas</th>
                            </tr>
                        </thead>
                        <tbody class="tabla-body">
                            @foreach ($usuarios as $usuario)
                                <tr>
                                    <td class="campo">{{ $usuario->last_name }}</td>
                                    <td class="campo">{{ $usuario->first_name }}</td>
                                    <td class="campo">{{ $usuario->finca }}</td>
                                    <td class="campo">{{ $usuario->horas_totales }} @choice('hora|horas', $usuario->horas_totales)</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
