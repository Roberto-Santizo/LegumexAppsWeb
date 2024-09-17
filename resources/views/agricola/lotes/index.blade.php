@extends('layouts.administracion')

@section('titulo')
Lotes por Finca
@endsection

@section('contenido')

<x-alertas />


<x-link route="lotes.create" text="Crear Lote" />

<div class="overflow-x-auto mt-10">
    <table class="tabla">
        <thead class="tabla-head">
            <tr class="text-xs md:text-sm">
                <th scope="col"
                    class="encabezado">
                    Nombre/Codificación del cultivo</th>
                <th scope="col"
                    class="encabezado">
                    Finca</th>
                <th scope="col"
                    class="encabezado">
                    Estado</th>
                <th scope="col"
                    class="encabezado">
                    Acción</th>

            </tr>
        </thead>
        <tbody class="tabla-body">
            @foreach ($lotes as $lote)
            <tr>
                <td class="campo">{{ $lote->nombre }}</td>
                <td class="campo">{{ $lote->finca->finca }}</td>
                <td class="campo">
                    <form action="{{ route('lotes.destroy',$lote) }}" class="estado"
                        method="POST">
                        @csrf
                        @method('DELETE')
                        @php
                            $estado = ($lote->estado) ? 'status-green' : 'status-red';
                        @endphp
                        <input data-status="{{ $lote->estado }}" id="destroy-button" type="submit"
                            value="{{ ($lote->estado == 1) ? 'ACTIVO' : 'INACTIVO' }}"
                            class="cursor-pointer text-white font-bold rounded p-2 {{ $estado }} ">
                    </form>
                </td>
                <td class="campo">
                    <a href="{{ route('lotes.edit',$lote) }}">
                        <i class="fa-solid fa-pen text-xl"></i>
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<x-paginacion :items="$lotes" />
@endsection