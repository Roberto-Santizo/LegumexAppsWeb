@extends('layouts.public')

@section('titulo')
@endsection

@section('contenido')

<section>
    <div class="relative w-full" data-aos="zoom-out-right">
        <img  src="{{ asset('img/header.jpg') }}" alt="Legumex Icono" class="w-full h-96 object-cover">
        <div
            class="absolute inset-0 items-center justify-center bg-black bg-opacity-50 shadow-lg text-white flex flex-col gap-5">
            <p class="text-3xl  font-bold text-center">Agroindustria Legumex</p>
        </div>
    </div>
</section>

<section>

</section>

@endsection