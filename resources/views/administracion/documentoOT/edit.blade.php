@extends('layouts.administracion')


@section('titulo')
    Editando orden trabajo NO. {{ $ot->id }}
@endsection


@section('contenido')
 
    <div class="mt-10 ">
        @if(session('mensaje'))
        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ session('mensaje') }}</p>
        @endif

        <form action="{{ route('documentoOT.update',$ot) }}" method="POST" id="formulario4" class="flex flex-col justify-center items-center md:block">
            @method('PATCH')
            @csrf

            @if($ot->estado_id == 1)
                <x-formulario-o-t1 :ot="$ot" />
            @elseif ($ot->estado_id == 2)
                <x-formulario-o-t2 :ot="$ot" />
            @endif
            <input type="submit" value="Guardar Orden de Trabajo" class="bg-blue-500 text-white p-2 font-bold rounded-lg mt-5 uppercase cursor-pointer">
        </form>
    </div>

@endsection