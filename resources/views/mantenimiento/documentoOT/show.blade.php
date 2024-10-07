@extends('layouts.mantenimiento')


@section('titulo')
Orden de trabajo
@endsection

@section('contenido')
<div class="container mt-5 bg-gray-100 p-5 rounded-xl flex flex-col">
    <h1 class="text-xl md:text-4xl font-bold text-center">Información general de la orden de trabajo</h1>
    <div class="text-sm md:text-xl mt-5 flex flex-col md:grid md:grid-cols-2 gap-2">

        <div>
            <p>Planta: <span class="font-bold">{{ $ot->planta->name }}</span></p>
            <p>Area: <span class="font-bold">{{ $ot->area->area }}</span></p>
            <p>Problema detectado: <span class="font-bold">{{ $ot->problema_detectado }}</span></p>
            @if($ot->mecanico_externo)
                <p>Mécanico Externo: <span class="font-bold">{{ $ot->mecanico_externo }}</span></p>
            @endif

            @if ($ot->equipo_problema)
            <p>Equipo con problema: <span class="font-bold">{{ $ot->equipo_problema }}</span></p>
            @endif
        </div>
        @if ($ot->elemento_id)
        <p>Ubicación: <span class="font-bold">{{ $ot->elemento->elemento }}</span></p>
        @endif
        <p>Imágenes de la reparación: <span class="font-bold hover:text-gray-500"><a href="{{ $ot->folder_url }}" target="__blank">Click Aquí</a></span></p>

        <div>
            <p>Fecha de creación: <span class="font-bold">{{ $ot->created_at->format('d-m-Y')}}</span></p>
            <p>Es necesario retirar el equipo: <span class="font-bold">{{ ($ot->retiro_equipo==1) ? 'SI' : 'NO'
                    }}</span></p>
            <p>Solicitado por: <span class="font-bold">{{ $ot->nombre_solicitante }}</span></p>
            <div class="flex flex-col">
                <p class="font-bold">Firma solicitante: </p>
                <img class="w-1/2" src="{{ asset('uploads') . '/' . $ot->firma_solicitante }}" alt="Firma solicitante">
            </div>

            <p>Fecha propuesta de entrega: <span class="font-bold">{{ $ot->fecha_propuesta }}</span></p>

            @if ($ot->estado_id == 2)
            <p>Fecha de entrega: <span class="font-bold">{{ $ot->fecha_entrega }}</span></p>
            <p>Hora de inicio: <span class="font-bold">{{ $ot->hora_inicio }}</span></p>
            <p>Hora final: <span class="font-bold">{{ $ot->hora_final }}</span></p>
            @endif

            @if($ot->rechazada)
            <p class="inline-block text-white p-2 rounded-lg bg-red-500 uppercase font-bold mt-5">Fue rechazada alguna
                vez</p>
            <p class="mt-2"><span class="font-bold">Razón del rechazo:</span> {{ $ot->observaciones_eliminacion }}</p> 
            @endif

            @if (($ot->fecha_propuesta < \Carbon\Carbon::now()->format('Y-m-d')))
                <p class="mt-5 bg-red-500 inline-block p-2 font-bold text-white rounded">ATRASADA</p>
                @elseif (($ot->fecha_propuesta == \Carbon\Carbon::now()->format('Y-m-d') && $ot->estado_id != 3))
                <p class="mt-5 bg-blue-500 inline-block p-2 font-bold text-white rounded">SE ENTREGA EL DÍA DE HOY</p>
            @endif
            
        </div>


    </div>

</div>
<div class="mt-5 flex items-center justify-between flex-col md:flex-row">
    <div class="flex flex-col gap-2 mb-10 md:flex-col md:gap-0 md:mb-0">
        @if ($ot->estado_id == 2)
        <div>
            <h1 class="text-xl font-bold uppercase">Trabajo realizado: </h1>
            <p>{{ $ot->trabajo_realizado }}</p>
        </div>

        <div>
            <h1 class="text-xl font-bold uppercase">Repuestos Utilizados: </h1>
            <p>{{ $ot->repuestos_utilizados }}</p>
        </div>
        @endif

    </div>
</div>


<div class="flex flex-row gap-2 justify-end">
    @if($ot->estado_id == 1)
    <a href="{{ route('documentoOT.edit',$ot) }}"
        class="bg-green-500 text-white p-2 cursor-pointer rounded-lg hover:bg-green-600 font-bold uppercase">
        Ya realicé el trabajo!
    </a>
    @elseif ($ot->estado_id == 2)
        @hasanyrole('admin|adminmanto')
            <a href="{{ route('documentoOT.edit',$ot) }}"
                class="bg-green-500 text-white p-2 cursor-pointer rounded-lg hover:bg-green-600 font-bold uppercase text-center">
                Firmar Revisión
            </a>

            @csrf
            
            <button id="rechazarBtn" class="bg-red-500 text-white p-2 cursor-pointer rounded-lg hover:bg-red-600 font-bold uppercase">Rechazar</button>
        @endhasanyrole
    @endif
</div>
@endsection