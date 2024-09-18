@extends('layouts.mantenimiento')

@section('titulo')
    Seleccione una planta
@endsection

@section('contenido')
    <x-link route="documentocp" text="Volver" icon="fa-solid fa-arrow-left" />
   

    <div class="flex flex-col uppercase">
        @foreach ($plantas as $planta)
            <a href="{{ route('documentocp.create',$planta->name) }}" class="mt-5 btn">
                {{ $planta->name }}
            </a>
        @endforeach
    </div>
   
@endsection