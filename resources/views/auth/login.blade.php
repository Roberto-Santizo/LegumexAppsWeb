@extends('layouts.public')

@section('titulo')
    Iniciar Sesión
@endsection

@section('contenido')
<div class="md:flex md:justify-center gap-10 md:items-center">
    <div class="md:w-4/12  bg-white p-6 rounded-lg shadow-lg">
        <form method="POST" action="{{ route('login') }}" novalidate>
            @csrf
            
           <x-alertas />

            <div class="mb-5">
                <label for="username" class="mb-2 block uppercase text-gray-500 font-bold">Nombre de Usuario</label>
                <input 
                    type="text"
                    id="username"
                    name="username"
                    placeholder="Tu Usuario"
                    class="border p-3 w-full rounded-lg @error('username') border-red-500 @enderror"    
                    value="{{ old('username') }}"
                    autocomplete="off"
                >
                                                
                @error('username')
                <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-5">
                <label for="password" class="mb-2 block uppercase text-gray-500 font-bold">Contraseña</label>
                <input 
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Contraseña"
                    class="border p-3 w-full rounded-lg @error('passoword') border-red-500 @enderror"   
                    autocomplete="off"
                >
                                                
                @error('password')
                    <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-5">
                <input type="checkbox" name="remember"> <label for="remember" class="text-gray-500 text-sm"> Mantener mi sesión abierta</label>
            </div>

            <input type="submit" value="Inciar Sesión" 
            class="bg-sky-600 hover:bg-sky-700 p-3 transition-colors cursor-pointer uppercase font-bold w-full text-white rounded-lg"
            >
        </form>
     
    </div>
</div>
@endsection