@extends('layouts.administracion')

@section('titulo')
    Crear Tarea Extraordinaria - Lote {{ $lote->nombre }} - Semana {{ $plansemanalfinca->semana }}
@endsection

@section('contenido')

<x-alertas />

<div class="bg-white p-6 rounded-lg shadow-lg mt-10 md:mt-5 container xl:w-2/3  mx-auto">
    <form action="{{ route('planSemanal.tareaLote.store',[$lote,$plansemanalfinca]) }}" method="POST" novalidate>
        @csrf

        <x-alertas />


        <x-input type="number" name="personas" label="Total de Personas Necesarias" value="{{ old('personas') }}" placeholder="Ingrese el total de personas necesarias para la tarea" />
        
        <x-input type="number" name="presupuesto" label="Presupuesto de la Tarea" value="{{ old('presupuesto') }}" placeholder="Presupuesto de la Tarea en Quetzales" />
        
        <x-input type="number" name="horas" label="Horas Necesarias" value="{{ old('horas') }}" placeholder="Horas necesarias para la Tarea" />
        
        <div class="mb-5">
            <label for="tarea_id" class="label-input">Seleccione la tarea extraoirdinaria </label>
            <select name="tarea_id" class="w-full p-4 rounded bg-gray-50 select">
                <option value="" class="opcion-default" selected disabled>---SELECCIONE UNA OPCIÓN---</option>
                @foreach ($tareas as $tarea)
                <option value="{{ $tarea->id }}">
                    {{ $tarea->tarea }}
                    </option>
                @endforeach
            </select>
            @error('tarea_id')
                <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center uppercase font-bold">{{ $message }}</p>
            @enderror
        </div>
        
        
        <div class="flex justify-end mt-10">
            <input type="submit" value="Guardar"
                class=" bg-sky-600 hover:bg-sky-700 p-3 transition-colors cursor-pointer uppercase font-bold text-white rounded-lg">
        </div>

    </form>
@endsection