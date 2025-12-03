@extends('layouts.auth')

@section('titulo')
    Ordenes de trabajo del checklist: {{$documento->planta->planta}}  - {{ $documento->fecha }}
@endsection


@section('contenido')
    @if(count($ordenes) == 0)
        <p class="text-center mt-10 uppercase font-bold">El checklist preoperacional de esta fecha no tiene ordenes de trabajo relacionadas</p>
    @else
    <div class="space-y-4 p-5">
        @foreach ($ordenes as $orden)
          <div class="bg-white shadow-md rounded-xl p-4 border border-gray-200 hover:shadow-lg transition">
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <p class="text-gray-700">
                    <span class="font-semibold text-gray-900">Área:</span>
                    {{ $orden->area->area }}
                </p>

                <p class="text-gray-700 md:col-span-2">
                    <span class="font-semibold text-gray-900">Problema:</span>
                    {{ $orden->problema_detectado }}
                </p>

                <p class="text-gray-700">
                    <span class="font-semibold text-gray-900">Correlativo:</span>
                    {{ $orden->correlativo }}
                </p>

                <p class="text-gray-700">
                    <span class="font-semibold text-gray-900">Fecha:</span>
                    {{ $orden->created_at->format('d-m-Y h:i:s A') }}
                </p>
            </div>
        </div>
        @endforeach
    </div>
    @endif
    
@endsection