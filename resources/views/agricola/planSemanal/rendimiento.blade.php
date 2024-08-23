@extends('layouts.administracion')

@section('titulo')
Revision Diaria Por Persona 
@endsection

@section('contenido')

<x-alertas />
<div class="mt-5">
    <p class="text-xl">Tarea a evaluar: {{ $tarealote->tarea->tarea }}</p>
    <p class="text-xl">Fecha: {{ \Carbon\Carbon::now()->format('d-m-Y') }}</p>

   <div class="mt-5">
        @foreach ($usuarios as $usuario)
        <a href="{{ route('planSemanal.diario',[$usuario->usuario,$tarealote]) }}">
            <div>
                <div class="border p-3 not-selected text-white rounded cursor-pointer w-1/2"
                    data-user="{{ $usuario->usuario->id }}">
                    <div class="flex flex-row items-center gap-3">
                        <i class="fa-solid fa-user text-2xl"></i>
                        <div>
                            <p class="font-bold">{{ $usuario->usuario->first_name }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </a>
        @endforeach
   </div>
</div>
@endsection