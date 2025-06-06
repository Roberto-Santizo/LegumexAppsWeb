@extends('layouts.auth')


@section('titulo')
Ordenes de Trabajo {{ $titulo }}
@endsection


@section('contenido')

<x-alertas />

<livewire:mostrar-ordenes-trabajo :estado="$estado"/>

@endsection