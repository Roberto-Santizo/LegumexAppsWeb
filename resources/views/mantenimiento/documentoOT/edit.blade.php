@extends('layouts.auth')


@section('titulo')
    Editando orden trabajo NO. {{ $ot->id }}
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
@endpush

@section('contenido')
 
    <div class="mt-10 ">
        <x-alertas />
        <form action="{{ route('documentoOT.update',$ot) }}" method="POST" id="formulario4" class="flex flex-col justify-center items-center md:block">
            @method('PATCH')
            @csrf

            @if($ot->estado_id == 1)
                <x-formulario-o-t1 :ot="$ot" :supervisores="$supervisores"/>
            @elseif ($ot->estado_id == 2)
                <x-formulario-o-t2 :ot="$ot" />
            @endif
            <input type="submit" value="Guardar Orden de Trabajo" class="btn bg-orange-500 hover:bg-orange-600 mt-10">
        </form>
    </div>

@endsection