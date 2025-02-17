<div class="w-1/2 mx-auto">
    <form class="space-y-5" wire:submit.prevent='save'>
        <div class="space-y-2">
            <label for="name" class="font-bold text-xl">Nombre del Equipo:</label>
            <input wire:model="name" type="text" id="name" class="w-full border rounded px-3 py-2" placeholder="Nombre del equipo" autocomplete="off"/>
            @error('name')
                <x-alerta-error :message="$message" />
            @enderror
        </div>

        <div class="space-y-2">
            <label for="code" class="font-bold text-xl">Codigo del Equipo:</label>
            <input wire:model="code" type="text" id="code" class="w-full border rounded px-3 py-2" placeholder="Codigo del equipo" autocomplete="off"/>
            @error('code')
                <x-alerta-error :message="$message" />
            @enderror
        </div>

        <div class="space-y-2">
            <label for="serie" class="font-bold text-xl">Serie del Equipo:</label>
            <input wire:model="serie" type="text" id="serie" class="w-full border rounded px-3 py-2" placeholder="Serie del equipo" autocomplete="off"/>
            @error('serie')
                <x-alerta-error :message="$message" />
            @enderror
        </div>

        <div class="space-y-2">
            <label for="modelo" class="font-bold text-xl">Modelo del Equipo:</label>
            <input wire:model="modelo" type="text" id="modelo" class="w-full border rounded px-3 py-2" placeholder="Modelo del equipo" autocomplete="off"/>
            @error('modelo')
                <x-alerta-error :message="$message" />
            @enderror
        </div>

        <div class="space-y-2">
            <label for="acquisition_date" class="font-bold text-xl">Fecha de Adquisición:</label>
            <input wire:model="acquisition_date" type="date" id="acquisition_date" class="w-full border rounded px-3 py-2" autocomplete="off"/>
            @error('acquisition_date')
                <x-alerta-error :message="$message" />
            @enderror
        </div>

        <div class="space-y-2">
            <label for="installation_date" class="font-bold text-xl">Fecha de Instalación:</label>
            <input wire:model="installation_date" type="date" id="installation_date" class="w-full border rounded px-3 py-2" autocomplete="off"/>
            @error('installation_date')
                <x-alerta-error :message="$message" />
            @enderror
        </div>

        <div class="flex flex-col">
            <label class="font-bold text-xl" for="area_id">Área:</label>
            <select wire:model='area_id' class="border p-3 border-black">
                <option selected>--SELECCIONE UNA AREA--</option>
                @foreach ($areas as $area)
                    <option value="{{ $area->id }}">{{ $area->area }} - {{ $area->planta->name }}</option>
                @endforeach
            </select>
            @error('area_id')
            <x-alerta-error :message="$message" />
            @enderror
        </div>

        <fieldset>
            <table class="w-full mb-5 mt-5">
                <thead class="bg-sky-600">
                    <tr>
                        <th scope="col" class="text-white text-sm md:text-xl p-2">Permiso</th>
                        <th scope="col" class="text-white text-sm md:text-xl p-2">Elegir</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($accesorios_all as $accesorio)
                        <tr class="odd:bg-orange-200 odd:text-white">
                            <td class="text-sm md:text-xl font-bold p-2">
                                {{ $accesorio->name }}
                            </td>
                            <td class="text-center">
                                <input {{ $equipo->accesorios->contains('accesorio_id',$accesorio->id) ? 'checked' : '' }} class="h-6 w-6 mt-2 lavadas" type="checkbox" wire:model="accesorioIds" value="{{ $accesorio->id }}">
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </fieldset>

        <div class="btn bg-orange-600 hover:bg-orange-800 mt-10 w-full text-center">
            <button class="flex justify-center items-center p-2 gap-2 w-full" type="submit">
                <p class="uppercase text-center">Guardar</p>
            </button>
        </div>


    </form>
</div>
