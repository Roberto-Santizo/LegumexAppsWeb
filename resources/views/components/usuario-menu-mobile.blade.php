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
                    class="mt-5 bg-orange-500 cursor-pointer hover:bg-orange-700 text-white font-bold py-2 px-4 rounded inline-block ">
            </form>

            @role('auxmanto')
            <form action="{{ route('logout') }}" method="POST" class="text-md">
                @csrf
                <input type="submit" value="Utilizar otro Usuario"
                    class="mt-5 bg-orange-500 cursor-pointer hover:bg-orange-700 text-white font-bold py-2 px-4 rounded inline-block ">
            </form>
            @endrole
        </div>
    </div>
</div>