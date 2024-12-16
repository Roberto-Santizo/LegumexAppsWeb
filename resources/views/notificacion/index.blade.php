@extends('layouts.notificacion')

@section('titulo')
@endsection

@section('contenido')
    <div class="w-full mx-auto">
        <h1 class="font-black md:text-7xl text-3xl">Novedades<h1>
                <div class="mt-5 flex flex-col gap-10">
                    <div>
                        <h2 class="md:text-3xl text-xl font-bold">Actualización de insumos</h2>
                    </div>
                    <div class="grid grid-cols-1">
                        <div class=" space-y-10">
                            <div class="p-5 space-y-5">
                                <div>
                                    <p class=" text-xl uppercase font-bold mb-5">En el apartado de asignación de personas:
                                    </p>
                                    <img src="{{ asset('img/img-notificaciones/img.png') }}" alt="Img Notificacion">
                                </div>

                                <p class="flex flex-col gap-5 justify-between p-5 rounded-xl shadow-xl border-l-8 border-green-500 md:text-xl text-sm font-medium"
                                    data-aos="zoom-in">
                                    Cuando se le de cierre una tarea se tendrá que colocar el total de los insumos asignados
                                    utilizados
                                </p>
                            </div>

                            <div class="p-5 space-y-5">
                                <div>
                                    <img src="{{ asset('img/img-notificaciones/img2.png') }}" alt="Img Notificacion">
                                </div>

                                <p class="flex flex-col gap-5 justify-between p-5 rounded-xl shadow-xl border-l-8 border-green-500 md:text-xl text-sm font-medium"
                                    data-aos="zoom-in">
                                    Cuando se ingrese la cantidad se ingresan con la unidad de medida correspondiente del
                                    insumo
                                    <span class="font-black">(La unidad de medida es la unidad de medida que se maneja en el
                                        sistema)</span>
                                </p>
                                <p class="flex flex-col gap-5 justify-between p-5 rounded-xl shadow-xl border-l-8 border-green-500 md:text-xl text-sm font-medium"
                                    data-aos="zoom-in">
                                    La toma de los insumos utilizados es igual que la toma de cosecha, se irá insumo por
                                    insumo
                                    guardando individualmente
                                </p>
                            </div>

                            <div class="p-5 space-y-5">
                                <div>
                                    <img src="{{ asset('img/img-notificaciones/img3.png') }}" alt="Img Notificacion">
                                </div>

                                <p class="flex flex-col gap-5 justify-between p-5 rounded-xl shadow-xl border-l-8 border-green-500 md:text-xl text-sm font-medium"
                                    data-aos="zoom-in">
                                    Una vez con todos los insumos guardados le daremos al boton "Cerrar Asignación"
                                </p>
                            </div>

                            <div class="p-5 space-y-5">
                                <div>
                                    <img src="{{ asset('img/img-notificaciones/img4.png') }}" alt="Img Notificacion">
                                </div>

                                <p class="flex flex-col gap-5 justify-between p-5 rounded-xl shadow-xl border-l-8 border-green-500 md:text-xl text-sm font-medium"
                                    data-aos="zoom-in">
                                    En el apartado de información de la tarea tendremos una tabla de resumen de insumos
                                    asignados e insumos utilizados para posterior análisis
                                </p>

                                <p class="flex flex-col uppercase gap-5 justify-between p-5 rounded-xl shadow-xl border-l-8 border-red-500 md:text-xl text-sm font-black"
                                    data-aos="zoom-in">
                                    ESTOS CAMBIOS SE REFLEJARÁN A PARTIR DE LA SIGUIENTE SEMANA
                                </p>
                            </div>
                        </div>



                        <a class="btn bg-indigo-500 hover:bg-indigo-600 text-center animate-blink-colors" data-aos="zoom-in"
                            href="{{ route('dashboard') }}">
                            Ir a la aplicación
                        </a>
                    </div>
                </div>
    </div>
@endsection
