@extends('layouts.agricola')

@section('titulo')
    Registro de Rendimiento Real (Ingresado en Planta)
@endsection

@section('contenido')

<x-alertas />

<livewire:toma-rendimiento-semanal-real :lote="$lote" :plansemanalfinca="$plansemanalfinca" :tarealotecosecha="$tarealotecosecha"/>

@endsection