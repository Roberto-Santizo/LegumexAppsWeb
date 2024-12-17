@extends('layouts.mantenimiento')


@section('titulo')
Ordenes de Trabajo {{ $titulo }}
@endsection


@section('contenido')

<x-alertas />

<livewire:mostrar-ordenes-trabajo :ordenes="$ordenes" :estado="$estado"/>

@endsection