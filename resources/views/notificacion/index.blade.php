@extends('layouts.notificacion')

@section('titulo')

@endsection

@section('contenido')

<div class="w-full mx-auto">
    <h1 class="font-black md:text-7xl text-3xl">Novedades<h1>
            <div class="mt-5 flex flex-col gap-10">
                <div>
                    <h2 class="md:text-3xl text-xl font-bold">Calculo de distribución de horas</h2>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2">
                    <div class="p-5">
                        <div>
                            <p class=" text-xl">En el apartado de información de la tarea: </p>
                            <img src="{{ asset('img/img-notificaciones/img.png') }}" alt="Img Notificacion">
                        </div>
                    </div>
                    <div class="flex flex-col gap-5 mt-5">
                        <p
                            class="flex flex-col gap-5 justify-between p-5 rounded-xl shadow-xl border-l-8 border-green-500 md:text-xl text-sm font-medium" data-aos="zoom-in">
                            Se agregó una tabla denominada **"Distribución de datos"**, donde se pueden observar los
                            días en que las personas asignadas registraron sus respectivas horas trabajadas y el monto
                            de dinero correspondiente. </p>
                        <p
                            class="flex flex-col gap-5 justify-between p-5 rounded-xl shadow-xl border-l-8 border-green-500 md:text-xl text-sm font-medium" data-aos="zoom-in">
                            El cálculo se realiza con base en el total de horas reportadas. Dependiendo de la asistencia
                            del empleado, se sumarán las horas correspondientes. </p>
                        <p
                            class="flex flex-col gap-5 justify-between p-5 rounded-xl shadow-xl border-l-8 border-green-500 md:text-xl text-sm font-medium" data-aos="zoom-in">
                            Al finalizar la semana, se obtiene un porcentaje basado en los datos recopilados. Con este
                            porcentaje, se calcula lo que le corresponde a cada empleado en términos de las horas
                            teóricas trabajadas y el presupuesto asignado. </p>
                        <p
                            class="flex flex-col gap-5 justify-between p-5 rounded-xl shadow-xl border-l-8 border-green-500 md:text-xl text-sm font-medium" data-aos="zoom-in">
                            El porcentaje se calcula utilizando los datos de horas reportadas diariamente, considerando
                            los momentos en que se pausó y se reanudó la tarea. </p>
                        <p
                            class="flex flex-col gap-5 justify-between p-5 rounded-xl shadow-xl border-l-8 border-green-500 md:text-xl text-sm font-medium" data-aos="zoom-in">
                            Estos datos se reflejarán en los reportes correspondientes.</p>
                        <p
                            class="flex flex-col gap-5 justify-between p-5 rounded-xl shadow-xl border-l-8 border-red-500 md:text-xl text-sm font-medium uppercase" data-aos="zoom-in">
                            Es importante tener en cuenta que estos datos solo estarán disponibles cuando se dé un
                            cierre definitivo a la tarea, al igual que las horas reflejadas en el dashboard. </p>

                        <a class="btn bg-indigo-500 hover:bg-indigo-600 text-center animate-blink-colors" data-aos="zoom-in"
                            href="{{ route('dashboard') }}">
                            Ir a la aplicación
                        </a>
                    </div>
                </div>
            </div>
</div>
@endsection