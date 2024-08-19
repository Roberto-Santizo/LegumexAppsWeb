@extends('layouts.administracion')

@section('titulo')
Herramientas
@endsection

@section('contenido')
<x-alertas />

<form action="{{ route('herramientas') }}" method="GET" class="mt-5 inline-block mr-5">
    <div class="items-center bg-gray-100 p-2 rounded-lg flex gap-1">
        <input autocomplete="off" class="border border-black p-1 rounded" type="text" name="query"
            placeholder="Buscar....">
        <button type="submit" class="hover:bg-orange-200 p-2 rounded">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
            </svg>
        </button>
    </div>
</form>

<a href="{{ route('herramientas.create') }}"
    class="mt-5 bg-orange-500 cursor-pointer hover:bg-orange-700 text-white font-bold py-2 px-4 rounded inline-block ">
    <i class="fa-solid fa-plus"></i>
    Crear
</a>

<div class="overflow-x-auto mt-10 overflow-y-hidden">
    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-xs md:text-sm">
        <thead class="bg-gray-50 dark:bg-gray-800">
            <tr class="text-xs md:text-sm">
                <th scope="col"
                    class="p-3 text-sm font-bold uppercase text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    Herramienta</th>
                <th scope="col"
                    class="p-3 text-sm font-bold uppercase text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    Acción</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200 dark:divide-gray-700 dark:bg-gray-900">
            @foreach ($herramientas as $herramienta)
            <tr>
                <td class="px-4 py-2 text-md font-medium whitespace-nowrap">{{ $herramienta->herramienta }}</td>
                <td class="px-4 py-2 text-md font-medium whitespace-nowrap text-xl flex gap-10">
                    <a href="{{ route('herramientas.edit', $herramienta) }}">
                        <i class="fa-solid fa-pen"></i>
                    </a>

                    @hasanyrole('admin|admin_mantenimiento')
                    <form method="POST" action="{{ route('herramientas.destroy', $herramienta) }}">
                        @csrf
                        @method('DELETE')
                        <input type="submit" value="eliminar"
                            class="cursor-pointer text-sm uppercase bg-red-500 hover:bg-red-600 text-white p-2 rounded">
                    </form>
                    @endhasanyrole
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
</table>

<div class="my-10">
    {{ $herramientas->links('pagination::tailwind') }}
</div>
@endsection