<div>
    <nav class="gap-5 p-4 flex flex-col items-center justify-center w-full">

        @hasanyrole('adminmanto|auxmanto')
        <x-usuario-menu-mobile />
        @endhasanyrole

        <a href="{{ route('dashboard.mantenimiento') }}"
            class=" {{  Route::is('dashboard*') ? 'bg-orange-500' : '' }} rounded-lg text-center flex flex-row  gap-5 md:gap-0  md:flex-col items-center md:justify-center p-3 w-full md:w-2/3 hover:bg-blue-400">
            <i class="fa-solid fa-house"></i>
            <span class="text-md md:text-xs uppercase font-bold">Dashboard</span>
        </a>
        <a href="{{ route('documentold') }}"
            class="{{  Route::is('documentold*') ? 'bg-orange-500' : '' }}  rounded-lg text-center flex flex-row  gap-5 md:gap-0  md:flex-col items-center md:justify-center p-3 w-full md:w-2/3 hover:bg-blue-400">
            <i class="fa-solid fa-hands-bubbles"></i>
            <span class="text-md md:text-xs uppercase font-bold">Lavado y desinfección</span>
        </a>
        <a href="{{ route('documentocp') }}"
            class="{{  Route::is('documentocp*') ? 'bg-orange-500' : '' }} rounded-lg text-center flex flex-row  gap-5 md:gap-0  md:flex-col items-center md:justify-center p-3 w-full md:w-2/3 hover:bg-blue-400">
            <i class="fa-solid fa-list-ul"></i>
            <span class="text-md md:text-xs uppercase font-bold">Checklist Preoperacional</span>
        </a>

        <a href="{{ route('documentoOT') }}"
            class=" {{  Route::is('documentoOT*') ? 'bg-orange-500' : '' }} rounded-lg text-center flex flex-row  gap-5 md:gap-0  md:flex-col items-center md:justify-center p-3 w-full md:w-2/3 hover:bg-blue-400">
            <i class="fa-solid fa-briefcase"></i>
            <span class="text-md md:text-xs uppercase font-bold">Ordenes de trabajo</span>
        </a>

        <a href="{{ route('registrostemp') }}"
            class="{{  Route::is('registrostemp*') ? 'bg-orange-500' : '' }} rounded-lg text-center flex flex-row  gap-5 md:gap-0  md:flex-col items-center md:justify-center p-3 w-full md:w-2/3 hover:bg-blue-400">
            <i class="fa-solid fa-temperature-high"></i>
            <span class="text-md md:text-xs uppercase font-bold">Registro de Temperatura</span>
        </a>

        @role('auxmanto')
        <a href="{{ route('misOrdenes') }}"
            class="{{  Route::is('misOrdenes*') ? 'bg-orange-500' : '' }} relative rounded-lg text-center flex flex-row  gap-5 md:gap-0  md:flex-col items-center md:justify-center p-3 w-full md:w-2/3 hover:bg-blue-400">
            <i class="fa-solid fa-user-tie"></i>
            <span class="text-md md:text-xs uppercase font-bold">Mis Ordenes</span>
            <span
                class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 bg-red-600 rounded-full">
                {{ auth()->user()->ordenes() }}
            </span>
        </a>
        @endrole

        @hasanyrole('adminmanto|admin')
        <a href="{{ route('administrar') }}"
            class="{{  Route::is('administrar*') ? 'bg-orange-500' : '' }} rounded-lg text-center flex flex-row  gap-5 md:gap-0  md:flex-col items-center md:justify-center p-3 w-full md:w-2/3 hover:bg-blue-400">
            <i class="fa-solid fa-universal-access"></i>
            <span class="text-md md:text-xs uppercase font-bold">Administrar ordenes de trabajo</span>
        </a>

        <a href="{{ route('herramientas') }}"
            class="{{  Route::is('herramientas*') ? 'bg-orange-500' : '' }} rounded-lg text-center flex flex-row  gap-5 md:gap-0  md:flex-col items-center md:justify-center p-3 w-full md:w-2/3 hover:bg-blue-400">
            <i class="fa-solid fa-screwdriver-wrench"></i>
            <span class="text-md md:text-xs uppercase font-bold">Herramientas</span>
        </a>
        @endhasanyrole


    </nav>

</div>