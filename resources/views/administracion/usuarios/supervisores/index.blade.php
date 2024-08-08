@extends('layouts.administracion')

@section('titulo')
Supervisores
@endsection

@section('contenido')
@if(session('success'))
<p class="bg-green-500 uppercase text-xl text-white my-2 rounded-lg p-2 text-center font-bold">{{ session('success') }}
</p>
@endif


<div class="flex w-full justify-between items-center">
    <a href="{{ route('usuarios') }}"
        class=" bg-orange-500 cursor-pointer hover:bg-orange-700 text-white font-bold py-2 px-4 rounded inline-block mt-5 mb-5 ">
        <i class="fa-solid fa-arrow-left"></i>
        Volver
    </a>

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
                <th scope="col" class="p-5">Acciones</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200 dark:divide-gray-700 dark:bg-gray-900">
            @foreach ($supervisores as $supervisor)
            <tr>
                <td class="px-4 py-2 text-md font-medium whitespace-nowrap">{{ $supervisor->id }}</td>
                <td class="px-4 py-2 text-md font-medium whitespace-nowrap">{{ $supervisor->name }}</td>
                <td class="px-4 py-2 text-md font-medium whitespace-nowrap">{{ $supervisor->role->name }}</td>
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


{{-- 
<div class="my-10">
    {{ $roles->links('pagination::tailwind') }}
</div> --}}
@endsection