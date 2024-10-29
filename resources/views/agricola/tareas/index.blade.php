@extends('layouts.agricola')

@section('titulo')
Tareas Generales Fincas
@endsection

@section('contenido')

<x-alertas />
<div>
    <livewire:mostrar-tareas-generales />
</div>
@endsection