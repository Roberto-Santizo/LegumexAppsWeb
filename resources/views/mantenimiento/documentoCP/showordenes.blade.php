@extends('layouts.mantenimiento')

@section('titulo')
    Ordenes de trabajo del checklist: {{$documento->planta->planta}}  - {{ $documento->fecha }}
@endsection


@section('contenido')
    @if(count($ordenes) == 0)
        <p class="text-center mt-10 uppercase font-bold">El checklist preoperacional de esta fecha no tiene ordenes de trabajo relacionadas</p>
    @else

        <x-ordenesde-trabajo :ots="$ordenes" />

    @endif
    
@endsection