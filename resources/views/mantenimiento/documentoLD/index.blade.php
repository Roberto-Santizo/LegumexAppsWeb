@extends('layouts.mantenimiento')

@section('titulo')
Documento Lavado y Desinfección de Herramientas
@endsection

@section('contenido')
<x-alertas />

<livewire:documento-lavado-controller-index />
@endsection