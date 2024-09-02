<div class="flex flex-col justify-center items-center gap-2">
    <!-- Botón para abrir el modal -->

    <div class="flex flex-col text-xs items-center bg-gray-200 rounded-lg gap-2">
        @if($hasMecanic == 0)
            
        <i wire:click="toggleModal" title="Asignar Mecánico" class="fa-solid fa-person-circle-plus icon-link"></i>
            
        @elseif ($hasMecanic == 1)
            <i wire:click="desAsignarMecanico" title="Desasignar Mecánico" class="text-2xl hover:text-orange-500 cursor-pointer  fa-solid fa-person-circle-xmark"></i>
            
        @endif
    </div>
    
    <!-- Modal -->
    @if($isOpen)
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity">
            <div class="fixed inset-0 z-10 overflow-y-auto">
                <div class="flex items-end justify-center min-h-full p-4 text-center sm:items-center sm:p-0">
                    <div class="relative bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">Seleccione el mecánico a asignarle el trabajo</h3>
                            <div class="mt-2">
                                <ul class="mt-2">
                                    @foreach($usuarios as $usuario)
                                        <li class="mt-1">
                                            <button wire:click="asignarMecanico({{ $usuario->id }})" class="text-left w-full px-4 py-2 border rounded hover:bg-gray-200">
                                                <i class="fa-solid fa-user"></i>
                                                {{ $usuario->name }}
                                            </button>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button wire:click="toggleModal" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border text-white font-bold uppercase bg-orange-500 shadow-sm px-4 py-2  text-base hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                Cerrar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
