@extends('layouts.mantenimiento')


@section('titulo')
    Ordenes Eliminadas
@endsection


@section('contenido')  
    @if (count($ordenes) > 0)
        <x-ordenesde-trabajo :ots="$ordenes"/>
    @else
        <p class="text-center mt-5">No hay ordenes eliminadas</p>
    @endif
@endsection