@extends('layouts.administracion')

@section('titulo')
Roles
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

    <a href="{{ route('usuarios.roles-create') }}"
        class="mt-5 bg-orange-500 cursor-pointer hover:bg-orange-700 text-white font-bold py-2 px-4 rounded inline-block ">
        <i class="fa-solid fa-plus"></i>
        Crear Rol
    </a>
</div>
<div class="overflow-x-auto mt-10">
    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-xs md:text-sm">
        <thead class="bg-gray-50 dark:bg-gray-800">
            <tr
                class="md:text-sm text-sm font-bold uppercase text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <th scope="col" class="p-5">No.</th>
                <th scope="col" class="p-5">Rol</th>
                <th scope="col" class="p-5">Fecha de creación</th>
                <th scope="col" class="p-5">Última fecha de actualización</th>
                <th scope="col" class="p-5 text-center">Acciones</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200 dark:divide-gray-700 dark:bg-gray-900">
            @foreach ($roles as $rol)
            <tr>
                <td class="px-4 py-2 text-md font-medium whitespace-nowrap">{{ $rol->id }}</td>
                <td class="px-4 py-2 text-md font-medium whitespace-nowrap">{{ $rol->name }}</td>
                <td class="px-4 py-2 text-md font-medium whitespace-nowrap">{{ $rol->created_at }}</td>
                <td class="px-4 py-2 text-md font-medium whitespace-nowrap">{{ $rol->updated_at }}</td>
                <td class="px-4 py-2 text-md font-medium whitespace-nowrap flex gap-5 justify-center items-center">
                    <a href="{{ route('usuarios.roles-edit', $rol) }}">
                        <i class="fa-solid fa-pen text-xl"></i>
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>



<div class="my-10">
    {{ $roles->links('pagination::tailwind') }}
</div>
@endsection