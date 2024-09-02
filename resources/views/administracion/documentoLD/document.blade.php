@extends('layouts.documents')

@section('titulo')
Documento
@endsection

@section('loadscreen')
<x-loading-screen />
@endsection

@section('contenido')
<div id="documento" class="documento-wrapper">
    <div class="grid grid-cols-3 border border-black border-separate border-spacing-0">
        <div class="flex justify-center items-center border-black">
            <img class="w-1/2" src="{{ asset('img/LOGO_LX.png') }}" name="ImagenLogo" />
        </div>

        <div class="text-center border-l border-black">
            <p class="border-b border-black p-1.5">FORMATO</p>
            <p class="no-margin">INSPECCIÓN LAVADO Y</p>
            <p class="no-margin p-1.5">DESINFECCIÓN DE HERRAMIENTAS</p>
        </div>
        <div class="text-start border-l border-black">
            <p class="p-1.5 border-black">CÓDIGO: FOR-MN-08</p>
            <p class="p-1.5 border-y border-black">VERSIÓN: 03</p>
            <p class="p-1.5 border-black">Página <span class="font-bold">1</span> de <span class="font-bold">1</span>
            </p>
        </div>
    </div>

    <div class="mt-5">
        <div class="grid grid-cols-4 border border-black border-separate border-spacing-0">
            <p class="p-2 border-r border-b border-black">Técnico de Mantenimiento: </p>
            <p class="p-2 border-r border-b  border-black">{{ $documentold->tecnico_mantenimiento }}</p>
            <p class="p-2 border-r border-b  border-black">Fecha: </p>
            <p class="p-2 border-b border-black">{{ $documentold->fecha }}</p>
            <p class="p-2 border-r border-black">Planta: </p>
            <p class="p-2 border-r border-black">{{ $documentold->planta->name }}</p>
            <p class="p-2 border-r border-black">Área: </p>
            <p class="p-2 border-black">{{ $documentold->area->area }}</p>
        </div>

        <h1 class="text-center font-bold border-x border-black p-2 border-separate border-spacing-0">INGRESO DE
            HERRAMIENTAS</h1>

        <div class="border-separate border-spacing-0">
            <div class="grid grid-cols-12 grid-rows-2">
                <p class="p-2 border border-black row-start-1 row-span-2 flex justify-center items-center">ÍTEM</p>
                <p
                    class="p-2 border-t border-b border-r border-black row-start-1 row-span-2 col-start-2 col-span-5 flex justify-center items-center">
                    HERRAMIENTA</p>
                <p class="p-2 border-t border-black col-start-7 col-span-3 text-center">LAVADO</p>
                <div class="grid grid-cols-2 col-start-7 col-span-3">
                    <p class="p-2 border-t border-b border-black text-center">SI</p>
                    <p class="p-2 border-l border-t border-r border-b border-black text-center">NO</p>
                </div>
                <p class="p-2 border-t border-x border-black row-start-1 col-start-10 col-span-3 text-center">
                    DESINFECCIÓN</p>
                <div class="grid grid-cols-2 col-start-10 col-span-3">
                    <p class="p-2 border-t border-b border-black text-center">SI</p>
                    <p class="p-2 border-t border-x border-b border-black text-center">NO</p>
                </div>
            </div>

            @php
            $contador = 1;
            @endphp

            @foreach ($documentold->herramientas as $herramienta)
            <div class="grid grid-cols-12 border-separate border-spacing-0">
                <p class="p-2 border-b border-l border-black row-start-1 row-span-2 flex justify-center items-center">{{
                    $contador
                    }}</p>
                <p
                    class="p-2 border-x border-b border-black row-start-1 row-span-2 col-start-2 col-span-5 flex items-center">
                    {{
                    $herramienta->herramienta->herramienta }}</p>
                <div class="grid grid-cols-2 col-start-7 col-span-3">
                    <p class="p-2 border-b border-black text-center">
                        @if($herramienta->lavada_entrada === 1)
                        x
                        @endif
                    </p>
                    <p class="p-2 border-l border-b border-r border-black text-center">
                        @if ($herramienta->lavada_entrada === 0)
                        x
                        @endif
                    </p>
                </div>

                <div class="grid grid-cols-2 col-start-10 col-span-3">
                    <p class="p-2 border-r border-b border-black text-center">
                        @if($herramienta->desinfectada_entrada === 1)
                        x
                        @endif
                    </p>
                    <p class="p-2 border-r border-b border-black text-center">
                        @if($herramienta->desinfectada_entrada === 0)
                        x
                        @endif
                    </p>
                </div>
            </div>
            @php
            $contador++;
            @endphp
            @endforeach
        </div>

        <h1 class="text-center font-bold  border-black p-2 border-separate border-spacing-0">SALIDA DE
            HERRAMIENTAS</h1>

        <div class="border-separate border-spacing-0">
            <div class="grid grid-cols-12 grid-rows-2">
                <p class="p-2 border border-black row-start-1 row-span-2 flex justify-center items-center">ÍTEM</p>
                <p
                    class="p-2 border-t border-b border-r border-black row-start-1 row-span-2 col-start-2 col-span-5 flex justify-center items-center">
                    HERRAMIENTA</p>
                <p class="p-2 border-t border-black col-start-7 col-span-3 text-center">LAVADO</p>
                <div class="grid grid-cols-2 col-start-7 col-span-3">
                    <p class="p-2 border-t border-b border-black text-center">SI</p>
                    <p class="p-2 border-l border-t border-r border-b border-black text-center">NO</p>
                </div>
                <p class="p-2 border-t border-x border-black row-start-1 col-start-10 col-span-3 text-center">
                    DESINFECCIÓN</p>
                <div class="grid grid-cols-2 col-start-10 col-span-3">
                    <p class="p-2 border-t border-b border-black text-center">SI</p>
                    <p class="p-2 border-t border-x border-b border-black text-center">NO</p>
                </div>
            </div>

            @php
            $contador = 1;
            @endphp

            @foreach ($documentold->herramientas as $herramienta)
            <div class="grid grid-cols-12 border-separate border-spacing-0">
                <p class="p-2 border-b border-l border-black row-start-1 row-span-2 flex justify-center items-center">{{
                    $contador
                    }}</p>
                <p
                    class="p-2 border-x border-b border-black row-start-1 row-span-2 col-start-2 col-span-5 flex items-center">
                    {{
                    $herramienta->herramienta->herramienta }}</p>
                <div class="grid grid-cols-2 col-start-7 col-span-3">
                    <p class="p-2 border-b border-black text-center">
                        @if($herramienta->lavada_salida === 1)
                        x
                        @endif
                    </p>
                    <p class="p-2 border-l border-r border-b border-black text-center">
                        @if ($herramienta->lavada_salida === 0)
                        x
                        @endif
                    </p>
                </div>

                <div class="grid grid-cols-2 col-start-10 col-span-3">
                    <p class="p-2 border-r border-b border-black text-center">
                        @if($herramienta->desinfectada_salida === 1)
                        x
                        @endif
                    </p>
                    <p class="p-2 border-r border-b border-black text-center">
                        @if($herramienta->desinfectada_salida === 0)
                        x
                        @endif
                    </p>
                </div>
            </div>
            @php
            $contador++;
            @endphp
            @endforeach
        </div>
    </div>

    <div class="mt-10 grid grid-cols-3 grid-rows-3 border-b border-black">

        <h1
            class="text-center font-bold border-t border-l border-black p-2 col-start-1 col-span-2 flex items-center justify-center">
            INSPECCIÓN CONTROL DE CALIDAD</h1>
        <h1
            class="text-center font-bold border-x border-t border-black p-2 col-start-3 flex items-center justify-center">
            INSPECTOR DE CALIDAD</h1>

        <div class="grid grid-cols-2 border border-black gap-5 col-start-1 col-span-2">
            <div class="flex gap-5 p-5 border-x border-black">
                <p class="text-xs">INGRESO DE HERRAMIENTAS</p>

                <div class="flex gap-5">
                    <p
                        class="h-2/3 text-xs border border-black p-2 @if($documentold->entrada === 1) bg-green-500 @endif">
                        BUENO</p>
                    <p class="h-2/3 text-xs border border-black p-2 @if($documentold->entrada === 0) bg-red-500 @endif">
                        MALO</p>

                </div>
            </div>

            <div class="break-words">
                <p><span class="font-bold">OBSERVACIONES:</span> {{ $documentold->observaciones_entrada }}</p>
            </div>
        </div>

        <div class="grid grid-cols-2  border-black gap-5 col-start-1 col-span-2">
            <div class="flex gap-5 p-5  border-x border-black">
                <p class="text-xs">SALIDA DE HERRAMIENTAS</p>
                <div class="flex gap-5">
                    <p
                        class="h-2/3 text-xs border border-black p-2 @if($documentold->salida === 1) bg-green-500 @endif">
                        BUENO</p>
                    <p class="h-2/3 text-xs border border-black p-2 @if($documentold->salida === 0) bg-red-500 @endif">
                        MALO</p>
                </div>
            </div>
            <div class="break-words">
                <p><span class="font-bold">OBSERVACIONES:</span> {{ $documentold->observaciones_salida }}</p>
            </div>
        </div>

        <div class="flex justify-center items-center col-start-3 row-start-2 border-t border-r border-black">
            <img width="200" height="100" src="{{ asset('uploads') . '/' . $documentold->firma_entrada }}"
                alt="Imagen Firma">
        </div>

        <div class="flex justify-center items-center col-start-3 row-start-3 border-t border-l border-r border-black">
            <img width="200" height="100" src="{{ asset('uploads') . '/' . $documentold->firma_salida }}"
                alt="Imagen Firma">
        </div>
    </div>

    <div class="border border-black mt-5 p-3 break-words mb-5">
        <p>Observaciones: {{ $documentold->observaciones }}</p>
    </div>

    <div class="flex justify-between items-center w-full">
        <div class="flex justify-center items-center flex-col gap-2">
            <img src="{{ asset('uploads') . '/' . $documentold->tecnico_firma }}" alt="Imagen Firma">
            <p class="mb-5">Técnico de Mantenimiento</p>
        </div>

        <div class="flex justify-center items-center flex-col gap-2">
            <img src="{{ asset('uploads') . '/' . $documentold->inspector_firma }}" alt="Imagen Firma">
            <p class="mb-5">Inspector de Calidad</p>
        </div>

        <div class="flex justify-center items-center flex-col gap-2">
            <img src="{{ asset('uploads') . '/' . $documentold->asistente_firma }}" alt="Imagen Firma">
            <p class="mb-5">Asistente de Mantenimiento</p>
        </div>
    </div>
</div>

<div class="flex justify-between items-center mt-10 pie-pagina">
    <p>FOR-MN-08</p>
    <div class="flex flex-col justify-center items-center">
        <p>APROBADO GCC</p>
        <p class="mb-5">Agroindustria Legumex, Chimaltenango, Guatemala</p>
    </div>
    <p>Septiembre 2023</p>
</div>
@endsection