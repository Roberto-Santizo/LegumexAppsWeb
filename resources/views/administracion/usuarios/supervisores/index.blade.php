@extends('layouts.administracion')

@section('titulo')
Supervisores
@endsection

@section('contenido')
@if(session('success'))
<p class="bg-green-500 uppercase text-xl text-white my-2 rounded-lg p-2 text-center font-bold">{{ session('success') }}
</p>
@endif


<div class="flex flex-col md:flex-row w-full justify-between items-center">
    <div class="flex flex-col xl:flex-row gap-5">
        <a href="{{ route('usuarios') }}"
            class=" bg-orange-500 cursor-pointer hover:bg-orange-700 text-white font-bold py-2 px-4 rounded inline-block mt-5 mb-5 ">
            <i class="fa-solid fa-arrow-left"></i>
            Volver
        </a>

        <form action="{{ route('usuarios.supervisores') }}" method="GET" class="mt-5 inline-block mr-5">
            <div class="items-center bg-gray-100 p-2 rounded-lg flex gap-1">
                <input class="border border-black p-1 rounded" type="text" name="query" placeholder="Buscar...."
                    value="{{ old('query', request()->input('query')) }}">
                <button type="submit" class="hover:bg-orange-200 p-2 rounded">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                </button>
            </div>
        </form>

        <a href="{{ route('usuarios.supervisores') }}"
            class="mt-2 md:mt-0 text-white font-bold bg-orange-500 hover:bg-orange-600 p-2 text-center rounded flex items-center justify-center">
            Borrar Filtros
        </a>
    </div>

    <a href="{{ route('usuarios.supervisores-create') }}"
        class="mt-5 bg-orange-500 cursor-pointer hover:bg-orange-700 text-white font-bold py-2 px-4 rounded inline-block ">
        <i class="fa-solid fa-plus"></i>
        Crear Supervisor
    </a>
</div>

<div class="overflow-x-auto mt-10">
    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-xs md:text-sm">
        <thead class="bg-gray-50 dark:bg-gray-800">
            <tr
                class="md:text-sm text-sm font-bold uppercase text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <th scope="col" class="p-5">No.</th>
                <th scope="col" class="p-5">Nombre</th>
                <th scope="col" class="p-5">Rol</th>
                <th scope="col" class="p-5">Estado</th>
                <th scope="col" class="p-5">Acciones</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200 dark:divide-gray-700 dark:bg-gray-900">
            @foreach ($supervisores as $supervisor)
            <tr>
                <td class="px-4 py-2 text-md font-medium whitespace-nowrap">{{ $supervisor->id }}</td>
                <td class="px-4 py-2 text-md font-medium whitespace-nowrap">{{ $supervisor->name }}</td>
                <td class="px-4 py-2 text-md font-medium whitespace-nowrap">{{ $supervisor->role->name }}</td>
                <td class="px-4 py-2 text-md font-medium whitespace-nowrap">
                    <form action="{{ route('usuarios.supervisores-destroy',$supervisor) }}" class="estado"
                        method="POST">
                        @csrf
                        @method('DELETE')
                        <input data-status="{{ $supervisor->status }}" id="supervisor_destroy-button" type="submit"
                            value="{{ ($supervisor->status == 1) ? 'ACTIVO' : 'INACTIVO' }}"
                            class="cursor-pointer text-white font-bold rounded p-2 {{ ($supervisor->status == 1) ? 'bg-green-500 hover:bg-green-600' : 'bg-red-500 hover:bg-red-600' }}">
                    </form>
                </td>
                <td class="px-4 py-2 text-md font-medium whitespace-nowrap flex gap-5 justify-center items-center">
                    <a href="{{ route('usuarios.supervisores-edit', $supervisor) }}">
                        <i class="fa-solid fa-pen text-xl"></i>
                    </a>
                </td>
            </tr>

            @endforeach
        </tbody>
    </table>
</div>



<div class="my-10">
    {{ $supervisores->links('pagination::tailwind') }}
</div>
@endsection