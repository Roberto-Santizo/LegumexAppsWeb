@extends('layouts.mantenimiento')


@section('titulo')
    Mis ordenes de trabajo pendientes 
@endsection

@section('contenido')
    @if ($misordenes->count())
    @else
        <p class="mt-10 text-center font-bold text-2xl">No tienes ordenes de trabajo pendientes</p>
    @endif

@endsection