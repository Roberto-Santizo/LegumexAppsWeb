<div class="mt-10">
    <div class="shadow-xl p-5 rounded-xl flex flex-row justify-between items-center">
        <div>
            <h2 class="text-3xl font-bold">Información de Cosecha de Semana {{ $plansemanalfinca->semana }}</h2>
            {{-- <p class="text-xl">Libras totales reportadas en finca: <span class="font-bold">{{ $sumaLibrasFinca }} lbs</span></p> --}}
            <p class="text-xl">Total de Personas que Cosecharon: <span class="font-bold">{{ $tarealotecosecha->users->count() }}</span></p>
            <div class="mt-5">
                <h2 class="text-2xl font-bold">Días cosechados: </h2>
                @foreach ($sumaPorFecha as $fecha)
                    <p>{{ $fecha->fecha }} -    <span class="font-bold"> {{ $fecha->total_libras }} LBS</span></p>
                @endforeach
            </div>
    
        </div>
        <p class="text-3xl font-bold">Total Libras: {{ $sumaLibrasFinca }} LBS</p>
    </div>

<div class="mt-10 flex flex-col gap-5">
    
    <div class="flex flex-row gap-10 justify-between bg-green-moss p-3 text-white font-bold rounded-xl">
        <table class="tabla">
            <thead class="bg-green-meadow">
                <tr class="text-xs md:text-sm rounded uppercase">
                    <th scope="col" class="text-white">Codigo</th>
                    <th scope="col" class="text-white">Empleado</th>
                    <th scope="col" class="text-white">Fecha</th>
                    <th scope="col" class="text-white">Total de Libras Cosechadas</th>
                </tr>
            </thead>
            <tbody class="tabla-body text-black">
                @foreach ($asignaciones as $asignacion)
                <tr>
                    <td>{{ $asignacion->codigo }}</td>
                    <td>{{ $asignacion->nombre }}</td>
                    <td class="text-center">{{ $asignacion->created_at->format('d-m-Y') }}</td>
                    <td class="text-center">{{ $asignacion->libras_asignacion }} lbs</td>
                </tr>

                @endforeach
            </tbody>
        </table>
    </div>
</div>

</div>
