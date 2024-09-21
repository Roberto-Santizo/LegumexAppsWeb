<div>
    @hasrole('admin')
        {{-- <x-administrador-navegacion /> --}}
        <x-mantenimiento-navegacion />
        {{-- <x-agricola-navegacion /> --}}
    @endhasrole

    @hasanyrole('adminmanto|auxmanto')
        <x-mantenimiento-navegacion />
    @endhasanyrole

    @hasanyrole('adminagricola|auxalameda')
        <x-agricola-navegacion />
    @endhasanyrole
</div>