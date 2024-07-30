@extends('layouts.administracion')

@section('titulo')
    Rendimiento de Reempaques
@endsection

@section('contenido')
    <div class="grid grid-rows-4 grid-cols-4 w-full h-full mt-10">
        <div class="grid grid-rows-8 grid-cols-8 row-span-2 col-span-2">
            @for ($i = 1; $i <= 4; $i++)
                <div class="col-start-{{ ($i+1)  }} cursor-pointer text-center posicion" data-micromodal-trigger="modal-1" data-pos="Posción N.{{ $i }}" id="p{{ $i }}" data-name="Nombre del empleado en turno {{$i}}">
                    <i class="fa-solid fa-person text-4xl"></i>
                    <p class="font-bold">P.{{ $i }}</p>
                </div>
            @endfor
            
            <div class="bg-mesarem row-start-2 row-span-1 col-start-2 col-span-4 flex justify-center items-center">
                <span class="text-xl font-bold">Mesa 1</span>
            </div>
            <div class="bg-mesarem row-start-3 col-start-6 col-span-1 row-span-4 flex justify-center items-center">
                <span class="text-xl font-bold">Mesa 2</span>
            </div>
        </div>
    </div>

    <div class="modal micromodal-slide" id="modal-1" aria-hidden="true">
        <div class="modal__overlay" tabindex="-1" data-micromodal-close>
          <div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="modal-1-title">
            <header class="modal__header">
              <h2 class="modal__title" id="modal-1-title"></h2>
              <button class="modal__close" aria-label="Close modal" data-micromodal-close></button>
            </header>
            <main class="modal__content" id="modal-1-content">
                <p class="text-xl font-bold mb-5">Nombre de empleado de turno</p>
                <form novalidate>
                    @csrf
                    <div class="mb-5">
                        <label for="campo1" class="mb-2 block uppercase text-gray-500 font-bold">Datos del campo 1</label>
                    
                        <input 
                            type="text"
                            id="campo1"
                            name="campo1"
                            placeholder="Datos del campo 1"
                            class="border p-3 w-full rounded-lg"
                        >
                    </div>
        
                    <div class="mb-5">
                        <label for="campo1" class="mb-2 block uppercase text-gray-500 font-bold">Datos del campo 1</label>
                        <input 
                            type="text"
                            id="campo1"
                            name="campo1"
                            placeholder="Datos del campo 1"
                            class="border p-3 w-full rounded-lg"
                        >
                    </div>
                    <input type="submit" value="Registrar rendimiento" class="bg-sky-600 hover:bg-sky-700 p-3 transition-colors cursor-pointer uppercase font-bold w-full text-white rounded-lg">
                </form>
            </main>
          </div>
        </div>
      </div>
@endsection