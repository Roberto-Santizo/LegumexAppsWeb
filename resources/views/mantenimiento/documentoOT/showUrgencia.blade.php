@extends('layouts.mantenimiento')


@section('titulo')
    Ordenes {{ $titulo }} pendientes
@endsection


@section('contenido') 
    <x-alertas />

    @if (count($ordenes) > 0)
        <x-ordenesde-trabajo :ots="$ordenes"/>
    @else
        <p class="text-center mt-5">No hay ordenes pendientes</p>
    @endif
@endsection