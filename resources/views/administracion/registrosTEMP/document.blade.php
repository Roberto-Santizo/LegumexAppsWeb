@extends('layouts.documents')

@section('titulo')
Documento
@endsection

{{-- @section('loadscreen')
<x-loading-screen />
@endsection --}}

@section('contenido')
<div id="documento5" class="documento-wrapper">
    <div class="grid grid-cols-3 border border-black ">
        <div class="flex justify-center items-center">
            <img class="w-1/2" src="{{ asset('img/LOGO_LX.png') }}" name="ImagenLogo" />
        </div>

        <div class="text-center border-l border-black">
            <p class="border-b border-black p-1.5">FORMATO</p>
            <p class="no-margin p-1.5">REGISTROS DE TEMPERATURA</p>
        </div>
        <div class="text-start border-l border-black">
            <p class="p-1.5 border-b border-black">CÓDIGO: FOR-MN-06</p>
            <p class="p-1.5  border-black">VERSIÓN: 04</p>
            <p class="p-1.5 border-t border-black">Página <span class="font-bold">1</span> de <span
                    class="font-bold">1</span></p>
        </div>
    </div>

    <div class="mt-5 flex justify-between items-center p-5">
        <p>Planta: I.Q.F.1</p>
        <p>Fecha: 10:44 AM</p>
    </div>

    <div class="grid grid-cols-16">

        <div class="grid grid-rows-2 col-span-4 border border-black text-center">
            <p>CONTROL DE TEMPERATURA CUARTOS FRIOS</p>
            <div class="grid grid-cols-2">
                <p class="border-r border-t border-black">REGISTRO DE ÁREA</p>
                <p class="border-t border-black">TEMPERATURA IDEAL</p>
            </div>
        </div>

        <p class="flex items-center justify-center border-t border-b border-black">08:00</p>
        <p class="flex items-center justify-center border-t border-l border-b border-black">10:00</p>
        <p class="flex items-center justify-center border-t border-l border-b border-black">12:00</p>
        <p class="flex items-center justify-center border-t border-l border-b border-black">14:00</p>
        <p class="flex items-center justify-center border-t border-l border-b border-black">16:00</p>
        <p class="flex items-center justify-center border-t border-l border-b border-black">18:00</p>
        <p class="flex items-center justify-center border-t border-l border-b border-black">20:00</p>
        <p class="flex items-center justify-center border-t border-l border-b border-black">22:00</p>
        <p class="flex items-center justify-center border-t border-l border-b border-black">00:00</p>
        <p class="flex items-center justify-center border-t border-l border-b border-black">02:00</p>
        <p class="flex items-center justify-center border-t border-l border-b border-black">04:00</p>
        <p class="flex items-center justify-center border-t border-l border-b border-r border-black">06:00</p>

        <div class="grid grid-rows-2 col-span-4 text-center">
            <div class="grid grid-cols-2">
                <p class="border-l border-r border-b border-black p-2">ANTECAMARA RECEPCIÓN</p>
                <p class="border-r border-b border-black p-2">45°F A 50°F</p>
            </div>

            <div class="grid grid-cols-2">
                <p class="border-l border-r border-b border-black p-2">CUARTO FRIO M.P.</p>
                <p class="border-r border-b border-black p-2">34°F A 40°F</p>
            </div>

            <div class="grid grid-cols-2">
                <p class="border-l border-r border-b border-black p-2">I.Q.F. LINEA 1</p>
                <p class="border-r border-b border-black p-2">0°F A -10°F</p>
            </div>

            <div class="grid grid-cols-2">
                <p class="border-l border-r border-b border-black p-2">I.Q.F. LINEA 2</p>
                <p class="border-r border-b border-black p-2">0°F A -10°F</p>
            </div>

            <div class="grid grid-cols-2">
                <p class="border-l border-r border-b border-black p-2">REEMPAQUE 1 Y 2</p>
                <p class="border-r border-b border-black p-2">38°F A 40°F</p>
            </div>

            <div class="grid grid-cols-2">
                <p class="border-l border-r border-b border-black p-2">REEMPAQUE 3</p>
                <p class="border-r border-b border-black p-2">38°F A 40°F</p>
            </div>

            <div class="grid grid-cols-2">
                <p class="border-l border-r border-b border-black p-2">ANTECAMARA EMBARQUES</p>
                <p class="border-r border-b border-black p-2">40°F A 45°F</p>
            </div>

            <div class="grid grid-cols-2">
                <p class="border-l border-r border-b border-black p-2">HOLDING FREEZER</p>
                <p class="border-r border-b border-black p-2">0°F A -10°F</p>
            </div>
        </div>

        <div class="grid grid-cols-12 col-span-12">
            @for ($i = 1; $i <= 96; $i++) 
            <div class="border-r border-b border-black" style="height:41px; width:120px;">
                <p>°F</p>
            </div>
            @endfor

    </div>

</div>

<div class="mt-10 col-span-2">

    <div class="flex justify-between">
        <div class="flex  flex-col justify-center items-center">
            <p>Tecnico de turno</p>
        </div>

        <div class="flex  flex-col justify-center items-center">
            <p>Revisado Por</p>
        </div>

        <div class="flex  flex-col justify-center items-center">
            <p>Jefe de mantenimiento</p>
        </div>
    </div>

    <div class="border border-black p-5">
        <p>Observaciones: </p>
    </div>


    <div class="flex justify-between items-center mt-10 pie-pagina">
        <p>FOR-MN-06</p>
        <div class="flex flex-col justify-center items-center">
            <p>APROBADO GCC</p>
            <p class="mb-10 ">Agroindustria Legumex, Chimaltenango, Guatemala</p>
        </div>
        <p>Septiembre 2023</p>
    </div>
</div>
@endsection