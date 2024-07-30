@extends('layouts.administracion')

@section('titulo')
    Crear Usuario
@endsection

@section('contenido')
    @if(session('error'))
        <p class="bg-orange-500 uppercase text-xl text-white my-2 rounded-lg p-2 text-center font-bold">{{ session('error') }}</p>
    @endif

    <a href="{{ route('usuarios') }}" class=" bg-orange-500 cursor-pointer hover:bg-orange-700 text-white font-bold py-2 px-4 rounded inline-block mt-5 mb-5 ">
        <i class="fa-solid fa-arrow-left"></i>
        Volver
    </a>

    <form action="{{ route('usuarios.store') }}" method="POST" class="mt-10">
        @csrf
        <div class="mb-5">
            <label for="name" class="mb-2 block uppercase text-gray-500 font-bold">Nombre: </label>
            <input
                type="text" 
                id="name"
                name="name"
                class="border p-3 w-full rounded-lg @error('name') border-red-500 @enderror"    
                placeholder="Nombre del nuevo usuario"
                autocomplete="off"
                value="{{ old('name') }}"
            >
                                        
            @error('name')
                <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-5">
            <label for="username" class="mb-2 block uppercase text-gray-500 font-bold">Nombre de usuario: </label>
            <input
                type="text" 
                id="username"
                name="username"
                class="border p-3 w-full rounded-lg @error('username') border-red-500 @enderror"    
                placeholder="Nombre del nuevo usuario"
                autocomplete="off"
                value="{{ old('username') }}"
            >
                                        
            @error('username')
                <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-5">
            <label for="email" class="mb-2 block uppercase text-gray-500 font-bold">Correo electronico: </label>
            <input
                type="email" 
                id="email"
                name="email"
                class="border p-3 w-full rounded-lg @error('email') border-red-500 @enderror"    
                placeholder="Nombre del nuevo usuario"
                autocomplete="off"
                value="{{ old('email') }}"
            >
                                        
            @error('email')
                <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-5">
            <label for="password" class="mb-2 block uppercase text-gray-500 font-bold">Contraseña</label>
            <input 
                type="password"
                id="password"
                name="password"
                placeholder="Contraseña de registro"
                class="border p-3 w-full rounded-lg @error('passowrd') border-red-500 @enderror"   
            >
                                            
        @error('password')
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

        <table class="w-full mb-5">
            <thead class="bg-sky-600">
                <tr>
                    <th scope="col" class="text-white text-sm md:text-xl p-2">Permiso</th>
                    <th scope="col" class="text-white text-sm md:text-xl p-2">Elegir</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($permisos as $permiso)
                    <tr class="odd:bg-orange-200 odd:text-white">
                        <td class="text-sm md:text-xl font-bold p-2">
                            {{ $permiso->name }}
                        </td>
                        <td class="text-center">
                            <input class="h-6 w-6 mt-2 lavadas" type="checkbox" name="permisos[]" value="{{ $permiso->id }}">
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <input type="submit" value="Crear" class=" bg-orange-600 hover:bg-orange-700 p-3 transition-colors cursor-pointer uppercase font-bold text-white rounded-lg">
    </form>
@endsection