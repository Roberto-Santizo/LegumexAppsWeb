<div class="flex flex-col gap-10">
    
    <div class="mt-5 shadow-xl p-10 uppercase md:flex md:justify-between space-y-5">
        <div class="md:text-xl text-xs">
            <p><span class="font-bold">Equipo:</span>  {{ $equipo->name }}</p>
            <p><span class="font-bold">Area:</span> {{ $equipo->area->area }}</p>
            <p><span class="font-bold">Planta:</span> {{ $equipo->area->planta->name }}</p>
            <p><span class="font-bold">Codigo:</span> {{ $equipo->code }}</p>
            <p><span class="font-bold">Fecha de adquisición:</span> {{ $equipo->acquisition_date ? $equipo->acquisition_date->format('d-m-Y') : 'sin datos'}}</p>
            <p><span class="font-bold">Fecha de instalación:</span> {{ $equipo->installation_date ? $equipo->installation_date->format('d-m-Y') : 'sin datos' }}</p>
            <p><span class="font-bold">Modelo:</span> {{ $equipo->modelo ?? 'sin datos' }}</p>
            <p><span class="font-bold">Serie:</span> {{ $equipo->serie ?? 'sin datos' }}</p>
            <button wire:click='Actualizar' class=" text-white p-2 font-bold  rounded w-1/2 mt-5 text-center {{ $equipo->status ?  'bg-green-500' : 'bg-red-500'}}"> {{ $equipo->status ? 'ACTIVO' : 'DESACTIVADO' }}</button>
        </div>
        <div>
            <x-generate-qr :url='$equipo->folder_url' />
            <a href="{{ $equipo->folder_url }}" target="_blank" class="font-bold text-center">
                VER IMAGENES
            </a>
        </div>
    </div>
    
    <div class="w-full flex justify-end">
        <button class="btn bg-green-500 hover:bg-green-600 md:w-1/6" wire:click='OpenModal'>
            <i class="fa-solid fa-plus"></i>
            Crear Trabajo
        </button>
    </div>

    <div class="md:grid md:grid-cols-2 md:space-x-5 md:space-y-0 flex flex-col space-y-10 md:text-xl text-xs">
       <div>
            <h2 class="font-bold md:text-4xl">Trabajos Preventivos <i class="fa-solid fa-clock text-orange-500"></i></h2>
            @if($this->equipo->trabajosPreventivos->count() === 0)
                <p class="text-center mt-10">Sin trabajos planificados</p>
            @endif
            @foreach($this->equipo->trabajosPreventivos as $trabajo)
                <div class="flex flex-col gap-5 mt-5">
                    <div class="p-5 shadow-xl flex justify-between">
                        <p><span class="font-bold">Tarea: </span>{{ $trabajo->descripcion }}</p>
                        <p><span class="font-bold">Fecha de planificación: </span>{{ $trabajo->fecha_planificacion->format('d-m-Y') }}</p>
                        <button wire:click='closeJob({{ $trabajo->id }})'>
                            <i class="fa-solid fa-circle-check icon-link"></i>
                        </button>
                    </div>
                </div>
            @endforeach
       </div>

        <div>
            <h2 class="font-bold md:text-4xl">Trabajos Realizados <i class="fa-solid fa-circle-check text-green-500"></i></h2>
    
            @if($this->equipo->trabajosRealizados->count() === 0)
                <p class="text-center mt-10">Sin trabajos cerrados</p>
            @endif

            @foreach($this->equipo->trabajosRealizados as $trabajo)
                <div class="flex flex-col gap-5 mt-5">
                    <div class="p-5 shadow-xl flex justify-between">
                        <p><span class="font-bold">Tarea: </span>{{ $trabajo->descripcion }}</p>
                        <p><span class="font-bold">Fecha de cierre: </span>{{ $trabajo->fecha_realizacion->format('d-m-Y') }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    @if ($open)
        <livewire:crear-trabajo-equipo :equipo='$equipo'/>
    @endif
    
</div>