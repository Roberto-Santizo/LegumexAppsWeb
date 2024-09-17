<div>   
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
                                class="btn">
                        </form>

                        @role('auxmanto')
                        <form action="{{ route('logout') }}" method="POST" class="text-md">
                            @csrf
                            <input type="submit" value="Utilizar otro Usuario"
                                class="btn">
                        </form>
                        @endrole
                    </div>
                </div>
            </div>

            <a href="{{ route('planSemanal') }}"
                class="{{  Route::is('planSemanal*') ? 'bg-orange-500' : '' }} sidebar-link">
                <i class="fa-solid fa-calendar-check"></i>
                <span class="sidebar-text">Tareas Finca</span>
            </a>


            <a href="{{ route('tareas') }}"
                class="{{  Route::is('tareas*') ? 'bg-orange-500' : '' }} sidebar-link">
                <i class="fa-solid fa-list-check"></i>
                <span class="sidebar-text">Tareas</span>
            </a>

            <a href="{{ route('lotes') }}"
                class="{{  Route::is('lotes*') ? 'bg-orange-500' : '' }} sidebar-link">
                <i class="fa-solid fa-map"></i>
                <span class="sidebar-text">Lotes</span>
            </a>

            <a href="{{ route('usuariosFincas') }}"
                class="{{  Route::is('usuariosFincas*') ? 'bg-orange-500' : '' }} sidebar-link">
                <i class="fa-solid fa-users"></i>
                <span class="sidebar-text">Ingresos Personal</span>
            </a>

            
            {{-- <a href="{{ route('cultivos') }}"
                class="{{  Route::is('cultivos*') ? 'bg-orange-500' : '' }} sidebar-link">
                <i class="fa-solid fa-leaf"></i>
                <span class="sidebar-text">Cultivos</span>
            </a> --}}

            {{-- <a href="{{ route('cdps') }}"
                class="{{  Route::is('cdps*') ? 'bg-orange-500' : '' }} sidebar-link">
                <i class="fa-solid fa-seedling"></i>
                <span class="sidebar-text">Control de Plantación</span>
            </a> --}}
        </nav>
    </div>
</div>