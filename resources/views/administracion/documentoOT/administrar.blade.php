@extends('layouts.administracion')


@section('titulo')
Administrar Ordenes de Trabajo
@endsection


@section('contenido')
<div class="mt-5 shadow-xl p-5 rounded-lg flex flex-col gap-5">
    <h2 class="text-2xl font-bold">Ordenes de trabajo pendientes por mecánico</h2>
    <div class="grid gap-2 grid-cols-2 md:grid-cols-3 xl:grid-cols-5">
        @foreach ($users as $user)
        <a href="{{ route('documentoOT.ordenesUsuario',$user) }}"
            class="flex flex-col p-5 rounded-xl border mt-5 hover:bg-gray-200 justify-center items-center ">
            <i class="fa-solid fa-user-gear text-4xl"></i>
            <div>
                <p class="text-center">{{ $user->name }}</p>
            </div>
        </a>
        @endforeach
    </div>
    @if ($users->hasPages())
    <div class="mt-5 px-2">
        {{ $users->links() }}
    </div>
    @endif
</div>

<div class="mt-5 shadow-xl p-5 rounded-lg">
    <h2 class="text-2xl font-bold">Ordenes de trabajo pendientes por prioridad</h2>
    <div class="flex flex-col gap-5 mt-5">

        <a href="{{ route('documentoOT.showurgencia', 1) }}">
            <div class="bg-red-500 hover:bg-red-600 p-5 rounded-xl shadow-xl ">
                <p class="text-white font-bold uppercase">Ordenes de trabajo urgentes</p>
            </div>
        </a>

        <a href="{{ route('documentoOT.showurgencia',2) }}">
            <div class="bg-yellow-500 hover:bg-yellow-600 p-5 rounded-xl shadow-xl">
                <p class="text-white font-bold uppercase">Ordenes de trabajo importantes</p>
            </div>
        </a>

        <a href="{{ route('documentoOT.showurgencia',3) }}">
            <div class="bg-green-500 hover:bg-green-600 p-5 rounded-xl shadow-xl ">
                <p class="text-white font-bold uppercase">Ordenes de trabajo no importante</p>
            </div>
        </a>

    </div>
</div>

<div class="mt-5 shadow-xl p-5 rounded-lg">
    <h2 class="text-2xl font-bold">Ordenes de trabajo eliminadas</h2>
    <div class="flex flex-col gap-5 mt-5">

        <a href="{{ route('documentoOT.showeliminadas') }}">
            <div class="bg-red-500 hover:bg-red-600 p-5 rounded-xl shadow-xl r">
                <p class="text-white font-bold uppercase">Ordenes de trabajo eliminadas</p>
            </div>
        </a>

    </div>
</div>

@endsection