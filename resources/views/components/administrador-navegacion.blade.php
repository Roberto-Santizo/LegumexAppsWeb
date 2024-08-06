<div>
    <nav class="gap-5 p-4 flex flex-col items-center justify-center w-full">
        <x-usuario-menu-mobile />
        
        <div class="flex flex-col gap-2">
            <div class="flex items-center justify-between w-full gap-2 p-3 cursor-pointer hover:bg-blue-200"
                id="administracion_navegacionBtn">
                <div class="flex flex-row gap-5 justify-center items-center">
                    <span class="text-md md:text-xs uppercase font-bold">Administración</span>
                </div>
                <i class="fa-solid fa-greater-than transition-transform duration-300" id="menuIcon3"></i>
            </div>

            <div class="hidden flex justify-center items-center flex-col" id="administracion_navegacion">
                <a href="{{ route('usuarios') }}"
                    class="{{  Route::is('usuarios*') ? 'bg-orange-500' : '' }} rounded-lg text-center flex flex-row  gap-5 md:gap-0  md:flex-col items-center md:justify-center p-3 w-full md:w-2/3 hover:bg-blue-400">
                    <i class="fa-solid fa-user"></i>
                    <span class="text-md md:text-xs uppercase font-bold">Gestionar Usuarios</span>
                </a>
            </div>
        </div>

        <div class="flex flex-col gap-2">
            <div class="flex items-center justify-between w-full gap-2 p-3 cursor-pointer hover:bg-blue-200"
                id="mantenimiento_navegacionBtn">
                <div class="flex flex-row gap-5 justify-center items-center">
                    <span class="text-md md:text-xs uppercase font-bold">Mantenimiento</span>
                </div>
                <i class="fa-solid fa-greater-than transition-transform duration-300" id="menuIcon2"></i>
            </div>

            <div class="hidden flex justify-center items-center flex-col gap-2" id="mantenimiento_navegacion">
                <x-mantenimiento-navegacion/>

            </div>
        </div>

    </nav>
</div>