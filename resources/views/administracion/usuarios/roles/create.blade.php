@extends('layouts.administracion')

@section('titulo')
    Crear Rol
@endsection

@section('contenido')
    <x-alertas />
    <a href="{{ route('roles') }}" class=" bg-orange-500 cursor-pointer hover:bg-orange-700 text-white font-bold py-2 px-4 rounded inline-block mt-5 mb-5 ">
        <i class="fa-solid fa-arrow-left"></i>
        Volver
    </a>

    <form action="{{ route('roles.store') }}" method="POST">
        @csrf
        <div class="mb-5">
            <label for="name" class="mb-2 block uppercase text-gray-500 font-bold">Nombre del rol: </label>
            <input
                type="text" 
                id="name"
                name="name"
                class="border p-3 w-full rounded-lg @error('name') border-red-500 @enderror"    
                placeholder="Nombre del nuevo rol"
                autocomplete="off"
                value="{{ old('name') }}"
            >
                                        
            @error('name')
                <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }}</p>
            @enderror
        </div>

        <input type="submit" value="Crear" class=" bg-orange-600 hover:bg-orange-700 p-3 transition-colors cursor-pointer uppercase font-bold text-white rounded-lg">
    </form>

@endsection