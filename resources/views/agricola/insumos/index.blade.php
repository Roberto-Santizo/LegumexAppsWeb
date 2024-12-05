@extends('layouts.agricola')

@section('titulo')
Insumos
@endsection

@section('contenido')

<x-alertas />
<div class="flex justify-end gap-5">
    <x-link class="bg-green-moss hover:bg-green-meadow" route="insumos.create" text="Crear Insumo" />
    <x-link class="bg-green-moss hover:bg-green-meadow" route="insumos.carga" text="Carga Masiva de Insumos" />
</div>
<livewire:insumos-controller-index />
@endsection