@extends('layouts.agricola')

@section('titulo')
    Lotes por Finca
@endsection

@section('contenido')
    <x-alertas />


    <div class="flex justify-between mt-10">
        <x-link route="lotes.consulta" text="Consultar Lote" class="btn bg-green-moss hover:bg-green-meadow" />
        <x-link route="lotes.create" text="Crear Lote" class="btn bg-green-moss hover:bg-green-meadow" />
    </div>

    <div class="overflow-x-auto mt-10">
        <table class="tabla">
            <thead class="tabla-head">
                <tr class="text-xs md:text-sm">
                    <th scope="col" class="encabezado">
                        Nombre/Codificación del cultivo</th>
                    <th scope="col" class="encabezado">
                        Finca</th>
                    <th scope="col" class="encabezado">
                        Estado</th>
                    <th scope="col" class="encabezado">
                        Reporte</th>
                </tr>
            </thead>
            <tbody class="tabla-body">
                @foreach ($lotes as $lote)
                    <tr>
                        <td class="campo">{{ $lote->nombre }}</td>
                        <td class="campo">{{ $lote->finca->finca }}</td>
                        <td class="campo">
                            <form action="{{ route('lotes.destroy', $lote) }}" class="estado" method="POST">
                                @csrf
                                @method('DELETE')
                                @php
                                    $estado = $lote->estado ? 'status-green' : 'status-red';
                                @endphp
                                <input data-status="{{ $lote->estado }}" id="destroy-button" type="submit"
                                    value="{{ $lote->estado == 1 ? 'ACTIVO' : 'INACTIVO' }}"
                                    class="cursor-pointer text-white font-bold rounded p-2 {{ $estado }} ">
                            </form>
                        </td>
                        <td class="campo">
                            <a href="{{ route('reporte.LotesHistorico',$lote) }}">
                                <i title="Reporte Historico"
                                    class="fa-solid fa-file-export text-3xl hover:text-gray-500 cursor-pointer"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <x-paginacion :items="$lotes" />
@endsection
