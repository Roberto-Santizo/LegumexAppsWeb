@extends('layouts.administracion')

@section('titulo')
    Editar usuario - {{ $usuario->name }}
@endsection

@section('contenido')

    <x-alertas />

    <x-link route="usuarios" icon="fa-solid fa-arrow-left" text="Volver" class=" btn bg-sky-600 hover:bg-sky-800"/>

    <form action="{{ route('usuarios.update',$usuario) }}" method="POST" class="mt-10">
        @csrf
        @method('PATCH')

        <x-input type="text" name="name" label="Nombre" value="{{ $usuario->name }}" placeholder="Nombre Completo del Usuario" />

        <x-input type="text" name="username" label="Username" value="{{ $usuario->username }}" placeholder="Username del Usuario" />
            
        <x-input type="email" name="email" label="Correo Electronico" value="{{ $usuario->email }}" placeholder="Correo del Usuario" />
            
        <x-input type="password" name="password" label="Contraseña" placeholder="Contraseña del Perfil" />
            
        <x-select name="role_id" label="Seleccione un Rol" :options="$roles" :selected=" $usuario->getRoleNames()->first()" />
    

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
                        <input 
                            {{ $permisos_usuarios->contains('id', $permiso->id) ? 'checked' : '' }} 
                            class="h-6 w-6 mt-2 lavadas" 
                            type="checkbox" 
                            name="permisos[]" 
                            value="{{ $permiso->name }}">
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        
        <input type="submit" value="Guardar" class="btn bg-sky-600 hover:bg-sky-800">
    </form>

@endsection