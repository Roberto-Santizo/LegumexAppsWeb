@extends('layouts.notificacion')

@section('titulo')

@endsection

@section('contenido')

<div class="w-full mx-auto">
    <h1 class="font-black text-7xl">Novedades<h1>

            <div class="mt-10">
                <h2 class="text-3xl font-bold">Calculo de distribución de horas</h2>

                <div>
                    <p class="text-2xl">En el apartado de la información de la tarea:</p>
                    <img src="{{ asset('img/img-notificaciones/img1.jpeg') }}" alt="">
                </div>

                <div>
                    @php
                        $message = 'Tener en cuenta que el resúmen se mostrará cuando le den cierre definitivo a la tarea';
                    @endphp
                    <img src="{{ asset('img/img-notificaciones/img2.jpeg') }}" alt="">
                    <div class="flex flex-col gap-5 mt-5">
                        <p
                            class="flex flex-col gap-5 justify-between p-5 rounded-xl shadow-xl border-l-8 border-orange-500 text-xl font-medium">
                            Se agregó una tabla de "Distribución de dato" en la cual se puede observar los
                            días que las personas asignadas llegaron con su respectivo monto de horas y dinero.</p>
                        <p
                            class="flex flex-col gap-5 justify-between p-5 rounded-xl shadow-xl border-l-8 border-orange-500 text-xl font-medium">
                            El calculo se realiza con base a un monto de horas reportadas y dependiendo de
                            la asistencia de le empleado se le irán sumando las horas.
                        </p>
                        <p
                            class="flex flex-col gap-5 justify-between p-5 rounded-xl shadow-xl border-l-8 border-orange-500 text-xl font-medium">
                            Al final de la semana de la semana tendremos un dato de porcentaje y con base a este dato
                            se calculo lo que le corresponde a cada empleado de las horas teoricas y presupuesto.
                        </p>

                        <p>
                            <livewire:mostrar-alerta :message="$message"/>
                        </p>
                    </div>


                    
                </div>
            </div>




</div>

@endsection