@extends('layouts.agricola')

@section('titulo')
    Tareas Finca Semanal
@endsection

@section('contenido')
    <x-alertas />

    @hasanyrole('admin|adminagricola')
        <div class="flex flex-col md:flex-row md:gap-5 justify-end mt-10">
            <x-link class="bg-green-moss hover:bg-green-meadow" route="planSemanal.create" text="Crear Plan Semanal" />
            <x-link class="bg-green-moss hover:bg-green-meadow" route="planSemanal.tareaLote.create"
                text="Crear Tarea Lote" />
            <x-link class="bg-green-moss hover:bg-green-meadow" route="planSemanal.tareaCosechaLote.create"
                text="Crear Tarea Cosecha Extraordinaria" />
        </div>
    @endhasanyrole

    <livewire:plan-semanal-fincas-index />
@endsection
