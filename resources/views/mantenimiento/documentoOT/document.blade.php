@extends('layouts.documents')

@section('titulo')
    Documento
@endsection

@section('loadscreen')
    <x-loading-screen />
@endsection

@section('contenido')
    <div id="documento2" class="documento-wrapper">
        <div class="grid grid-cols-3 border border-black ">
            <div class="flex justify-center items-center">
                <img class="w-1/2" src="{{ asset('img/LOGO_LX.png') }}" name="ImagenLogo"/>
            </div>
            
            <div class="text-center border-l border-black">
                <p class="border-b border-black p-1.5">FORMATO</p>
                <p class="no-margin p-1.5">ORDENES DE TRABAJO</p>
            </div>
            <div class="text-start border-l border-black">
                <p class="p-1.5 border-b border-black">CÓDIGO: FOR-MN-04</p>
                <p class="p-1.5  border-black">VERSIÓN: 05</p>
                <p class="p-1.5 border-t border-black">Página <span class="font-bold">1</span> de <span class="font-bold">1</span></p>
            </div>
        </div> 

        <div class="grid grid-cols-8 grid-rows-2 mt-10">
            <div class="border border-black p-2 inline-block col-start-1 col-span-2">
                <p class="font-bold">PLANTA: {{ $ot->planta->planta }} </p>
            </div>
            <div class="border border-black p-2 inline-block col-start-4 col-span-2">
                <p class="font-bold">ÁREA: {{ $ot->area->area }}</p>
            </div>
            <div class="border border-black p-2 inline-block col-start-7 col-span-2">
                <p class="font-bold">NO: {{ $ot->id }} </p>
            </div>
            <div class="border-x border-b border-black p-2 inline-block col-start-1 col-span-2">
                <p class="font-bold">FECHA: {{ \Illuminate\Support\Carbon::parse($ot->created_at)->format('d-m-Y')  }}</p>
            </div>
        </div>

        <div class="grid grid-cols-3 w-5/6">
            <div class="mt-5 flex flex-col gap-1">
                <div class="grid grid-cols-3">
                    <p class="text-xs">RECEPCIÓN DE M.P</p>
                    <div class="border border-black p-1 w-1/4" style="height: 20px;"></div>
                </div>
                
                <div class="grid grid-cols-3">
                    <p class="text-xs">ÁREA DE PREPARACIÓN</p>
                    <div class="border border-black p-1 w-1/4" style="height: 20px;"></div>
                </div>
                
                <div class="grid grid-cols-3">
                    <p class="text-xs">PROCESO</p>
                    <div class="border border-black p-1 w-1/4" style="height: 20px;"></div>
                </div>
                
                <div class="grid grid-cols-3">
                    <p class="text-xs">EMPAQUE</p>
                    <div class="border border-black p-1 w-1/4" style="height: 20px;"></div>
                </div>
        
                <div class="grid grid-cols-3">
                    <p class="text-xs">EMBARQUES</p>
                    <div class="border border-black p-1 w-1/4" style="height: 20px;"></div>
                </div>
            </div>
    
            <div class="mt-5 flex flex-col gap-1">
                <div class="grid grid-cols-3">
                    <p class="text-xs">ADMINISTRACIÓN</p>
                    <div style="height: 20px;" class="border border-black p-1 w-1/4 {{ ($ot->area_id == 19) ? 'bg-green-500' : (($ot->area_id == 24) ? 'bg-green-500' : '') }}"></div>
                </div>
                
                <div class="grid grid-cols-3">
                    <p class="text-xs">MANTENIMIENTO</p>
                    <div style="height: 20px;" class="border border-black p-1 w-1/4 {{ ($ot->area_id == 20) ? 'bg-green-500' : (($ot->area_id == 25) ? 'bg-green-500' : '') }}"></div>
                </div>
                
                <div class="grid grid-cols-3">
                    <p class="text-xs">GARITA</p>
                    <div style="height: 20px;" class="border border-black p-1 w-1/4 {{ ($ot->area_id == 21) ? 'bg-green-500' : (($ot->area_id == 26) ? 'bg-green-500' : '') }}"></div>
                </div>
                
                <div class="grid grid-cols-3">
                    <p class="text-xs">BODEGAS</p>
                    <div style="height: 20px;" class="border border-black p-1 w-1/4 {{ ($ot->area_id == 22) ? 'bg-green-500' : (($ot->area_id == 27) ? 'bg-green-500' : '') }}"></div>
                </div>
        
                <div class="grid grid-cols-3">
                    <p class="text-xs">OTROS</p>
                    <div style="height: 20px;" class="border border-black p-1 w-1/4 {{ ($ot->area_id == 23) ? 'bg-green-500' : (($ot->area_id == 28) ? 'bg-green-500' : '') }}"></div>
                </div>
            </div>

            <div class="grid grid-cols-4">
                <p class="text-xs col-start-3 col-span-2 border border-black p-2">Especifique: {{ ($ot->especifique) ? $ot->especifique : '' }}</p>
            </div>
        </div>
       
        <div class="grid grid-cols-4 mt-10 border border-black">
            <p class="p-3">EQUIPO CON PROBLEMA</p>

            <p class="border-l border-black p-3">{{  ($ot->elemento_id) ? $ot->elemento->elemento : $ot->equipo_problema}}</p>
            
            <p class="border-t border-black p-3">ES NECESARIO RETIRAR EL EQUIPO</p>
            <div class="flex gap-5 justify-around border-l border-t border-black p-1">
                <div class="flex gap-2 justify-center items-center">
                    <p>SI</p>
                    <p class="border border-black p-1 w-8 h-8 flex justify-center items-center {{ ($ot->retiro_equipo == 1) ? 'bg-green-500' : '' }}"></p>
                </div>
                <div class="flex gap-2 justify-center items-center">
                    <p>NO</p>
                    <p class="border border-black p-1 w-8 h-8 flex justify-center items-center {{ ($ot->retiro_equipo == 2) ? 'bg-green-500' : '' }}"></p>
                </div>
            </div>
            <p class="col-start-3 col-span-1 row-start-1 border-l border-b border-black p-3">CÓDIGO</p>
            <p class="col-start-4 col-span-1 row-start-1 border-l border-black"></p>
            <p class="border-l border-r border-black"></p>
            <p class="border-t border-black"></p>
        </div>

        <div class="mt-5 flex justify-between w-2/3">
            <div>
                <p class="font-bold">SOLICITADO POR:</p>
                <p>NOMBRE: {{ $ot->nombre_solicitante }}</p>
                <div class="flex">
                    <p>FIRMA: </p>
                    <img class="w-48 h-36" src="{{ asset('uploads') . '/' . $ot->firma_solicitante }}" alt="Imagen Firma">
                </div>
            </div>
            <div>
                <p class="font-bold">SUPERVISOR DE ÁREA:</p>
                <p>NOMBRE: {{ $ot->supervisor->name }}</p>
                <div class="flex">
                    <p>FIRMA: </p>
                    <img class="w-48 h-36" src="{{ asset('uploads') . '/' . $ot->firma_supervisor }}" alt="Imagen Firma">
                </div>
            </div>
        </div>

        <div class="mt-5 flex">
            <p class="font-bold text-sm">FECHA PROPUESTA DE ENTREGA</p>
            <p class="border border-black w-full">{{ \Illuminate\Support\Carbon::parse($ot->fecha_propuesta)->format('d-m-Y')  }}</p>
        </div>

        <div class="mt-5">
            <p class="border border-black  py-5"><span class="font-bold">ANTECEDENTES/PROBLEMAS DETECTADOS: </span> {{ $ot->problema_detectado }}</p>
        </div>

        <div class="mt-5">
            <p class="border border-black py-5"><span class="font-bold">TRABAJO REALIZADO: </span>{{ $ot->trabajo_realizado }}</p>
        </div>

        <div class="mt-5">
            <p class="border border-black py-5"><span class="font-bold">REPUESTOS UTILIZADOS: </span>{{ $ot->repuestos_utilizados }}</p>
        </div>

        <h1 class="text-center font-bold py-5">DEPARTAMENTO DE MANTENIMIENTO</h1>
        
        <div class="grid grid-cols-8 grid-rows-5 border border-black">
            <h3 class="col-start-1 col-span-4 text-center  border-black">MECÁNICO ASIGNADO</h3>
            <p class="row-start-2 col-start-1 col-span-4 border-t border-black p-1">NOMBRE: {{ $ot->usuario->name }}</p>

            <p class="row-start-3 col-start-1 col-span-4 border-t border-black p-1">FECHA DE ENTREGA: {{ \Illuminate\Support\Carbon::parse($ot->fecha_entrega)->format('d-m-Y') }}</p>

            <div class="row-start-4 col-start-1 col-span-4 border-t border-black flex gap-5">
                <p>Firma: </p>
                <img width="200"  src="{{ asset('uploads') . '/' . $ot->firma_mecanico }}" alt="Imagen Firma">
            </div>

            <h3 class="col-start-5 col-span-4  text-center row-start-1 border-l border-black">JEFE DE MANTENIMIENTO</h3>
            <p class="row-start-2 col-start-5 col-span-4 border-l border-t border-black p-1">NOMBRE: {{ $ot->jefemanto_nombre }}</p>

            <p class="row-start-3 col-start-5 col-span-4 border-l border-t border-black p-1">FECHA DE INSPECCIÓN: {{ \Illuminate\Support\Carbon::parse($ot->fecha_inspeccion)->format('d-m-Y') }}</p>

            <div class="row-start-4 col-start-5 col-span-4 border-t border-l border-black flex gap-5">
                <p>Firma: </p>
                <img width="200" src="{{ asset('uploads') . '/' . $ot->jefemanto_firma }}" alt="Imagen Firma">
            </div>

            <h3 class="row-start-5 col-start-1 col-span-8 text-center flex justify-center items-center border-t border-black p-1 font-bold">HORA</h3>
            <p class="row-start-7 col-start-1 col-span-3 border-t border-black p-3">INICIO</p>
            <p class="row-start-7 col-start-4 border-l border-t border-black p-3">{{ $ot->hora_inicio }}</p>
            <p class="row-start-7 col-start-5 col-span-2 border-l border-t border-r border-black p-3">FINAL</p>
            <p class="row-start-7 col-start-7 col-span-2 border-t border-black p-3">{{ $ot->hora_final }}</p>
        </div>
        
        <div class="grid grid-cols-3">
            <h3 class="font-bold text-center py-5 col-start-1 col-span-3">CONTROL DE CALIDAD</h3>
            
            <div class="grid grid-cols-3 col-span-3 border border-black ">
                <div class="col-start-1 col-span-2 h-full flex flex-col gap-5">
                    
                    <p style="margin-top: 35px;" class="border-b border-black p-5">SE DEVOLVIÓ EL EQUIPO FIJO LIMPIO (SI APLICA)</p>
                    
                    <p class="border-b border-black p-5">LIMPIEZA ADECUADA DEL EQUIPO Y ÁREA DE TRABAJO</p>
                    <p class="border-b border-black p-5">ORDEN DE ÁREA DE TRABAJO</p>
                    <p class="p-5">LIBERACIÓN DE TRABAJO</p>
                </div>

                <div class="grid grid-cols-2  border-l border-black">
                    <div class="justify-center items-center">
                        <p class="flex items-center justify-center border-r border-b border-black font-bold" style="height:40px;">SI</p>
                        <p class="flex items-center justify-center border-b border-black border-r" style="height: 60px;">{{ ($ot->devolucion_equipo) ? 'X' : '' }}</p>
                        <p class="flex items-center justify-center border-b border-black border-r" style="height: 85px;">{{ ($ot->limpieza_equipo) ? 'X' : '' }}</p>
                        <p class="flex items-center justify-center border-b border-black border-r" style="height: 85px;">{{ ($ot->orden_area) ? 'X' : '' }}</p>
                        <p class="flex items-center justify-center border-black border-r" style="height: 85px;">{{ ($ot->liberacion_trabajo) ? 'X' : '' }}</p>
                    </div>
                    <div class="justify-center items-center">
                        <p class="flex items-center justify-center  border-b border-black font-bold" style="height:40px;">NO</p>
                        <p class="flex items-center justify-center border-b border-black" style="height: 60px;">{{ ($ot->devolucion_equipo) ? '' : 'X' }}</p>
                        <p class="flex items-center justify-center border-b border-black" style="height: 85px;">{{ ($ot->limpieza_equipo) ? '' : 'X' }}</p>
                        <p class="flex items-center justify-center border-b border-black" style="height: 85px;">{{ ($ot->orden_area) ? '' : 'X' }}</p>
                        <p class="flex items-center justify-center" style="height: 85px;">{{ ($ot->liberacion_trabajo) ? '' : 'X' }}</p>
                    </div>
                </div>

                <div class="border-l border-black col-start-7 col-span-2">
                    <h3 class="font-bold text-center" style="height:40px;">CONTROL DE CALIDAD</h3>
                    <p class="border-y border-black p-1 flex items-center gap-2" style="height: 60px;"><span class="font-bold">NOMBRE:</span> {{ $ot->inspectorCalidad->name }}</p>

                    <div class="flex  border-black p-1 flex-row gap-2" style="height: 170px;">
                        <p class="">FIRMA: </p>
                        <img class="" src="{{ asset('uploads') . '/' . $ot->firma_calidad }}" alt="Imagen Firma">
                    </div>
                    <p class="border-t border-black p-1">FECHA DE INSPECCIÓN: {{  \Illuminate\Support\Carbon::parse($ot->fecha_inspeccion_calidad)->format('d-m-Y') }}</p>
                </div>
            </div>
        </div>
    </div>

        <div class="flex justify-between items-center mt-10 pie-pagina">
            <p>FOR-MN-04</p>
            <div class="flex flex-col justify-center items-center">
                <p>APROBADO GCC</p>
                <p class="mb-10 ">Agroindustria Legumex, Chimaltenango, Guatemala</p>
            </div>
            <p>Septiembre 2023</p>
        </div>
@endsection