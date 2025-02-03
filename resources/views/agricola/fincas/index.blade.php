@extends('layouts.agricola')

@section('titulo')
    Fincas
@endsection

@section('contenido')
    <x-alertas />

    <div class="overflow-x-auto mt-10">
        <table class="tabla">
            <thead class="tabla-head">
                <tr class="text-xs md:text-sm">
                    <th scope="col" class="encabezado">
                        Finca</th>
                    <th scope="col" class="encabezado">
                        Codigo</th>
                    <th scope="col" class="encabezado">
                        Reporte</th>
                </tr>
            </thead>
            <tbody class="tabla-body">
                @foreach ($fincas as $finca)
                    <tr>
                        <td class="campo">{{ $finca->finca }}</td>
                        <td class="campo">{{ $finca->code }}</td>
                        <td class="campo">
                            <a href="{{ route('reporte.HistoricoLotes',$finca->id) }}">
                                <i title="Reporte Historico de Lotes"
                                    class="fa-solid fa-file-export text-3xl hover:text-gray-500 cursor-pointer"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
