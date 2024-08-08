@extends('layouts.administracion')

@section('titulo')
Crear Supervisor
@endsection

@section('contenido')
<x-alertas />
<a href="{{ route('usuarios.supervisores') }}"
    class=" bg-orange-500 cursor-pointer hover:bg-orange-700 text-white font-bold py-2 px-4 rounded inline-block mt-5 mb-5 ">
    <i class="fa-solid fa-arrow-left"></i>
    Volver
</a>

<form action="{{ route('usuarios.supervisores-store') }}" method="POST">
    @csrf
    <div class="mb-5">
        <label for="name" class="mb-2 block uppercase text-gray-500 font-bold">Nombre del supervisor: </label>
        <input type="text" id="name" name="name"
            class="border p-3 w-full rounded-lg @error('name') border-red-500 @enderror"
            placeholder="Nombre del nuevo supervisor" autocomplete="off" value="{{ old('name') }}">

        @error('name')
        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }}</p>
        @enderror
    </div>

    <div class="mb-5">
        <label for="role_id" class="mb-2 block uppercase text-gray-500 font-bold ">Rol: </label>
        <select name="role_id" id="role" class="w-full p-4 rounded bg-gray-50">
            <option  value class="opcion-default" selected disabled>---SELECCIONE UNA OPCIÓN---</option>
            @foreach ($roles as $role)
                <option value="{{ $role->id }}">{{ $role->name }}</option>
            @endforeach

        </select>                                
        @error('role_id')
            <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">Seleccione un rol<p>
        @enderror
    </div>

    <input type="submit" value="Crear"
        class=" bg-orange-600 hover:bg-orange-700 p-3 transition-colors cursor-pointer uppercase font-bold text-white rounded-lg">
</form>

@endsection