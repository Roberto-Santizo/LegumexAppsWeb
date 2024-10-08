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

            <button type="submit" class="btn flex flex-row gap-5 bg-green-moss hover:bg-green-meadow">
                <p>Buscar Datos</p>
            </button>
        </div>
    </form>
</div>

<input type="hidden" value="{{ $tarea->id }}" id="tarea_id">

<div class="mt-5" id="myChartContainer">
    <div class="border border-red-500 bg-red-100 text-red-700 font-bold uppercase p-2 mt-2 text-sm flex flex-row gap-2 items-center hidden" id="alerta_datos">
        <i class="fa-solid fa-circle-exclamation"></i>
        <p>No existen datos de la consulta</p>
    </div>
    <canvas id="myChart" width="400" height="200"></canvas>

    <div class="justify-center flex-col items-center hidden" id="loading_icon">
        <div class=" w-16 h-16 border-8 border-green-500 border-dashed rounded-full animate-spin" ></div>
    </div>

</div>


@endsection