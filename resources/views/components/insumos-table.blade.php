    <table class="tabla">
        <thead class="bg-green-meadow">
            <tr class="text-xs md:text-sm rounded">
                <th scope="col" class="text-white uppercase">Insumo</th>
                <th scope="col" class="text-white uppercase">Cantidad Asignada</th>
                @if (!$asignacion)
                    <th scope="col" class="text-white uppercase">Cantidad Usada</th>
                @endif
            </tr>
        </thead>
        <tbody class="tabla-body">
            @foreach ($insumos as $insumo)
                <tr>
                    <td class="campo">{{ $insumo->insumo->insumo }}</td>
                    <td class="campo text-center">{{ $insumo->cantidad_asignada . ' ' . $insumo->insumo->medida }}</td>
                    @if (!$asignacion)
                        <td class="campo text-center">
                            {{ $insumo->cantidad_usada ? $insumo->cantidad_usada . ' ' . $insumo->insumo->medida : 'Sin registro' }}
                        </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
