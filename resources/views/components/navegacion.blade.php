<div>
    @hasrole('admin')
        <x-administrador-navegacion />
        <x-mantenimiento-navegacion />
        <x-agricola-navegacion />
        <x-recursos-navegacion />
    @endhasrole

    @hasanyrole('adminmanto|auxmanto')
        <x-mantenimiento-navegacion />
    @endhasanyrole

    @hasanyrole('adminagricola|auxfinca')
        <x-agricola-navegacion />
    @endhasanyrole

    @role('auxrrhh')
        <x-recursos-navegacion />
    @endrole
</div>