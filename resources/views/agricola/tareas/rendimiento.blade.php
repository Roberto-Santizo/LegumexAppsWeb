@extends('layouts.agricola')

@section('titulo')
Rendimiento Historico {{$tarea->tarea}}
@endsection

@section('contenido')

<x-alertas />

<x-link route="tareas" text=" Volver" class="bg-green-moss hover:bg-green-meadow"/>
<div class="flex flex-row justify-end ">
    <form class="mt-5" id="form_rendimientos">
        <div class="flex flex-row gap-5">
            <select id="finca_id" class="w-full p-4 rounded bg-gray-50">
                <option value="">--SELECCIONE UNA FINCA--</option>
                @foreach ($fincas as $finca)
                    <option value="{{ $finca->id }}">{{ $finca->finca }}</option>
                @endforeach
            </select>
            
            <select id="year" class="w-full p-4 rounded bg-gray-50">
                <option value="">--SELECCIONE UN AÑO--</option>
                @foreach ($years as $year)
                    <option value="{{ $year }}">{{ $year }}</option>
                @endforeach
            </select>

            <button type="submit" class="btn flex flex-row gap-5">
                <p>Buscar Datos</p>
            </button>
        </div>
    </form>
</div>

<input type="hidden" value="{{ $tarea->id }}" id="tarea_id">

<div class="mt-10">
    <canvas id="myChart" width="400" height="200"></canvas>
</div>
@endsection