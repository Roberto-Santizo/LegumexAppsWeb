@extends('layouts.agricola')

@section('titulo')
Dashboard Agricola
@endsection

@section('contenido')
<div class="flex flex-col gap-5 xl:grid xl:grid-cols-8 mt-10">
    <div class="flex flex-col justify-center items-center col-start-1 col-span-2 bg-green-moss rounded-lg p-4 shadow-2xl text-gray-600 text-xl">
        <div>
            <svg width="400" height="200" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <circle cx="12" cy="9" r="3" stroke="#598234" stroke-width="1.5"></circle> <circle cx="12" cy="12" r="10" stroke="#598234" stroke-width="1.5"></circle> <path d="M17.9691 20C17.81 17.1085 16.9247 15 11.9999 15C7.07521 15 6.18991 17.1085 6.03076 20" stroke="#598234" stroke-width="1.5" stroke-linecap="round"></path> </g></svg>
        </div>
        <p class="font-bold">{{ auth()->user()->name }}</p>
        <p class="font-bold">{{ auth()->user()->getRoleNames()->first() }}</p>
        <p class="font-bold">{{ auth()->user()->email }}</p>
    </div>

    <div class=" col-start-4 col-span-5 bg-green-moss rounded-2xl shadow-xl">
        <div class="bg-green-meadow w-full p-5 flex flex-row gap-2 items-center text-white rounded-t-2xl">
            <h1 class="text-2xl font-bold">Planes Semanales</h1>
        </div>

        <div class="grid grid-cols-3 lg:flex lg:flex-row lg:items-center lg:flex-wrap gap-5 p-5">
            @hasanyrole('admin|adminagricola')
            <a href="{{ route('planSemanal.create') }}" class="flex flex-col justify-center items-center hover:bg-green-700 rounded-xl lg:p-5">
                <svg width="100" height="50" viewBox="0 -0.5 17 17" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" class="si-glyph si-glyph-circle-plus" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>933</title> <defs> </defs> <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> <path d="M9.021,0.097 C4.625,0.097 1.063,3.655 1.063,8.04 C1.063,12.428 4.625,15.985 9.021,15.985 C13.416,15.985 16.979,12.427 16.979,8.04 C16.979,3.654 13.415,0.097 9.021,0.097 L9.021,0.097 Z M11.325,9.082 L10.088,9.082 L10.088,10.319 C10.088,11.298 10.147,12.088 9,12.088 C7.856,12.088 7.912,11.298 7.912,10.319 L7.912,9.082 L6.675,9.082 C5.696,9.082 4.906,9.138 4.906,7.994 C4.906,6.848 5.696,6.906 6.675,6.906 L7.912,6.906 L7.912,5.669 C7.912,4.69 7.856,3.9 9,3.9 C10.146,3.9 10.088,4.69 10.088,5.669 L10.088,6.906 L11.325,6.906 C12.304,6.906 13.094,6.847 13.094,7.994 C13.094,9.138 12.304,9.082 11.325,9.082 L11.325,9.082 Z" fill="#598234" class="si-glyph-fill"> </path> </g> </g></svg>
                <p class="text-sm text-center font-bold uppercase text-white">Crear Plan Semanal</p>
            </a>
            @endhasanyrole
        </div>

    </div>

    <div class=" col-start-4 col-span-5 bg-green-moss rounded-2xl shadow-xl">
        <div class="bg-green-meadow w-full p-5 flex flex-row gap-2 items-center text-white rounded-t-2xl">
            <h1 class="text-2xl font-bold">Control de tareas</h1>
        </div>

        <div class="flex flex-col gap-5 p-5">
           @foreach ($planes as $plan)
               <a href="{{ route('planSemanal.show',$plan) }}" class="flex flex-row gap-5 font-bold text-white bg-green-meadow p-3 rounded-xl justify-between shadow-xl transform transition-transform duration-300 hover:scale-1025">
                    <p>{{ $plan->finca->finca }} - Semana {{ $plan->semana }} </p>
                    <p class="uppercase">Tareas Completadas: {{ $plan->tareasRealizadas->count() }}/{{ $plan->tareasTotales->count() }}</p>
               </a>
           @endforeach

        </div>

    </div>

</div>
@endsection