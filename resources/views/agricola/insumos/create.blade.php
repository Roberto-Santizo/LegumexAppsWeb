@extends('layouts.agricola')

@section('titulo')
Crear Insumo
@endsection

@section('contenido')

<x-alertas />

<x-link-volver ruta="insumos" class="bg-green-moss hover:bg-green-meadow"/>

<livewire:insumos-controller-create />
@endsection