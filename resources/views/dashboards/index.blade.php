@extends('layouts.auth')

@section('titulo')
    Dashboard Admin
@endsection

@section('contenido')
    @php
        $color = '#3b82f6';
    @endphp

    <x-alertas />

    <div class="flex flex-col gap-10 xl:grid xl:grid-cols-8 mt-10" data-aos="zoom-in">
        <div class="col-span-8 bg-white rounded-2xl shadow-md border">
            <div class="bg-white px-6 py-4 flex items-center gap-3 rounded-t-2xl border-sky-300">
                <i class="fa-solid fa-user text-xl text-sky-600"></i>
                <h2 class="text-xl font-semibold text-sky-700">Manejo de Usuarios</h2>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5 p-6">
                <a href="{{ route('usuarios.create') }}"
                    class="bg-sky-50 hover:bg-sky-100 transition rounded-xl p-4 flex flex-col items-center shadow-sm">
                    <x-circle-plus :color="$color" />
                    <p class="text-center text-sm font-medium text-gray-700 mt-2">Crear Usuario</p>
                </a>

                <a href="{{ route('usuarios.roles-create') }}"
                    class="bg-sky-50 hover:bg-sky-100 transition rounded-xl p-4 flex flex-col items-center shadow-sm">
                    <x-circle-plus :color="$color" />
                    <p class="text-center text-sm font-medium text-gray-700 mt-2">Crear Rol</p>
                </a>

                <a href="{{ route('usuarios.permissions-create') }}"
                    class="bg-sky-50 hover:bg-sky-100 transition rounded-xl p-4 flex flex-col items-center shadow-sm">
                    <x-circle-plus :color="$color" />
                    <p class="text-center text-sm font-medium text-gray-700 mt-2">Crear Permiso</p>
                </a>

                <a href="{{ route('usuarios.supervisores-create') }}"
                    class="bg-sky-50 hover:bg-sky-100 transition rounded-xl p-4 flex flex-col items-center shadow-sm">
                    <x-circle-plus :color="$color" />
                    <p class="text-center text-sm font-medium text-gray-700 mt-2">Crear Supervisor</p>
                </a>
            </div>
        </div>

        <div class="col-span-8 bg-white rounded-2xl shadow-md mt-6 xl:mt-0 border">
            <div class="bg-white px-6 py-4 flex items-center gap-3 rounded-t-2xl border-b border-gray-300">
                <i class="fa-solid fa-clock text-xl text-gray-600"></i>
                <h2 class="text-xl font-semibold text-gray-700">Últimos Logeos</h2>
            </div>

            <div class="p-4 max-h-96 overflow-y-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="px-4 py-2 text-left text-gray-700 font-semibold">Nombre</th>
                            <th class="px-4 py-2 text-left text-gray-700 font-semibold">Última versión vista</th>
                            <th class="px-4 py-2 text-left text-gray-700 font-semibold">Fecha de logueo</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        @forelse ($sessions as $session)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-4 py-2">{{ $session->user->name ?? 'No se encontró nombre' }}</td>
                                <td class="px-4 py-2">{{ $session->user->last_seen_version ?? 'No se encontró versión' }}
                                </td>
                                <td class="px-4 py-2">{{ $session->ultima_coneccion }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-4 py-4 text-center text-gray-500">No hay registros disponibles
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
