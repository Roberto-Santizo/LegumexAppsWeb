<div class="overflow-x-auto mt-10">
    <table class="tabla">
        <thead class="tabla-head">
            <tr class="text-xs md:text-sm">
                <th scope="col" class="encabezado text-left">
                    Nombre del Insumo</th>
                <th scope="col" class="encabezado text-left">
                    Codigo</th>
                <th scope="col" class="encabezado text-left">
                    Unidad de Medida</th>
                <th scope="col" class="encabezado text-center">
                    Acciones</th>
            </tr>

        </thead>
        <tbody class="tabla-body">
            @foreach ($insumos as $insumo)
                <tr>
                    <td class="campo">{{ $insumo->insumo }}</td>
                    <td class="campo">{{ $insumo->code }}</td>
                    <td class="campo">{{ $insumo->medida }}</td>

                    <td class="campo flex flex-row gap-5">
                        <a href="{{ route('insumos.edit',$insumo) }}">
                            <i class="fa-solid fa-pen icon-link"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>