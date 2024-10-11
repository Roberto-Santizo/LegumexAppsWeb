<div class="mt-10">
    <div class="shadow-xl p-5 rounded-xl">
        <h2 class="text-3xl font-bold">Información de Cosecha de Semana {{ $plansemanalfinca->semana }}</h2>
        {{-- <p class="text-xl">Libras totales reportadas en finca: <span class="font-bold">{{ $sumaLibrasFinca }} lbs</span></p> --}}
        <p class="text-xl">Total de Personas que Cosecharon: <span class="font-bold">{{ $tarealotecosecha->users->count() }}</span></p>
    </div>

<div class="mt-10 flex flex-col gap-5">
    
    <div class="flex flex-row gap-10 justify-between bg-green-moss p-3 text-white font-bold rounded-xl">
        <table class="tabla">
            <thead class="bg-green-meadow">
                <tr class="text-xs md:text-sm rounded uppercase">
                    <th scope="col" class="text-white">Codigo</th>
                    <th scope="col" class="text-white">Empleado</th>
                    <th scope="col" class="text-white">Total de Libras Cosechadas</th>
                    <th scope="col" class="text-white">Porcentaje</th>
                </tr>
            </thead>
            <tbody class="tabla-body">
                {{-- @foreach ($resumenPorEmpleado as $codigo => $resumen)
                <div class="shadow-xl p-5 bg-green-moss text-white rounded-xl flex flex-col gap-5">
                    <!-- Mostrar el código, nombre del empleado y la suma total de libras asignadas -->
                    <p class="font-bold">Código: {{ $resumen['codigo'] }} - Nombre: {{ $resumen['nombre'] }}</p>
                    <p>Total libras asignadas: {{ $resumen['total_libras'] }}</p>
                    <p>Fecha de primera asignación: {{ \Carbon\Carbon::parse($resumen['fecha_asignacion'])->format('d/m/Y') }}</p>
                </div>
                @endforeach --}}
            </tbody>
        </table>
    </div>
</div>

</div>
