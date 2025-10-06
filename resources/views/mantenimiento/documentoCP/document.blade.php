@extends('layouts.documents')

@section('titulo')
Documento
@endsection

@section('loadscreen')
    <x-loading-screen />
@endsection

@section('contenido')
<div class="text-xs flex flex-col h-2/3 documento-wrapper pb-96 px-10 pt-10" id="documento3">
    <div class="grid grid-cols-3 border border-black" id="documento3">

        <div class="flex justify-center items-center border-x">
            <img class="w-60" src="{{ asset('img/LOGO_LX.png') }}" name="ImagenLogo" />
        </div>

        <div class="text-center border-x border-black">
            <p class="border-b border-black text-4xl py-3">FORMATO</p>
            <p class="no-margin text-4xl">CHECK LIST PREOPERACIONAL FUNCIONAMIENTO DEL EQUIPO</p>
        </div>
        <div class="text-start border-x">
            <p class="px-2 border-b border-black text-4xl py-3">CÓDIGO:
                @if ($documentocp->planta_id != 2)
                    FOR-MN-07
                @else
                    FOR-MN-{{ $documentocp->planta->prefix_docs }}-07
                @endif
            </p>
            <p class="px-2 text-4xl py-3">VERSIÓN: 03</p>
            <p class="px-2 border-t text-4xl py-3 border-black">Página <span class="font-bold">1</span> de <span
                    class="font-bold">1</span></p>
        </div>
    </div>

    <div class="grid grid-cols-2 mt-5">
        <div class="flex gap-3 text-4xl">
            <p>Planta: </p>
            <p> {{ ($documentocp->planta_id == 1) ? 'I.Q.F.1' : $documentocp->planta->name}}</p>
        </div> 
        <div class="justify-end flex gap-5 text-4xl">
            <p>Fecha: </p>
            <p>{{ $documentocp->fecha }}</p>
        </div>
        <div class=" col-start-1 col-span-2">
            <p class="text-4xl">Instruccciones: Se debe de revisar el funcionamiento correcto y el estado físico de la
                máquinaria y sus elementos en general como: soldaduras, cuchillas ( es revisada la posición correcta),
                bandas, mallas, tornillos, tuercas, bisagras, etc. Que todos esten completos, integros y en buenas
                condiciones de Mantenimiento. </p>
        </div>

    </div>

    <div class="grid grid-cols-2 grid-rows-2 mt-5 gap-5">

        @php
            $contador = 1;
        @endphp

        <div class="flex flex-col borderb-0 border-t border-r border-l border-b border-black">
            <div class="grid grid-cols-12 text-center">
                <p style="height: 42px" class="border-r border-black text-2xl">AREA</p>
                <p style="height: 42px" class="border-r border-black text-2xl">ITEM</p>
                <p style="height: 42px" class="border-r col-start-3 col-span-3 border-black text-2xl">UBICACIÓN</p>
                <p style="height: 42px" class="border-r border-black text-2xl">OK</p>
                <p style="height: 42px" class="border-r border-black col-start-7 col-span-2 text-2xl">PROBLEMA</p>
                <p style="height: 42px" class="border-r border-black col-start-9 col-span-2 text-2xl">ACCIÓN TOMADA</p>
                <p style="height: 42px" class="border-r border-black text-2xl">RESPONSABLE</p>
                <p style="height: 42px" class="border-black text-2xl">INSPECTOR</p>
            </div>

            @foreach ($areasT1 as $area)
            <div class="grid grid-cols-12 text-center border-b">
                <div class="text-2xl flex flex-col justify-center items-center p-5 last:border-0 border-b border-r border-black">
                    <p>{{$area->area->area}}</p>
                </div>
                <div class="border-r border-black">
                    @foreach ($area->area->elementos as $elemento)
                    <p style="height: 42px" class="text-2xl first:border-t last:border-b-0 border-b border-black">{{ $contador }}</p>
                    @php
                        $contador++;
                    @endphp
                    @endforeach
                </div>

                <div class="col-start-3 col-span-3 border-r border-black">
                    @foreach ($area->area->elementos as $elemento)
                    <p style="height: 42px" class="text-xl first:border-t last:border-0 border-b  border-black text-left">{{ $elemento->elemento }}</p>
                    @endforeach
                </div>

                <div class="border-r border-black">
                    @foreach ( $area->elementos as $elemento)
                    <p style="height: 42px" class="text-xl first:border-t last:border-0 border-b border-black">{{ ($elemento->ok == 1) ? 'OK' : '' }}
                    </p>
                    @endforeach
                </div>

                <div class="col-start-7 col-span-2 border-r border-black">
                    @foreach ( $area->elementos as $elemento)
                    <p style="height: 42px" class="text-xl first:border-t last:border-0 border-b border-black">{{ ($elemento->problema != '') ?
                        $elemento->problema : '' }}</p>
                    @endforeach
                </div>

                <div class="col-start-9 col-span-2 border-r border-black">
                    @foreach ( $area->elementos as $elemento)
                    <p style="height: 42px" class="text-xl first:border-t last:border-0 border-b border-black">{{ ($elemento->accion != '') ?
                        $elemento->accion : '' }}</p>
                    @endforeach
                </div>

                <div class="border-r border-black">
                    @foreach ( $area->elementos as $elemento)
                    @php
                    $nombreOt = ($elemento->orden_trabajos_id) ? "FOR_MN_04_" . $elemento->orden_trabajos_id : '';
                    @endphp
                    <p style="height: 42px" class="text-xl last:border-0 first:border-t border-b border-black">{{ ($elemento->orden_trabajos_id != '') ?
                        $nombreOt : '' }}</p>
                    @endforeach
                </div>

                <div class="flex justify-center items-center first:border-t border-b border-black ">
                    <img src="{{ asset('uploads') . '/' . $area->firma }}" alt="Imagen Firma" class="w-96">
                </div>
            </div>
            @endforeach
        </div>

        <div class="flex flex-col borderb-0 border-t border-r border-l border-black">
            <div class="grid grid-cols-12 text-center">
                <p style="height: 42px" class="text-2xl border-r border-black border-b">AREA</p>
                <p style="height: 42px" class="text-2xl border-r border-black border-b">ITEM</p>
                <p style="height: 42px" class="text-2xl border-r border-black col-start-3 col-span-3 border-b">UBICACIÓN</p>
                <p style="height: 42px" class="text-2xl border-r border-black border-b">OK</p>
                <p style="height: 42px" class="text-2xl border-r border-black col-start-7 col-span-2 border-b">PROBLEMA</p>
                <p style="height: 42px" class="text-2xl border-r border-black col-start-9 col-span-2 border-b">ACCIÓN TOMADA</p>
                <p style="height: 42px" class="text-2xl border-r border-black border-b">RESPONSABLE</p>
                <p style="height: 42px" class="text-2xl border-black border-b">INSPECTOR</p>
            </div>

            @foreach ($areasT2 as $area)
            <div class="grid grid-cols-12 text-center border-b h-auto border-black">
                <div class="text-2xl flex flex-col justify-center items-center p-5 border-r ">
                    <p>{{$area->area->area}}</p>
                </div>

                <div class="border-r border-l  border-black">
                    @foreach ($area->area->elementos as $elemento)
                    <p style="height: 42px" class="text-2xl last:border-b-0 border-b border-black">{{ $contador }}</p>
                    @php
                    $contador++;
                    @endphp
                    @endforeach
                </div>

                <div class="col-start-3 col-span-3 border-r border-black">
                    @foreach ($area->area->elementos as $elemento)
                    <p style="height: 42px" class="text-xl last:border-b-0 border-b border-black text-left py-1">{{ $elemento->elemento }}</p>
                    @endforeach
                </div>

                <div class="border-r last:border-b-0 border-black">
                    @foreach ( $area->elementos as $elemento)
                    <p style="height: 42px" class="text-xl last:border-b-0 border-b border-black py-1">{{ ($elemento->ok == 1) ? 'OK' : '' }}
                    </p>
                    @endforeach
                </div>

                <div class="col-start-7 col-span-2 border-r border-black">
                    @foreach ( $area->elementos as $elemento)
                    <p style="height: 42px" class="text-xl last:border-b-0 border-b border-black py-1">{{ ($elemento->problema != '') ?
                        $elemento->problema : '' }}</p>
                    @endforeach
                </div>

                <div class="col-start-9 col-span-2 border-r border-black">
                    @foreach ( $area->elementos as $elemento)
                    <p style="height: 42px" class="text-xl last:border-b-0 border-b border-black py-1">{{ ($elemento->accion != '') ?
                        $elemento->accion : '' }}</p>
                    @endforeach
                </div>

                <div class="border-r border-black ">
                    @foreach ( $area->elementos as $elemento)
                    @php
                    $nombreOt = ($elemento->orden_trabajos_id) ? "FOR_MN_04_" . $elemento->orden_trabajos_id : '';
                    @endphp
                    <p style="height: 42px" class="text-xl last:border-b-0 border-b border-black py-1">{{ ($elemento->orden_trabajos_id != '') ?
                        $nombreOt : '' }}</p>
                    @endforeach
                </div>

                <div class="flex justify-center items-center">
                    <img src="{{ asset('uploads') . '/' . $area->firma }}" alt="Imagen Firma" class="w-96">
                </div>
            </div>
            @endforeach
        </div>


        <div class="mt-5 col-span-2 text-4xl">
            <div class="border border-black p-5">
                <p>Observaciones: {{ $documentocp->observaciones }}</p>
            </div>

            <div class="flex justify-between">
                <div class="flex  flex-col justify-center items-center">
                    <img src="{{ asset('uploads') . '/' . $documentocp->verificado_firma }}" alt="Imagen Firma"
                        width="500">
                    <p>Verificado por</p>
                </div>

                <div class="flex  flex-col justify-center items-center">
                    <img style="" src="{{ asset('uploads') . '/' . $documentocp->jefemanto_firma }}" alt="Imagen Firma"
                        width="500">
                    <p>Jefe de mantenimiento</p>
                </div>

                <div class="flex  flex-col justify-center items-center">
                    <img style="" src="{{ asset('uploads') . '/' . $documentocp->supervisor_firma }}" alt="Imagen Firma"
                        width="500">
                    <p>Supervisor de calidad</p>
                </div>
            </div>

            <div class="flex justify-between items-center mt-5 pie-pagina text-4xl">
                <p>
                    @if ($documentocp->planta_id != 2)
                        FOR-MN-07
                    @else
                        FOR-MN-{{ $documentocp->planta->prefix_docs }}-07
                    @endif
                </p>
                <div class="flex flex-col justify-center items-center">
                    <p>APROBADO GCC</p>
                    <p class="mb-10 ">Agroindustria Legumex, Chimaltenango, Guatemala</p>
                </div>
                <p>Enero 2024</p>
            </div>
        </div>

    </div>

</div>

@endsection