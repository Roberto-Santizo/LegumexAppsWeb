@extends('layouts.auth')


@section('titulo')
    Ordenes {{ $titulo }} pendientes
@endsection


@section('contenido') 
    <x-alertas />

    @if (count($ordenes) > 0)
    @else
        <p class="text-center mt-5">No hay ordenes pendientes</p>
    @endif
@endsection