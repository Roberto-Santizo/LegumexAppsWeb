@extends('layouts.public')

@section('titulo')
    Iniciar Sesión
@endsection
    
@section('contenido')

<div class="flex justify-center items-center">
    <x-alertas />

    <div class="flex flex-col justify-center items-center gap-5">
        <form method="POST" action="{{ route('login') }}" class="md:w-96 w-64 shadow-xl border p-10" novalidate>
            @csrf

            <div>
                <x-input-label for="username" :value="__('Nombre de Usuario')" />
                <x-text-input id="username" class="block mt-1 w-full p-2 border" type="username" name="username" :value="old('username')"
                    required autofocus autocomplete="off" />
                <x-input-error :messages="$errors->get('username')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="password" :value="__('Contraseña')" />

                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                    autocomplete="current-password" />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-primary-button class="ms-3">
                    {{ __('Iniciar Sesión') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</div>

@endsection