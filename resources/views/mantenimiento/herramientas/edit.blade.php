@extends('layouts.administracion')

@section('titulo')
    Editar herramienta
@endsection

@section('contenido')
    @if(session('mensaje'))
        <p class="bg-orange-500 uppercase text-xl text-white my-2 rounded-lg p-2 text-center font-bold">{{ session('mensaje') }}</p>
    @endif

    <a href="{{ route('herramientas') }}" class=" bg-orange-500 cursor-pointer hover:bg-orange-700 text-white font-bold py-2 px-4 rounded inline-block mt-5 mb-5 ">
        <i class="fa-solid fa-arrow-left"></i>
        Volver
    </a>

    <form action="{{ route('herramientas.update',$herramienta) }}" class="mt-10" method="POST">
        @csrf
        @method('PATCH')
        <div class="mb-5">
            <label for="herramienta" class="mb-2 block uppercase text-gray-500 font-bold">Nombre de la herramienta: </label>
            <input 
                type="text"
                id="herramienta"
                name="herramienta"
                class="border p-3 w-full rounded-lg @error('herramienta') border-red-500 @enderror"   
                placeholder="Ingrese el nombre de la herramienta"
                value="{{ $herramienta->herramienta }}" 
                autocomplete="off"
            >
            
            @error('herramienta')
                <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }}</p>
            @enderror
        </div>

        <input type="submit" value="Guardar" class="bg-orange-500 text-white p-3 rounded-lg cursor-pointer hover:bg-orange-600 font-bold uppercase">
    </form>

@endsection