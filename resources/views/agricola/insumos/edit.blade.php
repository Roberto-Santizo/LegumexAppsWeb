@extends('layouts.agricola')

@section('titulo')
    Editar {{ $insumo->insumo }}
@endsection

@section('contenido')

<x-alertas />

<x-link-volver ruta="insumos" class="bg-green-moss hover:bg-green-meadow"/>

<livewire:insumos-controller-edit :insumoProp="$insumo"/>
@endsection