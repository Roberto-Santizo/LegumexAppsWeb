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
                        <input type="submit" value="Cerrar Sesión" class="mt-5 btn ">
                    </form>

                    @role('auxmanto')
                    <form action="{{ route('logout') }}" method="POST" class="text-md">
                        @csrf
                        <input type="submit" value="Utilizar otro Usuario" class="mt-5 btn ">
                    </form>
                    @endrole
                </div>
            </div>
        </div>


        <a href="{{ route('dashboard') }}"
            class=" {{  Route::is('dashboard*') ? 'bg-gray-500' : '' }} sidebar-link hover:bg-gray-500">
            <i class="fa-solid fa-house"></i>
            <span class="text-md md:text-xs uppercase font-bold">Dashboard</span>
        </a>

        <a href="{{ route('usuarios') }}" class="{{  Route::is('usuarios*') ? 'bg-gray-500' : '' }} sidebar-link hover:bg-gray-500">
            <i class="fa-solid fa-user"></i>
            <span class="sidebar-text">Gestionar Usuarios</span>
        </a>


    </nav>
</div>