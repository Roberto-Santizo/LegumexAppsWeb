@extends('layouts.administracion')

@section('titulo')
Toma rendimiento
@endsection

@section('contenido')

<x-alertas />
@php
$clasesEncabezados = 'p-3 text-sm font-bold uppercase text-left rtl:text-right text-gray-500 dark:text-gray-400';
$clasesEnlaces = 'bg-orange-500 cursor-pointer hover:bg-orange-700 text-white font-bold py-2 px-4 rounded
inline-block ';
$clasesCampo = 'px-4 py-2 text-md font-medium whitespace-nowrap';
@endphp
<div class="mt-5">
   

    <form action="" class="mt-10">
        <input type="submit" class="bg-orange-500 hover:bg-orange-600 cursor-pointer text-white font-bold p-2 rounded uppercase" value="Guardar">
    </form>
</div>
@endsection