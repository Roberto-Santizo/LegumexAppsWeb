@extends('layouts.notificacion')

@section('titulo')

@endsection

@section('contenido')

<div class="w-full mx-auto">
    <h1 class="font-black md:text-7xl text-3xl">Novedades<h1>
            <div class="mt-5 flex flex-col gap-10">
                <div>
                    <h2 class="md:text-3xl text-xl font-bold">Horas de uso Dron</h2>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2">
                    <div class=" space-y-10">
                        <div class="p-5">
                            <div>
                                <p class=" text-xl uppercase font-bold mb-5">En el apartado de asignación de personas: </p>
                                <img src="{{ asset('img/img-notificaciones/img.png') }}" alt="Img Notificacion">
                            </div>
                        </div>
                        
                        <div class="p-5">
                            <div>
                                <img src="{{ asset('img/img-notificaciones/img2.png') }}" alt="Img Notificacion">
                            </div>
                        </div>

                        <div class="p-5">
                            <div>
                                <img src="{{ asset('img/img-notificaciones/img3.png') }}" alt="Img Notificacion">
                            </div>
                        </div>

                        <div class="p-5">
                            <div>
                                <img src="{{ asset('img/img-notificaciones/img4.png') }}" alt="Img Notificacion">
                            </div>
                        </div>
                    </div>
                    

                    <div class="flex flex-col gap-5 mt-5">
                        <p
                            class="flex flex-col gap-5 justify-between p-5 rounded-xl shadow-xl border-l-8 border-green-500 md:text-xl text-sm font-medium" data-aos="zoom-in">
                            En el apartado de asignación de usuarios nos aparecerá una etiqueta que dice "TAREA CON DRON" para asignar el dron a esa tarea.
                        </p>
                        <p
                            class="flex flex-col gap-5 justify-between p-5 rounded-xl shadow-xl border-l-8 border-green-500 md:text-xl text-sm font-medium" data-aos="zoom-in">
                            Una vez que se haya asignado el dron a la tarea se llevará un recuento de las horas utilizadas del dron con base al inicio de la tarea y cierre de la misma
                        </p>
                        <p
                            class="flex flex-col gap-5 justify-between p-5 rounded-xl shadow-xl border-l-8 border-green-500 md:text-xl text-sm font-medium" data-aos="zoom-in">
                            Las horas se tomarán en desde el inicio hasta el momento en que se realiza la consulta   
                        </p>
                        <p
                            class="flex flex-col gap-5 justify-between p-5 rounded-xl shadow-xl border-l-8 border-green-500 md:text-xl text-sm font-medium" data-aos="zoom-in">
                            Al mostrar la tarea se mostarará una pequeña etiqueta en la parte inferior que nos dice que esa tarea esta realizandose con el dron    
                        </p>
                        <p
                            class="flex flex-col gap-5 justify-between p-5 rounded-xl shadow-xl border-l-8 border-green-500 md:text-xl text-sm font-medium" data-aos="zoom-in">
                            Estos datos se reflejarán en los reportes correspondientes.</p>
                        <p
                            class="flex flex-col gap-5 justify-between p-5 rounded-xl shadow-xl border-l-8 border-red-500 md:text-xl text-sm font-medium uppercase" data-aos="zoom-in">
                            Es importante tener en cuenta que la creación de las tareas se mantiene con el mismo procedimiento con el que se viene trabajando, es decir, se tiene que colocar
                            al menos una persona, con horas necesarias y presupuesto.
                        </p>

                        <a class="btn bg-indigo-500 hover:bg-indigo-600 text-center animate-blink-colors" data-aos="zoom-in"
                            href="{{ route('dashboard') }}">
                            Ir a la aplicación
                        </a>
                    </div>
                </div>
            </div>
</div>
@endsection