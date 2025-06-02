@extends('layouts.auth')

@section('titulo')
Herramientas
@endsection

@section('contenido')
<x-alertas />

<div>
    <div class="flex flex-row justify-end ">
        <form action="{{ route('herramientas') }}" method="GET" class="mt-5 inline-block mr-5">
            <div>
                <input class="border border-black p-1 rounded" type="text" name="query" placeholder="Buscar...."
                    value="{{ old('query', request()->input('query')) }}" autocomplete="off">
                <button type="submit" class="p-2 rounded">
                    <i class="fa-solid fa-magnifying-glass icon-link"></i>
                </button>
            </div>
        </form>
        <x-link route="herramientas" text="Borrar Filtros" class="btn bg-orange-600 hover:bg-orange-800"/>

    </div>

    <div class="flex flex-col md:flex-row gap-5 justify-center md:justify-end items-center mt-5">
        <x-link route="herramientas.create" text="Crear" class="btn bg-orange-600 hover:bg-orange-800"/>
    </div>
</div>

<div class="overflow-x-auto mt-10 overflow-y-hidden">
    <table class="tabla">
        <thead class="tabla-head">
            <tr class="text-xs md:text-sm">
                <th scope="col"
                    class="encabezado">
                    Herramienta</th>
                <th scope="col"
                    class="encabezado">
                    Acciónes</th>
            </tr>
        </thead>
        <tbody class="tabla-body">
            @foreach ($herramientas as $herramienta)
            <tr>
                <td class="campo">{{ $herramienta->herramienta }}</td>
                <td class="campo text-xl flex gap-10">
                    <a href="{{ route('herramientas.edit', $herramienta) }}">
                        <i class="fa-solid fa-pen icon-link"></i>
                    </a>

                    @hasanyrole('admin|admin_mantenimiento')
                    <form method="POST" action="{{ route('herramientas.destroy', $herramienta) }}">
                        @csrf
                        @method('DELETE')
                        <input type="submit" value="eliminar"
                            class="btn-red">
                    </form>
                    @endhasanyrole
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
</table>

<x-paginacion :items="$herramientas" />
@endsection