@extends('layouts.agricola')

@section('titulo')
    Resumen de cosecha {{ $tarealotecosecha->tarea->tarea }} - S{{ $tarealotecosecha->plansemanal->semana }} - {{ $tarealotecosecha->lote->nombre  }}
@endsection

@section('contenido')

<x-alertas />
<div class="flex justify-end mt-5">
    <a href="{{ route('planSemanal.tareasCosechaLote',[$tarealotecosecha->lote,$tarealotecosecha->plansemanal]) }}" class="btn bg-green-moss hover:bg-green-meadow ">
        <i class="fa-solid fa-arrow-left"></i>
        Volver
    </a>
</div>

<livewire:resumen-cosecha :tarealotecosecha="$tarealotecosecha"/>
 

@endsection