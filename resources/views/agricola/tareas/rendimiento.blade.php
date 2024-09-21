@extends('layouts.agricola')

@section('titulo')
Rendimiento Historico {{$tarea->tarea}}
@endsection

@section('contenido')

<x-alertas />

<x-link route="tareas" text=" Volver" class="bg-green-moss hover:bg-green-meadow"/>

<div>
    <canvas id="myChart" width="400" height="200"></canvas>
</div>
@endsection