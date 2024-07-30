@extends('layouts.administracion')

@section('titulo')
    Editar Permiso
@endsection

@section('contenido')
    @if(session('error'))
        <p class="bg-orange-500 uppercase text-xl text-white my-2 rounded-lg p-2 text-center font-bold">{{ session('error') }}</p>
    @endif

    <a href="{{ route('permissions') }}" class=" bg-orange-500 cursor-pointer hover:bg-orange-700 text-white font-bold py-2 px-4 rounded inline-block mt-5 mb-5 ">
        <i class="fa-solid fa-arrow-left"></i>
        Volver
    </a>

    <form action="{{ route('permissions.update',$permission) }}" method="POST">
        @csrf
        @method('PATCH')
        <div class="mb-5">
            <label for="name" class="mb-2 block uppercase text-gray-500 font-bold">Nombre del permiso: </label>
            <input
                type="text" 
                id="name"
                name="name"
                class="border p-3 w-full rounded-lg @error('name') border-red-500 @enderror"    
                placeholder="Nombre del permiso"
                autocomplete="off"
                value="{{ $permission->name }}"
            >
                                        
            @error('name')
                <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }}</p>
            @enderror
        </div>

        <input type="submit" value="Guardar" class=" bg-orange-600 hover:bg-orange-700 p-3 transition-colors cursor-pointer uppercase font-bold text-white rounded-lg">
    </form>

@endsection