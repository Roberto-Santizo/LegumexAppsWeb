@extends('layouts.administracion')


@section('titulo')
    Ordenes pendientes de {{ $usuario->name }}
@endsection


@section('contenido')
    @if ($ordenes->count() > 0)
        <x-ordenesde-trabajo :ots="$ordenes"/>  
    @else
        <p class="text-center mt-5">{{ $usuario->name }} no tiene ordenes pendientes</p>
    @endif
@endsection