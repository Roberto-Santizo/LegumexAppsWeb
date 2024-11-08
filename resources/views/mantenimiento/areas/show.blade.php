@extends('layouts.mantenimiento')

@section('titulo')
    {{ $area->area }} - {{ $area->planta->name }}
@endsection

@section('contenido')

<x-alertas />

<x-link-volver ruta="areas" class="bg-orange-600 hover:bg-orange-800"/>


<livewire:areas-controller-show :area="$area"/>

@endsection