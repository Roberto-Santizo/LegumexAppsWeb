<div>
    @php
        $clasesTextoEnlace = 'text-md md:text-xs uppercase font-bold';
        $clasesEnlaceSidebar = 'rounded-lg text-center flex flex-row  gap-5 md:gap-0  md:flex-col items-center md:justify-center p-3 w-full md:w-2/3 hover:bg-blue-400';
        $clasesBtnLogout = 'mt-5 bg-orange-500 cursor-pointer hover:bg-orange-700 text-white font-bold py-2 px-4 rounded inline-block';
    @endphp
    
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
                                class="{{ $clasesBtnLogout }}">
                        </form>

                        @role('auxmanto')
                        <form action="{{ route('logout') }}" method="POST" class="text-md">
                            @csrf
                            <input type="submit" value="Utilizar otro Usuario"
                                class="{{ $clasesBtnLogout }}">
                        </form>
                        @endrole
                    </div>
                </div>
            </div>

            {{-- <a href="{{ route('dashboard') }}"
                class=" {{  Route::is('dashboard*') ? 'bg-orange-500' : '' }} {{ $clasesEnlaceSidebar }}">
                <i class="fa-solid fa-house"></i>
                <span class="{{ $clasesTextoEnlace }}">Dashboard</span>
            </a> --}}

            <a href="{{ route('planSemanal') }}"
                class="{{  Route::is('planSemanal*') ? 'bg-orange-500' : '' }} {{ $clasesEnlaceSidebar }}">
                <i class="fa-solid fa-calendar-check"></i>
                <span class="{{ $clasesTextoEnlace }}">Tareas Finca</span>
            </a>


            <a href="{{ route('tareas') }}"
                class="{{  Route::is('tareas*') ? 'bg-orange-500' : '' }} {{ $clasesEnlaceSidebar }}">
                <i class="fa-solid fa-list-check"></i>
                <span class="{{ $clasesTextoEnlace }}">Tareas</span>
            </a>

            <a href="{{ route('cultivos') }}"
                class="{{  Route::is('cultivos*') ? 'bg-orange-500' : '' }} {{ $clasesEnlaceSidebar }}">
                <i class="fa-solid fa-leaf"></i>
                <span class="{{ $clasesTextoEnlace }}">Cultivos</span>
            </a>

            <a href="{{ route('lotes') }}"
                class="{{  Route::is('lotes*') ? 'bg-orange-500' : '' }} {{ $clasesEnlaceSidebar }}">
                <i class="fa-solid fa-map"></i>
                <span class="{{ $clasesTextoEnlace }}">Lotes</span>
            </a>

            <a href="{{ route('cdps') }}"
                class="{{  Route::is('cdps*') ? 'bg-orange-500' : '' }} {{ $clasesEnlaceSidebar }}">
                <i class="fa-solid fa-seedling"></i>
                <span class="{{ $clasesTextoEnlace }}">Control de Plantación</span>
            </a>

            <a href="{{ route('usuariosFincas') }}"
                class="{{  Route::is('usuariosFincas*') ? 'bg-orange-500' : '' }} {{ $clasesEnlaceSidebar }}">
                <i class="fa-solid fa-users"></i>
                <span class="{{ $clasesTextoEnlace }}">Ingresos Personal</span>
            </a>

        </nav>
    </div>
</div>