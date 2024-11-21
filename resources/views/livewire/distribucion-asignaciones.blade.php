<div>
    <table class="tabla">
        <thead class="bg-green-meadow">
            <tr class="text-xs md:text-sm rounded">
                <th scope="col" class="text-white"></th>
                @foreach ($fechasEntrada as $fecha)
                    <th scope="col" class="text-white">{{ $fecha }}</th>
                @endforeach
                <th scope="col" class="text-white">Porcentaje de asistencia</th>
                <th scope="col" class="text-white">Horas Totales</th>
                <th scope="col" class="text-white">Monto Total</th>
                
            </tr>
        </thead>
        <tbody class="tabla-body">
            @foreach ($tarea->users as $user)
            <tr>
                <td class="campo">{{ $user->nombre }}</td>
                @foreach ($user->entradas as $entrada)
                    <td class="campo text-center">
                        @if ($entrada['estado'])
                            <i title="Horas: {{ $entrada['horas'] }}" class="fa-solid fa-circle-check text-xl text-green-500"></i>
                        @else
                            <i title="Sin registros" class="fa-solid fa-circle-xmark text-xl text-red-500"></i>
                        @endif
                    </td>                    
                @endforeach
                <td class="campo text-center">{{ round($user->porcentaje*100,2) }}%</td>
                <td class="campo text-center">{{ round($user->horas_totales,2) }} H</td>
                <td class="campo text-center">Q {{ round($user->monto_total,2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
</div>


