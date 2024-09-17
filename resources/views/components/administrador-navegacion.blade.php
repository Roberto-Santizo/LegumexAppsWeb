<div>
    <nav class="gap-5 p-4 flex flex-col items-center justify-center w-full">
        <div class="w-full">
            <div class="flex items-center justify-between w-full gap-2 md:hidden p-3" id="menuMobile_account">
                <div class="flex flex-row gap-5 justify-center items-center">
                    <i class="fa-solid fa-user"></i>
                    <span class="text-md md:text-xs uppercase font-bold">Cuenta</span>
                </div>
                <i class="fa-solid fa-greater-than transition-transform duration-300" id="menuIcon"></i>
            </div>

            <div class="ml-10 hidden " id="accountContent">
                <div class="text-md">
                    <div>
                        <p><span class="font-bold">Nombre:</span> {{ auth()->user()->name }}</p>
                    </div>

                    <div>
                        <p><span class="font-bold">Nombre de usuario:</span> {{ auth()->user()->username }}</p>
                    </div>

                    <div>
                        <p><span class="font-bold">Correo:</span> {{ auth()->user()->email }}</p>
                    </div>
                    <div>
                        <p><span class="font-bold">Rol:</span> {{ auth()->user()->getRoleNames()->first() }}</p>
                    </div>

                </div>
                <div class="flex gap-2 w-full md:hidden">
                    <form action="{{ route('logout.microsoft') }}" method="POST" class="text-md">
                        @csrf
                        <input type="submit" value="Cerrar Sesión"
                            class="mt-5 btn ">
                    </form>

                    @role('auxmanto')
                    <form action="{{ route('logout') }}" method="POST" class="text-md">
                        @csrf
                        <input type="submit" value="Utilizar otro Usuario"
                            class="mt-5 btn ">
                    </form>
                    @endrole
                </div>
            </div>
        </div>

        <a href="{{ route('dashboard') }}"
            class=" {{  Route::is('dashboard*') ? 'bg-orange-500' : '' }} sidebar-link">
            <i class="fa-solid fa-house"></i>
            <span class="sidebar-text">Dashboard</span>
        </a>
        
        <a href="{{ route('usuarios') }}" class="{{  Route::is('usuarios*') ? 'bg-orange-500' : '' }} sidebar-link">
            <i class="fa-solid fa-user"></i>
            <span class="sidebar-text">Gestionar Usuarios</span>
        </a>
        
        <a href="{{ route('documentold') }}"
            class="{{  Route::is('documentold*') ? 'bg-orange-500' : '' }}  sidebar-link">
            <i class="fa-solid fa-hands-bubbles"></i>
            <span class="sidebar-text">Lavado y desinfección</span>
        </a>
        <a href="{{ route('documentocp') }}"
            class="{{  Route::is('documentocp*') ? 'bg-orange-500' : '' }} sidebar-link">
            <i class="fa-solid fa-list-ul"></i>
            <span class="sidebar-text">Checklist Preoperacional</span>
        </a>

        <a href="{{ route('documentoOT') }}"
            class=" {{  Route::is('documentoOT*') ? 'bg-orange-500' : '' }} sidebar-link">
            <i class="fa-solid fa-briefcase"></i>
            <span class="sidebar-text">Ordenes de trabajo</span>
        </a>

        <a href="{{ route('misOrdenes') }}"
            class="relative sidebar-link">
            <i class="fa-solid fa-user-tie"></i>
            <span class="sidebar-text">Mis Ordenes</span>
            <span
                class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 bg-red-600 rounded-full">
                {{ auth()->user()->ordenes() }}
            </span>
        </a>

        <a href="{{ route('administrar') }}"
            class="{{  Route::is('administrar*') ? 'bg-orange-500' : '' }} sidebar-link">
            <i class="fa-solid fa-universal-access"></i>
            <span class="sidebar-text">Administrar ordenes de trabajo</span>
        </a>

        <a href="{{ route('herramientas') }}"
            class="{{  Route::is('herramientas*') ? 'bg-orange-500' : '' }} sidebar-link">
            <i class="fa-solid fa-screwdriver-wrench"></i>
            <span class="text-md md:text-xs uppercase font-bold">Herramientas</span>
        </a>

    </nav>
</div>