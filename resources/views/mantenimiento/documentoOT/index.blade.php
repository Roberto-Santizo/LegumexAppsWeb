@extends('layouts.administracion');


@section('titulo')
    Ordenes de trabajo
@endsection


@section('contenido')
    <x-alertas />
    
    @can('create ot')
        <a href="{{ route('documentoOT.create') }}" class="mt-5 bg-orange-500 cursor-pointer hover:bg-orange-700 text-white font-bold py-2 px-4 rounded inline-block ">
            <i class="fa-solid fa-plus"></i>
            Crear
        </a>
    @endcan
        
        
    <div class="flex flex-col gap-5 mt-5">
        @foreach ($estados as $estado)
            <a href="{{ route('documentoOT.showordenes',$estado) }}">
                <div class="{{ ($estado->id == 1) ? 'bg-yellow-500' : (($estado->id == 2) ? 'bg-orange-500' : (($estado->id == 3) ? 'bg-green-500' : 'bg-red-500')) }} p-5 rounded-xl shadow-xl hover:{{ ($estado->id == 1) ? 'bg-yellow-600' : (($estado->id == 2) ? 'bg-orange-600' : (($estado->id == 3) ? 'bg-green-600' : 'bg-red-600')) }}">
                    <p class="text-white font-bold uppercase">Ordenes de trabajo {{ $estado->estado }}</p>
                </div>
            </a>
        @endforeach


    </div>
@endsection