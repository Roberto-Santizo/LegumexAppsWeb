<div>
    @hasrole('admin')
        <x-administrador-navegacion />
        <x-mantenimiento-navegacion />
    @endhasrole

    @hasanyrole('adminmanto|auxmanto')
        <x-mantenimiento-navegacion />
    @endhasanyrole
</div>