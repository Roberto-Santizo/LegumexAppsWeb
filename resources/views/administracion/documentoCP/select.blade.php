@extends('layouts.administracion')

@section('titulo')
    Seleccione una planta
@endsection

@section('contenido')
    <a href="{{ route('documentocp') }}" class=" bg-orange-500 cursor-pointer hover:bg-orange-700 text-white font-bold py-2 px-4 rounded inline-block mt-5 mb-5 ">
        <i class="fa-solid fa-arrow-left"></i>
            Volver
    </a>

    <div class="flex gap-10 justify-center items-center">
        @foreach ($plantas as $planta)
            <a href="{{ route('documentocp.create',$planta) }}" class="mt-5 bg-orange-500 cursor-pointer hover:bg-orange-700 text-white font-bold py-2 px-4 rounded w-full h-full text-center">
                {{ $planta->planta }}
            </a>
        @endforeach
    </div>
   
@endsection